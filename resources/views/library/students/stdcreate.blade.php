@extends('layouts.app')

@section('title', 'LMSP — Library Admin Login')

@section('content')
    <main class="py-5" style="margin-top: 70px;">
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Add New Student</h2>
                    <p class="text-muted mb-0">Admission, seat assignment and fees</p>
                </div>
                <a href="/library/students" class="btn btn-outline-secondary">
                    Back to Students
                </a>
            </div>
            <form method="POST" action="/library/students/store">
                @csrf

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white p-3 fw-bold">
                        Student Details
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Student Name *</label>
                                <input name="name" class="form-control" value="{{ old('name') }}" maxlength="100"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Mobile Number *</label>
                                <input name="mobile" class="form-control" value="{{ old('mobile') }}" maxlength="20"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Admission Date *</label>
                                <input type="date" name="admission_date" class="form-control"
                                    value="{{ old('admission_date', date('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Father / Guardian Name</label>
                                <input name="guardian_name" class="form-control" value="{{ old('guardian_name') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Guardian Mobile</label>
                                <input name="guardian_mobile" class="form-control" value="{{ old('guardian_mobile') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white p-3 fw-bold">
                        Seat Assignment
                    </div>
                    <div class="card-body p-4">
                        <label class="form-label">Available Seat</label>
                        <select name="seat_id" class="form-select">
                            <option value="">No seat assigned</option>
                            @foreach ($seats as $seat)
                                <option value="{{ $seat->id }}" @selected(old('seat_id') == $seat->id)>
                                    {{ $seat->seat_number }}
                                    {{ $seat->section ? ' - ' . $seat->section : '' }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">
                            Only available seats from your library are listed.
                        </small>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white p-3 fw-bold">
                        Fee & Initial Payment
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Total Fee (₹) *</label>
                                <input type="number" min="0" step="0.01" id="total_fee" name="total_fee"
                                    class="form-control" value="{{ old('total_fee', '0.00') }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Discount (₹)</label>
                                <input type="number" min="0" step="0.01" id="discount" name="discount"
                                    class="form-control" value="{{ old('discount', '0.00') }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Payable Fee (₹)</label>
                                <input type="text" id="payable_fee" class="form-control" value="0.00" readonly>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Payment Received Now (₹)</label>
                                <input type="number" min="0" step="0.01" id="initial_payment"
                                    name="initial_payment" class="form-control"
                                    value="{{ old('initial_payment', '0.00') }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Payment Method *</label>
                                <select name="payment_method" class="form-select" required>
                                    <option value="cash" @selected(old('payment_method', 'cash') == 'cash')>Cash</option>
                                    <option value="upi" @selected(old('payment_method') == 'upi')>UPI</option>
                                    <option value="card" @selected(old('payment_method') == 'card')>Card</option>
                                    <option value="bank_transfer" @selected(old('payment_method') == 'bank_transfer')>Bank Transfer</option>
                                    <option value="other" @selected(old('payment_method') == 'other')>Other</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Transaction Reference</label>
                                <input name="reference_number" class="form-control"
                                    value="{{ old('reference_number') }}">
                            </div>

                            <div class="col-12">
                                <div class="alert alert-info mb-0">
                                    Remaining Balance:
                                    <strong>₹<span id="balance">0.00</span></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg">
                    Save Student & Admission
                </button>
                <a href="/library/students" class="btn btn-light btn-lg">Cancel</a>
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const total = document.getElementById('total_fee');
            const discount = document.getElementById('discount');
            const payment = document.getElementById('initial_payment');
            const payable = document.getElementById('payable_fee');
            const balance = document.getElementById('balance');

            function calculateFees() {
                const totalAmount = Math.max(0, Number(total.value) || 0);
                const discountAmount = Math.max(0, Number(discount.value) || 0);
                const payableAmount = Math.max(0, totalAmount - discountAmount);
                const received = Math.max(0, Number(payment.value) || 0);

                payable.value = payableAmount.toFixed(2);
                balance.textContent = Math.max(0, payableAmount - received).toFixed(2);
            }

            [total, discount, payment].forEach(input => {
                input.addEventListener('input', calculateFees);
            });

            calculateFees();
        });
    </script>
@endsection
