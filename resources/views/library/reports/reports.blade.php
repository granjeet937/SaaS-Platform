@extends('layouts.library')

@section('title', ($tab === 'payments' ? 'Payment Report' : 'Student Report') . ' — LMSP')

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
                border: 1px solid #dee2e6 !important;
            }

            .print-header {
                display: block !important;
            }
        }

        .print-header {
            display: none;
        }
    </style>

    <div class="container-fluid px-2 px-md-3 py-2" style="max-width: 1200px;">

        {{-- Print-Only Letterhead --}}
        <div class="print-header border-bottom pb-2 mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-0">{{ $library->library_name ?? 'Study Library' }}</h4>
                    <small class="text-muted">{{ $library->address ?? '' }}
                        {{ $library->city ? '• ' . $library->city : '' }}</small>
                </div>
                <div class="text-end">
                    <div class="fw-bold text-uppercase">
                        {{ $tab === 'payments' ? 'Payment Collection Report' : 'Student Admission & Fee Report' }}</div>
                    <small class="text-muted">Period: {{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }} to
                        {{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}</small>
                </div>
            </div>
        </div>

        {{-- Top Header & Export Actions --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2 no-print">
            <div>
                <h5 class="fw-bold mb-0">Reports & Analytics</h5>
                <small class="text-muted">Generate, filter, print or export student & payment ledgers</small>
            </div>

            <div class="d-flex gap-2">
                <a href="/library/reports/export?tab={{ $tab }}&from_date={{ $fromDate }}&to_date={{ $toDate }}&status={{ $status }}&method={{ $method }}&search={{ urlencode($search) }}"
                    class="btn btn-success btn-sm">
                    <i class="fa-solid fa-file-excel me-1"></i> Export Excel (CSV)
                </a>
                <button type="button" onclick="window.print()" class="btn btn-dark btn-sm">
                    <i class="fa-solid fa-print me-1"></i> Print Report
                </button>
            </div>
        </div>

        {{-- Global Tab Switcher --}}
        <ul class="nav nav-pills bg-white p-1 rounded-3 shadow-sm mb-3 d-inline-flex no-print">
            <li class="nav-item">
                <a class="nav-link py-1 px-3 fw-semibold {{ $tab === 'students' ? 'active' : 'text-dark' }}"
                    href="/library/reports?tab=students&from_date={{ $fromDate }}&to_date={{ $toDate }}">
                    <i class="fa-solid fa-users me-1"></i> Student Report
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-1 px-3 fw-semibold {{ $tab === 'payments' ? 'active' : 'text-dark' }}"
                    href="/library/reports?tab=payments&from_date={{ $fromDate }}&to_date={{ $toDate }}">
                    <i class="fa-solid fa-indian-rupee-sign me-1"></i> Payment Report
                </a>
            </li>
        </ul>

        {{-- Filter Bar --}}
        <div class="card border-0 shadow-sm rounded-3 mb-3 no-print">
            <div class="card-body p-3">
                <form method="GET" action="/library/reports" class="row g-2 align-items-end">
                    <input type="hidden" name="tab" value="{{ $tab }}">

                    <div class="col-6 col-md-2">
                        <label class="form-label small fw-semibold mb-1">From Date</label>
                        <input type="date" name="from_date" class="form-control form-control-sm"
                            value="{{ $fromDate }}">
                    </div>

                    <div class="col-6 col-md-2">
                        <label class="form-label small fw-semibold mb-1">To Date</label>
                        <input type="date" name="to_date" class="form-control form-control-sm"
                            value="{{ $toDate }}">
                    </div>

                    @if ($tab === 'students')
                        <div class="col-6 col-md-3">
                            <label class="form-label small fw-semibold mb-1">Student / Fee Status</label>
                            <select name="status" class="form-select form-select-sm">
                                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Students</option>
                                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active Only</option>
                                <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Inactive Only
                                </option>
                                <option value="due" {{ $status === 'due' ? 'selected' : '' }}>Fee Due Pending</option>
                                <option value="clear" {{ $status === 'clear' ? 'selected' : '' }}>Fee Clear (No Due)
                                </option>
                            </select>
                        </div>
                    @else
                        <div class="col-6 col-md-3">
                            <label class="form-label small fw-semibold mb-1">Payment Mode</label>
                            <select name="method" class="form-select form-select-sm">
                                <option value="all" {{ $method === 'all' ? 'selected' : '' }}>All Modes</option>
                                <option value="cash" {{ $method === 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="upi" {{ $method === 'upi' ? 'selected' : '' }}>UPI</option>
                                <option value="card" {{ $method === 'card' ? 'selected' : '' }}>Card</option>
                                <option value="bank_transfer" {{ $method === 'bank_transfer' ? 'selected' : '' }}>Bank
                                    Transfer</option>
                                <option value="other" {{ $method === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    @endif

                    <div class="col-6 col-md-3">
                        <label class="form-label small fw-semibold mb-1">Search</label>
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="Name, code, mobile..." value="{{ $search }}">
                    </div>

                    <div class="col-12 col-md-2 d-flex gap-1">
                        <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold">
                            <i class="fa-solid fa-filter me-1"></i> Generate
                        </button>
                        <a href="/library/reports?tab={{ $tab }}" class="btn btn-outline-secondary btn-sm"
                            title="Reset Filters">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- TAB 1: STUDENT REPORT --}}
        @if ($tab === 'students')
            <div class="row g-2 mb-3">
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm p-3">
                        <small class="text-muted">Students Listed</small>
                        <div class="fw-bold fs-4">{{ $studentSummary['total_count'] }}</div>
                        <small class="text-success">{{ $studentSummary['active_count'] }} active</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm p-3">
                        <small class="text-muted">Monthly Fee Value</small>
                        <div class="fw-bold fs-4 text-primary">
                            ₹{{ number_format($studentSummary['total_monthly_fee'], 0) }}</div>
                        <small class="text-muted">Per 30-day cycle</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm p-3">
                        <small class="text-muted">Total Fee Collected</small>
                        <div class="fw-bold fs-4 text-success">₹{{ number_format($studentSummary['total_collected'], 0) }}
                        </div>
                        <small class="text-muted">From listed students</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm p-3">
                        <small class="text-muted">Pending Dues</small>
                        <div class="fw-bold fs-4 text-danger">₹{{ number_format($studentSummary['total_due'], 0) }}</div>
                        <small class="text-muted">30-day cycle balance</small>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">#</th>
                                    <th>Student</th>
                                    <th>Mobile</th>
                                    <th>Seat</th>
                                    <th>Admission</th>
                                    <th class="text-end">Monthly</th>
                                    <th class="text-end">Paid</th>
                                    <th class="text-end">Balance Due</th>
                                    <th class="text-center">Days Present</th>
                                    <th class="pe-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($studentRows as $index => $row)
                                    <tr>
                                        <td class="ps-3 text-muted">{{ $index + 1 }}</td>
                                        <td>
                                            <a href="/library/students/view/{{ $row->student->id }}"
                                                class="fw-semibold text-decoration-none text-dark">
                                                {{ $row->student->name }}
                                            </a>
                                            <div class="text-muted" style="font-size: 0.72rem;">
                                                {{ $row->student->student_code }}</div>
                                        </td>
                                        <td>{{ $row->student->mobile }}</td>
                                        <td>{{ $row->student->seat ? $row->student->seat->seat_number : '—' }}</td>
                                        <td>{{ $row->student->admission_date ? $row->student->admission_date->format('d M Y') : '—' }}
                                        </td>
                                        <td class="text-end">₹{{ number_format($row->monthly_fee, 0) }}</td>
                                        <td class="text-end text-success fw-semibold">
                                            ₹{{ number_format($row->total_paid, 0) }}</td>
                                        <td
                                            class="text-end fw-bold {{ $row->balance > 0 ? 'text-danger' : 'text-muted' }}">
                                            ₹{{ number_format($row->balance, 0) }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border">{{ $row->present_days }}
                                                d</span>
                                        </td>
                                        <td class="pe-3">
                                            @if ($row->student->status === 'active')
                                                <span class="badge bg-success-subtle text-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-4 text-muted">
                                            No student records found for the selected dates and filter.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        {{-- TAB 2: PAYMENT REPORT --}}
        @if ($tab === 'payments')
            <div class="row g-2 mb-3">
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm p-3">
                        <small class="text-muted">Total Collection</small>
                        <div class="fw-bold fs-4 text-success">₹{{ number_format($paymentSummary['total_amount'], 0) }}
                        </div>
                        <small class="text-muted">{{ $paymentSummary['total_transactions'] }} receipts</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm p-3">
                        <small class="text-muted">Cash Received</small>
                        <div class="fw-bold fs-4 text-dark">₹{{ number_format($paymentSummary['cash_amount'], 0) }}</div>
                        <small class="text-muted">Offline counter</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm p-3">
                        <small class="text-muted">UPI Received</small>
                        <div class="fw-bold fs-4 text-primary">₹{{ number_format($paymentSummary['upi_amount'], 0) }}
                        </div>
                        <small class="text-muted">QR / Online</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm p-3">
                        <small class="text-muted">Card / Bank / Other</small>
                        <div class="fw-bold fs-4 text-secondary">₹{{ number_format($paymentSummary['other_amount'], 0) }}
                        </div>
                        <small class="text-muted">Other modes</small>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Receipt #</th>
                                    <th>Date</th>
                                    <th>Student</th>
                                    <th>Seat</th>
                                    <th>Mode</th>
                                    <th>Ref / UTR</th>
                                    <th class="text-end">Amount</th>
                                    <th class="text-end pe-3 no-print">Receipt</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($paymentRows as $pay)
                                    <tr>
                                        <td class="ps-3 fw-semibold">
                                            REC-{{ str_pad((string) $pay->id, 5, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td>{{ $pay->payment_date ? \Carbon\Carbon::parse($pay->payment_date)->format('d M Y') : '—' }}
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $pay->student->name ?? 'Deleted Student' }}</div>
                                            <div class="text-muted" style="font-size: 0.72rem;">
                                                {{ $pay->student->student_code ?? '' }}</div>
                                        </td>
                                        <td>{{ $pay->student?->seat?->seat_number ?? '—' }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark border text-uppercase">
                                                {{ str_replace('_', ' ', $pay->payment_method) }}
                                            </span>
                                        </td>
                                        <td class="text-muted">{{ $pay->reference_number ?: '—' }}</td>
                                        <td class="text-end fw-bold text-success">
                                            ₹{{ number_format((float) $pay->amount, 2) }}</td>
                                        <td class="text-end pe-3 no-print">
                                            <a href="/library/payments/receipt/{{ $pay->id }}" target="_blank"
                                                class="btn btn-outline-secondary btn-sm py-0 px-2">
                                                <i class="fa-solid fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            No payment transactions found for the selected dates and filter.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection
