<aside class="sidebar" id="sidebar">
    @php
        $navLibrary = auth()->user()?->library;
        $navLibName = $navLibrary->library_name ?? 'Study Library';
        $navLibInitial = strtoupper(substr(trim($navLibName), 0, 1)) ?: 'L';
        $navLogoUrl = !empty($navLibrary?->logo)
            ? asset('storage/' . $navLibrary->logo)
            : "https://placehold.co/96x96/e8f7ff/0d7bf3?text={$navLibInitial}";

        $navStatus = $navLibrary->status ?? 'active';
        $isLibActive = $navStatus === 'active';

        $navStudentCount = $navLibrary
            ? \App\Models\Student::where('library_id', $navLibrary->id)->where('status', 'active')->count()
            : 0;
        $navPendingCount = $navLibrary
            ? \App\Models\Student::where('library_id', $navLibrary->id)->where('status', 'pending')->count()
            : 0;
        $navShiftCount = $navLibrary
            ? \App\Models\LibraryShift::where('library_id', $navLibrary->id)->where('status', true)->count()
            : 0;
        $navSeatCount = (int) ($navLibrary->total_seats ?? 0);
        $navInsideCount = $navLibrary
            ? \App\Models\StudentAttendance::where('library_id', $navLibrary->id)
                ->whereDate('attendance_date', now()->toDateString())
                ->where('status', 'present')
                ->whereNull('check_out_time')
                ->count()
            : 0;

        $currentTab = request('tab', 'students');
    @endphp

    <style>
        .sidebar .library-brand,
        .sidebar .library-brand-info,
        .sidebar .library-card,
        .sidebar .side-link {
            min-width: 0;
        }

        .sidebar .library-brand-info strong,
        .sidebar .library-brand-info small,
        .sidebar .side-link>span:first-of-type {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .sidebar .library-card .title {
            font-size: 0.78rem;
            line-height: 1.2;
        }

        .sidebar .library-card .sub {
            font-size: 0.7rem;
            line-height: 1.2;
            margin-top: 2px;
        }
    </style>

    <div class="sidebar-shell">
        <a href="/library-dashboard" class="library-brand">
            <div class="library-brand-logo flex-shrink-0">
                <img src="{{ $navLogoUrl }}" alt="{{ $navLibName }}" style="object-fit: cover;"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';">
                <span class="library-brand-fallback"><i class="fa-solid fa-building-columns"></i></span>
            </div>
            <span class="library-brand-info flex-grow-1">
                <strong>{{ $navLibName }}</strong>
                <small>{{ $navLibrary->library_type ?? 'Study Library' }}</small>
            </span>
        </a>

        <div class="library-card">
            <div class="d-flex align-items-center gap-2">
                <div class="library-mini-avatar flex-shrink-0">
                    <i class="fa-solid fa-id-card"></i>
                </div>
                <div class="min-w-0 flex-grow-1">
                    <div class="d-flex align-items-center gap-1 flex-wrap">
                        <span class="title text-truncate">{{ $navLibrary->library_code ?? 'LMSP-ACTIVE' }}</span>
                        <span
                            class="badge {{ $isLibActive ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }} rounded-pill flex-shrink-0"
                            style="font-size: 0.6rem; padding: 2px 6px;">
                            {{ $isLibActive ? 'Active' : ucfirst($navStatus) }}
                        </span>
                    </div>
                    <div class="sub text-truncate">
                        {{ $isLibActive ? 'Active library workspace' : 'Pending admin approval' }}
                    </div>
                </div>
                <span class="status-dot flex-shrink-0 {{ $isLibActive ? '' : 'bg-warning' }}"
                    title="{{ $isLibActive ? 'Active' : ucfirst($navStatus) }}"></span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-title">Overview</div>
            <a href="/library-dashboard" class="side-link {{ request()->is('library-dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie flex-shrink-0"></i>
                <span class="flex-grow-1">Dashboard</span>
            </a>

            <div class="nav-title">Library Setup</div>
            <a href="/library/shifts" class="side-link {{ request()->is('library/shifts*') ? 'active' : '' }}">
                <i class="fa-solid fa-clock flex-shrink-0"></i>
                <span class="flex-grow-1">Shifts & Timings</span>
                @if ($navShiftCount === 0)
                    <span class="nav-badge bg-warning text-dark flex-shrink-0">Setup</span>
                @else
                    <span class="nav-badge flex-shrink-0">{{ $navShiftCount }}</span>
                @endif
            </a>
            <a href="/library/seats" class="side-link {{ request()->is('library/seats*') ? 'active' : '' }}">
                <i class="fa-solid fa-chair flex-shrink-0"></i>
                <span class="flex-grow-1">Seats</span>
                @if ($navSeatCount > 0)
                    <span class="nav-badge flex-shrink-0">{{ $navSeatCount }}</span>
                @endif
            </a>

            <div class="nav-title">Library Management</div>
            <a href="/library/students" class="side-link {{ request()->is('library/students*') ? 'active' : '' }}">
                <i class="fa-solid fa-users flex-shrink-0"></i>
                <span class="flex-grow-1">Students</span>
                <span class="d-inline-flex align-items-center gap-1 flex-shrink-0">
                    @if ($navPendingCount > 0)
                        <span class="nav-badge bg-warning text-dark" title="{{ $navPendingCount }} pending approval">
                            +{{ $navPendingCount }}
                        </span>
                    @endif
                    <span class="nav-badge">{{ $navStudentCount }}</span>
                </span>
            </a>
            <a href="/library/attendance" class="side-link {{ request()->is('library/attendance*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check flex-shrink-0"></i>
                <span class="flex-grow-1">Attendance</span>
                @if ($navInsideCount > 0)
                    <span class="nav-badge bg-success text-white flex-shrink-0"
                        title="Inside Now">{{ $navInsideCount }}</span>
                @endif
            </a>
            <a href="/library/fees"
                class="side-link {{ request()->is('library/fees*') || request()->is('library/payments*') ? 'active' : '' }}">
                <i class="fa-solid fa-wallet flex-shrink-0"></i>
                <span class="flex-grow-1">Fees & Payments</span>
            </a>

            <div class="nav-title">Reports</div>
            <a href="/library/reports?tab=students"
                class="side-link {{ request()->is('library/reports*') && $currentTab === 'students' ? 'active' : '' }}">
                <i class="fa-solid fa-file-lines flex-shrink-0"></i>
                <span class="flex-grow-1">Student Report</span>
            </a>
            <a href="/library/reports?tab=payments"
                class="side-link {{ request()->is('library/reports*') && $currentTab === 'payments' ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line flex-shrink-0"></i>
                <span class="flex-grow-1">Payment Report</span>
            </a>

            <div class="nav-title">System</div>
            <a href="#" class="side-link">
                <i class="fa-solid fa-circle-question flex-shrink-0"></i>
                <span class="flex-grow-1">Help & Support</span>
            </a>
            <a href="#" class="side-link"
                onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
                <i class="fa-solid fa-right-from-bracket flex-shrink-0"></i>
                <span class="flex-grow-1">Logout</span>
            </a>
            <form id="sidebar-logout-form" action="{{ route('library.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </nav>

        <div class="side-footer">
            <div class="powered-by">
                <span>Powered by</span>
                <strong>Aqvion Technologies</strong>
                <span class="version">v1.0.0</span>
            </div>
        </div>
    </div>
</aside>
