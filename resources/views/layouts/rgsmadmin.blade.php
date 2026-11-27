<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LMSP — SaaS Super Admin')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 268px;
            --navy: #07162e;
            --blue: #0f7cff;
            --ink: #0f172a;
            --muted: #64748b;
            --shadow: 0 12px 32px rgba(15, 23, 42, 0.06);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--ink);
            background: #f4f7fb;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        .admin-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: var(--sidebar-width);
            z-index: 1050;
            padding: 14px;
        }

        .admin-sidebar-shell {
            height: 100%;
            border-radius: 22px;
            background: linear-gradient(165deg, #061226 0%, #0b254b 60%, #0e4f96 100%);
            box-shadow: 0 20px 50px rgba(6, 18, 38, 0.25);
            color: #fff;
            padding: 18px 14px;
            display: flex;
            flex-direction: column;
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 4px 6px 16px;
            color: #fff;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 14px;
        }

        .admin-brand-icon {
            width: 42px;
            height: 42px;
            border-radius: 13px;
            background: linear-gradient(135deg, #0f7cff, #38bdf8);
            display: grid;
            place-items: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .admin-nav {
            flex: 1;
            overflow-y: auto;
            scrollbar-width: none;
        }

        .admin-nav::-webkit-scrollbar {
            display: none;
        }

        .admin-nav-title {
            color: #7ea0c4;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 12px 10px 6px;
        }

        .admin-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 12px;
            margin: 3px 0;
            color: #cbd5e1;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            transition: 0.2s ease;
        }

        .admin-link i {
            width: 18px;
            text-align: center;
            color: #7dd3fc;
        }

        .admin-link:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }

        .admin-link.active {
            background: linear-gradient(135deg, #0f7cff, #0284c7);
            color: #fff;
            box-shadow: 0 8px 20px rgba(15, 124, 255, 0.3);
        }

        .admin-link.active i {
            color: #fff;
        }

        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .admin-topbar {
            position: sticky;
            top: 0;
            z-index: 900;
            padding: 14px 24px 0;
        }

        .admin-topbar-inner {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 10px 16px;
            box-shadow: var(--shadow);
        }

        .admin-content {
            flex: 1;
            padding: 20px 24px 32px;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 1040;
            background: rgba(6, 18, 38, 0.45);
        }

        @media (max-width: 991.98px) {
            :root {
                --sidebar-width: 0px;
            }

            .admin-sidebar {
                width: 280px;
                max-width: 85vw;
                transform: translateX(-105%);
                transition: transform 0.25s ease;
                padding: 8px;
                z-index: 1060;
            }

            .admin-sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
            }

            .admin-main {
                margin-left: 0;
            }

            .admin-topbar {
                padding: 10px 14px 0;
            }

            .admin-content {
                padding: 16px 14px 24px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="sidebar-overlay" id="adminSidebarOverlay"></div>

    @include('components.rgsmadmin.sidebar')

    <div class="admin-main">
        @include('components.rgsmadmin.header')

        <main class="admin-content">
            @yield('content')
        </main>

        @include('components.rgsmadmin.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const adminSidebar = document.getElementById('adminSidebar');
        const adminOverlay = document.getElementById('adminSidebarOverlay');
        const adminToggle = document.getElementById('adminMenuToggle');

        adminToggle?.addEventListener('click', () => {
            adminSidebar.classList.add('open');
            adminOverlay.classList.add('show');
        });

        adminOverlay?.addEventListener('click', () => {
            adminSidebar.classList.remove('open');
            adminOverlay.classList.remove('show');
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: @json(session('success')),
                showConfirmButton: false,
                timer: 2600,
                timerProgressBar: true
            });
        </script>
    @endif

    @stack('scripts')
</body>

</html>
