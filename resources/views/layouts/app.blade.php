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
            background: radial-gradient(circle at 80% 20%, rgba(40, 178, 255, .35), transparent 25%), linear-gradient(125deg, #05152f 0%, #082a53 52%, #0b5db8 100%);
        }

        .visual-wrap {
            perspective: 1400px;
        }

        .dashboard-scene {
            transform-style: preserve-3d;
            transform: rotateY(-10deg) rotateX(6deg);
            animation: sceneFloat 6s ease-in-out infinite;
        }

        .floating-chip {
            background: rgba(255, 255, 255, .15);
            border: 1px solid rgba(255, 255, 255, .25);
            backdrop-filter: blur(12px);
            animation: chipFloat 5s ease-in-out infinite;
        }

        .chip-pos-1 {
            top: 10%;
            right: -2%;
        }

        .chip-pos-2 {
            bottom: 10%;
            left: -4%;
            animation-delay: -2s;
        }

        .chip-pos-3 {
            bottom: -2%;
            right: 15%;
            animation-delay: -1s;
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

        @keyframes sceneFloat {

            0%,
            100% {
                transform: rotateY(-10deg) rotateX(6deg) translateY(0);
            }

            50% {
                transform: rotateY(-8deg) rotateX(4deg) translateY(-12px);
            }
        }

        @keyframes chipFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* --- Hero 3D Scene --- */
        .visual-wrap {
            perspective: 1600px;
            position: relative;
            min-height: 510px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dashboard-scene {
            position: relative;
            width: min(650px, 100%);
            aspect-ratio: 650/420;
            height: auto;
            transform-style: preserve-3d;
            transform: rotateY(-12deg) rotateX(7deg) rotateZ(-1deg);
            transition: transform .35s ease;
            animation: sceneFloat 6s ease-in-out infinite;
        }

        .dashboard-card {
            position: absolute;
            inset: 28px 0 0;
            border-radius: 28px;
            background: linear-gradient(145deg, rgba(255, 255, 255, .98), rgba(233, 244, 255, .94));
            border: 1px solid rgba(255, 255, 255, .8);
            box-shadow: 0 45px 100px rgba(0, 0, 0, .32), inset 0 1px rgba(255, 255, 255, 1);
            padding: 18px;
            overflow: hidden;
            color: #10213d;
        }

        .dashboard-card:before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 100% 0, rgba(81, 184, 255, .18), transparent 34%);
            pointer-events: none;
        }

        /* Dots & Layout */
        .dash-top {
            display: flex;
            gap: 7px;
            margin-bottom: 13px;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #bfd3ea;
        }

        .dash-body {
            display: grid;
            grid-template-columns: 145px 1fr;
            gap: 14px;
        }

        /* Left Mini Sidebar */
        .dash-side {
            background: #071b38;
            border-radius: 17px;
            padding: 14px;
            color: #fff;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .05);
        }

        .dash-side .mini-brand {
            font-weight: 800;
            font-size: 13px;
            margin-bottom: 15px;
        }

        .side-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 10px;
            color: #c8ddf8;
            margin: 9px 0;
            font-weight: 600;
        }

        .side-item.active {
            background: #157cf7;
            color: #fff;
            padding: 7px 9px;
            border-radius: 9px;
        }

        /* Main Metrics & Chart */
        .dash-main {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .mini-title {
            font-weight: 800;
            font-size: 13px;
        }

        .metric-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 9px;
        }

        .metric {
            padding: 10px;
            border-radius: 13px;
            background: rgba(255, 255, 255, .82);
            border: 1px solid #e1edf8;
        }

        .metric small {
            display: block;
            color: #7890a8;
            font-size: 9px;
            font-weight: 600;
        }

        .metric strong {
            font-size: 16px;
            font-weight: 700;
        }

        .chart {
            height: 120px;
            border-radius: 15px;
            background: rgba(255, 255, 255, .88);
            border: 1px solid #e1edf8;
            position: relative;
            overflow: hidden;
        }

        .bars {
            position: absolute;
            inset: 20px 18px 18px;
            display: flex;
            align-items: flex-end;
            gap: 10px;
        }

        .bar {
            flex: 1;
            border-radius: 7px 7px 2px 2px;
            background: linear-gradient(180deg, #1b9eff, #62d4ff);
            box-shadow: 0 8px 16px rgba(33, 156, 255, .18);
            animation: barPulse 2s ease-in-out infinite;
        }

        .bar:nth-child(2) {
            animation-delay: .1s;
        }

        .bar:nth-child(3) {
            animation-delay: .2s;
        }

        .bar:nth-child(4) {
            animation-delay: .3s;
        }

        .bar:nth-child(5) {
            animation-delay: .4s;
        }

        .bar:nth-child(6) {
            animation-delay: .5s;
        }

        .bar:nth-child(7) {
            animation-delay: .6s;
        }

        /* Floating Chips */
        .floating-chip {
            position: absolute;
            padding: 11px 15px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .22);
            box-shadow: 0 20px 50px rgba(0, 0, 0, .2);
            backdrop-filter: blur(16px);
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 10;
            animation: chipFloat 5s ease-in-out infinite;
        }

        .floating-chip i {
            color: #60e1ff;
        }

        .chip1 {
            top: 8%;
            right: -4%;
        }

        .chip2 {
            left: -6%;
            bottom: 10%;
            animation-delay: -2s;
        }

        .chip3 {
            right: 15%;
            bottom: -4%;
            animation-delay: -1s;
        }

        /* Keyframes */
        @keyframes sceneFloat {

            0%,
            100% {
                transform: rotateY(-12deg) rotateX(7deg) rotateZ(-1deg) translateY(0);
            }

            50% {
                transform: rotateY(-10deg) rotateX(5deg) rotateZ(-.5deg) translateY(-14px);
            }
        }

        @keyframes chipFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-12px);
            }
        }

        @keyframes barPulse {
            50% {
                transform: scaleY(.88);
                opacity: .82;
            }
        }

        /* Mobile & Tablet Adjustments */
        @media (max-width: 991.98px) {
            .visual-wrap {
                min-height: 420px;
            }

            .dashboard-scene {
                transform: rotateY(-6deg) rotateX(4deg);
            }

            .chip1 {
                right: 0;
            }

            .chip2 {
                left: 0;
            }
        }

        @media (max-width: 575.98px) {
            .visual-wrap {
                min-height: 320px;
            }

            .dashboard-scene {
                width: 100%;
                transform: none;
                animation: none;
            }

            .dash-body {
                grid-template-columns: 100px 1fr;
                gap: 8px;
            }

            .dash-side {
                padding: 9px;
            }

            .side-item {
                font-size: 8px;
                margin: 6px 0;
            }

            .metric strong {
                font-size: 13px;
            }

            .chart {
                height: 85px;
            }

            .floating-chip {
                display: none;
            }

            /* Mobile screens par overlap hatane ke liye */
        }
    </style>
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
    </script>
    <!-- Global Scroll Reveal & 3D Parallax Script -->
    <script>
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
        const visual = document.getElementById('heroVisual');
        const scene = document.getElementById('dashScene');
        if (visual && scene && window.matchMedia('(min-width: 992px)').matches) {
            visual.addEventListener('mousemove', (e) => {
                const r = visual.getBoundingClientRect();
                const x = (e.clientX - r.left) / r.width - .5;
                const y = (e.clientY - r.top) / r.height - .5;
                scene.style.animation = 'none';
                scene.style.transform =
                    `rotateY(${(-10 + x * 7).toFixed(2)}deg) rotateX(${(6 - y * 6).toFixed(2)}deg) translateY(-2px)`;
            });
            visual.addEventListener('mouseleave', () => {
                scene.style.animation = 'sceneFloat 6s ease-in-out infinite';
                scene.style.transform = '';
            });
        }
    </script>
    @stack('scripts')
</body>

</html>
