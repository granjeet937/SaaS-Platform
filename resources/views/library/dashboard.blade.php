@extends('layouts.app')

@section('title', 'Library Dashboard | LMSP')

@section('content')
<main class="py-5" style="margin-top: 70px;">
    <div class="container-xxl px-3 px-lg-4">

        <!-- Welcome Banner -->
        <section class="mb-4">
            <div class="row align-items-end g-3">
                <div class="col-md-8">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 rounded-pill small mb-2 d-inline-flex align-items-center gap-1">
                        <i class="fa-solid fa-sparkles"></i>
                        Library Overview
                        <span class="ms-1 d-inline-flex align-items-center gap-1 text-success fw-bold" style="font-size: 9px;">
                            <span class="rounded-circle bg-success d-inline-block" style="width: 6px; height: 6px;"></span>
                            LIVE
                        </span>
                    </span>
                    <h1 class="font-head fw-bold text-dark mt-1 mb-1">
                        Good morning, {{ $user->name }} 👋
                    </h1>
                    <p class="text-muted small mb-0">
                        Here’s what’s happening in your study library today.
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="badge bg-white text-secondary border px-3 py-2 rounded-pill shadow-sm small">
                        <i class="fa-regular fa-calendar text-primary me-1"></i>
                        {{ now()->format('l, d F Y') }}
                    </span>
                </div>
            </div>
        </section>

        <!-- Library Profile Panel -->
        <section class="mb-4">
            <div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 border-bottom pb-3 mb-3">
                    <div>
                        <h4 class="font-head fw-bold text-dark mb-1">{{ $library->library_name }}</h4>
                        <div class="small text-muted">
                            <span>{{ $library->library_type }}</span>
                            <span class="mx-1">•</span>
                            <span>Library Code: <strong class="text-primary font-monospace">{{ $library->library_code }}</strong></span>
                        </div>
                    </div>
                    <span class="badge {{ $library->status === 'active' ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-warning-subtle text-warning border border-warning-subtle' }} px-3 py-2 rounded-pill fw-bold">
                        {{ ucfirst($library->status) }}
                    </span>
                </div>

                <div class="row g-3 small">
                    <div class="col-6 col-md-3">
                        <span class="text-muted d-block" style="font-size: 11px;">Owner</span>
                        <strong class="text-dark fs-6">{{ $user->name }}</strong>
                    </div>
                    <div class="col-6 col-md-3">
                        <span class="text-muted d-block" style="font-size: 11px;">Email</span>
                        <strong class="text-dark fs-6">{{ $user->email }}</strong>
                    </div>
                    <div class="col-4 col-md-2">
                        <span class="text-muted d-block" style="font-size: 11px;">City</span>
                        <strong class="text-dark fs-6">{{ $library->city }}</strong>
                    </div>
                    <div class="col-4 col-md-2">
                        <span class="text-muted d-block" style="font-size: 11px;">State</span>
                        <strong class="text-dark fs-6">{{ $library->state }}</strong>
                    </div>
                    <div class="col-4 col-md-2">
                        <span class="text-muted d-block" style="font-size: 11px;">Total Seats</span>
                        <strong class="text-dark fs-6">{{ number_format($library->total_seats) }}</strong>
                    </div>
                </div>

                @if (!empty($library->facilities))
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-muted d-block mb-2 fw-semibold">Available Amenities</small>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($library->facilities as $facility)
                                <span class="badge bg-light text-secondary border px-2 py-1 rounded-pill small">
                                    <i class="fa-solid fa-circle-check text-success me-1"></i> {{ $facility }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- KPI Cards -->
        <section class="mb-4">
            <div class="row g-3">
                <!-- Total Students -->
                <div class="col-6 col-xl">
                    <div class="card border-0 rounded-4 shadow-sm p-3 h-100 bg-white">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="rounded-3 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <span class="badge bg-light text-muted">—</span>
                        </div>
                        <span class="text-muted small fw-semibold">Total Students</span>
                        <h3 class="font-head fw-bold my-1 text-dark">0</h3>
                        <small class="text-secondary" style="font-size: 11px;">Student module upcoming</small>
                    </div>
                </div>

                <!-- Present Today -->
                <div class="col-6 col-xl">
                    <div class="card border-0 rounded-4 shadow-sm p-3 h-100 bg-white">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="rounded-3 bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="fa-solid fa-user-check"></i>
                            </div>
                            <span class="badge bg-light text-muted">—</span>
                        </div>
                        <span class="text-muted small fw-semibold">Present Today</span>
                        <h3 class="font-head fw-bold my-1 text-success">0</h3>
                        <small class="text-secondary" style="font-size: 11px;">Attendance module upcoming</small>
                    </div>
                </div>

                <!-- Seats Occupied -->
                <div class="col-6 col-xl">
                    <div class="card border-0 rounded-4 shadow-sm p-3 h-100 bg-white">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="rounded-3 bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="fa-solid fa-chair"></i>
                            </div>
                            <span class="badge bg-info-subtle text-info">0%</span>
                        </div>
                        <span class="text-muted small fw-semibold">Seats Occupied</span>
                        <h3 class="font-head fw-bold my-1 text-dark">0/{{ number_format($library->total_seats) }}</h3>
                        <small class="text-secondary" style="font-size: 11px;">{{ number_format($library->total_seats) }} total capacity</small>
                    </div>
                </div>

                <!-- Monthly Revenue -->
                <div class="col-6 col-xl">
                    <div class="card border-0 rounded-4 shadow-sm p-3 h-100 bg-white">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="rounded-3 bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="fa-solid fa-indian-rupee-sign"></i>
                            </div>
                            <span class="badge bg-light text-muted">—</span>
                        </div>
                        <span class="text-muted small fw-semibold">Month Revenue</span>
                        <h3 class="font-head fw-bold my-1 text-dark">₹0</h3>
                        <small class="text-secondary" style="font-size: 11px;">Payment gateway link</small>
                    </div>
                </div>

                <!-- Expiring Soon -->
                <div class="col-12 col-xl">
                    <div class="card border-0 rounded-4 shadow-sm p-3 h-100 bg-white">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="rounded-3 bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <span class="badge bg-danger-subtle text-danger">0</span>
                        </div>
                        <span class="text-muted small fw-semibold">Expiring Soon</span>
                        <h3 class="font-head fw-bold my-1 text-danger">0</h3>
                        <small class="text-secondary" style="font-size: 11px;">Plan renewals alert</small>
                    </div>
                </div>
            </div>
        </section>

        <!-- Attendance & Seat Matrix Section -->
        <section class="mb-4">
            <div class="row g-3">
                <!-- Attendance Chart -->
                <div class="col-xl-8">
                    <div class="card border-0 rounded-4 shadow-sm p-4 h-100 bg-white">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                            <div>
                                <h5 class="font-head fw-bold text-dark mb-0">Attendance Overview</h5>
                                <small class="text-muted">Daily footfall for the current week</small>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                View Report <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>

                        <!-- Bar Graph Container (Flexbox) -->
                        <div class="d-flex justify-content-between align-items-baseline pt-4 px-2" style="height: 180px;">
                            @foreach (['Mon' => 20, 'Tue' => 35, 'Wed' => 45, 'Thu' => 30, 'Fri' => 55, 'Sat' => 40, 'Sun' => 25] as $day => $pct)
                                <div class="d-flex flex-column align-items-center flex-grow-1 h-100 justify-content-end">
                                    <div class="w-50 bg-primary bg-gradient rounded-top-2" style="height: {{ $pct }}%;"></div>
                                    <small class="text-muted fw-bold mt-2" style="font-size: 10px;">{{ $day }}</small>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center gap-4 mt-3 pt-3 border-top small text-muted">
                            <span class="d-flex align-items-center gap-1">
                                <span class="rounded-circle bg-primary d-inline-block" style="width: 8px; height: 8px;"></span> Check-in
                            </span>
                            <span class="d-flex align-items-center gap-1">
                                <span class="rounded-circle bg-info d-inline-block" style="width: 8px; height: 8px;"></span> Check-out
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Seat Occupancy Matrix -->
                <div class="col-xl-4">
                    <div class="card border-0 rounded-4 shadow-sm p-4 h-100 bg-white">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                            <div>
                                <h5 class="font-head fw-bold text-dark mb-0">Seat Matrix</h5>
                                <small class="text-muted">Real-time room occupancy</small>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Manage</a>
                        </div>

                        <!-- Mini Stats -->
                        <div class="row g-2 text-center mb-3">
                            <div class="col-4">
                                <div class="p-2 border rounded-3 bg-light">
                                    <small class="text-muted d-block" style="font-size: 10px;">Occupied</small>
                                    <strong class="text-primary">0</strong>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 border rounded-3 bg-light">
                                    <small class="text-muted d-block" style="font-size: 10px;">Available</small>
                                    <strong class="text-success">{{ number_format($library->total_seats) }}</strong>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 border rounded-3 bg-light">
                                    <small class="text-muted d-block" style="font-size: 10px;">Reserved</small>
                                    <strong class="text-warning">0</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Seat Pill Badges -->
                        <div class="d-flex flex-wrap gap-2 mb-3 overflow-auto" style="max-height: 140px;">
                            @for ($i = 1; $i <= min($library->total_seats, 20); $i++)
                                <span class="badge bg-success-subtle text-success border border-success-subtle p-2 rounded-3 small font-monospace">
                                    <i class="fa-solid fa-check me-1"></i> S{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            @endfor
                        </div>

                        <div class="d-flex justify-content-between mt-auto pt-2 border-top small text-muted" style="font-size: 11px;">
                            <span><i class="fa-solid fa-circle text-success me-1"></i> Available</span>
                            <span><i class="fa-solid fa-circle text-primary me-1"></i> Occupied</span>
                            <span><i class="fa-solid fa-circle text-warning me-1"></i> Reserved</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Students & Performance Section -->
        <section class="mb-4">
            <div class="row g-3">
                <!-- Recent Students -->
                <div class="col-xl-8">
                    <div class="card border-0 rounded-4 shadow-sm p-4 h-100 bg-white">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                            <div>
                                <h5 class="font-head fw-bold text-dark mb-0">Recent Admissions</h5>
                                <small class="text-muted">Latest student enrollments</small>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill px-3">View All</a>
                        </div>

                        <div class="text-center py-5">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px;">
                                <i class="fa-solid fa-users fs-3"></i>
                            </div>
                            <h6 class="fw-bold text-dark">No Students Enrolled Yet</h6>
                            <p class="text-muted small mb-3">Start onboarding students to manage profiles, payments, and shifts.</p>
                            <a href="#" class="btn btn-primary btn-sm rounded-pill px-3">
                                <i class="fa-solid fa-user-plus me-1"></i> Add First Student
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Operational Utilization Progress -->
                <div class="col-xl-4">
                    <div class="card border-0 rounded-4 shadow-sm p-4 h-100 bg-white">
                        <h5 class="font-head fw-bold text-dark mb-0 border-bottom pb-3">Utilization Goals</h5>

                        <div class="d-flex flex-column gap-3 mt-3">
                            <div>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted fw-semibold">Capacity Fill</span>
                                    <span class="text-dark fw-bold">0%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-primary" style="width: 0%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted fw-semibold">Seat Utilization</span>
                                    <span class="text-dark fw-bold">0%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-info" style="width: 0%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted fw-semibold">Monthly Collection</span>
                                    <span class="text-dark fw-bold">0%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Upgrade Callout -->
                        <div class="mt-4 p-3 rounded-3 bg-dark text-white position-relative overflow-hidden">
                            <span class="badge bg-warning text-dark fw-bold mb-2">GROWTH PLAN</span>
                            <h6 class="fw-bold mb-1">Scale your study space</h6>
                            <p class="text-white-50 small mb-2" style="font-size: 11px;">Enable automated SMS & WhatsApp fee alert triggers.</p>
                            <a href="#" class="btn btn-light btn-sm rounded-pill px-3 fw-bold">View Plans</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</main>
@endsection