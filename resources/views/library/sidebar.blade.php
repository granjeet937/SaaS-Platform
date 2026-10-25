<aside class="sidebar" id="sidebar">
    <div class="sidebar-shell">
        <a href="#" class="library-brand">
            <div class="library-brand-logo">
                <img src="https://placehold.co/96x96/e8f7ff/0d7bf3?text=R" alt="Riyansh Digital Library"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';">
                <span class="library-brand-fallback"><i class="fa-solid fa-building-columns"></i></span>
            </div>
            <span class="library-brand-info">
                <strong class="text-truncate">Riyansh Digital Library</strong>
                <small>Study Library</small>
            </span>
        </a>

        <div class="library-card">
            <div class="d-flex align-items-center gap-2">
                <div class="library-mini-avatar">
                    <i class="fa-solid fa-id-card"></i>
                </div>
                <div class="min-w-0 flex-grow-1">
                    <div class="title text-truncate">LMSP-2026-AX72</div>
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

            <div class="nav-title">Library Management</div>
            <a href="/library/students" class="side-link {{ request()->is('library/students*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i>
                <span>Students</span>
                <span class="nav-badge">250</span>
            </a>
            <a href="#" class="side-link">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Attendance</span>
            </a>
            <a href="#" class="side-link">
                <i class="fa-solid fa-chair"></i>
                <span>Seats</span>
            </a>
            <a href="#" class="side-link">
                <i class="fa-solid fa-file-lines"></i>
                <span>Student Report</span>
            </a>
            <a href="#" class="side-link">
                <i class="fa-solid fa-wallet"></i>
                <span>Fees & Payments</span>
                <span class="nav-badge">12</span>
            </a>
            <a href="#" class="side-link">
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
                <strong>LMSP</strong>
                <span class="version">v1.0.0</span>
            </div>
        </div>
    </div>
</aside>
