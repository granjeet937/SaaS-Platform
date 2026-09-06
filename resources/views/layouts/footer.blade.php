<footer id="contact" class="bg-dark text-white pt-5 pb-4 mt-auto border-top border-secondary border-opacity-25 position-relative z-1" style="background-color: #05152c !important;">
    <div class="container-xxl px-4 px-lg-5">
        <div class="row g-4">
            <div class="col-lg-5">
                <a class="d-inline-flex align-items-center gap-2 text-white text-decoration-none mb-3" href="{{ url('/') }}">
                    <div class="logo-box rounded-3 text-white" style="width: 38px; height: 38px; display: grid; place-items: center;">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <div>
                        <strong class="font-head fs-5 text-white d-block lh-1">LMSP</strong>
                        <small class="text-white-50" style="font-size: 9px;">Library Management SaaS Platform</small>
                    </div>
                </a>
                <p class="text-white-50 small pe-lg-5">
                    A premium management platform built for modern study libraries, self-study reading rooms, and student coworking hubs.
                </p>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="fw-bold mb-3">Product</h6>
                <div class="d-flex flex-column gap-2 small">
                    <a class="text-white-50 text-decoration-none" href="#features">Features</a>
                    <a class="text-white-50 text-decoration-none" href="#how">How It Works</a>
                    <a class="text-white-50 text-decoration-none" href="#pricing">Pricing</a>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="fw-bold mb-3">Company</h6>
                <div class="d-flex flex-column gap-2 small">
                    <a class="text-white-50 text-decoration-none" href="#contact">Contact</a>
                    <a class="text-white-50 text-decoration-none" href="{{ url('/library-login') }}">Login</a>
                    <a class="text-white-50 text-decoration-none" href="{{ url('/library-registration') }}">Register</a>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <h6 class="fw-bold mb-3">Platform Features</h6>
                <p class="small text-white-50 mb-0">
                    Students · Shift Attendance · Seat Layout · Memberships · Auto Expiry Alerts · Financial Reports
                </p>
            </div>
        </div>
        <hr class="border-secondary border-opacity-25 my-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 small text-white-50">
            <span>&copy; {{ date('Y') }} LMSP. All rights reserved.</span>
            <div class="d-flex gap-3 fs-6">
                <a href="#" class="text-white-50"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="text-white-50"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="text-white-50"><i class="fa-brands fa-linkedin"></i></a>
                <a href="#" class="text-white-50"><i class="fa-brands fa-x-twitter"></i></a>
            </div>
        </div>
    </div>
</footer>