@extends('layouts.library')

@section('title', 'Add New Student — LMSP')

@section('content')
    <div class="container-fluid px-2 px-md-3 py-2 pb-5 pb-md-3" style="max-width: 960px;">
        {{-- Compact Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold mb-0">New Student Admission</h5>
                <small class="text-muted">Quick setup • 30-day billing cycle</small>
            </div>
            <a href="/library/students" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Back
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show py-2 small" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="/library/students/store" id="admissionForm">
            @csrf

            {{-- 1. Basic Student Info --}}
            <div class="card border-0 shadow-sm rounded-3 mb-3">
                <div class="card-header bg-white py-2 px-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-bold small text-uppercase text-primary">
                        <i class="fa-solid fa-user me-1"></i> 1. Student Details
                    </span>
                    <span class="badge bg-light text-muted border fw-normal">Required</span>
                </div>
                <div class="card-body p-3">
                    <div class="row g-2">
                        <div class="col-12 col-sm-6">
                            <label class="form-label small fw-semibold mb-1">Student Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-sm"
                                value="{{ old('name') }}" placeholder="Full name" maxlength="100" required>
                        </div>

                        <div class="col-12 col-sm-6">
                            <label class="form-label small fw-semibold mb-1">Mobile Number <span
                                    class="text-danger">*</span></label>
                            <input type="tel" name="mobile" class="form-control form-control-sm"
                                value="{{ old('mobile') }}" placeholder="10-digit mobile" maxlength="20" inputmode="tel"
                                required>
                        </div>

                        <div class="col-6 col-sm-6">
                            <label class="form-label small fw-semibold mb-1">Admission Date <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="admission_date" class="form-control form-control-sm"
                                value="{{ old('admission_date', date('Y-m-d')) }}" required>
                        </div>

                        <div class="col-6 col-sm-6">
                            <label class="form-label small fw-semibold mb-1">Assign Seat</label>
                            <select name="seat_id" class="form-select form-select-sm">
                                <option value="">No Seat ({{ $seats->count() }} free)</option>
                                @foreach ($seats as $seat)
                                    <option value="{{ $seat->id }}" {{ old('seat_id') == $seat->id ? 'selected' : '' }}>
                                        {{ $seat->seat_number }}{{ $seat->section ? ' - ' . $seat->section : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Collapsible Guardian & Address --}}
                    <div class="mt-2 pt-2 border-top">
                        <a class="text-decoration-none small fw-semibold text-secondary d-inline-flex align-items-center"
                            data-bs-toggle="collapse" href="#optionalDetailsCollapse" role="button"
                            aria-expanded="{{ old('guardian_name') || old('guardian_mobile') || old('email') || old('address') ? 'true' : 'false' }}">
                            <i class="fa-solid fa-plus-circle me-1 text-primary"></i>
                            Add Email, Guardian & Address (Optional)
                        </a>

                        <div class="collapse {{ old('guardian_name') || old('guardian_mobile') || old('email') || old('address') ? 'show' : '' }} mt-2"
                            id="optionalDetailsCollapse">
                            <div class="row g-2">
                                <div class="col-12 col-sm-4">
                                    <label class="form-label small text-muted mb-1">Email</label>
                                    <input type="email" name="email" class="form-control form-control-sm"
                                        value="{{ old('email') }}" placeholder="student@email.com" maxlength="100">
                                </div>
                                <div class="col-6 col-sm-4">
                                    <label class="form-label small text-muted mb-1">Guardian Name</label>
                                    <input type="text" name="guardian_name" class="form-control form-control-sm"
                                        value="{{ old('guardian_name') }}" placeholder="Parent/Guardian" maxlength="100">
                                </div>
                                <div class="col-6 col-sm-4">
                                    <label class="form-label small text-muted mb-1">Guardian Mobile</label>
                                    <input type="tel" name="guardian_mobile" class="form-control form-control-sm"
                                        value="{{ old('guardian_mobile') }}" placeholder="Guardian phone" maxlength="20"
                                        inputmode="tel">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small text-muted mb-1">Address</label>
                                    <input type="text" name="address" class="form-control form-control-sm"
                                        value="{{ old('address') }}" placeholder="Village / Colony / City">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. Monthly Fee & Payment --}}
            <div class="card border-0 shadow-sm rounded-3 mb-3">
                <div
                    class="card-header bg-white py-2 px-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-bold small text-uppercase text-success">
                        <i class="fa-solid fa-indian-rupee-sign me-1"></i> 2. Fee & Initial Payment
                    </span>
                    <div class="d-flex gap-1">
                        @foreach ([500, 800, 1000, 1200] as $preset)
                            <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2 quick-fee-preset"
                                data-fee="{{ $preset }}" style="font-size: 0.72rem;">
                                ₹{{ $preset }}
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="row g-2 align-items-end">
                        <div class="col-4">
                            <label class="form-label small fw-semibold mb-1">Monthly Fee <span
                                    class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" name="total_fee" id="total_fee"
                                class="form-control form-control-sm fw-bold" value="{{ old('total_fee') }}"
                                placeholder="800" inputmode="decimal" required>
                        </div>

                        <div class="col-4">
                            <label class="form-label small fw-semibold mb-1">Discount</label>
                            <input type="number" step="0.01" min="0" name="discount" id="discount"
                                class="form-control form-control-sm" value="{{ old('discount', 0) }}"
                                inputmode="decimal">
                        </div>

                        <div class="col-4">
                            <label class="form-label small fw-semibold mb-1">Net / Month</label>
                            <input type="text" id="payable_fee"
                                class="form-control form-control-sm bg-light fw-bold text-primary" value="0.00"
                                readonly>
                        </div>

                        <div class="col-12 col-sm-6 mt-2">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label small fw-semibold mb-0">Received Today (₹)</label>
                                <button type="button" id="btnFullPaid"
                                    class="btn btn-link btn-sm p-0 text-decoration-none fw-semibold"
                                    style="font-size: 0.75rem;">
                                    Fill Full Payable
                                </button>
                            </div>
                            <input type="number" step="0.01" min="0" name="initial_payment"
                                id="initial_payment" class="form-control form-control-sm border-success"
                                value="{{ old('initial_payment', 0) }}" inputmode="decimal">
                            <div class="d-flex justify-content-between small mt-1">
                                <span class="text-muted">First Cycle Due:</span>
                                <strong class="text-danger">₹<span id="balance">0.00</span></strong>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 mt-2">
                            <label class="form-label small fw-semibold mb-1">Payment Mode <span
                                    class="text-danger">*</span></label>
                            <div class="btn-group btn-group-sm w-100" role="group">
                                @php $selectedMethod = old('payment_method', 'cash'); @endphp
                                @foreach (['cash' => 'Cash', 'upi' => 'UPI', 'bank_transfer' => 'Bank'] as $val => $label)
                                    <input type="radio" class="btn-check" name="payment_method"
                                        id="pm_{{ $val }}" value="{{ $val }}"
                                        {{ $selectedMethod === $val ? 'checked' : '' }} required>
                                    <label class="btn btn-outline-primary"
                                        for="pm_{{ $val }}">{{ $label }}</label>
                                @endforeach
                            </div>
                            <input type="text" name="reference_number" class="form-control form-control-sm mt-1"
                                value="{{ old('reference_number') }}" maxlength="100"
                                placeholder="UTR / Ref No. (Optional)">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Desktop Submit Bar --}}
            <div class="d-none d-md-flex justify-content-end gap-2 mt-3">
                <a href="/library/students" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary px-4 fw-semibold">
                    <i class="fa-solid fa-check me-1"></i> Save Admission
                </button>
            </div>

            {{-- Mobile Sticky Bottom Bar --}}
            <div class="d-md-none fixed-bottom bg-white border-top p-2 shadow-lg">
                <div class="d-flex gap-2">
                    <a href="/library/students" class="btn btn-light flex-shrink-0">Cancel</a>
                    <button type="submit" class="btn btn-primary w-100 fw-semibold">
                        <i class="fa-solid fa-check me-1"></i> Save Admission
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const total = document.getElementById('total_fee');
            const discount = document.getElementById('discount');
            const payment = document.getElementById('initial_payment');
            const payable = document.getElementById('payable_fee');
            const balance = document.getElementById('balance');
            const btnFullPaid = document.getElementById('btnFullPaid');

            let currentPayable = 0;

            function calculateFees() {
                const totalAmount = Math.max(0, Number(total.value) || 0);
                const discountAmount = Math.max(0, Number(discount.value) || 0);
                currentPayable = Math.max(0, totalAmount - discountAmount);
                const received = Math.max(0, Number(payment.value) || 0);

                payable.value = currentPayable.toFixed(2);
                balance.textContent = Math.max(0, currentPayable - received).toFixed(2);
            }

            if (total) {
                [total, discount, payment].forEach(input => {
                    input.addEventListener('input', calculateFees);
                });

                document.querySelectorAll('.quick-fee-preset').forEach(btn => {
                    btn.addEventListener('click', function() {
                        total.value = this.dataset.fee;
                        calculateFees();
                    });
                });

                if (btnFullPaid) {
                    btnFullPaid.addEventListener('click', function() {
                        payment.value = currentPayable.toFixed(2);
                        calculateFees();
                    });
                }

                calculateFees();
            }
        });
    </script>
@endpush
