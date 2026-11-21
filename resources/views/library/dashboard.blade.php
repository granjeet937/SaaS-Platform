@extends('layouts.library')

@section('title', 'LMSP — Library Dashboard')

@section('content')

    <!-- WELCOME SECTION (Compact) -->
    <section class="welcome py-3 mb-3">
        <div class="row align-items-center g-2">
            <div class="col-md-8">
                <span class="welcome-kicker">
                    <i class="fa-solid fa-sparkles"></i>
                    {{ $library->library_name ?? 'Library Overview' }}
                    <span class="ms-1 d-inline-flex align-items-center gap-1 text-success" style="font-size:8px;">
                        <span class="rounded-circle bg-success d-inline-block" style="width:5px;height:5px;"></span>
                        LIVE
                    </span>
                </span>
                <h1 class="h3 fw-bold mb-1">Namaste, {{ $user->name ?? 'Admin' }} 🙏</h1>
                <p class="mb-0 small">Here’s what’s happening in your study library today.</p>
            </div>

            <div class="col-md-4 text-md-end">
                <span class="date-pill">
                    <i class="fa-regular fa-calendar"></i>
                    {{ now()->format('l, d F Y') }}
                </span>
            </div>
        </div>
    </section>

    <!-- SUBSCRIPTION DETAILS (Compact) -->
    @if (isset($subscription) && $subscription)
        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body py-2 px-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex flex-wrap align-items-center gap-3 small">
                        <strong class="fs-6 text-dark">{{ $subscription->plan->name ?? 'Current Plan' }}</strong>
                        <span class="text-muted">Start:
                            <strong>{{ $subscription->start_date->format('d M Y') }}</strong></span>
                        <span class="text-muted">Expiry:
                            <strong>{{ $subscription->end_date->format('d M Y') }}</strong></span>
                        @if (($subscription->plan->slug ?? '') === 'free-trial')
                            <span class="text-primary">(Free Trial)</span>
                        @endif
                    </div>

                    <span class="badge bg-success rounded-pill px-3 py-1">
                        {{ ucfirst($subscription->status) }}
                    </span>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning rounded-4 py-2 px-3 mb-3 small">
            Your subscription is not active. Please choose a plan to continue.
        </div>
    @endif

    <!-- KPIS SECTION -->
    <section class="mb-3">
        <div class="row g-3">
            <div class="col-6 col-xl">
                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon"><i class="fa-solid fa-users"></i></div>
                        <span class="trend up">{{ $stats['activeStudents'] }} active</span>
                    </div>
                    <div class="kpi-label">Total Students</div>
                    <div class="kpi-value">{{ $stats['totalStudents'] }}</div>
                    <div class="kpi-meta">{{ $stats['newThisMonth'] }} new this month</div>
                </div>
            </div>

            <div class="col-6 col-xl">
                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon green"><i class="fa-solid fa-user-check"></i></div>
                        <span class="trend up">{{ $stats['attendanceRatePercent'] }}%</span>
                    </div>
                    <div class="kpi-label">Present Today</div>
                    <div class="kpi-value">{{ $stats['presentToday'] }}</div>
                    <div class="kpi-meta">{{ $stats['attendanceRatePercent'] }}% attendance rate</div>
                </div>
            </div>

            <div class="col-6 col-xl">
                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon purple"><i class="fa-solid fa-chair"></i></div>
                        <span class="trend up">{{ $stats['seatOccupancyPercent'] }}%</span>
                    </div>
                    <div class="kpi-label">Seats Occupied</div>
                    <div class="kpi-value">{{ $stats['occupiedSeats'] }}/{{ $stats['totalSeats'] }}</div>
                    <div class="kpi-meta">{{ $stats['availableSeats'] }} seats available</div>
                </div>
            </div>

            <div class="col-6 col-xl">
                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon orange"><i class="fa-solid fa-indian-rupee-sign"></i></div>
                        <span class="trend up">{{ now()->format('M Y') }}</span>
                    </div>
                    <div class="kpi-label">This Month Revenue</div>
                    <div class="kpi-value">₹{{ number_format($stats['thisMonthRevenue'], 0) }}</div>
                    <div class="kpi-meta">₹{{ number_format($stats['totalPendingDues'], 0) }} total pending</div>
                </div>
            </div>

            <div class="col-6 col-xl">
                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon pink"><i class="fa-solid fa-clock"></i></div>
                        <span
                            class="trend {{ $stats['expiringSoonCount'] > 0 ? 'down' : 'up' }}">{{ $stats['expiringSoonCount'] }}</span>
                    </div>
                    <div class="kpi-label">Expiring Soon</div>
                    <div class="kpi-value">{{ $stats['expiringSoonCount'] }}</div>
                    <div class="kpi-meta">Next 7 days (30d cycle)</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CHART + SEAT MAP -->
    <section class="mb-3">
        <div class="row g-3">
            <div class="col-xl-8 visual-chart">
                <div class="panel h-100">
                    <div class="panel-head">
                        <div>
                            <div class="panel-title">Attendance Overview</div>
                            <div class="panel-sub">Daily attendance for the last 7 days</div>
                        </div>
                        <a href="/library/attendance" class="panel-action">Open Register <i
                                class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>

                    <div class="chart-wrap">
                        <div class="chart-summary">
                            <div>
                                <div class="chart-value">{{ $stats['weeklyCheckInsTotal'] }}</div>
                                <div class="chart-note">Total check-ins (Last 7 days)</div>
                            </div>
                            <span class="badge rounded-pill text-bg-light">Last 7 Days</span>
                        </div>

                        <div class="bar-chart">
                            @foreach ($weeklyAttendance as $idx => $dayItem)
                                <div class="bar-col"
                                    title="{{ $dayItem->label }}: {{ $dayItem->check_in }} In, {{ $dayItem->check_out }} Out">
                                    <div class="bar"
                                        style="height:{{ $dayItem->in_height }}%;animation-delay:{{ $idx * 0.05 }}s">
                                    </div>
                                    <div class="bar secondary"
                                        style="height:{{ $dayItem->out_height }}%;animation-delay:{{ $idx * 0.05 + 0.03 }}s">
                                    </div>
                                    <span class="bar-label">{{ $dayItem->label }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="chart-legend">
                            <span><span class="legend-dot legend-blue"></span>Check-in</span>
                            <span><span class="legend-dot legend-purple"></span>Check-out</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 visual-seat">
                <div class="panel h-100">
                    <div class="panel-head">
                        <div>
                            <div class="panel-title">Live Seat Occupancy</div>
                            <div class="panel-sub">Showing first {{ $seats->count() }} seats</div>
                        </div>
                        <a href="/library/seats" class="panel-action">Manage</a>
                    </div>

                    <div class="seat-map">
                        <div class="seat-summary">
                            <div class="seat-stat">
                                <small>Occupied</small>
                                <strong>{{ $stats['occupiedSeats'] }}</strong>
                            </div>
                            <div class="seat-stat">
                                <small>Available</small>
                                <strong>{{ $stats['availableSeats'] }}</strong>
                            </div>
                            <div class="seat-stat">
                                <small>Maintenance</small>
                                <strong>{{ $stats['maintenanceSeats'] }}</strong>
                            </div>
                        </div>

                        <div class="seat-grid">
                            @forelse ($seats as $seat)
                                @php
                                    $shortLabel = preg_replace('/^LAB\d+-/', '', $seat->seat_number);
                                    $seatClass = $seat->status === 'maintenance' ? 'reserved' : $seat->status;
                                @endphp
                                <div class="seat {{ $seatClass }}"
                                    title="{{ $seat->seat_number }} ({{ ucfirst($seat->status) }})">
                                    @if ($seat->status === 'occupied')
                                        <i class="fa-solid fa-user"></i>
                                    @elseif ($seat->status === 'maintenance')
                                        <i class="fa-solid fa-wrench"></i>
                                    @else
                                        <i class="fa-solid fa-check"></i>
                                    @endif
                                    {{ $shortLabel }}
                                </div>
                            @empty
                                <div class="text-muted small py-3 text-center" style="grid-column: 1 / -1;">
                                    No seats generated yet. <a href="/library/seats">Setup Seats</a>
                                </div>
                            @endforelse
                        </div>

                        <div class="seat-legend">
                            <span><span class="legend-dot" style="background:#2fcf96"></span>Available</span>
                            <span><span class="legend-dot" style="background:#27abff"></span>Occupied</span>
                            <span><span class="legend-dot" style="background:#967aff"></span>Maintenance</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- RECENT STUDENTS + ACTIVITY -->
    <section class="mb-3">
        <div class="row g-3">
            <div class="col-xl-8">
                <div class="panel h-100">
                    <div class="panel-head">
                        <div>
                            <div class="panel-title">Recent Students</div>
                            <div class="panel-sub">Latest admissions and 30-day cycle fee status</div>
                        </div>
                        <a href="/library/students" class="panel-action">View All</a>
                    </div>

                    <div class="table-wrap">
                        <table class="table student-table">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Monthly</th>
                                    <th>Seat</th>
                                    <th>Next Due</th>
                                    <th>Status</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentStudents as $st)
                                    @php
                                        $initials = collect(explode(' ', trim($st->name)))
                                            ->filter()
                                            ->take(2)
                                            ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                                            ->implode('');
                                    @endphp
                                    <tr>
                                        <td>
                                            <a href="/library/students/view/{{ $st->id }}"
                                                class="text-decoration-none text-dark">
                                                <div class="student">
                                                    <div class="student-avatar">{{ $initials ?: 'ST' }}</div>
                                                    <div>
                                                        <div class="student-name">{{ $st->name }}</div>
                                                        <div class="student-id">{{ $st->student_code }}</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                        <td>₹{{ number_format((float) $st->payable_fee, 0) }}</td>
                                        <td>{{ $st->seat ? $st->seat->seat_number : '—' }}</td>
                                        <td>{{ $st->computed_next_due->format('d M') }}</td>
                                        <td>
                                            @if ($st->computed_balance > 0)
                                                <span class="status pending">
                                                    <i class="fa-solid fa-circle"></i>Due
                                                    ₹{{ number_format($st->computed_balance, 0) }}
                                                </span>
                                            @else
                                                <span class="status present">
                                                    <i class="fa-solid fa-circle"></i>Clear
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $st->admission_date ? $st->admission_date->format('d M') : '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            No students admitted yet. <a href="/library/students/create">Add first
                                                student</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="panel h-100">
                    <div class="panel-head">
                        <div>
                            <div class="panel-title">Recent Activity</div>
                            <div class="panel-sub">Latest updates from your library</div>
                        </div>
                        <a href="/library/fees" class="panel-action">All</a>
                    </div>

                    <div class="activity-list">
                        @forelse ($recentActivities as $act)
                            <div class="activity">
                                @if ($act->type === 'payment')
                                    <div class="activity-icon"><i class="fa-solid fa-money-bill-wave"></i></div>
                                @else
                                    <div class="activity-icon green"><i class="fa-solid fa-user-plus"></i></div>
                                @endif
                                <div class="activity-text">
                                    <strong>{{ $act->title }}</strong> {{ $act->detail }}
                                    <span class="activity-time">{{ $act->timestamp->diffForHumans() }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-muted small py-3 text-center">
                                No recent activity recorded yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PERFORMANCE + QUICK ACTIONS + UPGRADE -->
    <section class="mb-3">
        <div class="row g-3">
            <div class="col-lg-4">
                <div class="panel h-100">
                    <div class="panel-head">
                        <div>
                            <div class="panel-title">Library Performance</div>
                            <div class="panel-sub">Current plan utilization</div>
                        </div>
                    </div>

                    @php
                        $maxPlanSeats = $subscription?->plan?->max_seats ?? max(1, $stats['totalSeats']);
                        $studentCapacityPercent =
                            $maxPlanSeats > 0
                                ? min(100, (int) round(($stats['activeStudents'] / $maxPlanSeats) * 100))
                                : 0;
                    @endphp

                    <div class="mini-progress">
                        <div class="progress-row">
                            <div class="progress-head">
                                <span>Student Capacity</span>
                                <span>{{ $studentCapacityPercent }}%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" style="width:{{ $studentCapacityPercent }}%"></div>
                            </div>
                        </div>

                        <div class="progress-row">
                            <div class="progress-head">
                                <span>Seat Utilization</span>
                                <span>{{ $stats['seatOccupancyPercent'] }}%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar purple" style="width:{{ $stats['seatOccupancyPercent'] }}%">
                                </div>
                            </div>
                        </div>

                        <div class="progress-row">
                            <div class="progress-head">
                                <span>Monthly Collection</span>
                                <span>{{ $stats['collectionRatePercent'] }}%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar green" style="width:{{ $stats['collectionRatePercent'] }}%">
                                </div>
                            </div>
                        </div>

                        <div class="progress-row mb-0">
                            <div class="progress-head">
                                <span>Today's Attendance</span>
                                <span>{{ $stats['attendanceRatePercent'] }}%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" style="width:{{ $stats['attendanceRatePercent'] }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="panel h-100">
                    <div class="panel-head">
                        <div>
                            <div class="panel-title">Quick Actions</div>
                            <div class="panel-sub">Common library operations</div>
                        </div>
                    </div>

                    <div class="quick-grid">
                        <a href="/library/students/create" class="quick">
                            <div class="quick-icon"><i class="fa-solid fa-user-plus"></i></div>
                            <div class="quick-title">Add Student</div>
                            <div class="quick-sub">Create new student profile</div>
                        </a>

                        <a href="/library/attendance" class="quick">
                            <div class="quick-icon"><i class="fa-solid fa-user-check"></i></div>
                            <div class="quick-title">Mark Attendance</div>
                            <div class="quick-sub">Register & Kiosk mode</div>
                        </a>

                        <a href="/library/seats" class="quick">
                            <div class="quick-icon"><i class="fa-solid fa-chair"></i></div>
                            <div class="quick-title">Assign Seat</div>
                            <div class="quick-sub">Manage seat allocation</div>
                        </a>

                        <a href="/library/fees" class="quick">
                            <div class="quick-icon"><i class="fa-solid fa-indian-rupee-sign"></i></div>
                            <div class="quick-title">Collect Fee</div>
                            <div class="quick-sub">Record a payment</div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="upgrade h-100">
                    <span class="upgrade-badge"><i class="fa-solid fa-crown me-1"></i> GROW WITH LMSP</span>
                    <h3>Run your study library like a modern business.</h3>
                    <p>
                        Unlock advanced analytics, automated reminders, additional staff accounts
                        and higher student capacity with your next LMSP plan.
                    </p>
                    <a href="#" class="btn btn-light mt-2">
                        View Plans <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
