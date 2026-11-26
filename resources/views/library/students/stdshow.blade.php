@extends('layouts.library')

@section('title', $student->name . ' — Student Profile')

@section('content')
    @php
        $initials =
            collect(explode(' ', trim($student->name)))
                ->filter()
                ->take(2)
                ->map(fn($p) => strtoupper(substr($p, 0, 1)))
                ->implode('') ?:
            'ST';
    @endphp

    <div class="container-fluid py-3">
        {{-- Top Header Bar --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div class="d-flex align-items-center gap-3">
                @if ($student->photo)
                    <img src="{{ route('students.photo', $student->id) }}" alt="{{ $student->name }}"
                        class="rounded-circle border shadow-sm object-fit-cover flex-shrink-0"
                        style="width: 58px; height: 58px;">
                @else
                    <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center border flex-shrink-0"
                        style="width: 58px; height: 58px; font-size: 1.2rem;">
                        {{ $initials }}
                    </div>
                @endif

                <div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <h4 class="mb-0 fw-bold">{{ $student->name }}</h4>
                        @if ($student->status === 'active')
                            <span class="badge bg-success-subtle text-success border border-success-subtle text-capitalize">
                                {{ $student->status }}
                            </span>
                        @else
                            <span
                                class="badge bg-secondary-subtle text-secondary border border-secondary-subtle text-capitalize">
                                {{ $student->status }}
                            </span>
                        @endif
                        @if ($student->shift)
                            <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle">
                                <i class="fa-regular fa-clock me-1"></i>{{ $student->shift->shift_name }}
                            </span>
                        @endif
                    </div>
                    <p class="text-muted mb-0 small mt-1">
                        Student Code: <strong>{{ $student->student_code }}</strong>
                        &bull; Admitted on:
                        <strong>{{ $student->admission_date ? $student->admission_date->format('d M Y') : '—' }}</strong>
                        &bull; Next Due Date: <strong class="text-primary">{{ $nextDueDate->format('d M Y') }}</strong>
                    </p>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                    data-bs-target="#collectFeeModal">
                    <i class="fa-solid fa-indian-rupee-sign me-1"></i> Collect Fee
                </button>

                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#editStudentModal">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit Profile
                </button>

                <form action="/library/students/toggle-status/{{ $student->id }}" method="POST" class="d-inline"
                    onsubmit="return confirm('{{ $student->status === 'active' ? 'Deactivate this student? Assigned seat will be released automatically.' : 'Activate this student?' }}');">
                    @csrf
                    @if ($student->status === 'active')
                        <button type="submit" class="btn btn-warning btn-sm">
                            <i class="fa-solid fa-user-slash me-1"></i> Deactivate
                        </button>
                    @else
                        <button type="submit" class="btn btn-outline-success btn-sm">
                            <i class="fa-solid fa-user-check me-1"></i> Activate
                        </button>
                    @endif
                </form>

                <form action="/library/students/delete/{{ $student->id }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Are you sure you want to permanently delete this student and all their payment records?');">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fa-solid fa-trash me-1"></i> Delete
                    </button>
                </form>

                <a href="/library/students" class="btn btn-outline-secondary btn-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Students
                </a>
            </div>
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

        {{-- 30-Day Cycle Fee Summary Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body py-3">
                        <div class="text-muted small">Monthly Payable</div>
                        <div class="fs-5 fw-bold text-dark">₹{{ number_format($monthlyPayable, 2) }}</div>
                        <div class="text-muted" style="font-size: 0.72rem;">
                            Fee ₹{{ number_format((float) $student->total_fee, 0) }} - Disc
                            ₹{{ number_format((float) $student->discount, 0) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body py-3">
                        <div class="text-muted small">Active Cycles (30d)</div>
                        <div class="fs-5 fw-bold text-info">{{ $totalMonths }} {{ Str::plural('Month', $totalMonths) }}
                        </div>
                        <div class="text-muted" style="font-size: 0.72rem;">From
                            {{ $student->admission_date ? $student->admission_date->format('d M Y') : '—' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body py-3">
                        <div class="text-muted small">Total Due ({{ $totalMonths }}m)</div>
                        <div class="fs-5 fw-bold text-primary">₹{{ number_format($totalDue, 2) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body py-3">
                        <div class="text-muted small">Total Paid</div>
                        <div class="fs-5 fw-bold text-success">₹{{ number_format($totalPaid, 2) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body py-3">
                        <div class="text-muted small">Remaining Balance</div>
                        <div class="fs-5 fw-bold {{ $remainingBalance > 0 ? 'text-danger' : 'text-success' }}">
                            ₹{{ number_format($remainingBalance, 2) }}
                        </div>
                        <div class="text-muted" style="font-size: 0.72rem;">
                            {{ $remainingBalance > 0 ? 'Pending Dues' : 'All Clear' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Left Column: Shift, Seat & Student Details --}}
            <div class="col-lg-5">
                {{-- Shift & Seat Information Card --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold">
                            <i class="fa-solid fa-chair text-primary me-2"></i>Shift & Seat Allocation
                        </h6>
                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#changeSeatModal">
                            <i class="fa-solid fa-right-left me-1"></i> Change Shift / Seat
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="text-muted small">Assigned Shift</div>
                                @if ($student->shift)
                                    <div class="fw-bold text-dark">{{ $student->shift->shift_name }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">
                                        {{ $student->shift->shift_code }} &bull; {{ $student->shift->duration_hours }} Hrs
                                        @if ($student->shift->start_time && $student->shift->end_time)
                                            <br>{{ \Carbon\Carbon::parse($student->shift->start_time)->format('h:i A') }}
                                            – {{ \Carbon\Carbon::parse($student->shift->end_time)->format('h:i A') }}
                                        @endif
                                    </div>
                                @else
                                    <div class="text-muted fw-semibold">Not Assigned</div>
                                @endif
                            </div>
                            <div class="col-6">
                                <div class="text-muted small">Seat & Section</div>
                                <div class="fw-bold fs-6 {{ $student->seat ? 'text-primary' : 'text-muted' }}">
                                    {{ $student->seat ? $student->seat->seat_number : 'Not Assigned' }}
                                </div>
                                <div class="text-muted" style="font-size: 0.75rem;">
                                    {{ $student->seat && $student->seat->section ? $student->seat->section : 'No Section' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Personal & Guardian Information Card --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="mb-0 fw-bold">
                            <i class="fa-solid fa-user text-primary me-2"></i>Student Profile
                        </h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm mb-0">
                            <tbody>
                                <tr>
                                    <th class="text-muted fw-normal" style="width: 42%;">Student Code</th>
                                    <td class="fw-semibold">{{ $student->student_code }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted fw-normal">Student Name</th>
                                    <td class="fw-semibold">{{ $student->name }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted fw-normal">Mobile</th>
                                    <td>
                                        <a href="tel:{{ $student->mobile }}" class="text-decoration-none text-dark">
                                            {{ $student->mobile }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted fw-normal">Email</th>
                                    <td>{{ $student->email ?: '—' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted fw-normal">Guardian Name</th>
                                    <td>{{ $student->guardian_name ?: '—' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted fw-normal">Guardian Mobile</th>
                                    <td>{{ $student->guardian_mobile ?: '—' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted fw-normal">Admission Date</th>
                                    <td>{{ $student->admission_date ? $student->admission_date->format('d M Y') : '—' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted fw-normal">Status</th>
                                    <td class="text-capitalize">{{ $student->status }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted fw-normal align-top">Address</th>
                                    <td>{{ $student->address ?: '—' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Right Column: Payment History --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold">
                            <i class="fa-solid fa-receipt text-primary me-2"></i>Payment History
                        </h6>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-light text-dark border">
                                {{ $student->payments->count() }} {{ Str::plural('Record', $student->payments->count()) }}
                            </span>
                            <button type="button" class="btn btn-success btn-sm py-0 px-2" data-bs-toggle="modal"
                                data-bs-target="#collectFeeModal">
                                + Add Payment
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">#</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Status</th>
                                        <th>Reference / Notes</th>
                                        <th>Receipt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($student->payments as $index => $payment)
                                        <tr>
                                            <td class="ps-3">{{ $index + 1 }}</td>
                                            <td>
                                                {{ $payment->payment_date ? $payment->payment_date->format('d M Y') : '—' }}
                                            </td>
                                            <td class="fw-semibold text-success">
                                                ₹{{ number_format((float) $payment->amount, 2) }}
                                            </td>
                                            <td class="text-uppercase small">
                                                {{ str_replace('_', ' ', $payment->payment_method) }}
                                            </td>
                                            <td>
                                                @if ($payment->payment_status === 'paid')
                                                    <span
                                                        class="badge bg-success-subtle text-success border border-success-subtle text-capitalize">
                                                        Paid
                                                    </span>
                                                @else
                                                    <span
                                                        class="badge bg-warning-subtle text-warning border border-warning-subtle text-capitalize">
                                                        {{ $payment->payment_status }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="small text-muted">
                                                {{ $payment->reference_number ?: '—' }}
                                                @if ($payment->notes)
                                                    <div class="text-muted fst-italic" style="font-size: 0.75rem;">
                                                        {{ $payment->notes }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="/library/payments/receipt/{{ $payment->id }}" target="_blank"
                                                    class="btn btn-outline-primary btn-sm py-0 px-2"
                                                    title="Print Receipt">
                                                    <i class="fa-solid fa-print"></i>
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
        </div>
    </div>

    {{-- Collect Fee Modal --}}
    <div class="modal fade" id="collectFeeModal" tabindex="-1" aria-labelledby="collectFeeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form action="/library/students/collect-fee/{{ $student->id }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="collectFeeModalLabel">
                            <i class="fa-solid fa-indian-rupee-sign text-success me-2"></i>Collect Fee Payment
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-light border small d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <div>Monthly Fee: <strong>₹{{ number_format($monthlyPayable, 2) }}</strong></div>
                                <div>Pending Balance: <strong
                                        class="{{ $remainingBalance > 0 ? 'text-danger' : 'text-success' }}">₹{{ number_format($remainingBalance, 2) }}</strong>
                                </div>
                            </div>
                            <div class="d-flex flex-column gap-1">
                                @if ($remainingBalance > 0)
                                    <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2 quick-fee-btn"
                                        data-amount="{{ number_format($remainingBalance, 2, '.', '') }}">
                                        Full Due (₹{{ number_format($remainingBalance, 0) }})
                                    </button>
                                @endif
                                <button type="button" class="btn btn-outline-primary btn-sm py-0 px-2 quick-fee-btn"
                                    data-amount="{{ number_format($monthlyPayable, 2, '.', '') }}">
                                    1 Month (₹{{ number_format($monthlyPayable, 0) }})
                                </button>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Amount (₹) <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="1" name="amount"
                                    id="collectAmountInput" class="form-control"
                                    value="{{ $remainingBalance > 0 ? number_format($remainingBalance, 2, '.', '') : number_format($monthlyPayable, 2, '.', '') }}"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Payment Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="payment_date" class="form-control"
                                    value="{{ now()->toDateString() }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Payment Method <span
                                        class="text-danger">*</span></label>
                                <select name="payment_method" class="form-select" required>
                                    <option value="cash">Cash</option>
                                    <option value="upi">UPI</option>
                                    <option value="card">Card</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Reference / Transaction ID</label>
                                <input type="text" name="reference_number" class="form-control" maxlength="100"
                                    placeholder="Optional UTR / Ref">
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-semibold">Notes (e.g. Month Name)</label>
                                <input type="text" name="notes" class="form-control" maxlength="255"
                                    placeholder="e.g. Fee for Cycle {{ $totalMonths }} ({{ $nextDueDate->copy()->subDays(30)->format('d M') }} - {{ $nextDueDate->format('d M') }})">
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

    {{-- Change Shift & Seat Modal --}}
    <div class="modal fade" id="changeSeatModal" tabindex="-1" aria-labelledby="changeSeatModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form action="/library/students/change-seat/{{ $student->id }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="changeSeatModalLabel">
                            <i class="fa-solid fa-right-left text-primary me-2"></i>Change Shift & Seat
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-light border small mb-3">
                            <div>Current Shift: <strong>{{ $student->shift?->shift_name ?? 'Not Assigned' }}</strong></div>
                            <div>
                                Current Seat: <strong>{{ $student->seat?->seat_number ?? 'Not Assigned' }}</strong>
                                @if ($student->seat?->section)
                                    ({{ $student->seat->section }})
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="modalShiftSelect" class="form-label small fw-semibold">
                                Select Shift <span class="text-danger">*</span>
                            </label>
                            <select name="shift_id" id="modalShiftSelect" class="form-select" required>
                                <option value="">-- Choose Shift --</option>
                                @foreach ($shifts as $sh)
                                    <option value="{{ $sh->id }}" data-fee="{{ $sh->monthly_fee }}"
                                        data-duration="{{ $sh->duration_hours }}"
                                        data-start="{{ $sh->start_time ? substr($sh->start_time, 0, 5) : '' }}"
                                        data-end="{{ $sh->end_time ? substr($sh->end_time, 0, 5) : '' }}"
                                        {{ $student->shift_id == $sh->id ? 'selected' : '' }}>
                                        {{ $sh->shift_name }} ({{ $sh->duration_hours }}h -
                                        ₹{{ (int) $sh->monthly_fee }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="seatSelectInput" class="form-label small fw-semibold">
                                Select Seat for Selected Shift
                            </label>
                            <select name="seat_id" id="seatSelectInput" class="form-select">
                                <option value="">-- No Seat / Release Seat --</option>
                                @foreach ($allSeats as $seat)
                                    @php
                                        $others = $seat->activeStudents->where('id', '!=', $student->id);
                                        $usedHrs = $others->sum(fn($s) => $s->shift->duration_hours ?? 0);
                                        $bookedSlots = $others
                                            ->map(
                                                fn($st) => [
                                                    'id' => $st->shift_id,
                                                    'start' => $st->shift?->start_time
                                                        ? substr($st->shift->start_time, 0, 5)
                                                        : null,
                                                    'end' => $st->shift?->end_time
                                                        ? substr($st->shift->end_time, 0, 5)
                                                        : null,
                                                ],
                                            )
                                            ->values();
                                        $isCurrent = $student->seat_id == $seat->id;
                                        $baseLabel =
                                            $seat->seat_number .
                                            ($seat->section ? ' (' . $seat->section . ')' : '') .
                                            ($isCurrent ? ' [Current]' : '') .
                                            ($usedHrs > 0 ? " — {$usedHrs}/24h used" : ' — Empty');
                                    @endphp
                                    <option value="{{ $seat->id }}" data-base-label="{{ $baseLabel }}"
                                        data-used-hours="{{ $usedHrs }}"
                                        data-booked-slots='@json($bookedSlots)'
                                        {{ $isCurrent ? 'selected' : '' }}>
                                        {{ $baseLabel }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">
                                Seats occupied in the selected shift are automatically disabled.
                            </div>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="update_shift_fee" value="1"
                                id="updateShiftFeeCheck">
                            <label class="form-check-label small" for="updateShiftFeeCheck">
                                Also update monthly fee to new shift's rate (<strong
                                    id="modalNewShiftFeePreview">₹{{ number_format((float) ($student->shift?->monthly_fee ?? $student->total_fee), 0) }}</strong>)
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-check me-1"></i> Save Shift & Seat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Student Modal --}}
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form action="/library/students/update/{{ $student->id }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="editStudentModalLabel">
                            <i class="fa-solid fa-user-pen text-primary me-2"></i>Edit Student Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Student Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $student->name) }}" maxlength="100" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Mobile <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="mobile" class="form-control"
                                    value="{{ old('mobile', $student->mobile) }}" maxlength="20" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Shift <span
                                        class="text-danger">*</span></label>
                                <select name="shift_id" id="editShiftSelect" class="form-select" required>
                                    <option value="">-- Choose Shift --</option>
                                    @foreach ($shifts as $sh)
                                        <option value="{{ $sh->id }}" data-fee="{{ $sh->monthly_fee }}"
                                            {{ old('shift_id', $student->shift_id) == $sh->id ? 'selected' : '' }}>
                                            {{ $sh->shift_name }} ({{ $sh->duration_hours }}h -
                                            ₹{{ (int) $sh->monthly_fee }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Admission Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="admission_date" class="form-control"
                                    value="{{ old('admission_date', $student->admission_date ? $student->admission_date->format('Y-m-d') : '') }}"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $student->email) }}" maxlength="100">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Update Photo (Optional)</label>
                                <input type="file" name="photo" class="form-control"
                                    accept="image/png,image/jpeg,image/webp">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Guardian Name</label>
                                <input type="text" name="guardian_name" class="form-control"
                                    value="{{ old('guardian_name', $student->guardian_name) }}" maxlength="100">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Guardian Mobile</label>
                                <input type="text" name="guardian_mobile" class="form-control"
                                    value="{{ old('guardian_mobile', $student->guardian_mobile) }}" maxlength="20">
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-semibold">Address</label>
                                <textarea name="address" class="form-control" rows="2">{{ old('address', $student->address) }}</textarea>
                            </div>

                            <div class="col-12">
                                <hr class="my-1">
                                <div class="small fw-bold text-uppercase text-muted">Monthly Fee Structure (30-Day Cycle)
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Monthly Fee (₹) <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" name="total_fee" id="editTotalFee"
                                    class="form-control" value="{{ old('total_fee', $student->total_fee) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Monthly Discount (₹)</label>
                                <input type="number" step="0.01" min="0" name="discount" id="editDiscount"
                                    class="form-control" value="{{ old('discount', $student->discount) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Monthly Payable (₹)</label>
                                <input type="text" id="editPayablePreview"
                                    class="form-control bg-light fw-bold text-primary"
                                    value="{{ number_format((float) $student->payable_fee, 2, '.', '') }}" readonly>
                                <div class="form-text" style="font-size: 0.72rem;">Already Paid:
                                    ₹{{ number_format($totalPaid, 2) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-check me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const totalInput = document.getElementById('editTotalFee');
            const discountInput = document.getElementById('editDiscount');
            const payablePreview = document.getElementById('editPayablePreview');
            const editShiftSelect = document.getElementById('editShiftSelect');

            function updatePayable() {
                const total = parseFloat(totalInput.value) || 0;
                const discount = parseFloat(discountInput.value) || 0;
                const payable = Math.max(0, total - discount);
                payablePreview.value = payable.toFixed(2);
            }

            if (totalInput && discountInput) {
                totalInput.addEventListener('input', updatePayable);
                discountInput.addEventListener('input', updatePayable);
            }

            if (editShiftSelect && totalInput) {
                editShiftSelect.addEventListener('change', function() {
                    const fee = this.options[this.selectedIndex]?.dataset?.fee;
                    if (fee !== undefined && fee !== '') {
                        totalInput.value = fee;
                        updatePayable();
                    }
                });
            }

            // Live Shift & Seat Filter inside Change Shift/Seat Modal
            const modalShiftSelect = document.getElementById('modalShiftSelect');
            const seatSelectInput = document.getElementById('seatSelectInput');
            const modalFeePreview = document.getElementById('modalNewShiftFeePreview');

            function toMinutes(t) {
                if (!t) return null;
                const [h, m] = t.split(':').map(Number);
                return h * 60 + m;
            }

            function slotsOverlap(s1Start, s1End, s2Start, s2End) {
                const a1 = toMinutes(s1Start),
                    a2 = toMinutes(s1End);
                const b1 = toMinutes(s2Start),
                    b2 = toMinutes(s2End);
                if (a1 === null || a2 === null || b1 === null || b2 === null) return false;

                const segsA = a2 > a1 ? [
                    [a1, a2]
                ] : [
                    [a1, 1440],
                    [0, a2]
                ];
                const segsB = b2 > b1 ? [
                    [b1, b2]
                ] : [
                    [b1, 1440],
                    [0, b2]
                ];

                for (const [x1, x2] of segsA) {
                    for (const [y1, y2] of segsB) {
                        if (x1 < y2 && x2 > y1) return true;
                    }
                }
                return false;
            }

            function filterModalSeats() {
                if (!modalShiftSelect || !seatSelectInput) return;

                const opt = modalShiftSelect.options[modalShiftSelect.selectedIndex];
                const shiftId = opt && opt.value ? parseInt(opt.value, 10) : null;
                const shiftDur = opt ? (parseInt(opt.dataset.duration, 10) || 0) : 0;
                const shiftStart = opt ? (opt.dataset.start || null) : null;
                const shiftEnd = opt ? (opt.dataset.end || null) : null;

                if (modalFeePreview && opt && opt.dataset.fee !== undefined) {
                    modalFeePreview.textContent = '₹' + Math.round(parseFloat(opt.dataset.fee) || 0);
                }

                Array.from(seatSelectInput.options).forEach(seatOpt => {
                    if (!seatOpt.value) return;

                    const baseLabel = seatOpt.dataset.baseLabel;
                    const usedHours = parseInt(seatOpt.dataset.usedHours, 10) || 0;
                    const bookedSlots = JSON.parse(seatOpt.dataset.bookedSlots || '[]');

                    if (!shiftId) {
                        seatOpt.disabled = false;
                        seatOpt.textContent = baseLabel;
                        return;
                    }

                    const sameShift = bookedSlots.some(s => s.id === shiftId);
                    const overlap = bookedSlots.some(s => slotsOverlap(shiftStart, shiftEnd, s.start, s
                        .end));
                    const exceeds = (usedHours + shiftDur) > 24;

                    if (sameShift || overlap || exceeds) {
                        seatOpt.disabled = true;
                        seatOpt.textContent = `${baseLabel} — Unavailable in this shift`;
                        if (seatOpt.selected) seatSelectInput.value = '';
                    } else {
                        seatOpt.disabled = false;
                        seatOpt.textContent = baseLabel;
                    }
                });
            }

            if (modalShiftSelect) {
                modalShiftSelect.addEventListener('change', filterModalSeats);
                filterModalSeats();
            }

            // Quick fill buttons inside Collect Fee Modal
            const collectAmountInput = document.getElementById('collectAmountInput');
            document.querySelectorAll('.quick-fee-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (collectAmountInput) {
                        collectAmountInput.value = this.dataset.amount;
                    }
                });
            });

            @if ($errors->any())
                const editModalEl = document.getElementById('editStudentModal');
                if (editModalEl && typeof bootstrap !== 'undefined') {
                    new bootstrap.Modal(editModalEl).show();
                }
            @endif
        });
    </script>
@endsection
