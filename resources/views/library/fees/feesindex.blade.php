@extends('layouts.library')

@section('content')
<div class="container-fluid py-3">
    {{-- Page Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h4 class="mb-0 fw-bold">Fees & Payments</h4>
            <p class="text-muted small mb-0">Automatic 30-day billing cycle tracking, fee collection, and receipts</p>
        </div>
        <a href="/library/students" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-users me-1"></i> View All Students
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Top Summary Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body py-3">
                    <div class="text-muted small">Today's Collection</div>
                    <div class="fs-4 fw-bold text-primary">₹{{ number_format($todayCollection, 2) }}</div>
                    <div class="text-muted" style="font-size: 0.72rem;">{{ now()->format('d M Y') }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body py-3">
                    <div class="text-muted small">Total Collected</div>
                    <div class="fs-4 fw-bold text-success">₹{{ number_format($totalCollected, 2) }}</div>
                    <div class="text-muted" style="font-size: 0.72rem;">All-time paid fees</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body py-3">
                    <div class="text-muted small">Total Pending Dues</div>
                    <div class="fs-4 fw-bold {{ $totalPendingDues > 0 ? 'text-danger' : 'text-success' }}">
                        ₹{{ number_format($totalPendingDues, 2) }}
                    </div>
                    <div class="text-muted" style="font-size: 0.72rem;">Across active 30d cycles</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body py-3">
                    <div class="text-muted small">Students With Dues</div>
                    <div class="fs-4 fw-bold text-warning">{{ $pendingStudentsCount }}</div>
                    <div class="text-muted" style="font-size: 0.72rem;">Pending fee balance</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Student Fee Ledger Card --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="row g-2 align-items-center">
                <div class="col-md-5">
                    <h6 class="mb-0 fw-bold">
                        <i class="fa-solid fa-wallet text-primary me-2"></i>Student Fee Ledger (30-Day Cycle)
                    </h6>
                </div>
                <div class="col-md-7">
                    <form method="GET" action="/library/fees" class="d-flex flex-wrap justify-content-md-end gap-2">
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="/library/fees?filter=all&search={{ urlencode($search) }}"
                               class="btn {{ $filter === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">All</a>
                            <a href="/library/fees?filter=pending&search={{ urlencode($search) }}"
                               class="btn {{ $filter === 'pending' ? 'btn-danger' : 'btn-outline-danger' }}">Pending</a>
                            <a href="/library/fees?filter=paid&search={{ urlencode($search) }}"
                               class="btn {{ $filter === 'paid' ? 'btn-success' : 'btn-outline-success' }}">Clear</a>
                        </div>

                        <div class="input-group input-group-sm" style="max-width: 240px;">
                            <input type="hidden" name="filter" value="{{ $filter }}">
                            <input type="text" name="search" class="form-control" placeholder="Name, code, mobile..." value="{{ $search }}">
                            <button type="submit" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Student</th>
                            <th>Seat</th>
                            <th>Monthly</th>
                            <th>Cycles</th>
                            <th>Total Due</th>
                            <th>Paid</th>
                            <th>Balance</th>
                            <th>Next Due</th>
                            <th class="text-end pe-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($studentFeeRows as $row)
                            @php $st = $row->student; @endphp
                            <tr>
                                <td class="ps-3">
                                    <a href="/library/students/view/{{ $st->id }}" class="fw-semibold text-decoration-none text-dark">
                                        {{ $st->name }}
                                    </a>
                                    <div class="small text-muted">{{ $st->student_code }} &bull; {{ $st->mobile }}</div>
                                </td>
                                <td>
                                    @if ($st->seat)
                                        <span class="badge bg-light text-dark border">{{ $st->seat->seat_number }}</span>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td>₹{{ number_format($row->monthlyPayable, 0) }}</td>
                                <td>
                                    <span class="badge bg-info-subtle text-info border border-info-subtle">
                                        {{ $row->totalMonths }}m
                                    </span>
                                </td>
                                <td>₹{{ number_format($row->totalDue, 2) }}</td>
                                <td class="text-success fw-semibold">₹{{ number_format($row->totalPaid, 2) }}</td>
                                <td>
                                    @if ($row->remainingBalance > 0)
                                        <span class="fw-bold text-danger">₹{{ number_format($row->remainingBalance, 2) }}</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Clear</span>
                                    @endif
                                </td>
                                <td class="small">{{ $row->nextDueDate->format('d M Y') }}</td>
                                <td class="text-end pe-3">
                                    <div class="d-inline-flex gap-1">
                                        <button type="button"
                                                class="btn btn-success btn-sm py-1 px-2 open-collect-modal"
                                                data-bs-toggle="modal"
                                                data-bs-target="#globalCollectFeeModal"
                                                data-student-id="{{ $st->id }}"
                                                data-student-name="{{ $st->name }}"
                                                data-student-code="{{ $st->student_code }}"
                                                data-monthly="{{ number_format($row->monthlyPayable, 2, '.', '') }}"
                                                data-balance="{{ number_format($row->remainingBalance, 2, '.', '') }}">
                                            <i class="fa-solid fa-indian-rupee-sign me-1"></i> Collect
                                        </button>
                                        <a href="/library/students/view/{{ $st->id }}" class="btn btn-outline-secondary btn-sm py-1 px-2" title="View Profile">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    No student records found for this filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Recent Payments & Receipts Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold">
                <i class="fa-solid fa-receipt text-success me-2"></i>Recent Payments & Receipts
            </h6>
            <span class="badge bg-light text-dark border">Latest {{ $recentPayments->count() }}</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Receipt #</th>
                            <th>Date</th>
                            <th>Student</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Reference / Notes</th>
                            <th class="text-end pe-3">Receipt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentPayments as $payment)
                            <tr>
                                <td class="ps-3 fw-semibold">REC-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="small">{{ $payment->payment_date ? $payment->payment_date->format('d M Y') : '—' }}</td>
                                <td>
                                    @if ($payment->student)
                                        <a href="/library/students/view/{{ $payment->student->id }}" class="fw-semibold text-decoration-none text-dark">
                                            {{ $payment->student->name }}
                                        </a>
                                        <div class="small text-muted">{{ $payment->student->student_code }}</div>
                                    @else
                                        <span class="text-muted">Deleted Student</span>
                                    @endif
                                </td>
                                <td class="fw-bold text-success">₹{{ number_format((float) $payment->amount, 2) }}</td>
                                <td class="text-uppercase small">{{ str_replace('_', ' ', $payment->payment_method) }}</td>
                                <td class="small text-muted">
                                    {{ $payment->reference_number ?: '—' }}
                                    @if ($payment->notes)
                                        <div class="fst-italic" style="font-size: 0.75rem;">{{ $payment->notes }}</div>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <a href="/library/payments/receipt/{{ $payment->id }}" target="_blank" class="btn btn-outline-primary btn-sm py-1 px-2">
                                        <i class="fa-solid fa-print me-1"></i> Print
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
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

{{-- Global Collect Fee Modal --}}
<div class="modal fade" id="globalCollectFeeModal" tabindex="-1" aria-labelledby="globalCollectFeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form id="globalCollectFeeForm" action="" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="globalCollectFeeModalLabel">
                        <i class="fa-solid fa-indian-rupee-sign text-success me-2"></i>Collect Fee Payment
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-light border small d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="fw-bold text-dark" id="modalStudentTitle">Student Name</div>
                            <div>Monthly: <strong id="modalMonthlyText">₹0.00</strong> &bull; Pending: <strong class="text-danger" id="modalBalanceText">₹0.00</strong></div>
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2" id="btnFillFullDue">Full Due</button>
                            <button type="button" class="btn btn-outline-primary btn-sm py-0 px-2" id="btnFillOneMonth">1 Month</button>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Amount (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="1" name="amount" id="globalAmountInput" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Payment Date <span class="text-danger">*</span></label>
                            <input type="date" name="payment_date" class="form-control" value="{{ now()->toDateString() }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Payment Method <span class="text-danger">*</span></label>
                            <select name="payment_method" class="form-select" required>
                                <option value="cash">Cash</option>
                                <option value="upi">UPI</option>
                                <option value="card">Card</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Reference / UTR</label>
                            <input type="text" name="reference_number" class="form-control" maxlength="100" placeholder="Optional">
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-semibold">Notes</label>
                            <input type="text" name="notes" class="form-control" maxlength="255" placeholder="e.g. Monthly fee payment">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-check me-1"></i> Record Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('globalCollectFeeForm');
    const titleEl = document.getElementById('modalStudentTitle');
    const monthlyText = document.getElementById('modalMonthlyText');
    const balanceText = document.getElementById('modalBalanceText');
    const amountInput = document.getElementById('globalAmountInput');
    const btnFullDue = document.getElementById('btnFillFullDue');
    const btnOneMonth = document.getElementById('btnFillOneMonth');

    let currentMonthly = 0;
    let currentBalance = 0;

    document.querySelectorAll('.open-collect-modal').forEach(btn => {
        btn.addEventListener('click', function () {
            const studentId = this.dataset.studentId;
            const studentName = this.dataset.studentName;
            const studentCode = this.dataset.studentCode;
            currentMonthly = parseFloat(this.dataset.monthly) || 0;
            currentBalance = parseFloat(this.dataset.balance) || 0;

            form.action = '/library/students/collect-fee/' + studentId;
            titleEl.textContent = studentName + ' (' + studentCode + ')';
            monthlyText.textContent = '₹' + currentMonthly.toFixed(2);
            balanceText.textContent = '₹' + currentBalance.toFixed(2);

            amountInput.value = (currentBalance > 0 ? currentBalance : currentMonthly).toFixed(2);
            btnFullDue.style.display = currentBalance > 0 ? 'inline-block' : 'none';
        });
    });

    if (btnFullDue) {
        btnFullDue.addEventListener('click', () => {
            amountInput.value = currentBalance.toFixed(2);
        });
    }

    if (btnOneMonth) {
        btnOneMonth.addEventListener('click', () => {
            amountInput.value = currentMonthly.toFixed(2);
        });
    }
});
</script>
@endsection