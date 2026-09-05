<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LMSP Login - Smart Study Library Management SaaS">
    <title>LMSP — Library Admin Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --navy: #07162e;
            --navy2: #0a3261;
            --blue: #0d7bf3;
            --cyan: #44dfff;
            --ink: #10213d;
            --muted: #6f8299;
            --line: #dce8f7;
            --soft: #f6faff;
        }

        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, system-ui, sans-serif;
            color: var(--ink);
            background: linear-gradient(145deg, #eef7ff, #f9fcff 55%, #eef6ff);
            overflow-x: hidden;
        }

        body::before,
        body::after {
            content: "";
            position: fixed;
            z-index: -2;
            border-radius: 50%;
            filter: blur(8px);
            pointer-events: none;
        }

        body::before {
            width: 430px;
            height: 430px;
            left: -160px;
            top: -140px;
            background: radial-gradient(circle, rgba(20, 128, 246, .18), transparent 68%);
        }

        body::after {
            width: 500px;
            height: 500px;
            right: -210px;
            bottom: -240px;
            background: radial-gradient(circle, rgba(119, 89, 255, .16), transparent 68%);
        }

        a {
            text-decoration: none
        }

        .nav-shell {
            padding-top: 18px;
        }

        .navbar-premium {
            background: rgba(255, 255, 255, .73);
            border: 1px solid rgba(255, 255, 255, .96);
            box-shadow: 0 16px 45px rgba(18, 67, 112, .12);
            backdrop-filter: blur(18px);
            border-radius: 22px;
            padding: 10px 14px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--ink);
        }

        .logo-box {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            color: #fff;
            background: linear-gradient(145deg, #0b63db, #34d5ff);
            box-shadow: 0 10px 24px rgba(13, 123, 243, .25);
        }

        .brand strong {
            font-family: 'Space Grotesk';
            font-size: 21px;
            line-height: 1;
        }

        .brand small {
            display: block;
            color: #7b8da4;
            font-size: 9px;
            font-weight: 700;
            margin-top: 3px;
        }

        .btn-main {
            background: linear-gradient(135deg, #1592ff, #0e66ef);
            color: #fff;
            border: 0;
            font-weight: 800;
            border-radius: 13px;
            padding: .75rem 1.1rem;
            box-shadow: 0 15px 30px rgba(13, 115, 246, .22);
            transition: .25s;
        }

        .btn-main:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 19px 34px rgba(13, 115, 246, .28);
        }

        .btn-ghost {
            border: 1px solid #cfe2f8;
            background: rgba(255, 255, 255, .82);
            color: #0d67dd;
            font-weight: 800;
            border-radius: 13px;
            padding: .75rem 1.1rem;
        }

        .page-wrap {
            padding: 42px 0 70px;
        }

        .login-shell {
            border: 1px solid rgba(210, 228, 244, .88);
            background: rgba(255, 255, 255, .77);
            box-shadow: 0 30px 90px rgba(20, 76, 125, .12);
            backdrop-filter: blur(18px);
            border-radius: 30px;
            overflow: hidden;
        }

        .panel-left {
            background:
                radial-gradient(circle at 84% 12%, rgba(69, 217, 255, .18), transparent 30%),
                radial-gradient(circle at 10% 90%, rgba(121, 93, 255, .16), transparent 28%),
                linear-gradient(145deg, #07162e, #0a3261 62%, #0b76c5);
            color: #fff;
            padding: 48px 40px;
            position: relative;
            overflow: hidden;
        }

        .panel-left::before {
            content: "";
            position: absolute;
            width: 340px;
            height: 340px;
            border-radius: 50%;
            right: -130px;
            top: -140px;
            background: radial-gradient(circle, rgba(70, 225, 255, .22), transparent 65%);
            animation: float 7s ease-in-out infinite;
        }

        .panel-left::after {
            content: "";
            position: absolute;
            width: 270px;
            height: 270px;
            border-radius: 50%;
            left: -130px;
            bottom: -155px;
            background: radial-gradient(circle, rgba(123, 96, 255, .22), transparent 65%);
        }

        .panel-left>* {
            position: relative;
            z-index: 2;
        }

        .panel-kicker {
            font-size: 10px;
            font-weight: 900;
            letter-spacing: 1.4px;
            color: #72e5ff;
            text-transform: uppercase;
        }

        .panel-left h2 {
            font-family: 'Space Grotesk';
            font-size: 38px;
            line-height: 1.05;
            letter-spacing: -1.2px;
            margin: 12px 0 14px;
        }

        .panel-left p {
            color: #d2e5fa;
            line-height: 1.8;
            font-size: 14px;
            max-width: 450px;
        }

        .benefit {
            display: flex;
            gap: 12px;
            margin: 15px 0;
            color: #dfedfb;
            font-size: 13px;
            line-height: 1.55;
        }

        .benefit i {
            color: #55e6b7;
            margin-top: 3px;
        }

        .secure-card {
            margin-top: 30px;
            padding: 18px;
            border-radius: 22px;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .16);
            box-shadow: inset 0 1px rgba(255, 255, 255, .09);
        }

        .secure-item {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, .09);
            color: #e5effa;
            font-size: 11px;
        }

        .secure-item:last-child {
            border-bottom: 0
        }

        .secure-item i {
            width: 30px;
            height: 30px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: rgba(73, 225, 255, .1);
            color: #71eaff;
        }

        .form-panel {
            padding: 48px 46px;
            background: rgba(255, 255, 255, .56);
        }

        .form-head {
            margin-bottom: 28px;
        }

        .form-head .kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 13px;
            border-radius: 999px;
            background: #e9f5ff;
            border: 1px solid #d6ebff;
            color: #0877ef;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: 1px;
        }

        .form-head h1 {
            font-family: 'Space Grotesk';
            font-weight: 700;
            font-size: 42px;
            letter-spacing: -1.5px;
            line-height: 1.04;
            margin: 16px 0 8px;
        }

        .form-head h1 span {
            background: linear-gradient(90deg, #087af0, #8a72ff, #21cfa7);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .form-head p {
            margin: 0;
            color: var(--muted);
            line-height: 1.65;
            font-size: 13px;
        }

        .form-label {
            font-size: 12px;
            font-weight: 800;
            color: #334b67;
            margin-bottom: 7px;
        }

        .form-control {
            height: 49px;
            border-radius: 13px;
            border: 1px solid #d8e6f4;
            background: rgba(255, 255, 255, .88);
            font-size: 13px;
            padding: 0 14px;
            color: #213750;
            box-shadow: 0 6px 18px rgba(26, 87, 137, .03);
            transition: .2s;
        }

        .form-control:focus {
            border-color: #72b7ff;
            box-shadow: 0 0 0 4px rgba(13, 123, 243, .09);
            background: #fff;
        }

        .input-group .btn {
            border-color: #d8e6f4;
        }

        .password-toggle {
            cursor: pointer;
            color: #70849b;
            background: #fff;
        }

        .form-check-label {
            color: #6e839b;
            font-size: 11px;
        }

        .form-check-input {
            margin-top: .18em;
        }

        .form-check-input:checked {
            background-color: var(--blue);
            border-color: var(--blue);
        }

        .forgot {
            color: #0878eb;
            font-size: 11px;
            font-weight: 800;
        }

        .forgot:hover {
            color: #055bb3
        }

        .login-btn {
            min-height: 52px;
            font-size: 14px;
            width: 100%;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 25px 0;
            color: #8ca0b5;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #e0ebf6;
        }

        .register-box {
            border: 1px solid #dce8f5;
            background: rgba(247, 251, 255, .8);
            border-radius: 18px;
            padding: 15px 16px;
            text-align: center;
            font-size: 12px;
            color: #71869e;
        }

        .register-box a {
            color: #0878eb;
            font-weight: 800;
        }

        .demo-box {
            margin-top: 18px;
            padding: 14px 15px;
            border-radius: 16px;
            background: #eff8ff;
            border: 1px solid #d6ecff;
            color: #56718d;
            font-size: 11px;
            line-height: 1.7;
        }

        .error-text {
            display: none;
            margin-top: 6px;
            color: #dc3545;
            font-size: 10px;
        }

        .has-error .error-text {
            display: block
        }

        .has-error .form-control {
            border-color: #dc3545;
        }

        .form-footer {
            border-top: 1px solid #e6eef6;
            margin-top: 25px;
            padding-top: 16px;
            color: #8295a9;
            font-size: 10px;
        }

        .brand-mark-mini {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #66809c;
            font-weight: 800;
        }

        .brand-mark-mini i {
            color: #0b76de
        }

        @keyframes float {
            50% {
                transform: translateY(20px) scale(1.05)
            }
        }

        @media(max-width:991.98px) {
            .page-wrap {
                padding-top: 32px
            }

            .form-panel {
                padding: 34px 30px
            }
        }

        @media(max-width:767.98px) {
            .nav-shell {
                padding-top: 10px
            }

            .navbar-premium {
                border-radius: 18px
            }

            .page-wrap {
                padding: 25px 0 40px
            }

            .login-shell {
                border-radius: 22px
            }

            .panel-left {
                display: none
            }

            .form-panel {
                padding: 28px 20px
            }

            .form-head h1 {
                font-size: 35px
            }
        }

        @media(max-width:420px) {
            .brand small {
                display: none
            }

            .form-head h1 {
                font-size: 31px
            }

            .form-panel {
                padding: 24px 16px
            }

            .login-btn {
                min-height: 49px
            }
        }
    </style>
</head>

<body>
    <main class="page-wrap">
        <div class="container-xxl px-3 px-lg-4">
            <div class="login-shell row g-0">

                <!-- Left panel hidden on mobile/tablet -->
                <div class="col-lg-5 panel-left d-none d-lg-block">
                    <div class="panel-kicker">LMSP SECURE LOGIN</div>

                    <h2>Welcome back to your study library.</h2>

                    <p>
                        Sign in to manage your students, attendance, seats, memberships,
                        fees and daily library operations from one powerful dashboard.
                    </p>

                    <div class="mt-4">
                        <div class="benefit">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Manage your complete library from one dashboard.</span>
                        </div>

                        <div class="benefit">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Track student attendance and live seat occupancy.</span>
                        </div>

                        <div class="benefit">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Manage memberships, renewals and pending fees.</span>
                        </div>

                        <div class="benefit">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Access your library securely from anywhere.</span>
                        </div>
                    </div>

                    <div class="secure-card">
                        <div class="fw-bold mb-1" style="font-size:13px;">Your LMSP Workspace</div>

                        <div class="secure-item">
                            <i class="fa-solid fa-users"></i>
                            <span>Students & Profiles</span>
                        </div>

                        <div class="secure-item">
                            <i class="fa-solid fa-calendar-check"></i>
                            <span>Attendance & Check-in</span>
                        </div>

                        <div class="secure-item">
                            <i class="fa-solid fa-chair"></i>
                            <span>Seats & Rooms</span>
                        </div>

                        <div class="secure-item">
                            <i class="fa-solid fa-wallet"></i>
                            <span>Fees & Memberships</span>
                        </div>
                    </div>
                </div>

                <!-- Login form -->
                <div class="col-lg-7 form-panel">
                    <div class="form-head">
                        <span class="kicker">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            ADMIN LOGIN
                        </span>

                        <h1>Welcome <span>Back.</span></h1>

                        <p>
                            Sign in using your registered email address and password.
                        </p>
                    </div>

                    <form id="loginForm" novalidate>

                        <div class="mb-3">
                            <label class="form-label">
                                Email Address <span class="text-danger">*</span>
                            </label>

                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="owner@example.com" autocomplete="email" required>

                            <div class="error-text" id="emailError">
                                Please enter a valid email address.
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <label class="form-label mb-0">
                                    Password <span class="text-danger">*</span>
                                </label>

                                <a href="/forgot-password" class="forgot">
                                    Forgot Password?
                                </a>
                            </div>

                            <div class="input-group mt-2">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Enter your password" autocomplete="current-password" minlength="8"
                                    required>

                                <button class="btn password-toggle" type="button" id="togglePassword"
                                    aria-label="Show password">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>

                            <div class="error-text" id="passwordError">
                                Password must contain at least 8 characters.
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>

                            <span class="small text-secondary">
                                <i class="fa-solid fa-shield-halved text-success me-1"></i>
                                Secure Login
                            </span>
                        </div>

                        <button type="submit" class="btn btn-main login-btn">
                            Sign In to Dashboard
                            <i class="fa-solid fa-arrow-right ms-2"></i>
                        </button>

                        <div class="divider">or</div>

                        <div class="register-box">
                            Don't have a library account?
                            <a href="/library-registration">Create your library</a>
                        </div>

                        <div class="demo-box">
                            <strong class="d-block mb-1">
                                <i class="fa-solid fa-circle-info me-1 text-primary"></i>
                                First time using LMSP?
                            </strong>
                            Register your study library first, choose your plan, configure seats
                            and memberships, and then use this login to access your dashboard.
                        </div>

                        <div class="form-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <span class="brand-mark-mini">
                                <i class="fa-solid fa-book-open"></i>
                                LMSP
                            </span>
                            <span>© 2026 LMSP · Secure Study Library Management</span>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const form = document.getElementById('loginForm');
        const email = document.getElementById('email');
        const password = document.getElementById('password');

        document.getElementById('togglePassword').addEventListener('click', function () {
            const icon = this.querySelector('i');
            const isPassword = password.type === 'password';

            password.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('fa-eye', !isPassword);
            icon.classList.toggle('fa-eye-slash', isPassword);
        });

        function setError(input, messageId, show) {
            const wrapper = input.closest('.mb-3');
            wrapper.classList.toggle('has-error', show);

            if (show) {
                document.getElementById(messageId).textContent =
                    document.getElementById(messageId).textContent || '';
            }
        }

        [email, password].forEach(input => {
            input.addEventListener('input', () => {
                input.closest('.mb-3').classList.remove('has-error');
            });
        });

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            let valid = true;

            const emailValid = email.validity.valid && email.value.trim() !== '';
            const passwordValid = password.value.trim().length >= 8;

            setError(email, 'emailError', !emailValid);
            setError(password, 'passwordError', !passwordValid);

            if (!emailValid || !passwordValid) {
                valid = false;
            }

            if (!valid) {
                const firstError = document.querySelector('.has-error input');
                firstError?.focus();
                return;
            }

            // Frontend demo only.
            // Replace this section with your Laravel login request.
            const btn = form.querySelector('button[type="submit"]');
            const original = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Signing In...';

            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = original;

                // Example:
                // form.submit();
                // or use fetch('/login', { method: 'POST', body: new FormData(form) })
                alert('Login form is ready. Connect this form with your Laravel authentication route.');
            }, 900);
        });
    </script>

</body>

</html>