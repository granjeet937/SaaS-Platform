<header class="admin-topbar">
    <div class="admin-topbar-inner d-flex align-items-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-light border d-lg-none" id="adminMenuToggle">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div>
                <h6 class="fw-bold mb-0">SaaS Control Center</h6>
                <small class="text-muted d-none d-sm-inline">Manage libraries, approvals, plans & platform
                    revenue</small>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <a href="{{ url('/') }}" target="_blank"
                class="btn btn-outline-primary btn-sm rounded-pill px-3 d-none d-md-inline-flex align-items-center gap-1">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Visit Site
            </a>

            <div class="d-flex align-items-center gap-2">
                <div class="rounded-3 bg-primary-subtle text-primary fw-bold d-grid"
                    style="width:38px;height:38px;place-items:center;">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div class="d-none d-sm-block lh-sm">
                    <div class="fw-bold small">{{ auth()->user()?->name ?? 'SaaS Admin' }}</div>
                    <small class="text-muted" style="font-size: 11px;">Super Admin</small>
                </div>
            </div>
        </div>
    </div>
</header>
