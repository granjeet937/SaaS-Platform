<aside class="sidebar" id="sidebar">
    @php
        $navLibrary = auth()->user()?->library;
        $navLibName = $navLibrary->library_name ?? 'Study Library';
        $navLibInitial = strtoupper(substr(trim($navLibName), 0, 1)) ?: 'L';
        $navStudentCount = $navLibrary
            ? \App\Models\Student::where('library_id', $navLibrary->id)->where('status', 'active')->count()
            : 0;
        $navShiftCount = $navLibrary
            ? \App\Models\LibraryShift::where('library_id', $navLibrary->id)->where('status', true)->count()
            : 0;
        $currentTab = request('tab', 'students');
    @endphp
    <div class="sidebar-shell">
        <a href="/library-dashboard" class="library-brand">
            <div class="library-brand-logo">
                <img src="https://placehold.co/96x96/e8f7ff/0d7bf3?text={{ $navLibInitial }}" alt="{{ $navLibName }}"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';">
                <span class="library-brand-fallback"><i class="fa-solid fa-building-columns"></i></span>
            </div>
            <span class="library-brand-info">
                <strong class="text-truncate">{{ $navLibName }}</strong>
                <small>{{ $navLibrary->library_type ?? 'Study Library' }}</small>
            </span>
        </a>

        <div class="library-card">
            <div class="d-flex align-items-center gap-2">
                <div class="library-mini-avatar">
                    <i class="fa-solid fa-id-card"></i>
                </div>
                <div class="min-w-0 flex-grow-1">
                    <div class="title text-truncate">{{ $navLibrary->library_code ?? 'LMSP-ACTIVE' }}</div>
                    <div class="sub">Active library workspace</div>
                </div>
                <span class="status-dot" title="Active"></span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-title">Overview</div>
            <a href="/library-dashboard" class="side-link {{ request()->is('library-dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Dashboard</span>
            </a>

            <div class="nav-title">Library Setup</div>
            <a href="/library/shifts" class="side-link {{ request()->is('library/shifts*') ? 'active' : '' }}">
                <i class="fa-solid fa-clock"></i>
                <span>Shifts & Timings</span>
                @if ($navShiftCount === 0)
                    <span class="nav-badge bg-warning text-dark">Setup</span>
                @else
                    <span class="nav-badge">{{ $navShiftCount }}</span>
                @endif
            </a>
            <a href="/library/seats" class="side-link {{ request()->is('library/seats*') ? 'active' : '' }}">
                <i class="fa-solid fa-chair"></i>
                <span>Seats</span>
            </a>

            <div class="nav-title">Library Management</div>
            <a href="/library/students" class="side-link {{ request()->is('library/students*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i>
                <span>Students</span>
                <span class="nav-badge">{{ $navStudentCount }}</span>
            </a>
            <a href="/library/attendance" class="side-link {{ request()->is('library/attendance*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Attendance</span>
            </a>
            <a href="/library/fees"
                class="side-link {{ request()->is('library/fees*') || request()->is('library/payments*') ? 'active' : '' }}">
                <i class="fa-solid fa-wallet"></i>
                <span>Fees & Payments</span>
            </a>

            <div class="nav-title">Reports</div>
            <a href="/library/reports?tab=students"
                class="side-link {{ request()->is('library/reports*') && $currentTab === 'students' ? 'active' : '' }}">
                <i class="fa-solid fa-file-lines"></i>
                <span>Student Report</span>
            </a>
            <a href="/library/reports?tab=payments"
                class="side-link {{ request()->is('library/reports*') && $currentTab === 'payments' ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i>
                <span>Payment Report</span>
            </a>

            <div class="nav-title">System</div>
            <a href="#" class="side-link">
                <i class="fa-solid fa-circle-question"></i>
                <span>Help & Support</span>
            </a>
            <a href="#" class="side-link"
                onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
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
