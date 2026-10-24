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
}
