<!-- partial:partials/_sidebar -->
<nav class="sidebar sidebar-offcanvas shadow" id="sidebar">
    <ul class="nav">

        <!-- ADMIN PROFILE -->
        <li class="nav-item nav-profile shadow mb-4">
            <div class="nav-link bgcolor">
                <div class="profile-image">
                    <img src="{{ asset(Auth::guard('admin')->user()->image ?? 'images/faces/face5.jpg') }}"
                        alt="image" />
                </div>
                <div class="profile-name">
                    <p class="name text-light">
                        {{ Auth::guard('admin')->user()->fullname ?? 'Admin' }}
                    </p>

                    <p class="designation text-light">
                        {{ Auth::guard('admin')->user()->role === 'admin' ? 'Super Admin' : ucfirst(Auth::guard('admin')->user()->role) }}
                    </p>
                </div>
            </div>
        </li>

        <!-- DASHBOARD -->
        <li class="nav-item {{ request()->is('admin') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/admin') }}">
                <i class="fas fa-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <!-- USERS -->
        <li class="nav-item {{ request()->is('admin/users*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/admin/users') }}">
                <i class="fas fa-users menu-icon"></i>
                <span class="menu-title">Users</span>
            </a>
        </li>

        <!-- WALLETS -->
        <li class="nav-item {{ request()->is('admin/wallets*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/admin/wallets') }}">
                <i class="fas fa-wallet menu-icon"></i>
                <span class="menu-title">Investments</span>
            </a>
        </li>

        <!-- LOANS -->
        <li class="nav-item {{ request()->is('admin/loans*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/admin/loans') }}">
                <i class="fas fa-file-invoice-dollar menu-icon"></i>
                <span class="menu-title">Loans</span>
            </a>
        </li>

        <!-- EMI -->
        <li class="nav-item {{ request()->is('admin/emis*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/admin/emis') }}">
                <i class="fas fa-calendar-check menu-icon"></i>
                <span class="menu-title">EMI Management</span>
            </a>
        </li>

        <!-- APPROVALS -->
        <li class="nav-item {{ request()->is('admin/approvals*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/admin/approvals') }}">
                <i class="fas fa-clock menu-icon"></i>
                <span class="menu-title">Pending EMIs</span>
            </a>
        </li>

        <!-- REPORTS -->
        <li class="nav-item {{ request()->is('admin/reports*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/admin/reports') }}">
                <i class="fas fa-chart-line menu-icon"></i>
                <span class="menu-title">Reports</span>
            </a>
        </li>
        <!-- Policy -->
        <li class="nav-item {{ request()->is('admin/loanPolicy*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/admin/loanPolicy') }}">
                <i class="fas fa-shield-alt  menu-icon menu-icon"></i>
                <span class="menu-title">Loan Policy</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('admin/investorpolicy*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/admin/investorpolicy') }}">
                <i class="fas fa-balance-scale menu-icon menu-icon"></i>
                <span class="menu-title">Investor Policy</span>
            </a>
        </li>

        <!-- SETTINGS -->
        <li class="nav-item {{ request()->is('admin/settings*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/admin/settings') }}">
                <i class="fas fa-cog menu-icon"></i>
                <span class="menu-title">Settings</span>
            </a>
        </li>

        <!-- LOGOUT -->
        <li class="nav-item">
            <a class="nav-link text-danger" href="{{ route('admin.logout') }}">
                <i class="fas fa-sign-out-alt menu-icon"></i>
                <span class="menu-title">Logout</span>
            </a>
        </li>

    </ul>
</nav>
