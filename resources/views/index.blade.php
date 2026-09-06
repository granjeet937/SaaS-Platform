@extends('layouts.app')

@section('title', 'LMSP — Smart Study Library Management SaaS')

@section('content')
    <!-- Hero Section -->
    <header class="hero-section text-white pb-5 position-relative" id="home">
        <div class="container-xxl px-4 px-lg-5 py-4">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 reveal">
                    <div
                        class="badge bg-white bg-opacity-10 border border-white border-opacity-25 px-3 py-2 rounded-pill small mb-3">
                        <i class="fa-solid fa-wand-magic-sparkles text-info me-1"></i> Smart Management for Study Libraries
                    </div>
                    <h1 class="display-4 font-head fw-bold lh-sm mb-3">
                        Manage Your Study Library <span class="gradient-text">Smarter & Better.</span>
                    </h1>
                    <p class="lead text-light text-opacity-75 mb-4">
                        One powerful SaaS platform to manage students, attendance, seats, memberships, fees and your
                        complete study-library operations — from anywhere.
                    </p>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <a href="{{ url('/library-registration') }}" class="btn btn-main btn-lg rounded-3 px-4">
                            Start Free <i class="fa-solid fa-arrow-right ms-2"></i>
                        </a>
                        <a href="#features" class="btn btn-outline-light btn-lg rounded-3 px-4">
                            <i class="fa-solid fa-play me-2"></i> Explore Platform
                        </a>
                    </div>
                    <div class="d-flex flex-wrap gap-4 small text-light text-opacity-75">
                        <span><i class="fa-solid fa-circle-check text-success me-1"></i> Easy Setup</span>
                        <span><i class="fa-solid fa-circle-check text-success me-1"></i> No Complex Software</span>
                        <span><i class="fa-solid fa-circle-check text-success me-1"></i> Cloud Based</span>
                    </div>
                </div>

                <!-- 3D Interactive Scene -->
                <div class="col-lg-6 reveal delay-2">
                    <div class="visual-wrap" id="heroVisual">
                        <div class="dashboard-scene" id="dashScene">
                            <!-- Floating Chips -->
                            <div class="floating-chip chip1">
                                <i class="fa-solid fa-user-check"></i> 180 Students Present
                            </div>
                            <div class="floating-chip chip2">
                                <i class="fa-solid fa-chair"></i> 82% Seats Occupied
                            </div>
                            <div class="floating-chip chip3">
                                <i class="fa-solid fa-indian-rupee-sign"></i> ₹42,500 Collected
                            </div>

                            <!-- Main Dashboard Card -->
                            <div class="dashboard-card">
                                <div class="dash-top">
                                    <span class="dot"></span>
                                    <span class="dot"></span>
                                    <span class="dot"></span>
                                </div>
                                <div class="dash-body">
                                    <!-- Left Sidebar -->
                                    <div class="dash-side">
                                        <div class="mini-brand"><i class="fa-solid fa-book-open me-1"></i> LMSP</div>
                                        <div class="side-item active"><i class="fa-solid fa-table-cells-large"></i>
                                            Dashboard</div>
                                        <div class="side-item"><i class="fa-solid fa-users"></i> Students</div>
                                        <div class="side-item"><i class="fa-solid fa-calendar-check"></i> Attendance</div>
                                        <div class="side-item"><i class="fa-solid fa-chair"></i> Seats</div>
                                        <div class="side-item"><i class="fa-solid fa-wallet"></i> Payments</div>
                                        <div class="side-item"><i class="fa-solid fa-chart-line"></i> Reports</div>
                                    </div>

                                    <!-- Right Main Content -->
                                    <div class="dash-main">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="mini-title">Welcome back, Admin 👋</div>
                                            <span class="badge bg-light text-dark border">Today</span>
                                        </div>

                                        <div class="metric-row">
                                            <div class="metric"><small>Total Students</small><strong>250</strong></div>
                                            <div class="metric"><small>Present Today</small><strong>180</strong></div>
                                            <div class="metric"><small>Available Seats</small><strong>40</strong></div>
                                        </div>

                                        <!-- Bar Chart -->
                                        <div class="chart">
                                            <div class="bars">
                                                <span class="bar" style="height:56%"></span>
                                                <span class="bar" style="height:60%"></span>
                                                <span class="bar" style="height:76%"></span>
                                                <span class="bar" style="height:50%"></span>
                                                <span class="bar" style="height:88%"></span>
                                                <span class="bar" style="height:68%"></span>
                                                <span class="bar" style="height:96%"></span>
                                            </div>
                                        </div>

                                        <div class="metric-row">
                                            <div class="metric"><small>Monthly Revenue</small><strong>₹42.5K</strong></div>
                                            <div class="metric"><small>Expiring Soon</small><strong>12</strong></div>
                                            <div class="metric"><small>Active Plans</small><strong>4</strong></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Stats Strip -->
    <section class="position-relative z-2" style="margin-top: -35px;">
        <div class="container-xxl px-3 px-lg-5">
            <div class="glass-card shadow-sm rounded-4 p-3 border">
                <div class="row g-3 text-center text-lg-start">
                    <div class="col-6 col-lg border-end border-light-subtle">
                        <h3 class="font-head fw-bold mb-0">1,000+</h3>
                        <small class="text-muted fw-bold">Libraries Joined</small>
                    </div>
                    <div class="col-6 col-lg border-end border-light-subtle">
                        <h3 class="font-head fw-bold mb-0">200K+</h3>
                        <small class="text-muted fw-bold">Students Managed</small>
                    </div>
                    <div class="col-6 col-lg border-end border-light-subtle">
                        <h3 class="font-head fw-bold mb-0">99.9%</h3>
                        <small class="text-muted fw-bold">Cloud Uptime</small>
                    </div>
                    <div class="col-6 col-lg border-end border-light-subtle">
                        <h3 class="font-head fw-bold mb-0">24×7</h3>
                        <small class="text-muted fw-bold">Online Access</small>
                    </div>
                    <div class="col-12 col-lg">
                        <h3 class="font-head fw-bold mb-0 text-warning">4.9/5</h3>
                        <small class="text-muted fw-bold">Owner Rating</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="py-5" id="features">
        <div class="container-xxl px-4 px-lg-5 py-4">
            <div class="text-center col-lg-8 mx-auto mb-5 reveal">
                <span
                    class="badge bg-primary-subtle text-primary fw-bold text-uppercase px-3 py-2 rounded-pill small">Features</span>
                <h2 class="display-6 font-head fw-bold mt-2">Everything Your Study Library Needs</h2>
                <p class="text-muted">Built specifically for study libraries and reading rooms — not book-lending
                    libraries.
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3 reveal">
                    <div class="card h-100 glass-card rounded-4 p-4 shadow-sm border hover-lift">
                        <div class="rounded-3 bg-success text-white mb-3"
                            style="width:50px;height:50px;display:grid;place-items:center;">
                            <i class="fa-solid fa-users fs-5"></i>
                        </div>
                        <h5 class="fw-bold">Student Management</h5>
                        <p class="text-muted small mb-0">Add, manage, search and track every student from one workspace.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal">
                    <div class="card h-100 glass-card rounded-4 p-4 shadow-sm border hover-lift">
                        <div class="rounded-3 bg-primary text-white mb-3"
                            style="width:50px;height:50px;display:grid;place-items:center;">
                            <i class="fa-solid fa-calendar-check fs-5"></i>
                        </div>
                        <h5 class="fw-bold">Smart Attendance</h5>
                        <p class="text-muted small mb-0">Quick check-in, check-out, QR attendance and complete history.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal">
                    <div class="card h-100 glass-card rounded-4 p-4 shadow-sm border hover-lift">
                        <div class="rounded-3 bg-info text-white mb-3"
                            style="width:50px;height:50px;display:grid;place-items:center;">
                            <i class="fa-solid fa-chair fs-5"></i>
                        </div>
                        <h5 class="fw-bold">Seats & Rooms</h5>
                        <p class="text-muted small mb-0">Visual seat layout, shift allocation, and real-time occupancy
                            status.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal">
                    <div class="card h-100 glass-card rounded-4 p-4 shadow-sm border hover-lift">
                        <div class="rounded-3 bg-warning text-white mb-3"
                            style="width:50px;height:50px;display:grid;place-items:center;">
                            <i class="fa-solid fa-indian-rupee-sign fs-5"></i>
                        </div>
                        <h5 class="fw-bold">Fees & Dues</h5>
                        <p class="text-muted small mb-0">Track due fees, collect receipts, and automate expiry reminders.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Us Section -->
    <section class="py-5 bg-soft">
        <div class="container-xxl px-4 px-lg-5 py-4">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 reveal">
                    <div class="card border-dashed p-5 text-center bg-white bg-opacity-50 rounded-4 border-2">
                        <i class="fa-regular fa-image fs-1 text-secondary mb-3"></i>
                        <strong class="d-block text-dark">Library Room View</strong>
                        <small class="text-muted">Insert your actual study room photograph here</small>
                    </div>
                </div>
                <div class="col-lg-6 reveal">
                    <span
                        class="badge bg-primary-subtle text-primary fw-bold text-uppercase px-3 py-2 rounded-pill small">Why
                        LMSP</span>
                    <h3 class="display-6 font-head fw-bold mt-2">Give Every Student a Better Place to Study.</h3>
                    <p class="text-muted">Stop managing physical registers and notebooks separately. Bring your entire
                        study space into a unified dashboard.</p>
                    <div class="d-flex flex-column gap-2 mt-3 text-secondary small fw-semibold">
                        <div><i class="fa-solid fa-circle-check text-success me-2"></i> Instant student onboarding &
                            profile logs</div>
                        <div><i class="fa-solid fa-circle-check text-success me-2"></i> QR check-in and shift management
                        </div>
                        <div><i class="fa-solid fa-circle-check text-success me-2"></i> Automatic WhatsApp/SMS fee alerts
                        </div>
                        <div><i class="fa-solid fa-circle-check text-success me-2"></i> Instant revenue & occupancy
                            analytical reports</div>
                    </div>
                    <a href="{{ url('/library-registration') }}" class="btn btn-main mt-4 px-4 py-2 rounded-3">
                        Start Managing Your Library <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section class="py-5" id="pricing">
        <div class="container-xxl px-4 px-lg-5 py-4">
            <div class="text-center col-lg-8 mx-auto mb-5 reveal">
                <span
                    class="badge bg-primary-subtle text-primary fw-bold text-uppercase px-3 py-2 rounded-pill small">Plans</span>
                <h2 class="display-6 font-head fw-bold mt-2">Start Small. Scale Without Limits.</h2>
                <p class="text-muted">Flexible options based on your library seating capacity.</p>
            </div>
            <div class="row g-4 align-items-stretch">
                <div class="col-md-6 col-lg-3 reveal">
                    <div class="card h-100 p-4 rounded-4 border glass-card shadow-sm">
                        <h5 class="fw-bold">Free Trial</h5>
                        <div class="font-head fs-1 fw-bold mt-2">₹0 <small class="fs-6 text-muted">/ 30 days</small></div>
                        <ul class="list-unstyled small text-muted my-4 d-flex flex-column gap-2">
                            <li><i class="fa-solid fa-check text-success me-2"></i> Up to 50 students</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i> Daily attendance</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i> Seat assignments</li>
                        </ul>
                        <a href="{{ url('/library-registration') }}"
                            class="btn btn-outline-primary rounded-3 w-100 mt-auto">Get Started</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal">
                    <div class="card h-100 p-4 rounded-4 border-2 border-primary glass-card shadow position-relative">
                        <span class="badge bg-primary text-white position-absolute top-0 end-0 m-3">POPULAR</span>
                        <h5 class="fw-bold">Starter</h5>
                        <div class="font-head fs-1 fw-bold mt-2 text-primary">₹999 <small class="fs-6 text-muted">/ 3
                                Months</small></div>
                        <ul class="list-unstyled small text-muted my-4 d-flex flex-column gap-2">
                            <li><i class="fa-solid fa-check text-success me-2"></i> Up to 200 students</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i> All core modules</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i> Expiry reminders</li>
                        </ul>
                        <a href="{{ url('/library-registration') }}" class="btn btn-main rounded-3 w-100 mt-auto">Start
                            Plan</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal">
                    <div class="card h-100 p-4 rounded-4 border glass-card shadow-sm">
                        <h5 class="fw-bold">Pro</h5>
                        <div class="font-head fs-1 fw-bold mt-2">₹1,499 <small class="fs-6 text-muted">/ 6 Months</small>
                        </div>
                        <ul class="list-unstyled small text-muted my-4 d-flex flex-column gap-2">
                            <li><i class="fa-solid fa-check text-success me-2"></i> Up to 500 students</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i> Reports & exports</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i> Priority support</li>
                        </ul>
                        <a href="{{ url('/library-registration') }}"
                            class="btn btn-outline-primary rounded-3 w-100 mt-auto">Choose Pro</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal">
                    <div class="card h-100 p-4 rounded-4 border glass-card shadow-sm">
                        <h5 class="fw-bold">Business</h5>
                        <div class="font-head fs-1 fw-bold mt-2">₹2,499 <small class="fs-6 text-muted">/ 1 Year</small>
                        </div>
                        <ul class="list-unstyled small text-muted my-4 d-flex flex-column gap-2">
                            <li><i class="fa-solid fa-check text-success me-2"></i> Unlimited students</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i> Multi-branch feature</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i> Dedicated manager</li>
                        </ul>
                        <a href="{{ url('/library-registration') }}"
                            class="btn btn-outline-primary rounded-3 w-100 mt-auto">Contact Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5" id="register">
        <div class="container-xxl px-4 px-lg-5">
            <div class="bg-dark text-white p-5 rounded-4 shadow-lg position-relative overflow-hidden"
                style="background: radial-gradient(circle at 90% 10%, rgba(53, 213, 255, .25), transparent 25%), linear-gradient(125deg, #07162e, #0a3261 65%, #0f7cff) !important;">
                <div class="row align-items-center g-4">
                    <div class="col-lg-8">
                        <span class="badge bg-white bg-opacity-10 text-info px-3 py-2 rounded-pill small mb-2">DIGITIZE
                            TODAY</span>
                        <h2 class="display-6 font-head fw-bold mb-3">Run Your Library Like a Modern Business.</h2>
                        <p class="text-white-50 mb-0">Register once, configure seats and plans, and start managing
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
