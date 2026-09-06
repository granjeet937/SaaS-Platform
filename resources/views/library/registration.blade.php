@extends('layouts.app')

@section('title', 'LMSP — Create Your Study Library')

@section('content')
    <main class="py-5" style="margin-top: 70px;">
        <div class="container-xxl px-3 px-lg-4">
            <div class="row justify-content-center">
                <div class="col-xl-11">
                    <div class="card border-0 rounded-4 shadow-lg overflow-hidden">
                        <div class="row g-0">
                            <div
                                class="col-lg-4 p-4 p-md-5 text-white d-none d-lg-flex flex-column justify-content-between bg-dark position-relative">
                                <div>
                                    <span
                                        class="badge bg-white bg-opacity-10 text-info border border-white border-opacity-25 px-3 py-1 rounded-pill small mb-3">
                                        LMSP ONBOARDING
                                    </span>
                                    <h2 class="font-head fw-bold mt-2">Start managing your library smarter.</h2>

                                    <p class="text-light text-opacity-75 small mt-3">
                                        Create your library account once. After registration, configure seats, membership
                                        plans, students, and shifts directly from your admin panel.
                                    </p>

                                    <div class="d-flex flex-column gap-3 mt-4 text-light text-opacity-75 small">
                                        <div class="d-flex align-items-start gap-2">
                                            <i class="fa-solid fa-circle-check text-success mt-1"></i>
                                            <span>Independent workspace & database for your library.</span>
                                        </div>
                                        <div class="d-flex align-items-start gap-2">
                                            <i class="fa-solid fa-circle-check text-success mt-1"></i>
                                            <span>Shift-wise seat layout & live vacancy tracking.</span>
                                        </div>
                                        <div class="d-flex align-items-start gap-2">
                                            <i class="fa-solid fa-circle-check text-success mt-1"></i>
                                            <span>Flexible plans: monthly, quarterly, & custom terms.</span>
                                        </div>
                                        <div class="d-flex align-items-start gap-2">
                                            <i class="fa-solid fa-circle-check text-success mt-1"></i>
                                            <span>Automated fee expiry reminders & daily collection reports.</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Setup Checklist Box -->
                                <div
                                    class="bg-white bg-opacity-10 border border-white border-opacity-10 rounded-3 p-3 mt-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <strong class="small text-white">Setup Readiness</strong>
                                        <span
                                            class="badge bg-info bg-opacity-25 text-info border border-info border-opacity-25">STEP
                                            1 OF 2</span>
                                    </div>
                                    <div
                                        class="d-flex justify-content-between align-items-center small text-light border-bottom border-white border-opacity-10 pb-2">
                                        <span><i class="fa-solid fa-users me-2 text-info"></i>Students Record</span>
                                        <span class="badge bg-light text-dark">Ready</span>
                                    </div>
                                    <div
                                        class="d-flex justify-content-between align-items-center small text-light border-bottom border-white border-opacity-10 py-2">
                                        <span><i class="fa-solid fa-chair me-2 text-info"></i>Seat Matrix</span>
                                        <span class="badge bg-light text-dark">Auto</span>
                                    </div>
                                    <div
                                        class="d-flex justify-content-between align-items-center small text-light border-bottom border-white border-opacity-10 py-2">
                                        <span><i class="fa-solid fa-calendar-check me-2 text-info"></i>QR Check-in</span>
                                        <span class="badge bg-light text-dark">Instant</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center small text-light pt-2">
                                        <span><i class="fa-solid fa-wallet me-2 text-info"></i>Fees Receipt</span>
                                        <span class="badge bg-light text-dark">Digital</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Form Panel -->
                            <div class="col-lg-8 p-4 p-md-5 bg-white">
                                <div class="mb-4">
                                    <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-1 rounded-pill small">
                                        <i class="fa-solid fa-building me-1"></i> NEW REGISTRATION
                                    </span>
                                    <h1 class="font-head fw-bold mt-2">Library <span class="text-primary">Setup.</span></h1>
                                    <p class="text-muted small mb-0">Enter your library space details and owner credentials
                                        to get started.</p>
                                </div>

                                @if (session('error'))
                                    <div class="alert alert-danger py-2 small rounded-3 mb-3">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <form id="registerForm" method="POST" action="{{ url('/library-registration') }}"
                                    enctype="multipart/form-data" novalidate>
                                    @csrf

                                    <!-- Section 1: Library Details -->
                                    <h6 class="text-primary fw-bold text-uppercase border-bottom pb-2 mb-3 small"
                                        style="letter-spacing: 0.5px;">
                                        1. Library Premises
                                    </h6>
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-secondary">
                                                Library Type <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('library_type') is-invalid @enderror"
                                                name="library_type" required>
                                                <option value="">Select library type...</option>
                                                <option value="Study Library"
                                                    {{ old('library_type') == 'Study Library' ? 'selected' : '' }}>Study
                                                    Library</option>
                                                <option value="Reading Room"
                                                    {{ old('library_type') == 'Reading Room' ? 'selected' : '' }}>Reading
                                                    Room</option>
                                                <option value="Study Center"
                                                    {{ old('library_type') == 'Study Center' ? 'selected' : '' }}>Study
                                                    Center</option>
                                                <option value="Co-Study Space"
                                                    {{ old('library_type') == 'Co-Study Space' ? 'selected' : '' }}>Co-Study
                                                    Space</option>
                                                <option value="Other"
                                                    {{ old('library_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a library type.</div>
                                            @error('library_type')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-secondary">
                                                Library Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control @error('library_name') is-invalid @enderror"
                                                name="library_name" value="{{ old('library_name') }}"
                                                placeholder="e.g. Apex Digital Study Library" required>
                                            <div class="invalid-feedback">Please enter your library name.</div>
                                            @error('library_name')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Logo Upload -->
                                        {{-- <div class="col-12">
                                            <label class="form-label small fw-bold text-secondary">Library Logo
                                                (Optional)</label>
                                            <div
                                                class="p-3 border border-2 border-dashed rounded-3 bg-light d-flex align-items-center gap-3">
                                                <div id="logoPreview"
                                                    class="border rounded-3 bg-white text-secondary d-flex align-items-center justify-content-center overflow-hidden flex-shrink-0"
                                                    style="width: 55px; height: 55px;">
                                                    <i class="fa-solid fa-image fs-4"></i>
                                                    <img id="logoImg" alt="Logo preview"
                                                        class="w-100 h-100 object-fit-cover d-none">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input class="form-control form-control-sm" id="logo"
                                                        name="logo" type="file"
                                                        accept="image/png,image/jpeg,image/webp">
                                                    <div class="text-muted small mt-1" style="font-size: 11px;">PNG, JPG or
                                                        WEBP · Recommended square ratio</div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>

                                    <!-- Section 2: Owner Credentials -->
                                    <h6 class="text-primary fw-bold text-uppercase border-bottom pb-2 mb-3 small"
                                        style="letter-spacing: 0.5px;">
                                        2. Owner Account Credentials
                                    </h6>
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-secondary">
                                                Full Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control @error('owner_name') is-invalid @enderror"
                                                name="owner_name" value="{{ old('owner_name') }}"
                                                placeholder="Enter full name" required>
                                            <div class="invalid-feedback">Please enter owner's name.</div>
                                            @error('owner_name')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-secondary">
                                                Mobile Number <span class="text-danger">*</span>
                                            </label>
                                            <input type="tel"
                                                class="form-control @error('owner_mobile') is-invalid @enderror"
                                                name="owner_mobile" value="{{ old('owner_mobile') }}"
                                                inputmode="numeric" maxlength="10" placeholder="10-digit number"
                                                required>
                                            <div class="invalid-feedback">Enter a valid 10-digit phone number.</div>
                                            @error('owner_mobile')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label small fw-bold text-secondary">
                                                Email Address (Login ID) <span class="text-danger">*</span>
                                            </label>
                                            <input type="email"
                                                class="form-control @error('owner_email') is-invalid @enderror"
                                                name="owner_email" value="{{ old('owner_email') }}"
                                                placeholder="owner@example.com" autocomplete="email" required>
                                            <div class="invalid-feedback">Please enter a valid email address.</div>
                                            @error('owner_email')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-secondary">
                                                Password <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="password" class="form-control rounded-start-3"
                                                    id="password" name="password" minlength="8"
                                                    placeholder="Min. 8 characters" required>
                                                <button
                                                    class="btn btn-outline-secondary border-start-0 rounded-end-3 password-toggle"
                                                    type="button" data-target="password">
                                                    <i class="fa-solid fa-eye text-secondary"></i>
                                                </button>
                                                <div class="invalid-feedback">Password must be at least 8 characters.</div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-secondary">
                                                Confirm Password <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="password" class="form-control rounded-start-3"
                                                    id="confirmPassword" name="confirm_password"
                                                    placeholder="Re-enter password" required>
                                                <button
                                                    class="btn btn-outline-secondary border-start-0 rounded-end-3 password-toggle"
                                                    type="button" data-target="confirmPassword">
                                                    <i class="fa-solid fa-eye text-secondary"></i>
                                                </button>
                                                <div class="invalid-feedback">Passwords do not match.</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section 3: Location -->
                                    <h6 class="text-primary fw-bold text-uppercase border-bottom pb-2 mb-3 small"
                                        style="letter-spacing: 0.5px;">
                                        3. Library Location
                                    </h6>
                                    <div class="row g-3 mb-4">
                                        <div class="col-12">
                                            <label class="form-label small fw-bold text-secondary">
                                                Street Address <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="2"
                                                placeholder="Building, Floor, Near Landmark" required>{{ old('address') }}</textarea>
                                            <div class="invalid-feedback">Please enter library location address.</div>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold text-secondary">
                                                City <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control @error('city') is-invalid @enderror"
                                                name="city" value="{{ old('city') }}" placeholder="City" required>
                                            <div class="invalid-feedback">Please enter city.</div>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold text-secondary">
                                                State <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('state') is-invalid @enderror"
                                                name="state" required>
                                                <option value="">Select state...</option>
                                                <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                <option value="Maharashtra">Maharashtra</option>
                                                <option value="Delhi">Delhi</option>
                                                <option value="Bihar">Bihar</option>
                                                <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                <option value="Rajasthan">Rajasthan</option>
                                                <option value="Gujarat">Gujarat</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <div class="invalid-feedback">Please select state.</div>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold text-secondary">
                                                Pincode <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control @error('pincode') is-invalid @enderror" name="pincode"
                                                inputmode="numeric" maxlength="6" value="{{ old('pincode') }}"
                                                placeholder="6-digit PIN" required>
                                            <div class="invalid-feedback">Enter valid 6-digit pincode.</div>
                                        </div>
                                    </div>

                                    <!-- Section 4: Capacity & Amenities (Using Bootstrap btn-check) -->
                                    <h6 class="text-primary fw-bold text-uppercase border-bottom pb-2 mb-3 small"
                                        style="letter-spacing: 0.5px;">
                                        4. Capacity & Amenities
                                    </h6>
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold text-secondary">
                                                Total Seats <span class="text-danger">*</span>
                                            </label>
                                            <input type="number"
                                                class="form-control @error('total_seats') is-invalid @enderror"
                                                name="total_seats" min="5" placeholder="e.g. 100"
                                                value="{{ old('total_seats') }}" required>
                                            <div class="invalid-feedback">Enter seat capacity.</div>
                                        </div>

                                        <div class="col-md-8">
                                            <label class="form-label small fw-bold text-secondary d-block">Available
                                                Amenities</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <div>
                                                    <input class="btn-check" type="checkbox" id="f1"
                                                        name="facilities[]" value="Wi-Fi">
                                                    <label class="btn btn-outline-secondary btn-sm rounded-3 px-3 py-2"
                                                        for="f1"><i class="fa-solid fa-wifi me-1 text-primary"></i>
                                                        Wi-Fi</label>
                                                </div>
                                                <div>
                                                    <input class="btn-check" type="checkbox" id="f2"
                                                        name="facilities[]" value="AC">
                                                    <label class="btn btn-outline-secondary btn-sm rounded-3 px-3 py-2"
                                                        for="f2"><i
                                                            class="fa-solid fa-snowflake me-1 text-primary"></i> AC</label>
                                                </div>
                                                <div>
                                                    <input class="btn-check" type="checkbox" id="f3"
                                                        name="facilities[]" value="Power Backup">
                                                    <label class="btn btn-outline-secondary btn-sm rounded-3 px-3 py-2"
                                                        for="f3"><i class="fa-solid fa-bolt me-1 text-primary"></i>
                                                        Power Backup</label>
                                                </div>
                                                <div>
                                                    <input class="btn-check" type="checkbox" id="f4"
                                                        name="facilities[]" value="CCTV">
                                                    <label class="btn btn-outline-secondary btn-sm rounded-3 px-3 py-2"
                                                        for="f4"><i class="fa-solid fa-video me-1 text-primary"></i>
                                                        CCTV</label>
                                                </div>
                                                <div>
                                                    <input class="btn-check" type="checkbox" id="f5"
                                                        name="facilities[]" value="Drinking Water">
                                                    <label class="btn btn-outline-secondary btn-sm rounded-3 px-3 py-2"
                                                        for="f5"><i
                                                            class="fa-solid fa-glass-water me-1 text-primary"></i> Water
                                                        Filter</label>
                                                </div>
                                                <div>
                                                    <input class="btn-check" type="checkbox" id="f6"
                                                        name="facilities[]" value="Locker">
                                                    <label class="btn btn-outline-secondary btn-sm rounded-3 px-3 py-2"
                                                        for="f6"><i class="fa-solid fa-lock me-1 text-primary"></i>
                                                        Lockers</label>
                                                </div>
                                                <div>
                                                    <input class="btn-check" type="checkbox" id="f7"
                                                        name="facilities[]" value="Biometric">
                                                    <label class="btn btn-outline-secondary btn-sm rounded-3 px-3 py-2"
                                                        for="f7"><i
                                                            class="fa-solid fa-fingerprint me-1 text-primary"></i>
                                                        Biometric</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Terms & Conditions -->
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" id="terms" required>
                                        <label class="form-check-label small text-muted" for="terms">
                                            I agree to the <a href="#"
                                                class="text-primary text-decoration-none fw-semibold">Terms of Service</a>
                                            and <a href="#"
                                                class="text-primary text-decoration-none fw-semibold">Privacy Policy</a>.
                                        </label>
                                        <div class="invalid-feedback">You must accept the terms before creating the
                                            account.</div>
                                    </div>

                                    <!-- Actions -->
                                    <div
                                        class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                                        <span class="small text-muted">
                                            <i class="fa-solid fa-shield-halved text-success me-1"></i> Data handled
                                            securely under cloud encryption
                                        </span>
                                        <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold px-4">
                                            Create My Library <i class="fa-solid fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>

                                    <div class="p-3 bg-light rounded-3 text-center small text-secondary border mt-4">
                                        Already registered your study center?
                                        <a href="{{ url('/library-login') }}"
                                            class="text-primary fw-bold text-decoration-none">Login here</a>
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
        const form = document.getElementById('registerForm');
        const pwd = document.getElementById('password');
        const cPwd = document.getElementById('confirmPassword');
        const logoInput = document.getElementById('logo');
        const logoImg = document.getElementById('logoImg');
        const logoIcon = document.querySelector('#logoPreview i');

        // Logo Preview logic
        logoInput.addEventListener('change', () => {
            const file = logoInput.files?.[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                logoImg.src = e.target.result;
                logoImg.classList.remove('d-none');
                logoIcon.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        });

        // Password View Toggle
        document.querySelectorAll('.password-toggle').forEach(btn => {
            btn.addEventListener('click', () => {
                const targetInput = document.getElementById(btn.dataset.target);
                const icon = btn.querySelector('i');
                const isPassword = targetInput.type === 'password';
                targetInput.type = isPassword ? 'text' : 'password';
                icon.classList.toggle('fa-eye', !isPassword);
                icon.classList.toggle('fa-eye-slash', isPassword);
            });
        });

        // Native Bootstrap Validation & Helpers
        function validMobile(v) {
            return /^\d{10}$/.test(v);
        }

        function validPin(v) {
            return /^\d{6}$/.test(v);
        }

        // Live validation clean
        form.querySelectorAll('input, select, textarea').forEach(el => {
            el.addEventListener('input', () => el.classList.remove('is-invalid'));
        });

        form.addEventListener('submit', function(e) {
            let valid = true;

            form.querySelectorAll('[required]').forEach(el => {
                let bad = !el.value.trim();
                if (el.type === 'checkbox') bad = !el.checked;
                if (el.name === 'owner_mobile') bad = !validMobile(el.value.trim());
                if (el.name === 'pincode') bad = !validPin(el.value.trim());
                if (el.name === 'password') bad = el.value.length < 8;
                if (el.name === 'confirm_password') bad = el.value !== pwd.value;
                if (el.type === 'email') bad = !el.validity.valid;

                if (bad) {
                    valid = false;
                    el.classList.add('is-invalid');
                } else {
                    el.classList.remove('is-invalid');
                }
            });

            if (!valid) {
                e.preventDefault();
                const first = document.querySelector('.is-invalid');
                first?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                first?.focus();
                return;
            }

            const btn = form.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Registering Library...';
        });
    </script>
@endpush
