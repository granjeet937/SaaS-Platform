<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LMSP - Premium Study Library Management SaaS Platform">
    <title>@yield('title', 'LMSP — Smart Study Library Management SaaS')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap 5.3.3 & FontAwesome 6 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --navy: #07162e;
            --blue: #0f7cff;
            --cyan: #35d5ff;
            --ink: #10213d;
            --glass: rgba(255, 255, 255, .75);
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--ink);
            background-color: #f8fbff;
            overflow-x: hidden;
        }

        .font-head {
            font-family: 'Space Grotesk', sans-serif;
        }

        .bg-soft {
            background: linear-gradient(180deg, #f8fbff, #eef7ff);
        }

        .glass-card {
            background: var(--glass);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, .9);
        }

        .logo-box {
            background: linear-gradient(145deg, #0d64dc, #30cfff);
            box-shadow: 0 8px 18px rgba(19, 128, 255, .25);
        }

        .btn-main {
            background: linear-gradient(135deg, #1592ff, #0e66ef);
            color: #fff;
            border: 0;
            font-weight: 700;
            transition: .25s ease;
        }

        .btn-main:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(13, 115, 246, .28);
        }

        .gradient-text {
            background: linear-gradient(90deg, #43dfff, #8ea6ff, #54f6c0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Hero gradients & glow */
        .hero-section {
            padding-top: 150px;
            background: radial-gradient(circle at 80% 20%, rgba(40, 178, 255, .35), transparent 25%),
                linear-gradient(125deg, #05152f 0%, #082a53 52%, #0b5db8 100%);
        }

        /* Interactive Cards */
        .hover-lift {
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(28, 83, 137, .12) !important;
        }

        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity .7s ease, transform .7s ease;
        }

        .reveal.show {
            opacity: 1;
            transform: none;
        }
    </style>

    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100 position-relative">

    {{-- Global Navbar --}}
    @include('layouts.header')

    {{-- Page Body Content --}}
    <main class="flex-grow-1">
        @yield('content')
    </main>

    {{-- Global Footer --}}
    @include('layouts.footer')

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            @if (session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: @json(session('success')),
                    showConfirmButton: false,
                    timer: 3500,
                    timerProgressBar: true
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: @json(session('error')),
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true
                });
            @endif

            @if (session('warning'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'warning',
                    title: @json(session('warning')),
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true
                });
            @endif

            @if (session('info'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: @json(session('info')),
                    showConfirmButton: false,
                    timer: 3500,
                    timerProgressBar: true
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Please check the form.',
                    html: `
                        <ul style="margin:0; padding-left:18px; text-align:left;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    `,
                    showConfirmButton: false,
                    timer: 6000,
                    timerProgressBar: true
                });
            @endif

        });

        // Scroll animation observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: .1
        });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>

    @stack('scripts')
</body>

</html>
