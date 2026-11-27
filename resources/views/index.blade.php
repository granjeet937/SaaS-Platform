@extends('layouts.app')

@section('title', 'LMSP — Smart Study Library Management SaaS')

@section('content')
    <!-- Hero Section -->
    <header class="hero-section text-white pb-5 position-relative" id="home" style="padding-top: 120px;">
        <div class="container-xxl px-4 px-lg-5 py-1">
            <div class="row align-items-center g-4">
                <div class="col-lg-6 reveal">
                    <div class="badge bg-white bg-opacity-10 border border-white border-opacity-25 px-3 py-1 rounded-pill mb-2"
                        style="font-size: 0.78rem;">
                        <i class="fa-solid fa-wand-magic-sparkles text-info me-1"></i> Built for Study Libraries & Reading
                        Rooms
                    </div>
                    <h1 class="h1 font-head fw-bold lh-sm mb-2" style="font-size: clamp(1.85rem, 2.8vw, 2.55rem);">
                        Manage Your Study Library <span class="gradient-text">Smarter & Better.</span>
                    </h1>
                    <p class="text-light text-opacity-75 mb-3" style="font-size: 0.96rem; line-height: 1.55;">
                        One unified SaaS platform to manage multi-shift seats, student self-registration, kiosk attendance,
                        30-day billing cycles, and fee receipts — from anywhere.
                    </p>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <a href="{{ url('/library-registration') }}" class="btn btn-main px-4 py-2 rounded-3">
                            Start Free Trial <i class="fa-solid fa-arrow-right ms-2"></i>
                        </a>
                        <a href="#features" class="btn btn-outline-light px-4 py-2 rounded-3">
                            <i class="fa-solid fa-layer-group me-2"></i> Explore Features
                        </a>
                    </div>
                    <div class="d-flex flex-wrap gap-3 text-light text-opacity-75" style="font-size: 0.82rem;">
                        <span><i class="fa-solid fa-circle-check text-success me-1"></i> Instant Setup</span>
                        <span><i class="fa-solid fa-circle-check text-success me-1"></i> Multi-Shift Seat Sharing</span>
                        <span><i class="fa-solid fa-circle-check text-success me-1"></i> Cloud Based</span>
                    </div>
                </div>

                <!-- 3D Interactive Scene -->
                <div class="col-lg-6 reveal delay-2">
                    @include('partials.hero_dashboard')
                </div>
            </div>
        </div>
    </header>

    <!-- Highlights Strip -->
    <section class="position-relative">
        <div class="container-xxl px-3 px-lg-5">
            <div class="glass-card shadow-sm rounded-4 p-3 border">
                <div class="row g-3 text-center text-lg-start">
                    <div class="col-6 col-lg border-end border-light-subtle">
                        <h3 class="font-head fw-bold mb-0 text-primary">24-Hr</h3>
                        <small class="text-muted fw-bold">Multi-Shift Seat Matrix</small>
                    </div>
                    <div class="col-6 col-lg border-end border-light-subtle">
                        <h3 class="font-head fw-bold mb-0 text-success">1-Tap</h3>
                        <small class="text-muted fw-bold">Kiosk Self Check-In</small>
                    </div>
                    <div class="col-6 col-lg border-end border-light-subtle">
                        <h3 class="font-head fw-bold mb-0">30-Day</h3>
                        <small class="text-muted fw-bold">Automated Fee Cycles</small>
                    </div>
                    <div class="col-6 col-lg border-end border-light-subtle">
                        <h3 class="font-head fw-bold mb-0">99.9%</h3>
                        <small class="text-muted fw-bold">Cloud Uptime</small>
                    </div>
                    <div class="col-12 col-lg">
                        <h3 class="font-head fw-bold mb-0 text-warning">24×7</h3>
                        <small class="text-muted fw-bold">Mobile & Desktop Access</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="py-4" id="features">
        <div class="container-xxl px-4 px-lg-5 py-2">
            <div class="text-center col-lg-8 mx-auto mb-5 reveal">
                <span
                    class="badge bg-primary-subtle text-primary fw-bold text-uppercase px-3 py-2 rounded-pill small">Features</span>
                <h2 class="display-6 font-head fw-bold mt-2">Everything Your Study Library Needs</h2>
                <p class="text-muted">Built specifically for reading rooms and self-study libraries — not book-lending
                    libraries.
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3 reveal">
                    <div class="card h-100 glass-card rounded-4 p-4 shadow-sm border hover-lift">
                        <div class="rounded-3 bg-info text-white mb-3"
                            style="width:50px;height:50px;display:grid;place-items:center;">
                            <i class="fa-solid fa-chair fs-5"></i>
                        </div>
                        <h5 class="fw-bold">Shift-Wise Seats</h5>
                        <p class="text-muted small mb-0">Allocate the same seat across Morning, Evening, and Night shifts
                            with zero timing overlap.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal">
                    <div class="card h-100 glass-card rounded-4 p-4 shadow-sm border hover-lift">
                        <div class="rounded-3 bg-primary text-white mb-3"
                            style="width:50px;height:50px;display:grid;place-items:center;">
                            <i class="fa-solid fa-tablet-screen-button fs-5"></i>
                        </div>
                        <h5 class="fw-bold">Self-Attendance Kiosk</h5>
                        <p class="text-muted small mb-0">Password-locked tablet kiosk mode where students punch in/out
                            using their mobile digits.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal">
                    <div class="card h-100 glass-card rounded-4 p-4 shadow-sm border hover-lift">
                        <div class="rounded-3 bg-success text-white mb-3"
                            style="width:50px;height:50px;display:grid;place-items:center;">
                            <i class="fa-solid fa-link fs-5"></i>
                        </div>
                        <h5 class="fw-bold">Online Self-Registration</h5>
                        <p class="text-muted small mb-0">Share a unique admission link on WhatsApp so students submit
                            forms & photos before arriving.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal">
                    <div class="card h-100 glass-card rounded-4 p-4 shadow-sm border hover-lift">
                        <div class="rounded-3 bg-warning text-white mb-3"
                            style="width:50px;height:50px;display:grid;place-items:center;">
                            <i class="fa-solid fa-indian-rupee-sign fs-5"></i>
                        </div>
                        <h5 class="fw-bold">30-Day Fees & Receipts</h5>
                        <p class="text-muted small mb-0">Automatic 30-day cycle dues tracking, printable receipts, and
                            instant email confirmations.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Us Section (Replaced Empty Placeholder with Live Product Preview Card) -->
    <section class="py-4 bg-soft">
        <div class="container-xxl px-4 px-lg-5 py-2">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 reveal">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                            <div>
                                <span class="badge bg-primary-subtle text-primary fw-bold">SMART SEAT MATRIX</span>
                                <h6 class="fw-bold mb-0 mt-1">Seat #LIB1-04 — 24 Hour Utilization</h6>
                            </div>
                            <span class="badge bg-success-subtle text-success rounded-pill px-3">24/24 Hrs Filled</span>
                        </div>

                        <div class="d-flex flex-column gap-2">
                            <div class="p-3 rounded-3 border bg-light d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold small text-dark">Morning Slot (06:00 AM – 02:00 PM)</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">Rahul Sharma &bull; STU-RSH01
                                    </div>
                                </div>
                                <span class="badge bg-primary">8 Hrs</span>
                            </div>

                            <div class="p-3 rounded-3 border bg-light d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold small text-dark">Evening Slot (02:00 PM – 10:00 PM)</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">Priya Verma &bull; STU-PVR02</div>
                                </div>
                                <span class="badge bg-info text-dark">8 Hrs</span>
                            </div>

                            <div class="p-3 rounded-3 border bg-light d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold small text-dark">Night Slot (10:00 PM – 06:00 AM)</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">Amit Patel &bull; STU-APT03</div>
                                </div>
                                <span class="badge bg-dark">8 Hrs</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 reveal">
                    <span
                        class="badge bg-primary-subtle text-primary fw-bold text-uppercase px-3 py-2 rounded-pill small">Why
                        LMSP</span>
                    <h3 class="display-6 font-head fw-bold mt-2">Maximize Revenue From Every Single Seat.</h3>
                    <p class="text-muted">Stop managing physical registers and spreadsheets separately. Bring your
                        shifts, seat allocations, attendance, and fee cycles into one unified cloud dashboard.</p>
                    <div class="d-flex flex-column gap-2 mt-3 text-secondary small fw-semibold">
                        <div><i class="fa-solid fa-circle-check text-success me-2"></i> Conflict-free shift & seat
                            allocation (supports midnight-crossing shifts)</div>
                        <div><i class="fa-solid fa-circle-check text-success me-2"></i> Admin-locked Kiosk Mode with
                            off-shift punch warnings</div>
                        <div><i class="fa-solid fa-circle-check text-success me-2"></i> Automatic email notifications for
                            admissions, approvals & fee payments</div>
                        <div><i class="fa-solid fa-circle-check text-success me-2"></i> Filterable Student & Payment
                            reports with CSV/Print support</div>
                    </div>
                    <a href="{{ url('/library-registration') }}" class="btn btn-main mt-4 px-4 py-2 rounded-3">
                        Start Managing Your Library <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section class="py-4" id="pricing">
        <div class="container-xxl px-4 px-lg-5 py-2">
            <div class="text-center col-lg-8 mx-auto mb-5 reveal">
                <span
                    class="badge bg-primary-subtle text-primary fw-bold text-uppercase px-3 py-2 rounded-pill small">Plans</span>
                <h2 class="display-6 font-head fw-bold mt-2">Start Free. Scale Without Limits.</h2>
                <p class="text-muted">Flexible options based on your library seating capacity.</p>
            </div>
            <div class="row g-4 align-items-stretch justify-content-center">
                @forelse ($plans ?? [] as $plan)
                    <div class="col-md-6 col-lg-3 reveal">
                        <div
                            class="card h-100 p-4 rounded-4 border {{ $plan->is_popular ? 'border-2 border-primary shadow position-relative' : 'glass-card shadow-sm' }}">

                            @if ($plan->is_popular)
                                <span class="badge bg-primary text-white position-absolute top-0 end-0 m-3">
                                    POPULAR
                                </span>
                            @endif

                            <h5 class="fw-bold">{{ $plan->name }}</h5>

                            <div class="font-head fs-1 fw-bold mt-2 {{ $plan->is_popular ? 'text-primary' : '' }}">
                                ₹{{ number_format($plan->price, 0) }}
                                <small class="fs-6 text-muted">/ {{ $plan->duration_label }}</small>
                            </div>

                            <ul class="list-unstyled small text-muted my-4 d-flex flex-column gap-2">
                                @if (is_array($plan->features))
                                    @foreach ($plan->features as $feature)
                                        <li>
                                            <i class="fa-solid fa-check text-success me-2"></i>
                                            {{ $feature }}
                                        </li>
                                    @endforeach
                                @endif
                            </ul>

                            <a href="{{ url('/library-registration') }}"
                                class="btn {{ $plan->is_popular ? 'btn-main' : 'btn-outline-primary' }} rounded-3 w-100 mt-auto">
                                {{ $plan->slug === 'free-trial' || $plan->price == 0 ? 'Start Free Trial' : 'Choose Plan' }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-4">
                        Subscription plans are being updated. <a href="{{ url('/library-registration') }}">Register now
                            for a Free Trial</a>.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-4" id="register">
        <div class="container-xxl px-4 px-lg-5">
            <div class="bg-dark text-white p-5 rounded-4 shadow-lg position-relative overflow-hidden"
                style="background: radial-gradient(circle at 90% 10%, rgba(53, 213, 255, .25), transparent 25%), linear-gradient(125deg, #07162e, #0a3261 65%, #0f7cff) !important;">
                <div class="row align-items-center g-4">
                    <div class="col-lg-8">
                        <span class="badge bg-white bg-opacity-10 text-info px-3 py-2 rounded-pill small mb-2">DIGITIZE
                            TODAY</span>
                        <h2 class="display-6 font-head fw-bold mb-3">Run Your Library Like a Modern Business.</h2>
                        <p class="text-white-50 mb-0">Register once, configure shifts and seats, and start managing
                            effortlessly.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ url('/library-registration') }}" class="btn btn-light btn-lg rounded-3 px-4 fw-bold">
                            Create My Library <i class="fa-solid fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
