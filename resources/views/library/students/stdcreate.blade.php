@extends('layouts.library')

@section('title', 'Add New Student — LMSP')

@section('content')
    <div class="container py-2">
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
                <div class="card-header bg-white p-3 fw-bold">Student Details</div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Student Name *</label>
                            <input name="name" class="form-control" value="{{ old('name') }}" maxlength="100" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mobile Number *</label>
                            <input name="mobile" class="form-control" value="{{ old('mobile') }}" maxlength="20" required>
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
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg">Save Student & Admission</button>
            <a href="/library/students" class="btn btn-light btn-lg">Cancel</a>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fee calculation script
            const total = document.getElementById('total_fee');
            const discount = document.getElementById('discount');
            const payment = document.getElementById('initial_payment');
            const payable = document.getElementById('payable_fee');
            const balance = document.getElementById('balance');

            if (total) {
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
            }
        });
    </script>
@endpush
