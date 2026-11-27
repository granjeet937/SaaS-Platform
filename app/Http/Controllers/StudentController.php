<?php

namespace App\Http\Controllers;

use App\Models\LibraryShift;
use App\Models\Seat;
use App\Models\Student;
use App\Models\StudentPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Mail\LibraryNotificationMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StudentController extends Controller
{
    private function timeToMinutes(?string $time): ?int
    {
        if (!$time) {
            return null;
        }
        $parts = explode(':', $time);
        return ((int) $parts[0] * 60) + (int) ($parts[1] ?? 0);
    }

    private function shiftsOverlap(LibraryShift $s1, LibraryShift $s2): bool
    {
        $a1 = $this->timeToMinutes($s1->start_time);
        $a2 = $this->timeToMinutes($s1->end_time);
        $b1 = $this->timeToMinutes($s2->start_time);
        $b2 = $this->timeToMinutes($s2->end_time);

        if ($a1 === null || $a2 === null || $b1 === null || $b2 === null) {
            return false;
        }

        $segsA = $a2 > $a1 ? [[$a1, $a2]] : [[$a1, 1440], [0, $a2]];
        $segsB = $b2 > $b1 ? [[$b1, $b2]] : [[$b1, 1440], [0, $b2]];

        foreach ($segsA as [$x1, $x2]) {
            foreach ($segsB as [$y1, $y2]) {
                if ($x1 < $y2 && $x2 > $y1) {
                    return true;
                }
            }
        }

        return false;
    }

    private function syncSeatStatus(int $libraryId, ?int $seatId): void
    {
        if (!$seatId) {
            return;
        }

        $seat = Seat::where('library_id', $libraryId)->find($seatId);
        if (!$seat || $seat->status === 'maintenance') {
            return;
        }

        $usedHours = Student::where('library_id', $libraryId)
            ->where('seat_id', $seatId)
            ->where('status', 'active')
            ->with('shift')
            ->get()
            ->sum(fn($s) => $s->shift->duration_hours ?? 0);

        $seat->update([
            'status' => $usedHours >= 24 ? 'occupied' : 'available',
        ]);
    }

    private function validateSeatForShift(int $libraryId, int $seatId, LibraryShift $shift, ?int $ignoreStudentId = null): Seat
    {
        $seat = Seat::where('library_id', $libraryId)
            ->where('id', $seatId)
            ->lockForUpdate()
            ->first();

        if (!$seat || $seat->status === 'maintenance' || $seat->status === 'occupied') {
            throw ValidationException::withMessages([
                'seat_id' => 'This seat is unavailable or already fully occupied.',
            ]);
        }

        $activeStudentsOnSeat = Student::where('library_id', $libraryId)
            ->where('seat_id', $seat->id)
            ->where('status', 'active')
            ->when($ignoreStudentId, fn($q) => $q->where('id', '!=', $ignoreStudentId))
            ->with('shift')
            ->get();

        if ($activeStudentsOnSeat->contains('shift_id', $shift->id)) {
            throw ValidationException::withMessages([
                'seat_id' => "This seat is already booked for {$shift->shift_name}.",
            ]);
        }

        foreach ($activeStudentsOnSeat as $existing) {
            if ($existing->shift && $this->shiftsOverlap($shift, $existing->shift)) {
                throw ValidationException::withMessages([
                    'seat_id' => "Timing overlaps with existing student ({$existing->shift->shift_name}) on this seat.",
                ]);
            }
        }

        $usedHours = $activeStudentsOnSeat->sum(fn($s) => $s->shift->duration_hours ?? 0);
        if (($usedHours + $shift->duration_hours) > 24) {
            throw ValidationException::withMessages([
                'seat_id' => 'Not enough remaining shift hours available on this seat.',
            ]);
        }

        return $seat;
    }

    public function index(Request $request)
    {
        $library = $request->user()->library;
        abort_unless($library, 403, 'Library account not found.');

        $students = Student::where('library_id', $library->id)
            ->with(['seat', 'shift'])
            ->latest()
            ->paginate(15);

        $shifts = LibraryShift::where('library_id', $library->id)
            ->where('status', true)
            ->orderBy('start_time')
            ->orderBy('duration_hours')
            ->get();

        $availableSeats = Seat::where('library_id', $library->id)
            ->where('status', 'available')
            ->with('activeStudents')
            ->orderBy('seat_number')
            ->get();

        return view('library.students.stdindex', compact('students', 'shifts', 'availableSeats'));
    }

    public function create(Request $request)
    {
        $library = $request->user()->library;
        abort_unless($library, 403, 'Library account not found.');

        $shifts = LibraryShift::where('library_id', $library->id)
            ->where('status', true)
            ->orderBy('start_time')
            ->orderBy('duration_hours')
            ->get();

        $seats = Seat::where('library_id', $library->id)
            ->where('status', 'available')
            ->with('activeStudents')
            ->orderBy('seat_number')
            ->get();

        return view('library.students.stdcreate', compact('shifts', 'seats'));
    }

    public function store(Request $request)
    {
        $library = $request->user()->library;
        abort_unless($library, 403, 'Library account not found.');

        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:100'],
            'mobile'           => ['required', 'string', 'max:20'],
            'email'            => ['nullable', 'email', 'max:100'],
            'guardian_name'    => ['nullable', 'string', 'max:100'],
            'guardian_mobile'  => ['nullable', 'string', 'max:20'],
            'address'          => ['nullable', 'string'],
            'admission_date'   => ['required', 'date'],
            'shift_id'         => ['required', 'integer'],
            'seat_id'          => ['nullable', 'integer'],
            'total_fee'        => ['required', 'numeric', 'min:0', 'max:99999999'],
            'discount'         => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'initial_payment'  => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'payment_method'   => ['required', 'in:cash,upi,card,bank_transfer,other'],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'photo'            => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ]);

        $shift = LibraryShift::where('library_id', $library->id)
            ->where('id', $validated['shift_id'])
            ->where('status', true)
            ->first();

        if (!$shift) {
            throw ValidationException::withMessages([
                'shift_id' => 'Selected shift is invalid or inactive.',
            ]);
        }

        $totalFee       = (float) $validated['total_fee'];
        $discount       = (float) ($validated['discount'] ?? 0);
        $initialPayment = (float) ($validated['initial_payment'] ?? 0);
        $payableFee     = round($totalFee - $discount, 2);

        if ($discount > $totalFee) {
            throw ValidationException::withMessages([
                'discount' => 'Discount cannot exceed total fee.',
            ]);
        }

        if ($initialPayment > $payableFee) {
            throw ValidationException::withMessages([
                'initial_payment' => 'Payment cannot exceed payable fee.',
            ]);
        }

        $photoPath = null;

        try {
            DB::transaction(function () use (
                $request,
                $validated,
                $library,
                $shift,
                $totalFee,
                $discount,
                $payableFee,
                $initialPayment,
                &$photoPath
            ) {
                $seat = null;
                if (!empty($validated['seat_id'])) {
                    $seat = $this->validateSeatForShift($library->id, (int) $validated['seat_id'], $shift);
                }

                $cleanName = preg_replace('/[^a-zA-Z\s]/', '', trim($validated['name']));
                $words = array_values(array_filter(explode(' ', $cleanName)));

                if (count($words) >= 3) {
                    $prefix = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1) . substr($words[2], 0, 1));
                } else {
                    $joined = str_replace(' ', '', $cleanName);
                    $prefix = strtoupper(str_pad(substr($joined, 0, 3), 3, 'X'));
                }

                $sequence = Student::where('library_id', $library->id)->count() + 1;

                do {
                    $studentCode = 'STU-' . $prefix . str_pad($sequence, 2, '0', STR_PAD_LEFT);
                    $sequence++;
                } while (Student::where('student_code', $studentCode)->exists());

                if ($request->hasFile('photo')) {
                    $file = $request->file('photo');
                    $extension = strtolower($file->getClientOriginalExtension());
                    $relativeDir = "Library/{$library->library_code}/Students/{$studentCode}";
                    $fileName = "{$studentCode}.{$extension}";

                    $fullDir = base_path($relativeDir);
                    if (!is_dir($fullDir)) {
                        mkdir($fullDir, 0755, true);
                    }

                    $file->move($fullDir, $fileName);
                    $photoPath = "{$relativeDir}/{$fileName}";
                }

                $student = Student::create([
                    'library_id'      => $library->id,
                    'student_code'    => $studentCode,
                    'name'            => $validated['name'],
                    'mobile'          => $validated['mobile'],
                    'email'           => $validated['email'] ?? null,
                    'guardian_name'   => $validated['guardian_name'] ?? null,
                    'guardian_mobile' => $validated['guardian_mobile'] ?? null,
                    'address'         => $validated['address'] ?? null,
                    'photo'           => $photoPath,
                    'admission_date'  => $validated['admission_date'],
                    'shift_id'        => $shift->id,
                    'seat_id'         => $seat?->id,
                    'total_fee'       => $totalFee,
                    'discount'        => $discount,
                    'payable_fee'     => $payableFee,
                    'status'          => 'active',
                ]);

                if ($seat) {
                    $this->syncSeatStatus($library->id, $seat->id);
                }

                if ($initialPayment > 0) {
                    StudentPayment::create([
                        'library_id'       => $library->id,
                        'student_id'       => $student->id,
                        'amount'           => $initialPayment,
                        'payment_method'   => $validated['payment_method'],
                        'payment_status'   => 'paid',
                        'payment_date'     => now()->toDateString(),
                        'reference_number' => $validated['reference_number'] ?? null,
                    ]);
                }
                $this->sendStudentMail($library, $validated['email'] ?? null, [
                    'subject'        => "Admission Confirmed — {$library->library_name}",
                    'recipient_name' => $validated['name'],
                    'badge_text'     => 'ADMISSION CONFIRMED',
                    'badge_color'    => '#16a34a',
                    'intro_message'  => "Welcome to {$library->library_name}! Your library admission has been completed.",
                    'details'        => [
                        'Student Code'   => $studentCode,
                        'Shift'          => $shift->shift_name,
                        'Seat'           => $seat?->seat_number ?? 'Not Assigned',
                        'Monthly Fee'    => '₹' . number_format($payableFee, 2),
                        'Paid Today'     => '₹' . number_format($initialPayment, 2),
                        'Admission Date' => $validated['admission_date'],
                    ],
                    'footer_note'    => 'Please keep your Student Code handy for daily attendance check-in.',
                ]);
            });
        } catch (\Throwable $e) {
            if ($photoPath && file_exists(base_path($photoPath))) {
                unlink(base_path($photoPath));
            }
            throw $e;
        }

        return redirect('/library/students')
            ->with('success', 'Student admitted successfully.');
    }

    public function showPhoto(Request $request, $id)
    {
        $student = Student::where('library_id', $request->user()->library_id)
            ->findOrFail($id);

        if (!$student->photo || !file_exists(base_path($student->photo))) {
            abort(404);
        }

        return response()->file(base_path($student->photo));
    }

    public function show(Request $request, $id)
    {
        $library = $request->user()->library;
        abort_unless($library, 403, 'Library account not found.');

        $student = Student::where('library_id', $library->id)
            ->with([
                'seat',
                'shift',
                'payments' => function ($query) {
                    $query->orderByDesc('payment_date')->orderByDesc('id');
                },
            ])
            ->findOrFail($id);

        $admissionDate = $student->admission_date
            ? $student->admission_date->copy()->startOfDay()
            : now()->startOfDay();

        $daysElapsed = max(0, (int)$admissionDate->diffInDays(now()->startOfDay(), false));
        $totalMonths = (int) floor($daysElapsed / 30) + 1;

        $monthlyPayable = (float)$student->payable_fee;
        $totalDue = round($totalMonths * $monthlyPayable, 2);

        $totalPaid = (float)$student->payments
            ->where('payment_status', 'paid')
            ->sum('amount');

        $remainingBalance = max(0, round($totalDue - $totalPaid, 2));
        $nextDueDate = $admissionDate->copy()->addDays($totalMonths * 30);
        $shifts = LibraryShift::where('library_id', $library->id)->where('status', true)->orderBy('start_time')->orderBy('duration_hours')->get();
        $allSeats = Seat::where('library_id', $library->id)->where('status', '!=', 'maintenance')->with('activeStudents')->orderBy('seat_number')->get();

        return view('library.students.stdshow', compact(
            'student',
            'totalMonths',
            'monthlyPayable',
            'totalDue',
            'totalPaid',
            'remainingBalance',
            'nextDueDate',
            'allSeats',
            'shifts'
        ));
    }

    public function update(Request $request, $id)
    {
        $library = $request->user()->library;
        abort_unless($library, 403, 'Library account not found.');

        $student = Student::where('library_id', $library->id)->findOrFail($id);

        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:100'],
            'mobile'          => ['required', 'string', 'max:20'],
            'email'           => ['nullable', 'email', 'max:100'],
            'guardian_name'   => ['nullable', 'string', 'max:100'],
            'guardian_mobile' => ['nullable', 'string', 'max:20'],
            'address'         => ['nullable', 'string'],
            'admission_date'  => ['required', 'date'],
            'shift_id'        => ['required', 'integer'],
            'total_fee'       => ['required', 'numeric', 'min:0', 'max:99999999'],
            'discount'        => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'photo'           => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ]);

        $newShift = LibraryShift::where('library_id', $library->id)
            ->where('id', $validated['shift_id'])
            ->where('status', true)
            ->first();

        if (!$newShift) {
            throw ValidationException::withMessages([
                'shift_id' => 'Selected shift is invalid or inactive.',
            ]);
        }

        $totalFee = (float) $validated['total_fee'];
        $discount = (float) ($validated['discount'] ?? 0);
        $payableFee = round($totalFee - $discount, 2);

        if ($discount > $totalFee) {
            throw ValidationException::withMessages([
                'discount' => 'Discount cannot exceed total fee.',
            ]);
        }

        $totalPaid = (float) $student->payments()
            ->where('payment_status', 'paid')
            ->sum('amount');

        if ($payableFee < $totalPaid) {
            throw ValidationException::withMessages([
                'total_fee' => 'Payable fee (₹' . number_format($payableFee, 2) . ') cannot be less than already paid amount (₹' . number_format($totalPaid, 2) . ').',
            ]);
        }

        DB::transaction(function () use ($request, $library, $student, $validated, $newShift, $totalFee, $discount, $payableFee) {
            // If shift changed while student holds a seat, verify new shift doesn't clash on that seat
            if ($student->seat_id && (int) $student->shift_id !== (int) $newShift->id) {
                $this->validateSeatForShift($library->id, (int) $student->seat_id, $newShift, $student->id);
            }

            $photoPath = $student->photo;
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $extension = strtolower($file->getClientOriginalExtension());
                $relativeDir = "Library/{$library->library_code}/Students/{$student->student_code}";
                $fileName = "{$student->student_code}.{$extension}";

                $fullDir = base_path($relativeDir);
                if (!is_dir($fullDir)) {
                    mkdir($fullDir, 0755, true);
                }

                if ($photoPath && file_exists(base_path($photoPath))) {
                    unlink(base_path($photoPath));
                }

                $file->move($fullDir, $fileName);
                $photoPath = "{$relativeDir}/{$fileName}";
            }

            $student->update([
                'name'            => $validated['name'],
                'mobile'          => $validated['mobile'],
                'email'           => $validated['email'] ?? null,
                'guardian_name'   => $validated['guardian_name'] ?? null,
                'guardian_mobile' => $validated['guardian_mobile'] ?? null,
                'address'         => $validated['address'] ?? null,
                'admission_date'  => $validated['admission_date'],
                'shift_id'        => $newShift->id,
                'photo'           => $photoPath,
                'total_fee'       => $totalFee,
                'discount'        => $discount,
                'payable_fee'     => $payableFee,
            ]);

            if ($student->seat_id) {
                $this->syncSeatStatus($library->id, (int) $student->seat_id);
            }
        });

        return redirect('/library/students/view/' . $student->id)
            ->with('success', 'Student details updated successfully.');
    }

    public function toggleStatus(Request $request, $id)
    {
        $library = $request->user()->library;
        abort_unless($library, 403, 'Library account not found.');

        $message = '';

        DB::transaction(function () use ($library, $id, &$message) {
            $student = Student::where('library_id', $library->id)
                ->lockForUpdate()
                ->findOrFail($id);

            if ($student->status === 'active') {
                $oldSeatId = $student->seat_id;

                $student->update([
                    'status'  => 'inactive',
                    'seat_id' => null,
                ]);

                $this->syncSeatStatus($library->id, $oldSeatId);
                $message = 'Student deactivated and assigned seat released.';
            } else {
                $student->update([
                    'status' => 'active',
                ]);

                $message = 'Student activated successfully.';
            }
        });
        $toggledStudent = Student::find($id);
        if ($toggledStudent) {
            $isActive = $toggledStudent->status === 'active';
            $this->sendStudentMail($library, $toggledStudent->email, [
                'subject'        => ($isActive ? 'Membership Activated' : 'Membership Deactivated') . " — {$library->library_name}",
                'recipient_name' => $toggledStudent->name,
                'badge_text'     => $isActive ? 'ACTIVE' : 'INACTIVE',
                'badge_color'    => $isActive ? '#16a34a' : '#dc2626',
                'intro_message'  => $isActive
                    ? "Your membership at {$library->library_name} has been reactivated."
                    : "Your membership at {$library->library_name} has been marked inactive and your seat has been released.",
                'details'        => [
                    'Student Code' => $toggledStudent->student_code,
                    'Status'       => ucfirst($toggledStudent->status),
                ],
            ]);
        }
        return redirect('/library/students/view/' . $id)
            ->with('success', $message);
    }

    public function destroy(Request $request, $id)
    {
        $library = $request->user()->library;
        abort_unless($library, 403, 'Library account not found.');

        DB::transaction(function () use ($library, $id) {
            $student = Student::where('library_id', $library->id)
                ->lockForUpdate()
                ->findOrFail($id);

            $oldSeatId = $student->seat_id;
            $photoPath = $student->photo;

            $student->payments()->delete();
            $student->delete();

            $this->syncSeatStatus($library->id, $oldSeatId);

            if ($photoPath && file_exists(base_path($photoPath))) {
                unlink(base_path($photoPath));
            }
        });

        return redirect('/library/students')
            ->with('success', 'Student deleted successfully.');
    }

    public function collectFee(Request $request, $id)
    {
        $library = $request->user()->library;
        abort_unless($library, 403, 'Library account not found.');

        $student = Student::where('library_id', $library->id)->findOrFail($id);

        $validated = $request->validate([
            'amount'           => ['required', 'numeric', 'min:1', 'max:99999999'],
            'payment_method'   => ['required', 'in:cash,upi,card,bank_transfer,other'],
            'payment_date'     => ['required', 'date'],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'notes'            => ['nullable', 'string', 'max:255'],
        ]);

        StudentPayment::create([
            'library_id'       => $library->id,
            'student_id'       => $student->id,
            'amount'           => round((float) $validated['amount'], 2),
            'payment_method'   => $validated['payment_method'],
            'payment_status'   => 'paid',
            'payment_date'     => $validated['payment_date'],
            'reference_number' => $validated['reference_number'] ?? null,
            'notes'            => $validated['notes'] ?? null,
        ]);
        $this->sendStudentMail($library, $student->email, [
            'subject'        => "Fee Payment Receipt — ₹" . number_format((float) $validated['amount'], 2),
            'recipient_name' => $student->name,
            'badge_text'     => 'PAYMENT RECEIVED',
            'badge_color'    => '#16a34a',
            'intro_message'  => 'Thank you! We have received your monthly fee payment.',
            'details'        => [
                'Student Code'   => $student->student_code,
                'Amount Paid'    => '₹' . number_format((float) $validated['amount'], 2),
                'Payment Mode'   => strtoupper(str_replace('_', ' ', $validated['payment_method'])),
                'Payment Date'   => $validated['payment_date'],
                'Reference No.'  => $validated['reference_number'] ?? '—',
            ],
        ]);
        return redirect()->back()
            ->with('success', 'Fee payment of ₹' . number_format((float) $validated['amount'], 2) . ' recorded successfully.');
    }

    public function feesIndex(Request $request)
    {
        $library = $request->user()->library;
        abort_unless($library, 403, 'Library account not found.');

        $search = trim((string) $request->query('search', ''));
        $filter = trim((string) $request->query('filter', 'all'));

        $studentsQuery = Student::where('library_id', $library->id)
            ->with([
                'seat',
                'payments' => function ($query) {
                    $query->where('payment_status', 'paid');
                },
            ])
            ->orderBy('name');

        if ($search !== '') {
            $studentsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('student_code', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        $allStudents = $studentsQuery->get();

        $today = now()->startOfDay();
        $totalPendingDues = 0;
        $pendingStudentsCount = 0;

        $studentFeeRows = $allStudents->map(function ($student) use ($today, &$totalPendingDues, &$pendingStudentsCount) {
            $admissionDate = $student->admission_date
                ? $student->admission_date->copy()->startOfDay()
                : $today->copy();

            $daysElapsed = max(0, (int) $admissionDate->diffInDays($today, false));
            $totalMonths = (int) floor($daysElapsed / 30) + 1;

            $monthlyPayable = (float) $student->payable_fee;
            $totalDue = round($totalMonths * $monthlyPayable, 2);
            $totalPaid = (float) $student->payments->sum('amount');
            $remainingBalance = max(0, round($totalDue - $totalPaid, 2));
            $nextDueDate = $admissionDate->copy()->addDays($totalMonths * 30);

            if ($remainingBalance > 0) {
                $totalPendingDues += $remainingBalance;
                $pendingStudentsCount++;
            }

            return (object) [
                'student'          => $student,
                'totalMonths'      => $totalMonths,
                'monthlyPayable'   => $monthlyPayable,
                'totalDue'         => $totalDue,
                'totalPaid'        => $totalPaid,
                'remainingBalance' => $remainingBalance,
                'nextDueDate'      => $nextDueDate,
                'isPaid'           => $remainingBalance <= 0,
            ];
        });

        if ($filter === 'pending') {
            $studentFeeRows = $studentFeeRows->filter(fn($row) => $row->remainingBalance > 0)->values();
        } elseif ($filter === 'paid') {
            $studentFeeRows = $studentFeeRows->filter(fn($row) => $row->remainingBalance <= 0)->values();
        }

        $totalCollected = (float) StudentPayment::where('library_id', $library->id)
            ->where('payment_status', 'paid')
            ->sum('amount');

        $todayCollection = (float) StudentPayment::where('library_id', $library->id)
            ->where('payment_status', 'paid')
            ->whereDate('payment_date', now()->toDateString())
            ->sum('amount');

        $recentPayments = StudentPayment::where('library_id', $library->id)
            ->with('student.seat')
            ->orderByDesc('payment_date')
            ->orderByDesc('id')
            ->limit(25)
            ->get();

        return view('library.fees.feesindex', compact(
            'library',
            'studentFeeRows',
            'totalCollected',
            'totalPendingDues',
            'pendingStudentsCount',
            'todayCollection',
            'recentPayments',
            'search',
            'filter'
        ));
    }

    public function printReceipt(Request $request, $id)
    {
        $library = $request->user()->library;
        abort_unless($library, 403, 'Library account not found.');

        $payment = StudentPayment::where('library_id', $library->id)
            ->with(['student.seat'])
            ->findOrFail($id);

        $student = $payment->student;

        $admissionDate = ($student && $student->admission_date)
            ? $student->admission_date->copy()->startOfDay()
            : now()->startOfDay();

        $daysElapsed = max(0, (int) $admissionDate->diffInDays(now()->startOfDay(), false));
        $totalMonths = (int) floor($daysElapsed / 30) + 1;
        $totalDue = $student ? round($totalMonths * (float) $student->payable_fee, 2) : 0;

        $totalPaid = $student
            ? (float) $student->payments()->where('payment_status', 'paid')->sum('amount')
            : (float) $payment->amount;

        $remainingBalance = max(0, round($totalDue - $totalPaid, 2));

        return view('library.fees.receipt', compact(
            'library',
            'payment',
            'student',
            'totalDue',
            'totalPaid',
            'remainingBalance'
        ));
    }

    public function changeSeat(Request $request, $id)
    {
        $library = $request->user()->library;
        abort_unless($library, 403, 'Library account not found.');

        $validated = $request->validate([
            'shift_id'        => ['required', 'integer'],
            'seat_id'         => ['nullable', 'integer'],
            'update_shift_fee' => ['nullable', 'boolean'],
        ]);

        $newShift = LibraryShift::where('library_id', $library->id)
            ->where('id', $validated['shift_id'])
            ->where('status', true)
            ->first();

        if (!$newShift) {
            throw ValidationException::withMessages([
                'shift_id' => 'Selected shift is invalid or inactive.',
            ]);
        }

        $newSeatId = !empty($validated['seat_id']) ? (int) $validated['seat_id'] : null;

        DB::transaction(function () use ($library, $id, $newShift, $newSeatId, $validated) {
            $student = Student::where('library_id', $library->id)
                ->lockForUpdate()
                ->findOrFail($id);

            $oldSeatId = $student->seat_id;

            // Validate seat against the newly selected shift
            $validatedSeat = null;
            if ($newSeatId) {
                $validatedSeat = $this->validateSeatForShift($library->id, $newSeatId, $newShift, $student->id);
            }

            $updateData = [
                'shift_id' => $newShift->id,
                'seat_id'  => $validatedSeat?->id,
            ];

            // Optionally update monthly fee to match the new shift's fee
            if (!empty($validated['update_shift_fee'])) {
                $newTotalFee = (float) $newShift->monthly_fee;
                $discount = (float) $student->discount;
                $newPayable = max(0, round($newTotalFee - $discount, 2));

                $totalPaid = (float) $student->payments()
                    ->where('payment_status', 'paid')
                    ->sum('amount');

                if ($newPayable < $totalPaid) {
                    throw ValidationException::withMessages([
                        'shift_id' => 'New shift payable fee (₹' . number_format($newPayable, 2) . ') cannot be less than already paid amount (₹' . number_format($totalPaid, 2) . '). Uncheck fee update or adjust discount.',
                    ]);
                }

                $updateData['total_fee'] = $newTotalFee;
                $updateData['payable_fee'] = $newPayable;
            }

            $student->update($updateData);

            $this->syncSeatStatus($library->id, $oldSeatId);
            if ($validatedSeat) {
                $this->syncSeatStatus($library->id, $validatedSeat->id);
            }
        });

        return redirect('/library/students/view/' . $id)
            ->with('success', 'Shift and seat allocation updated successfully.');
    }

    public function publicRegisterForm(string $token)
    {
        $library = \App\Models\Library::where('admission_token', $token)->firstOrFail();
        $shifts = LibraryShift::where('library_id', $library->id)
            ->where('status', true)
            ->orderBy('start_time')
            ->get();

        return view('library.students.public_register', compact('library', 'token', 'shifts'));
    }

    public function publicRegisterStore(Request $request, string $token)
    {
        $library = \App\Models\Library::where('admission_token', $token)->firstOrFail();

        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:100'],
            'mobile'          => ['required', 'string', 'max:20'],
            'email'           => ['nullable', 'email', 'max:100'],
            'guardian_name'   => ['nullable', 'string', 'max:100'],
            'guardian_mobile' => ['nullable', 'string', 'max:20'],
            'address'         => ['nullable', 'string', 'max:500'],
            'admission_date'  => ['required', 'date'],
            'shift_id'        => ['nullable', 'integer'],
            'photo'           => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ]);

        $exists = Student::where('library_id', $library->id)
            ->where('mobile', trim($validated['mobile']))
            ->whereIn('status', ['pending', 'active'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['mobile' => 'This mobile number is already registered or pending approval in this library.']);
        }

        // Sequential student code generate karein taaki photo folder bhi usi code se bane
        $cleanName = preg_replace('/[^a-zA-Z\s]/', '', trim($validated['name']));
        $words = array_values(array_filter(explode(' ', $cleanName)));
        $prefix = count($words) >= 3
            ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1) . substr($words[2], 0, 1))
            : strtoupper(str_pad(substr(str_replace(' ', '', $cleanName), 0, 3), 3, 'X'));

        $sequence = Student::where('library_id', $library->id)->count() + 1;
        do {
            $studentCode = 'STU-' . $prefix . str_pad($sequence, 2, '0', STR_PAD_LEFT);
            $sequence++;
        } while (Student::where('student_code', $studentCode)->exists());

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = strtolower($file->getClientOriginalExtension());
            $relativeDir = "Library/{$library->library_code}/Students/{$studentCode}";
            $fileName = "{$studentCode}.{$extension}";

            $fullDir = base_path($relativeDir);
            if (!is_dir($fullDir)) {
                mkdir($fullDir, 0755, true);
            }

            $file->move($fullDir, $fileName);
            $photoPath = "{$relativeDir}/{$fileName}";
        }

        $validShiftId = null;
        if (!empty($validated['shift_id'])) {
            $validShiftId = LibraryShift::where('library_id', $library->id)
                ->where('id', $validated['shift_id'])
                ->where('status', true)
                ->value('id');
        }

        Student::create([
            'library_id'      => $library->id,
            'student_code'    => $studentCode,
            'name'            => trim($validated['name']),
            'mobile'          => trim($validated['mobile']),
            'email'           => $validated['email'] ?? null,
            'guardian_name'   => $validated['guardian_name'] ?? null,
            'guardian_mobile' => $validated['guardian_mobile'] ?? null,
            'address'         => $validated['address'] ?? null,
            'photo'           => $photoPath,
            'admission_date'  => $validated['admission_date'],
            'shift_id'        => $validShiftId,
            'seat_id'         => null,
            'total_fee'       => 0,
            'discount'        => 0,
            'payable_fee'     => 0,
            'status'          => 'pending',
        ]);
        $this->sendStudentMail($library, $validated['email'] ?? null, [
            'subject'        => "Registration Received — {$library->library_name}",
            'recipient_name' => trim($validated['name']),
            'badge_text'     => 'REGISTRATION SUBMITTED',
            'badge_color'    => '#d97706',
            'intro_message'  => "Your online registration for {$library->library_name} has been received and is pending admin approval.",
            'details'        => [
                'Application Code' => $studentCode,
                'Mobile'           => trim($validated['mobile']),
                'Joining Date'     => $validated['admission_date'],
                'Status'           => 'Pending Approval',
            ],
            'footer_note'    => 'Please visit the library desk to complete seat allocation and activation.',
        ]);
        return back()->with('submitted', true);
    }

    public function regenerateInviteToken(Request $request)
    {
        $library = $request->user()->library;
        abort_unless($library, 403, 'Library account not found.');

        $library->update([
            'admission_token' => strtoupper(Str::random(16)),
        ]);

        return redirect()->back()->with('success', 'New registration link generated. Old link is now invalid.');
    }

    public function approvePending(Request $request, $id)
    {
        $library = $request->user()->library;
        abort_unless($library, 403, 'Library account not found.');

        $validated = $request->validate([
            'admission_date'   => ['required', 'date'],
            'shift_id'         => ['required', 'integer'],
            'seat_id'          => ['nullable', 'integer'],
            'total_fee'        => ['required', 'numeric', 'min:0', 'max:99999999'],
            'discount'         => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'initial_payment'  => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'payment_method'   => ['required', 'in:cash,upi,card,bank_transfer,other'],
            'reference_number' => ['nullable', 'string', 'max:100'],
        ]);

        $shift = LibraryShift::where('library_id', $library->id)
            ->where('id', $validated['shift_id'])
            ->where('status', true)
            ->first();

        if (!$shift) {
            throw ValidationException::withMessages([
                'shift_id' => 'Selected shift is invalid or inactive.',
            ]);
        }

        $totalFee = (float) $validated['total_fee'];
        $discount = (float) ($validated['discount'] ?? 0);
        $initialPayment = (float) ($validated['initial_payment'] ?? 0);
        $payableFee = round($totalFee - $discount, 2);

        if ($discount > $totalFee) {
            throw ValidationException::withMessages([
                'discount' => 'Discount cannot exceed total fee.',
            ]);
        }

        if ($initialPayment > $payableFee) {
            throw ValidationException::withMessages([
                'initial_payment' => 'Initial payment cannot exceed payable fee.',
            ]);
        }

        DB::transaction(function () use ($library, $id, $validated, $shift, $totalFee, $discount, $payableFee, $initialPayment) {
            $student = Student::where('library_id', $library->id)
                ->where('status', 'pending')
                ->lockForUpdate()
                ->findOrFail($id);

            $seat = null;
            if (!empty($validated['seat_id'])) {
                $seat = $this->validateSeatForShift($library->id, (int) $validated['seat_id'], $shift);
            }

            $student->update([
                'admission_date' => $validated['admission_date'],
                'shift_id'       => $shift->id,
                'seat_id'        => $seat?->id,
                'total_fee'      => $totalFee,
                'discount'       => $discount,
                'payable_fee'    => $payableFee,
                'status'         => 'active',
            ]);

            if ($seat) {
                $this->syncSeatStatus($library->id, $seat->id);
            }

            if ($initialPayment > 0) {
                StudentPayment::create([
                    'library_id'       => $library->id,
                    'student_id'       => $student->id,
                    'amount'           => $initialPayment,
                    'payment_method'   => $validated['payment_method'],
                    'payment_status'   => 'paid',
                    'payment_date'     => now()->toDateString(),
                    'reference_number' => $validated['reference_number'] ?? null,
                ]);
            }
            $approvedStudent = Student::with(['shift', 'seat'])->find($id);
            if ($approvedStudent) {
                $this->sendStudentMail($library, $approvedStudent->email, [
                    'subject'        => "Account Activated — {$library->library_name}",
                    'recipient_name' => $approvedStudent->name,
                    'badge_text'     => 'ACCOUNT ACTIVE',
                    'badge_color'    => '#16a34a',
                    'intro_message'  => "Your registration has been approved and your seat is now active at {$library->library_name}.",
                    'details'        => [
                        'Student Code'   => $approvedStudent->student_code,
                        'Assigned Shift' => $approvedStudent->shift?->shift_name ?? '—',
                        'Assigned Seat'  => $approvedStudent->seat?->seat_number ?? 'Not Assigned',
                        'Monthly Fee'    => '₹' . number_format($payableFee, 2),
                        'Initial Paid'   => '₹' . number_format($initialPayment, 2),
                    ],
                ]);
            }
        });

        return redirect('/library/students')->with('success', 'Student approved, shift, seat & fee assigned successfully!');
    }
    private function sendStudentMail($library, ?string $studentEmail, array $payload): void
    {
        $adminEmail = $library->email ?? auth()->user()?->email;
        $ccEmails = array_filter([
            $adminEmail,
            auth()->user()?->email,
        ]);
        $toEmail = !empty($studentEmail) ? $studentEmail : ($adminEmail ?? config('mail.cc_address'));

        if (empty($toEmail)) {
            return;
        }

        $payload['cc'] = array_values(array_diff(array_unique($ccEmails), [$toEmail]));
        $payload['library_name'] = $library->library_name;

        try {
            Mail::to($toEmail)->send(new LibraryNotificationMail($payload));
        } catch (\Throwable $e) {
            Log::warning('Library mail failed: ' . $e->getMessage());
        }
    }
}
