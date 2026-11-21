<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\StudentPayment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $library = $request->user()->library;

        abort_unless($library, 403, 'Library account not found.');

        $tab = in_array($request->query('tab'), ['students', 'payments'])
            ? $request->query('tab')
            : 'students';

        $fromDate = $request->query('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->query('to_date', now()->toDateString());
        $status = trim((string) $request->query('status', 'all'));
        $method = trim((string) $request->query('method', 'all'));
        $search = trim((string) $request->query('search', ''));

        $studentRows = collect();
        $studentSummary = [
            'total_count' => 0,
            'active_count' => 0,
            'total_monthly_fee' => 0,
            'total_collected' => 0,
            'total_due' => 0,
        ];

        $paymentRows = collect();
        $paymentSummary = [
            'total_transactions' => 0,
            'total_amount' => 0,
            'cash_amount' => 0,
            'upi_amount' => 0,
            'other_amount' => 0,
        ];

        if ($tab === 'students') {
            $studentRows = $this->buildStudentReport($library->id, $fromDate, $toDate, $status, $search, $studentSummary);
        } else {
            $paymentRows = $this->buildPaymentReport($library->id, $fromDate, $toDate, $method, $search, $paymentSummary);
        }

        return view('library.reports.reports', compact(
            'library',
            'tab',
            'fromDate',
            'toDate',
            'status',
            'method',
            'search',
            'studentRows',
            'studentSummary',
            'paymentRows',
            'paymentSummary'
        ));
    }

    public function exportCsv(Request $request)
    {
        $library = $request->user()->library;

        abort_unless($library, 403, 'Library account not found.');

        $tab = in_array($request->query('tab'), ['students', 'payments'])
            ? $request->query('tab')
            : 'students';

        $fromDate = $request->query('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->query('to_date', now()->toDateString());
        $status = trim((string) $request->query('status', 'all'));
        $method = trim((string) $request->query('method', 'all'));
        $search = trim((string) $request->query('search', ''));

        $filename = "{$tab}_report_{$fromDate}_to_{$toDate}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        if ($tab === 'students') {
            $summary = [];
            $rows = $this->buildStudentReport($library->id, $fromDate, $toDate, $status, $search, $summary);

            $callback = function () use ($rows) {
                $file = fopen('php://output', 'w');
                fputcsv($file, [
                    'Student Code',
                    'Name',
                    'Mobile',
                    'Seat',
                    'Admission Date',
                    'Monthly Fee',
                    'Total Billed (30d)',
                    'Total Paid',
                    'Balance Due',
                    'Next Due Date',
                    'Days Present',
                    'Status'
                ]);

                foreach ($rows as $r) {
                    fputcsv($file, [
                        $r->student->student_code,
                        $r->student->name,
                        $r->student->mobile,
                        $r->student->seat ? $r->student->seat->seat_number : 'Unassigned',
                        $r->student->admission_date ? $r->student->admission_date->format('Y-m-d') : '',
                        $r->monthly_fee,
                        $r->total_due,
                        $r->total_paid,
                        $r->balance,
                        $r->next_due_date->format('Y-m-d'),
                        $r->present_days,
                        ucfirst($r->student->status),
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        $summary = [];
        $rows = $this->buildPaymentReport($library->id, $fromDate, $toDate, $method, $search, $summary);

        $callback = function () use ($rows) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Receipt ID',
                'Payment Date',
                'Student Code',
                'Student Name',
                'Mobile',
                'Seat',
                'Amount',
                'Payment Mode',
                'Reference No.',
                'Status'
            ]);

            foreach ($rows as $pay) {
                fputcsv($file, [
                    'REC-' . str_pad((string) $pay->id, 5, '0', STR_PAD_LEFT),
                    $pay->payment_date ? \Carbon\Carbon::parse($pay->payment_date)->format('Y-m-d') : '',
                    $pay->student->student_code ?? '',
                    $pay->student->name ?? 'Deleted Student',
                    $pay->student->mobile ?? '',
                    $pay->student?->seat?->seat_number ?? '—',
                    $pay->amount,
                    strtoupper(str_replace('_', ' ', $pay->payment_method)),
                    $pay->reference_number ?? '',
                    ucfirst($pay->payment_status),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function buildStudentReport(int $libraryId, string $fromDate, string $toDate, string $status, string $search, array &$summary)
    {
        $today = now()->startOfDay();

        $query = Student::where('library_id', $libraryId)
            ->with(['seat', 'payments' => fn($q) => $q->where('payment_status', 'paid')]);

        if ($fromDate !== '' && $toDate !== '') {
            $query->whereBetween('admission_date', [$fromDate, $toDate]);
        }

        if ($status === 'active' || $status === 'inactive') {
            $query->where('status', $status);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('student_code', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        $students = $query->orderByDesc('admission_date')->orderByDesc('id')->get();

        $attendanceCounts = StudentAttendance::where('library_id', $libraryId)
            ->whereIn('student_id', $students->pluck('id'))
            ->where('status', 'present')
            ->selectRaw('student_id, COUNT(*) as present_count')
            ->groupBy('student_id')
            ->pluck('present_count', 'student_id');

        $rows = $students->map(function ($st) use ($today, $attendanceCounts) {
            $admissionDate = $st->admission_date ? $st->admission_date->copy()->startOfDay() : $today->copy();
            $daysElapsed = max(0, (int) $admissionDate->diffInDays($today, false));
            $totalMonths = (int) floor($daysElapsed / 30) + 1;

            $monthlyFee = (float) $st->payable_fee;
            $totalDue = round($totalMonths * $monthlyFee, 2);
            $totalPaid = (float) $st->payments->sum('amount');
            $balance = max(0, round($totalDue - $totalPaid, 2));
            $nextDueDate = $admissionDate->copy()->addDays($totalMonths * 30);

            return (object) [
                'student' => $st,
                'monthly_fee' => $monthlyFee,
                'total_months' => $totalMonths,
                'total_due' => $totalDue,
                'total_paid' => $totalPaid,
                'balance' => $balance,
                'next_due_date' => $nextDueDate,
                'present_days' => (int) ($attendanceCounts[$st->id] ?? 0),
            ];
        });

        if ($status === 'due') {
            $rows = $rows->filter(fn($r) => $r->balance > 0)->values();
        } elseif ($status === 'clear') {
            $rows = $rows->filter(fn($r) => $r->balance <= 0)->values();
        }

        $summary = [
            'total_count' => $rows->count(),
            'active_count' => $rows->filter(fn($r) => $r->student->status === 'active')->count(),
            'total_monthly_fee' => round($rows->sum('monthly_fee'), 2),
            'total_collected' => round($rows->sum('total_paid'), 2),
            'total_due' => round($rows->sum('balance'), 2),
        ];

        return $rows;
    }

    private function buildPaymentReport(int $libraryId, string $fromDate, string $toDate, string $method, string $search, array &$summary)
    {
        $query = StudentPayment::where('library_id', $libraryId)
            ->where('payment_status', 'paid')
            ->with(['student.seat']);

        if ($fromDate !== '' && $toDate !== '') {
            $query->whereBetween('payment_date', [$fromDate, $toDate]);
        }

        if ($method !== '' && $method !== 'all') {
            $query->where('payment_method', $method);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('reference_number', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($sq) use ($search) {
                        $sq->where('name', 'like', "%{$search}%")
                            ->orWhere('student_code', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%");
                    });
            });
        }

        $payments = $query->orderByDesc('payment_date')->orderByDesc('id')->get();

        $cashAmount = (float) $payments->where('payment_method', 'cash')->sum('amount');
        $upiAmount = (float) $payments->where('payment_method', 'upi')->sum('amount');
        $totalAmount = (float) $payments->sum('amount');

        $summary = [
            'total_transactions' => $payments->count(),
            'total_amount' => round($totalAmount, 2),
            'cash_amount' => round($cashAmount, 2),
            'upi_amount' => round($upiAmount, 2),
            'other_amount' => round(max(0, $totalAmount - ($cashAmount + $upiAmount)), 2),
        ];

        return $payments;
    }
}
