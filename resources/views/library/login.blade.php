@extends('layouts.app')

@section('title', 'LMSP — Library Admin Login')

@section('content')
    <main class="py-5" style="margin-top: 70px;">
        <div class="container-xxl px-3 px-lg-4">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="card border-0 rounded-4 shadow-lg overflow-hidden">
                        <div class="row g-0">
                            <div
                                class="col-lg-5 p-4 p-md-5 text-white d-none d-lg-flex flex-column justify-content-between bg-dark position-relative">
                                <div>
                                    <span
                                        class="badge bg-white bg-opacity-10 text-info border border-white border-opacity-25 px-3 py-1 rounded-pill small mb-3">
                                        LMSP SECURE LOGIN
                                    </span>

                                    <h2 class="font-head fw-bold mt-2">Welcome back to your study library.</h2>

                                    <p class="text-light text-opacity-75 small mt-3">
                                        Sign in to manage your students, attendance, seats, memberships, fees, and daily
                                        library operations from one powerful dashboard.
                                    </p>

                                    <div class="d-flex flex-column gap-2 mt-4 text-light text-opacity-75 small">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-circle-check text-success"></i>
                                            <span>Manage your complete library from one dashboard.</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-circle-check text-success"></i>
                                            <span>Track student attendance & live seat occupancy.</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-circle-check text-success"></i>
                                            <span>Manage memberships, renewals & pending fees.</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-circle-check text-success"></i>
                                            <span>Access your library securely from anywhere.</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Workspace Features Box -->
                                <div
                                    class="bg-white bg-opacity-10 border border-white border-opacity-10 rounded-3 p-3 mt-4">
                                    <div class="fw-bold small mb-2 text-white">Your LMSP Workspace</div>
                                    <div class="d-flex flex-column gap-2">
                                        <div
                                            class="d-flex align-items-center gap-2 text-light small border-bottom border-white border-opacity-10 pb-2">
                                            <div class="rounded-2 bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center"
                                                style="width: 32px; height: 32px;">
                                                <i class="fa-solid fa-users"></i>
                                            </div>
                                            <span>Students & Profiles</span>
                                        </div>
                                        <div
                                            class="d-flex align-items-center gap-2 text-light small border-bottom border-white border-opacity-10 pb-2">
                                            <div class="rounded-2 bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center"
                                                style="width: 32px; height: 32px;">
                                                <i class="fa-solid fa-calendar-check"></i>
                                            </div>
                                            <span>Attendance & QR Check-in</span>
                                        </div>
                                        <div
                                            class="d-flex align-items-center gap-2 text-light small border-bottom border-white border-opacity-10 pb-2">
                                            <div class="rounded-2 bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center"
                                                style="width: 32px; height: 32px;">
                                                <i class="fa-solid fa-chair"></i>
                                            </div>
                                            <span>Seats & Shift Allotment</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 text-light small">
                                            <div class="rounded-2 bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center"
                                                style="width: 32px; height: 32px;">
                                                <i class="fa-solid fa-wallet"></i>
                                            </div>
                                            <span>Fees & Due Reminders</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Login Form Panel -->
                            <div class="col-lg-7 p-4 p-md-5 bg-white">
                                <div class="mb-4">
                                    <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-1 rounded-pill small">
                                        <i class="fa-solid fa-right-to-bracket me-1"></i> ADMIN LOGIN
                                    </span>
                                    <h1 class="font-head fw-bold mt-2">Welcome <span class="text-primary">Back.</span></h1>
                                    <p class="text-muted small mb-0">Sign in using your registered email address and
                                        password.</p>
                                </div>

                                @if (session('error'))
                                    <div class="alert alert-danger py-2 small rounded-3 mb-3">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <form id="loginForm" method="POST" action="{{ url('/library-loginLMSP') }}" novalidate>
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-secondary">
                                            Email Address <span class="text-danger">*</span>
                                        </label>
                                        <input type="email"
                                            class="form-control form-control-lg fs-6 rounded-3 @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}"
                                            placeholder="owner@example.com" autocomplete="email" required>
                                        <div class="invalid-feedback">
                                            Please enter a valid email address.
                                        </div>
                                        @error('email')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password Input -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label small fw-bold text-secondary mb-0">
                                                Password <span class="text-danger">*</span>
                                            </label>
                                            <a href="{{ url('/forgot-password') }}"
                                                class="small text-primary text-decoration-none fw-bold">
                                                Forgot Password?
                                            </a>
                                        </div>
                                        <div class="input-group">
                                            <input type="password" class="form-control form-control-lg fs-6 rounded-start-3"
                                                id="password" name="password" placeholder="Enter your password"
                                                autocomplete="current-password" minlength="8" required>
                                            <button class="btn btn-outline-secondary border-start-0 rounded-end-3"
                                                type="button" id="togglePassword" aria-label="Show password">
                                                <i class="fa-solid fa-eye text-secondary"></i>
                                            </button>
                                            <div class="invalid-feedback">
                                                Password must contain at least 8 characters.
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Remember Me & Security -->
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                            <label class="form-check-label small text-muted" for="remember">
                                                Remember me
                                            </label>
                                        </div>
                                        <span class="small text-muted">
                                            <i class="fa-solid fa-shield-halved text-success me-1"></i> Secure Login
                                        </span>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 fw-bold">
                                        Sign In to Dashboard <i class="fa-solid fa-arrow-right ms-2"></i>
                                    </button>

                                    <!-- Divider -->
                                    <div class="d-flex align-items-center my-4">
                                        <hr class="flex-grow-1 my-0 text-secondary opacity-25">
                                        <span class="px-3 small text-muted text-uppercase fw-semibold">or</span>
                                        <hr class="flex-grow-1 my-0 text-secondary opacity-25">
                                    </div>

                                    <!-- Registration Link -->
                                    <div class="p-3 bg-light rounded-3 text-center small text-secondary border">
                                        Don't have a library account?
                                        <a href="{{ url('/library-registration') }}"
                                            class="text-primary fw-bold text-decoration-none">Create your library</a>
                                    </div>

                                    <!-- First Time Note -->
                                    <div
                                        class="p-3 rounded-3 mt-3 border border-info-subtle bg-info bg-opacity-10 text-secondary small">
                                        <strong class="d-block text-primary mb-1">
                                            <i class="fa-solid fa-circle-info me-1"></i> First time using LMSP?
                                        </strong>
                                        Register your study library first, configure seats and plans, and then use this
                                        login to access your admin dashboard.
                                    </div>

                                    <div
                                        class="border-top mt-4 pt-3 d-flex justify-content-between align-items-center small text-muted">
                                        <span class="fw-bold text-secondary">
                                            <i class="fa-solid fa-book-open text-primary me-1"></i> LMSP
                                        </span>
                                        <span>&copy; {{ date('Y') }} LMSP · Study Library SaaS</span>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        const form = document.getElementById('loginForm');
        const email = document.getElementById('email');
        const password = document.getElementById('password');

        document.getElementById('togglePassword').addEventListener('click', function() {
            const icon = this.querySelector('i');
            const isPassword = password.type === 'password';
            password.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('fa-eye', !isPassword);
            icon.classList.toggle('fa-eye-slash', isPassword);
        });

        [email, password].forEach(input => {
            input.addEventListener('input', () => {
                input.classList.remove('is-invalid');
            });
        });

        form.addEventListener('submit', function(e) {
            let valid = true;
            const emailValid = email.validity.valid && email.value.trim() !== '';
            const passwordValid = password.value.trim().length >= 8;

            if (!emailValid) {
                email.classList.add('is-invalid');
                valid = false;
            }

            if (!passwordValid) {
                password.classList.add('is-invalid');
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
                document.querySelector('.is-invalid')?.focus();
                return;
            }

            const btn = form.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Signing In...';
        });
    </script>
@endpush
