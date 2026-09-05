<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LMSP Library Registration">
    <title>LMSP — Create Your Study Library</title>
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
            --blue: #0d7bf3;
            --cyan: #44dfff;
            --ink: #10213d;
            --muted: #6f8299;
            --line: #dce8f7;
            --soft: #f6faff
        }

        * {
            box-sizing: border-box
        }

        html {
            scroll-behavior: smooth
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, system-ui, sans-serif;
            color: var(--ink);
            background: linear-gradient(145deg, #eef7ff, #f9fcff 55%, #eef6ff);
            overflow-x: hidden
        }

        body:before,
        body:after {
            content: "";
            position: fixed;
            z-index: -2;
            border-radius: 50%;
            filter: blur(8px);
            pointer-events: none
        }

        .before {
            content: ""
        }

        body:before {
            width: 430px;
            height: 430px;
            left: -160px;
            top: -140px;
            background: radial-gradient(circle, rgba(20, 128, 246, .18), transparent 68%)
        }

        body:after {
            width: 500px;
            height: 500px;
            right: -210px;
            bottom: -240px;
            background: radial-gradient(circle, rgba(119, 89, 255, .16), transparent 68%)
        }

        a {
            text-decoration: none
        }

        .nav-shell {
            padding-top: 18px
        }

        .navbar-premium {
            background: rgba(255, 255, 255, .73);
            border: 1px solid rgba(255, 255, 255, .96);
            box-shadow: 0 16px 45px rgba(18, 67, 112, .12);
            backdrop-filter: blur(18px);
            border-radius: 22px;
            padding: 10px 14px
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--ink)
        }

        .logo-box {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            color: #fff;
            background: linear-gradient(145deg, #0b63db, #34d5ff);
            box-shadow: 0 10px 24px rgba(13, 123, 243, .25)
        }

        .brand strong {
            font-family: 'Space Grotesk';
            font-size: 21px;
            line-height: 1
        }

        .brand small {
            display: block;
            color: #7b8da4;
            font-size: 9px;
            font-weight: 700;
            margin-top: 3px
        }

        .btn-main {
            background: linear-gradient(135deg, #1592ff, #0e66ef);
            color: #fff;
            border: 0;
            font-weight: 800;
            border-radius: 13px;
            padding: .75rem 1.1rem;
            box-shadow: 0 15px 30px rgba(13, 115, 246, .22);
            transition: .25s
        }

        .btn-main:hover {
            color: #fff;
            transform: translateY(-2px)
        }

        .btn-ghost {
            border: 1px solid #cfe2f8;
            background: rgba(255, 255, 255, .82);
            color: #0d67dd;
            font-weight: 800;
            border-radius: 13px;
            padding: .75rem 1.1rem
        }

        .page-wrap {
            padding: 42px 0 70px
        }

        .hero-intro {
            text-align: center;
            max-width: 820px;
            margin: 0 auto 34px
        }

        .kicker {
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
            letter-spacing: 1px
        }

        .hero-intro h1 {
            font-family: 'Space Grotesk';
            font-weight: 700;
            font-size: clamp(36px, 5vw, 58px);
            letter-spacing: -2px;
            line-height: 1.03;
            margin: 16px 0 10px
        }

        .hero-intro h1 span {
            background: linear-gradient(90deg, #087af0, #8a72ff, #21cfa7);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent
        }

        .hero-intro p {
            color: var(--muted);
            margin: 0;
            line-height: 1.7
        }

        .register-shell {
            border: 1px solid rgba(210, 228, 244, .88);
            background: rgba(255, 255, 255, .77);
            box-shadow: 0 30px 90px rgba(20, 76, 125, .12);
            backdrop-filter: blur(18px);
            border-radius: 30px;
            overflow: hidden
        }

        .panel-left {
            background: linear-gradient(145deg, #07162e, #0a3261 62%, #0b76c5);
            color: #fff;
            padding: 44px 38px;
            position: relative;
            overflow: hidden
        }

        .panel-left:before {
            content: "";
            position: absolute;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            right: -120px;
            top: -130px;
            background: radial-gradient(circle, rgba(69, 217, 255, .3), transparent 65%);
            animation: float 7s ease-in-out infinite
        }

        .panel-left:after {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            left: -120px;
            bottom: -150px;
            background: radial-gradient(circle, rgba(121, 93, 255, .26), transparent 65%)
        }

        .panel-left>* {
            position: relative;
            z-index: 2
        }

        .panel-left h2 {
            font-family: 'Space Grotesk';
            font-size: 34px;
            line-height: 1.08;
            letter-spacing: -1px
        }

        .panel-left p {
            color: #d2e5fa;
            line-height: 1.75;
            font-size: 14px
        }

        .benefits {
            margin-top: 27px
        }

        .benefit {
            display: flex;
            gap: 12px;
            margin: 15px 0;
            color: #dfedfb;
            font-size: 13px;
            line-height: 1.55
        }

        .benefit i {
            color: #55e6b7;
            margin-top: 3px
        }

        .preview-card {
            margin-top: 30px;
            padding: 18px;
            border-radius: 22px;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .16);
            box-shadow: inset 0 1px rgba(255, 255, 255, .09)
        }

        .mini-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
            padding: 10px 0;
            font-size: 11px
        }

        .mini-row:last-child {
            border-bottom: 0
        }

        .badge-soft {
            background: rgba(70, 225, 255, .14);
            color: #7feaff;
            border: 1px solid rgba(127, 234, 255, .2);
            padding: 5px 8px;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 800
        }

        .form-panel {
            padding: 38px 38px
        }

        .form-title {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 22px
        }

        .form-title h3 {
            font-family: 'Space Grotesk';
            font-size: 29px;
            letter-spacing: -.8px;
            margin: 0
        }

        .form-title p {
            color: var(--muted);
            font-size: 12px;
            margin: 6px 0 0
        }

        .progress-wrap {
            min-width: 150px
        }

        .progress {
            height: 8px;
            background: #eaf2fb;
            border-radius: 999px;
            overflow: hidden
        }

        .progress-bar {
            background: linear-gradient(90deg, #0d7bf3, #48dfff);
            border-radius: 999px
        }

        .section-label {
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 1px;
            color: #1675d9;
            text-transform: uppercase;
            margin: 25px 0 13px
        }

        .form-label {
            font-size: 12px;
            font-weight: 800;
            color: #334b67;
            margin-bottom: 7px
        }

        .form-control,
        .form-select {
            height: 47px;
            border-radius: 13px;
            border: 1px solid #d8e6f4;
            background: rgba(255, 255, 255, .84);
            font-size: 13px;
            padding: 0 14px;
            color: #213750;
            box-shadow: 0 6px 18px rgba(26, 87, 137, .03);
            transition: .2s
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #72b7ff;
            box-shadow: 0 0 0 4px rgba(13, 123, 243, .09);
            background: #fff
        }

        .input-group .btn {
            border-color: #d8e6f4
        }

        .help {
            font-size: 10px;
            color: #8798ac;
            margin-top: 6px
        }

        .logo-upload {
            border: 1.5px dashed #afd2ee;
            background: #f7fbff;
            border-radius: 16px;
            padding: 14px
        }

        .logo-preview {
            width: 68px;
            height: 68px;
            border-radius: 16px;
            border: 1px solid #d8e8f7;
            background: #fff;
            display: grid;
            place-items: center;
            overflow: hidden;
            box-shadow: 0 8px 22px rgba(21, 82, 132, .07)
        }

        .logo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none
        }

        .logo-preview i {
            font-size: 22px;
            color: #6d95bc
        }

        .facility-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px
        }

        .facility {
            position: relative
        }

        .facility input {
            position: absolute;
            opacity: 0
        }

        .facility label {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 11px 12px;
            border: 1px solid #dce8f5;
            border-radius: 12px;
            background: #fff;
            font-size: 11px;
            font-weight: 700;
            color: #536a83;
            cursor: pointer;
            transition: .2s;
            height: 100%
        }

        .facility label i {
            color: #86a0ba
        }

        .facility input:checked+label {
            background: #eef7ff;
            border-color: #86c3ff;
            color: #0c6fdb;
            box-shadow: 0 8px 18px rgba(14, 123, 239, .08)
        }

        .facility input:checked+label i {
            color: #0e7af1
        }

        .terms {
            font-size: 11px;
            color: #768ba2
        }

        .terms a {
            color: #0878eb;
            font-weight: 700
        }

        .submit-row {
            margin-top: 26px;
            padding-top: 20px;
            border-top: 1px solid #e4edf6
        }

        .secure {
            font-size: 10px;
            color: #7890a6
        }

        .secure i {
            color: #11b67a;
            margin-right: 6px
        }

        .library-code {
            display: none;
            margin-top: 18px;
            background: #effcf7;
            border: 1px solid #bfeeda;
            color: #166f52;
            border-radius: 15px;
            padding: 14px;
            font-size: 12px
        }

        .library-code strong {
            font-size: 18px;
            letter-spacing: 1px
        }

        .invalid-msg {
            display: none;
            font-size: 10px;
            color: #dc3545;
            margin-top: 6px
        }

        .was-invalid .invalid-msg {
            display: block
        }

        .was-invalid .form-control,
        .was-invalid .form-select {
            border-color: #dc3545
        }

        .password-toggle {
            cursor: pointer;
            color: #70849b
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

        @keyframes float {
            50% {
                transform: translateY(20px) scale(1.05)
            }
        }

        @media(max-width:991.98px) {
            .page-wrap {
                padding-top: 35px
            }

            .panel-left {
                padding: 34px 28px
            }

            .form-panel {
                padding: 30px 28px
            }

            .facility-grid {
                grid-template-columns: repeat(2, 1fr)
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
                padding: 28px 0 42px
            }

            .hero-intro {
                margin-bottom: 24px
            }

            .hero-intro h1 {
                letter-spacing: -1.2px
            }

            .register-shell {
                border-radius: 22px
            }

            .panel-left {
                padding: 28px 22px
            }

            .panel-left h2 {
                font-size: 28px
            }

            .form-panel {
                padding: 25px 20px
            }

            .form-title {
                display: block
            }

            .progress-wrap {
                margin-top: 15px
            }

            .submit-row .btn {
                width: 100%
            }
        }

        @media(max-width:420px) {
            .brand small {
                display: none
            }

            .facility-grid {
                grid-template-columns: 1fr
            }

            .hero-intro h1 {
                font-size: 36px
            }

            .panel-left h2 {
                font-size: 25px
            }

            .form-title h3 {
                font-size: 24px
            }
        }
    </style>
</head>

<body>
    <main class="page-wrap">
        <div class="container-xxl px-3 px-lg-4">
            <div class="register-shell row g-0">
                <div class="col-lg-4 panel-left d-none d-lg-block">
                    <div class="mb-2 text-uppercase fw-bold" style="font-size:10px;letter-spacing:1.4px;color:#72e5ff">
                        LMSP ONBOARDING</div>
                    <h2 class="mt-2">Start managing your library smarter.</h2>
                    <p class="mt-3">Create your library account once. After registration, you can configure seats,
                        membership plans, students and staff from your own dashboard.</p>
                    <div class="benefits">
                        <div class="benefit"><i class="fa-solid fa-circle-check"></i><span>Separate dashboard and data
                                for your library.</span></div>
                        <div class="benefit"><i class="fa-solid fa-circle-check"></i><span>Manage students, attendance
                                and seat occupancy.</span></div>
                        <div class="benefit"><i class="fa-solid fa-circle-check"></i><span>Create monthly, quarterly,
                                half-yearly and yearly plans.</span></div>
                        <div class="benefit"><i class="fa-solid fa-circle-check"></i><span>Track fees, renewals, reports
                                and daily operations.</span></div>
                    </div>
                    <div class="preview-card">
                        <div class="d-flex justify-content-between align-items-center mb-2"><strong
                                style="font-size:13px">Your Library</strong><span class="badge-soft">READY TO SET
                                UP</span></div>
                        <div class="mini-row"><span><i
                                    class="fa-solid fa-users me-2"></i>Students</span><strong>Manage</strong></div>
                        <div class="mini-row"><span><i
                                    class="fa-solid fa-chair me-2"></i>Seats</span><strong>Configure</strong></div>
                        <div class="mini-row"><span><i
                                    class="fa-solid fa-calendar-check me-2"></i>Attendance</span><strong>Track</strong>
                        </div>
                        <div class="mini-row"><span><i
                                    class="fa-solid fa-wallet me-2"></i>Fees</span><strong>Collect</strong></div>
                    </div>
                </div>

                <div class="col-lg-8 form-panel">
                    <div class="form-title">
                        <div class="hero-intro">
                            <h1>Library <span>Registration.</span></h1>
                            <p>Enter your library and owner details to create your account.</p>
                        </div>
                    </div>

                    <form id="registerForm" novalidate>
                        <div class="section-label">Library Details</div>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Library Type <span
                                        class="text-danger">*</span></label><select class="form-select"
                                    name="library_type" required>
                                    <option value="">Select library type</option>
                                    <option>Study Library</option>
                                    <option>Reading Room</option>
                                    <option>Study Center</option>
                                    <option>Co-Study Space</option>
                                    <option>Other</option>
                                </select>
                                <div class="invalid-msg">Please select a library type.</div>
                            </div>
                            <div class="col-md-6"><label class="form-label">Library Name <span
                                        class="text-danger">*</span></label><input class="form-control"
                                    name="library_name" placeholder="e.g. Riyansh Digital Library" required>
                                <div class="invalid-msg">Please enter library name.</div>
                            </div>
                            <div class="col-12"><label class="form-label">Library Logo</label>
                                <div class="logo-upload d-flex flex-wrap gap-3 align-items-center">
                                    <div class="logo-preview" id="logoPreview"><i class="fa-solid fa-image"></i><img
                                            id="logoImg" alt="Logo preview"></div>
                                    <div class="flex-grow-1"><input class="form-control" id="logo" name="logo"
                                            type="file" accept="image/png,image/jpeg,image/webp">
                                        <div class="help">PNG, JPG or WEBP · Recommended square logo · Optional</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="section-label">Owner Account</div>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Library Owner Name <span
                                        class="text-danger">*</span></label><input class="form-control"
                                    name="owner_name" placeholder="Enter full name" required>
                                <div class="invalid-msg">Please enter owner name.</div>
                            </div>
                            <div class="col-md-6"><label class="form-label">Owner Mobile Number <span
                                        class="text-danger">*</span></label><input class="form-control"
                                    name="owner_mobile" type="tel" inputmode="numeric" maxlength="10"
                                    placeholder="10-digit mobile number" required>
                                <div class="invalid-msg">Enter a valid 10-digit mobile number.</div>
                            </div>
                            <div class="col-md-6"><label class="form-label">Owner Email <span
                                        class="text-danger">*</span></label><input class="form-control"
                                    name="owner_email" type="email" placeholder="owner@example.com" required>
                                <div class="invalid-msg">Please enter a valid email address.</div>
                            </div>
                            <div class="col-md-6"><label class="form-label">Password <span
                                        class="text-danger">*</span></label>
                                <div class="input-group"><input class="form-control" id="password" name="password"
                                        type="password" minlength="8" placeholder="Minimum 8 characters"
                                        required><button class="btn bg-white password-toggle" type="button"
                                        data-target="password" aria-label="Show password"><i
                                            class="fa-solid fa-eye"></i></button></div>
                                <div class="invalid-msg">Password must contain at least 8 characters.</div>
                            </div>
                            <div class="col-md-6"><label class="form-label">Confirm Password <span
                                        class="text-danger">*</span></label>
                                <div class="input-group"><input class="form-control" id="confirmPassword"
                                        name="confirm_password" type="password" placeholder="Re-enter password"
                                        required><button class="btn bg-white password-toggle" type="button"
                                        data-target="confirmPassword" aria-label="Show password"><i
                                            class="fa-solid fa-eye"></i></button></div>
                                <div class="invalid-msg">Passwords do not match.</div>
                            </div>
                        </div>

                        <div class="section-label">Library Address</div>
                        <div class="row g-3">
                            <div class="col-12"><label class="form-label">Address <span
                                        class="text-danger">*</span></label><textarea class="form-control"
                                    name="address" rows="2" style="height:auto;padding-top:12px;padding-bottom:12px"
                                    placeholder="Building, street, landmark" required></textarea>
                                <div class="invalid-msg">Please enter library address.</div>
                            </div>
                            <div class="col-md-4"><label class="form-label">City <span
                                        class="text-danger">*</span></label><input class="form-control" name="city"
                                    placeholder="City" required>
                                <div class="invalid-msg">Please enter city.</div>
                            </div>
                            <div class="col-md-4"><label class="form-label">State <span
                                        class="text-danger">*</span></label><select class="form-select" name="state"
                                    required>
                                    <option value="">Select state</option>
                                    <option>Uttar Pradesh</option>
                                    <option>Maharashtra</option>
                                    <option>Delhi</option>
                                    <option>Bihar</option>
                                    <option>Madhya Pradesh</option>
                                    <option>Rajasthan</option>
                                    <option>Gujarat</option>
                                    <option>Other</option>
                                </select>
                                <div class="invalid-msg">Please select state.</div>
                            </div>
                            <div class="col-md-4"><label class="form-label">Pincode <span
                                        class="text-danger">*</span></label><input class="form-control" name="pincode"
                                    inputmode="numeric" maxlength="6" placeholder="6-digit pincode" required>
                                <div class="invalid-msg">Enter a valid 6-digit pincode.</div>
                            </div>
                        </div>

                        <div class="section-label">Library Setup</div>
                        <div class="row g-3">
                            <div class="col-md-5"><label class="form-label">Total Seats <span
                                        class="text-danger">*</span></label><input class="form-control"
                                    name="total_seats" type="number" min="1" max="100000" placeholder="e.g. 100"
                                    required>
                                <div class="invalid-msg">Enter total number of seats.</div>
                            </div>
                            <div class="col-md-7"><label class="form-label">Available Facilities</label>
                                <div class="facility-grid">
                                    <div class="facility"><input id="f1" type="checkbox" name="facilities[]"
                                            value="Wi-Fi"><label for="f1"><i class="fa-solid fa-wifi"></i>Wi-Fi</label>
                                    </div>
                                    <div class="facility"><input id="f2" type="checkbox" name="facilities[]"
                                            value="AC"><label for="f2"><i class="fa-solid fa-snowflake"></i>AC</label>
                                    </div>
                                    <div class="facility"><input id="f3" type="checkbox" name="facilities[]"
                                            value="CCTV"><label for="f3"><i class="fa-solid fa-video"></i>CCTV</label>
                                    </div>
                                    <div class="facility"><input id="f4" type="checkbox" name="facilities[]"
                                            value="Power Backup"><label for="f4"><i class="fa-solid fa-bolt"></i>Power
                                            Backup</label></div>
                                    <div class="facility"><input id="f5" type="checkbox" name="facilities[]"
                                            value="Parking"><label for="f5"><i
                                                class="fa-solid fa-square-parking"></i>Parking</label></div>
                                    <div class="facility"><input id="f6" type="checkbox" name="facilities[]"
                                            value="Drinking Water"><label for="f6"><i
                                                class="fa-solid fa-glass-water"></i>Drinking Water</label></div>
                                    <div class="facility"><input id="f7" type="checkbox" name="facilities[]"
                                            value="Locker"><label for="f7"><i
                                                class="fa-solid fa-lock"></i>Locker</label></div>
                                    <div class="facility"><input id="f8" type="checkbox" name="facilities[]"
                                            value="Biometric"><label for="f8"><i
                                                class="fa-solid fa-fingerprint"></i>Biometric</label></div>
                                </div>
                            </div>
                        </div>

                        <div class="submit-row">
                            <div class="form-check mb-3"><input class="form-check-input" type="checkbox" id="terms"
                                    required><label class="form-check-label terms" for="terms">I agree to the <a
                                        href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</label>
                                <div class="invalid-msg">Please accept the terms to continue.</div>
                            </div>
                            <div
                                class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                                <div class="secure"><i class="fa-solid fa-shield-halved"></i>Your account information is
                                    securely handled.</div><button class="btn btn-main btn-lg px-4" type="submit">Create
                                    My Library <i class="fa-solid fa-arrow-right ms-2"></i></button>
                            </div>
                            <div class="library-code" id="libraryCode">
                                <div class="small fw-bold mb-1">Registration successful</div>
                                <div>Your Library Code: <strong id="codeValue"></strong></div>
                                <div class="small mt-1">Save this code. You can use it to continue your setup.</div>
                            </div>
                        </div>
                        <div class="register-box mt-3">
                            Already have a library account?
                            <a href="/library-login"> Login to your account</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const form = document.getElementById('registerForm');
        const logoInput = document.getElementById('logo');
        const logoImg = document.getElementById('logoImg');
        const logoIcon = document.querySelector('#logoPreview i');
        logoInput.addEventListener('change', () => { const file = logoInput.files?.[0]; if (!file) return; const reader = new FileReader(); reader.onload = e => { logoImg.src = e.target.result; logoImg.style.display = 'block'; logoIcon.style.display = 'none' }; reader.readAsDataURL(file) });

        document.querySelectorAll('.password-toggle').forEach(btn => btn.addEventListener('click', () => { const input = document.getElementById(btn.dataset.target); const icon = btn.querySelector('i'); const show = input.type === 'password'; input.type = show ? 'text' : 'password'; icon.classList.toggle('fa-eye', !show); icon.classList.toggle('fa-eye-slash', show) }));

        function validMobile(v) { return /^\d{10}$/.test(v) } function validPin(v) { return /^\d{6}$/.test(v) }
        form.addEventListener('submit', e => {
            e.preventDefault(); let valid = true; form.querySelectorAll('[required]').forEach(el => { el.closest('.form-check, .col-md-6, .col-md-4, .col-12')?.classList.remove('was-invalid'); });
            form.querySelectorAll('[required]').forEach(el => { const holder = el.closest('.form-check') || el.closest('.col-md-6') || el.closest('.col-md-5') || el.closest('.col-md-4') || el.closest('.col-12'); let bad = !el.value.trim(); if (el.type === 'checkbox') bad = !el.checked; if (el.name === 'owner_mobile') bad = !validMobile(el.value.trim()); if (el.name === 'pincode') bad = !validPin(el.value.trim()); if (el.name === 'password') bad = el.value.length < 8; if (el.name === 'confirm_password') bad = el.value !== document.getElementById('password').value; if (el.type === 'email') bad = !el.validity.valid; if (bad) { valid = false; holder?.classList.add('was-invalid') } });
            if (!valid) { const first = document.querySelector('.was-invalid'); first?.scrollIntoView({ behavior: 'smooth', block: 'center' }); return; }
            const code = 'LMSP-' + new Date().getFullYear() + '-' + Math.random().toString(36).slice(2, 8).toUpperCase(); document.getElementById('codeValue').textContent = code; document.getElementById('libraryCode').style.display = 'block'; document.getElementById('libraryCode').scrollIntoView({ behavior: 'smooth', block: 'center' });
        });

        form.querySelectorAll('input,select,textarea').forEach(el => el.addEventListener('input', () => { const holder = el.closest('.form-check') || el.closest('.col-md-6') || el.closest('.col-md-5') || el.closest('.col-md-4') || el.closest('.col-12'); holder?.classList.remove('was-invalid') }));
    </script>
</body>

</html>