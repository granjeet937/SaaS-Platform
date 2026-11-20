<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use App\Models\Student;
use App\Models\StudentPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $library = $request->user()->library;

        abort_unless($library, 403, 'Library account not found.');

        $students = Student::where('library_id', $library->id)
            ->with('seat')
            ->latest()
            ->paginate(15);

        return view('library.students.stdindex', compact('students'));
    }

    public function create(Request $request)
    {
        $library = $request->user()->library;

        abort_unless($library, 403, 'Library account not found.');

        $seats = Seat::where('library_id', $library->id)
            ->where('status', 'available')
            ->orderBy('seat_number')
            ->get();

        return view('library.students.stdcreate', compact('seats'));
    }

    public function store(Request $request)
    {
        $library = $request->user()->library;

        abort_unless($library, 403, 'Library account not found.');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'mobile' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
            'guardian_name' => ['nullable', 'string', 'max:100'],
            'guardian_mobile' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'admission_date' => ['required', 'date'],
            'seat_id' => ['nullable', 'integer'],
            'total_fee' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'discount' => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'initial_payment' => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'payment_method' => [
                'required',
                'in:cash,upi,card,bank_transfer,other'
            ],
            'reference_number' => ['nullable', 'string', 'max:100'],
        ]);

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
                'initial_payment' => 'Payment cannot exceed payable fee.',
            ]);
        }

        DB::transaction(function () use (
            $validated,
            $library,
            $totalFee,
            $discount,
            $payableFee,
            $initialPayment
        ) {
            $seat = null;

            if (!empty($validated['seat_id'])) {
                $seat = Seat::where('library_id', $library->id)
                    ->where('id', $validated['seat_id'])
                    ->lockForUpdate()
                    ->first();

                if (!$seat || $seat->status !== 'available') {
                    throw ValidationException::withMessages([
                        'seat_id' => 'This seat is no longer available. Please select another seat.',
                    ]);
                }
            }

            $student = Student::create([
                'library_id' => $library->id,
                'student_code' => 'STU-' . strtoupper(Str::random(12)),
                'name' => $validated['name'],
                'mobile' => $validated['mobile'],
                'email' => $validated['email'] ?? null,
                'guardian_name' => $validated['guardian_name'] ?? null,
                'guardian_mobile' => $validated['guardian_mobile'] ?? null,
                'address' => $validated['address'] ?? null,
                'admission_date' => $validated['admission_date'],
                'seat_id' => $seat?->id,
                'total_fee' => $totalFee,
                'discount' => $discount,
                'payable_fee' => $payableFee,
                'status' => 'active',
            ]);

            if ($seat) {
                $seat->update(['status' => 'occupied']);
            }

            if ($initialPayment > 0) {
                StudentPayment::create([
                    'library_id' => $library->id,
                    'student_id' => $student->id,
                    'amount' => $initialPayment,
                    'payment_method' => $validated['payment_method'],
                    'payment_status' => 'paid',
                    'payment_date' => now()->toDateString(),
                    'reference_number' => $validated['reference_number'] ?? null,
                ]);
            }
        });

        return redirect('/library/students')
            ->with('success', 'Student admitted successfully.');
    }
    public function show(Request $request, $id)
    {
        $library = $request->user()->library;

        abort_unless($library, 403, 'Library account not found.');

        $student = Student::where('library_id', $library->id)
            ->with([
                'seat',
                'payments' => function ($query) {
                    $query->orderByDesc('payment_date')->orderByDesc('id');
                },
            ])
            ->findOrFail($id);

        // 30-day cycle calculation from admission_date
        $admissionDate = $student->admission_date
            ? $student->admission_date->copy()->startOfDay()
            : now()->startOfDay();

        $daysElapsed = max(0, (int) $admissionDate->diffInDays(now()->startOfDay(), false));
        $totalMonths = (int) floor($daysElapsed / 30) + 1;

        $monthlyPayable = (float) $student->payable_fee;
        $totalDue = round($totalMonths * $monthlyPayable, 2);

        $totalPaid = (float) $student->payments
            ->where('payment_status', 'paid')
            ->sum('amount');

        $remainingBalance = max(0, round($totalDue - $totalPaid, 2));
        $nextDueDate = $admissionDate->copy()->addDays($totalMonths * 30);

        $availableSeats = Seat::where('library_id', $library->id)
            ->where('status', 'available')
            ->orderBy('seat_number')
            ->get();

        return view('library.students.stdshow', compact(
            'student',
            'totalMonths',
            'monthlyPayable',
            'totalDue',
            'totalPaid',
            'remainingBalance',
            'nextDueDate',
            'availableSeats'
        ));
    }
    public function update(Request $request, $id)
    {
        $library = $request->user()->library;

        abort_unless($library, 403, 'Library account not found.');

        $student = Student::where('library_id', $library->id)->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'mobile' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
            'guardian_name' => ['nullable', 'string', 'max:100'],
            'guardian_mobile' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'admission_date' => ['required', 'date'],
            'total_fee' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'discount' => ['nullable', 'numeric', 'min:0', 'max:99999999'],
        ]);

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

        $student->update([
            'name' => $validated['name'],
            'mobile' => $validated['mobile'],
            'email' => $validated['email'] ?? null,
            'guardian_name' => $validated['guardian_name'] ?? null,
            'guardian_mobile' => $validated['guardian_mobile'] ?? null,
            'address' => $validated['address'] ?? null,
            'admission_date' => $validated['admission_date'],
            'total_fee' => $totalFee,
            'discount' => $discount,
            'payable_fee' => $payableFee,
        ]);

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
                // Deactivate karte waqt assigned seat free kar dein
                if ($student->seat_id) {
                    Seat::where('library_id', $library->id)
                        ->where('id', $student->seat_id)
                        ->update(['status' => 'available']);
                }

                $student->update([
                    'status' => 'inactive',
                    'seat_id' => null,
                ]);

                $message = 'Student deactivated and assigned seat released.';
            } else {
                $student->update([
                    'status' => 'active',
                ]);

                $message = 'Student activated successfully.';
            }
        });

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

            if ($student->seat_id) {
                Seat::where('library_id', $library->id)
                    ->where('id', $student->seat_id)
                    ->update(['status' => 'available']);
            }

            $student->payments()->delete();

            // Student record delete karein
            $student->delete();
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
            'amount' => ['required', 'numeric', 'min:1', 'max:99999999'],
            'payment_method' => ['required', 'in:cash,upi,card,bank_transfer,other'],
            'payment_date' => ['required', 'date'],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        StudentPayment::create([
            'library_id' => $library->id,
            'student_id' => $student->id,
            'amount' => round((float) $validated['amount'], 2),
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'paid',
            'payment_date' => $validated['payment_date'],
            'reference_number' => $validated['reference_number'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->back()
            ->with('success', 'Fee payment of ₹' . number_format((float) $validated['amount'], 2) . ' recorded successfully.');
    }
    public function feesIndex(Request $request)
    {
        $library = $request->user()->library;

        abort_unless($library, 403, 'Library account not found.');

        $search = trim((string) $request->query('search', ''));
        $filter = trim((string) $request->query('filter', 'all')); // all, pending, paid

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
                'student' => $student,
                'totalMonths' => $totalMonths,
                'monthlyPayable' => $monthlyPayable,
                'totalDue' => $totalDue,
                'totalPaid' => $totalPaid,
                'remainingBalance' => $remainingBalance,
                'nextDueDate' => $nextDueDate,
                'isPaid' => $remainingBalance <= 0,
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
            'seat_id' => ['nullable', 'integer'],
        ]);

        $newSeatId = !empty($validated['seat_id']) ? (int) $validated['seat_id'] : null;

        DB::transaction(function () use ($library, $id, $newSeatId) {
            $student = Student::where('library_id', $library->id)
                ->lockForUpdate()
                ->findOrFail($id);

            if ((int) $student->seat_id === (int) $newSeatId) {
                return;
            }

            if ($student->seat_id) {
                Seat::where('library_id', $library->id)
                    ->where('id', $student->seat_id)
                    ->update(['status' => 'available']);
            }

            if ($newSeatId) {
                $newSeat = Seat::where('library_id', $library->id)
                    ->where('id', $newSeatId)
                    ->lockForUpdate()
                    ->first();

                if (!$newSeat || $newSeat->status !== 'available') {
                    throw ValidationException::withMessages([
                        'seat_id' => 'Selected seat is no longer available. Please choose another seat.',
                    ]);
                }

                $newSeat->update(['status' => 'occupied']);
                $student->update(['seat_id' => $newSeat->id]);
            } else {
                $student->update(['seat_id' => null]);
            }
        });

        return redirect('/library/students/view/' . $id)
            ->with('success', $newSeatId ? 'Seat assigned/updated successfully.' : 'Seat released successfully.');
    }
}
