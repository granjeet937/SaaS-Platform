@php
    $pendingLibsCount = \App\Models\Library::where('status', 'pending')->count();
    $totalLibsCount = \App\Models\Library::count();
@endphp

<aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-sidebar-shell">
        <a href="{{ url('/rgsmadmin/dashboard') }}" class="admin-brand">
            <div class="admin-brand-icon">
                <i class="fa-solid fa-crown"></i>
            </div>
            <div class="min-w-0">
                <strong class="d-block fs-6" style="font-family: 'Space Grotesk', sans-serif;">LMSP Admin</strong>
                <small class="text-info" style="font-size: 11px;">SaaS Owner Panel</small>
            </div>
        </a>

        <nav class="admin-nav">
            <div class="admin-nav-title">Overview</div>
            <a href="{{ url('/rgsmadmin/dashboard') }}"
                class="admin-link {{ request()->is('rgsmadmin/dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i>
                <span class="flex-grow-1">Dashboard</span>
            </a>

            <div class="admin-nav-title">Tenants & Billing</div>
            <a href="{{ url('/rgsmadmin/dashboard?status=pending') }}"
                class="admin-link {{ request('status') === 'pending' ? 'active' : '' }}">
                <i class="fa-solid fa-hourglass-half"></i>
                <span class="flex-grow-1">Pending Approvals</span>
                @if ($pendingLibsCount > 0)
                    <span class="badge bg-warning text-dark rounded-pill">{{ $pendingLibsCount }}</span>
                @endif
            </a>

            <a href="{{ url('/rgsmadmin/dashboard?status=all') }}"
                class="admin-link {{ request('status') === 'all' ? 'active' : '' }}">
                <i class="fa-solid fa-building-columns"></i>
                <span class="flex-grow-1">All Libraries</span>
                <span class="badge bg-white bg-opacity-10 rounded-pill">{{ $totalLibsCount }}</span>
            </a>

            <div class="admin-nav-title">Account</div>
            <a href="#" class="admin-link text-danger"
                onclick="event.preventDefault(); document.getElementById('saas-admin-logout').submit();">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </a>
            <form id="saas-admin-logout" action="{{ route('rgsmadmin.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </nav>

        <div class="pt-3 border-top border-white border-opacity-10 text-center"
            style="font-size: 11px; color: #94a3b8;">
            LMSP SaaS Engine &bull; v1.0
        </div>
    </div>
</aside>
