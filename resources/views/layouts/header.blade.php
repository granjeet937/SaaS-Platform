<div class="nav-shell position-absolute top-0 start-50 translate-middle-x w-100 px-3 z-3" style="max-width: 1450px; margin-top: 16px;">
    <nav class="navbar navbar-expand-lg glass-card rounded-4 px-3 py-2">
        <div class="container-fluid p-0">
            <a class="navbar-brand d-flex align-items-center gap-2 m-0" href="{{ url('/') }}">
                <div class="logo-box rounded-3 text-white d-grid place-items-center" style="width: 42px; height: 42px; display: grid; place-items: center;">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div>
                    <strong class="font-head fs-5 d-block lh-1 text-dark">LMSP</strong>
                    <small class="text-secondary fw-semibold" style="font-size: 9px; letter-spacing: 0.1px;">Study Library SaaS</small>
                </div>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto fw-bold gap-lg-2">
                    <li class="nav-item"><a class="nav-link px-3 text-dark active" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link px-3 text-secondary" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link px-3 text-secondary" href="#how">How It Works</a></li>
                    <li class="nav-item"><a class="nav-link px-3 text-secondary" href="#pricing">Pricing</a></li>
                    <li class="nav-item"><a class="nav-link px-3 text-secondary" href="#contact">Contact</a></li>
                </ul>
                <div class="d-flex gap-2 mt-3 mt-lg-0">
                    <a href="{{ url('/library-login') }}" class="btn btn-outline-primary fw-bold rounded-3 px-3 py-2">Login</a>
                    <a href="{{ url('/library-registration') }}" class="btn btn-main rounded-3 px-3 py-2">
                        Get Started <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</div>