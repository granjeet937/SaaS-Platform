@extends('layouts.library')

@section('title', 'Parent Report — ' . $student->name)

@section('content')
    <style>
        @media print {

            .sidebar,
            .topbar,
            .no-print {
                display: none !important;
            }

            .main-content,
            .content-wrapper,
            .container-fluid {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            .card {
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
            }
        }
    </style>

    <div class="container-fluid px-2 px-md-3 py-2" style="max-width: 1000px;">

        {{-- Top Navigation & Print/WhatsApp Actions --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2 no-print">
            <a href="/library/reports?tab=students" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to Student Report
            </a>

            @php
                $waMessage =
                    "Hello! Student Progress & Fee Report for *{$student->name}* ({$library->library_name}):\n" .
                    '• Period: ' .
                    \Carbon\Carbon::parse($fromDate)->format('d M Y') .
                    ' to ' .
                    \Carbon\Carbon::parse($toDate)->format('d M Y') .
                    "\n" .
                    "• Present Days: {$presentCount} | Absent Days: {$absentCount} ({$attendancePercent}%)\n" .
                    '• Total Fee Paid: ₹' .
                    number_format($totalPaid, 0) .
                    "\n" .
                    '• Pending Balance: ₹' .
                    number_format($balanceDue, 0);
                $targetPhone = preg_replace('/\D/', '', (string) ($student->guardian_mobile ?: $student->mobile));
                if (strlen($targetPhone) === 10) {
                    $targetPhone = '91' . $targetPhone;
                }
            @endphp

            <div class="d-flex gap-2">
                @if ($targetPhone)
                    <a href="https://wa.me/{{ $targetPhone }}?text={{ urlencode($waMessage) }}" target="_blank"
                        class="btn btn-success btn-sm">
                        <i class="fa-brands fa-whatsapp me-1"></i> Send to Parent
                    </a>
                @endif
                <button type="button" onclick="window.print()" class="btn btn-dark btn-sm">
                    <i class="fa-solid fa-print me-1"></i> Print Statement
                </button>
            </div>
        </div>

        {{-- Date Filter Bar --}}
        <div class="card border-0 shadow-sm rounded-3 mb-3 no-print">
            <div class="card-body py-2 px-3">
                <form method="GET" action="/library/reports/student/{{ $student->id }}" class="row g-2 align-items-end">
                    <div class="col-5 col-sm-4">
                        <label class="form-label small fw-semibold mb-1">Attendance From</label>
                        <input type="date" name="from_date" class="form-control form-control-sm"
                            value="{{ $fromDate }}">
                    </div>
                    <div class="col-5 col-sm-4">
                        <label class="form-label small fw-semibold mb-1">Attendance To</label>
                        <input type="date" name="to_date" class="form-control form-control-sm"
                            value="{{ $toDate }}">
                    </div>
                    <div class="col-2 col-sm-4">
                        <button type="submit" class="btn btn-primary btn-sm w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Printable Parent Report Sheet --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3">
            {{-- Letterhead --}}
            <div class="bg-primary text-white p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                    <div>
                        <div class="text-uppercase small opacity-75 fw-semibold">Student Attendance & Fee Statement</div>
                        <h4 class="fw-bold mb-1">{{ $library->library_name ?? 'Study Library' }}</h4>
                        <div class="small opacity-75">
                            {{ $library->address ?? '' }}{{ $library->city ? ', ' . $library->city : '' }}
                        </div>
                    </div>
                    <div class="text-sm-end small">
                        <div><strong>Generated:</strong> {{ now()->format('d M Y') }}</div>
                        <div><strong>Period:</strong> {{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }} –
                            {{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                {{-- Student & Guardian Profile Strip --}}
                <div class="row g-3 bg-light rounded-3 p-3 mb-4 border">
                    <div class="col-6 col-md-3">
                        <small class="text-muted d-block">Student Name</small>
                        <strong>{{ $student->name }}</strong>
                        <div class="text-muted small">{{ $student->student_code }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-muted d-block">Guardian / Parent</small>
                        <strong>{{ $student->guardian_name ?: '—' }}</strong>
                        <div class="text-muted small">{{ $student->guardian_mobile ?: $student->mobile }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-muted d-block">Assigned Seat</small>
                        <strong>{{ $student->seat?->seat_number ?? 'Not Assigned' }}</strong>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-muted d-block">Admission Date</small>
                        <strong>{{ $student->admission_date?->format('d M Y') ?? '—' }}</strong>
                    </div>
                </div>

                {{-- Summary KPIs (Attendance + Fees) --}}
                <div class="row g-2 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="border rounded-3 p-3 text-center h-100">
                            <small class="text-muted d-block">Days Present</small>
                            <div class="fw-bold fs-4 text-success">{{ $presentCount }}</div>
                            <small class="text-muted">{{ $attendancePercent }}% regularity</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="border rounded-3 p-3 text-center h-100">
                            <small class="text-muted d-block">Days Absent</small>
                            <div class="fw-bold fs-4 text-danger">{{ $absentCount }}</div>
                            <small class="text-muted">In selected period</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="border rounded-3 p-3 text-center h-100">
                            <small class="text-muted d-block">Total Fee Paid</small>
                            <div class="fw-bold fs-4 text-primary">₹{{ number_format($totalPaid, 0) }}</div>
                            <small class="text-muted">Monthly: ₹{{ number_format($monthlyFee, 0) }}</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="border rounded-3 p-3 text-center h-100">
                            <small class="text-muted d-block">Balance Due</small>
                            <div class="fw-bold fs-4 {{ $balanceDue > 0 ? 'text-danger' : 'text-success' }}">
                                ₹{{ number_format($balanceDue, 0) }}
                            </div>
                            <small class="text-muted">Next due: {{ $nextDueDate->format('d M Y') }}</small>
                        </div>
                    </div>
                </div>

                {{-- Two-Column Detail: Date-wise Attendance + Fee Payment Receipts --}}
                <div class="row g-4">
                    {{-- Left: Date-by-Date Attendance Log --}}
                    <div class="col-12 col-lg-6">
                        <h6 class="fw-bold mb-2">
                            <i class="fa-solid fa-calendar-check text-primary me-1"></i> Date-Wise Attendance Log
                        </h6>
                        <div class="table-responsive border rounded-3">
                            <table class="table table-sm table-striped align-middle mb-0 small">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Date</th>
                                        <th>Day</th>
                                        <th>Status</th>
                                        <th class="pe-3">In / Out Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($attendances as $att)
                                        <tr>
                                            <td class="ps-3 fw-semibold">{{ $att->attendance_date->format('d M Y') }}</td>
                                            <td class="text-muted">{{ $att->attendance_date->format('D') }}</td>
                                            <td>
                                                @if ($att->status === 'present')
                                                    <span class="badge bg-success-subtle text-success">Present</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger">Absent</span>
                                                @endif
                                            </td>
                                            <td class="pe-3 text-muted">
                                                @if ($att->status === 'present')
                                                    {{ $att->check_in_time ? \Carbon\Carbon::parse($att->check_in_time)->format('h:i A') : '—' }}
                                                    @if ($att->check_out_time)
                                                        –
                                                        {{ \Carbon\Carbon::parse($att->check_out_time)->format('h:i A') }}
                                                    @endif
                                                @else
                                                    —
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-3 text-muted">
                                                No attendance marked in this date range.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Right: Fee Payment History --}}
                    <div class="col-12 col-lg-6">
                        <h6 class="fw-bold mb-2">
                            <i class="fa-solid fa-wallet text-success me-1"></i> Fee Payment History
                        </h6>
                        <div class="table-responsive border rounded-3">
                            <table class="table table-sm table-striped align-middle mb-0 small">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Date</th>
                                        <th>Receipt</th>
                                        <th>Mode</th>
                                        <th class="text-end pe-3">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($student->payments as $pay)
                                        <tr>
                                            <td class="ps-3">
                                                {{ \Carbon\Carbon::parse($pay->payment_date)->format('d M Y') }}</td>
                                            <td class="text-muted">
                                                REC-{{ str_pad((string) $pay->id, 5, '0', STR_PAD_LEFT) }}</td>
                                            <td class="text-uppercase">{{ str_replace('_', ' ', $pay->payment_method) }}
                                            </td>
                                            <td class="text-end pe-3 fw-bold text-success">
                                                ₹{{ number_format((float) $pay->amount, 0) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-3 text-muted">
                                                No payments recorded yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
