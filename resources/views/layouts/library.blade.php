<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LMSP Study Library Management Dashboard">
    <title>@yield('title', 'LMSP — Library Dashboard')</title>

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --navy: #07162e;
            --navy2: #0a2345;
            --blue: #0f7cff;
            --cyan: #35d5ff;
            --ink: #10213d;
            --muted: #6d819d;
            --line: #dce8f7;
            --soft: #f6faff;
            --success: #18b879;
            --warning: #f5a623;
            --danger: #e85d75;
            --purple: #7858eb;
            --sidebar-width: 278px;
            --shadow: 0 18px 45px rgba(23, 70, 120, .08);
            --shadow-lg: 0 26px 70px rgba(17, 70, 120, .12);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, system-ui, sans-serif;
            color: var(--ink);
            background: radial-gradient(circle at 8% 0%, rgba(53, 213, 255, .07), transparent 24%),
                radial-gradient(circle at 94% 10%, rgba(120, 88, 235, .06), transparent 24%), #f7fbff;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        button,
        input,
        select {
            font-family: inherit;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: var(--sidebar-width);
            z-index: 1050;
            padding: 16px;
        }

        .sidebar-shell {
            height: 100%;
            border-radius: 24px;
            background: radial-gradient(circle at 90% 8%, rgba(53, 213, 255, .13), transparent 25%),
                linear-gradient(160deg, #07162e 0%, #08264b 57%, #0b5fa9 100%);
            box-shadow: 0 25px 70px rgba(8, 42, 80, .23);
            color: #fff;
            padding: 17px 14px 14px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
        }

        .library-brand {
            display: flex;
            align-items: center;
            gap: 11px;
            color: #fff;
            padding: 4px 6px 16px;
            position: relative;
            z-index: 2;
        }

        .library-brand-logo {
            width: 48px;
            height: 48px;
            flex: 0 0 48px;
            display: grid;
            place-items: center;
            overflow: hidden;
            border-radius: 15px;
            background: #fff;
            border: 1px solid rgba(255, 255, 255, .28);
        }

        .library-brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .library-brand-info strong {
            display: block;
            max-width: 170px;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 14px;
            line-height: 1.15;
        }

        .library-brand-info small {
            display: block;
            color: #91b0cf;
            font-size: 9px;
            margin-top: 4px;
            font-weight: 700;
        }

        .library-card {
            margin: 0 2px 15px;
            padding: 12px;
            border: 1px solid rgba(255, 255, 255, .11);
            background: rgba(255, 255, 255, .07);
            border-radius: 17px;
        }

        .library-mini-avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            color: #58dfff;
            background: rgba(255, 255, 255, .08);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #38e2a2;
        }

        .sidebar-nav {
            flex: 1;
            overflow: auto;
            padding: 3px 1px;
            scrollbar-width: none;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 0;
            display: none;
        }

        .nav-title {
            color: #7698b8;
            font-size: 9px;
            font-weight: 900;
            letter-spacing: 1.1px;
            padding: 12px 10px 7px;
            text-transform: uppercase;
        }

        .side-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 9px 11px;
            margin: 3px 0;
            color: #c6d9ed;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
            transition: .22s ease;
        }

        .side-link i {
            width: 18px;
            text-align: center;
            color: #7fa7cd;
        }

        .side-link:hover {
            background: rgba(255, 255, 255, .07);
            color: #fff;
            transform: translateX(2px);
        }

        .side-link.active {
            color: #fff;
            background: linear-gradient(135deg, #158eff, #0c6ef2);
            box-shadow: 0 13px 28px rgba(15, 124, 255, .26);
        }

        .side-link.active i {
            color: #fff;
        }

        .nav-badge {
            margin-left: auto;
            min-width: 22px;
            height: 20px;
            padding: 0 6px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            font-size: 9px;
            background: rgba(255, 255, 255, .10);
            color: #dff2ff;
        }

        .side-footer {
            margin-top: 8px;
            padding-top: 11px;
            border-top: 1px solid rgba(255, 255, 255, .10);
        }

        .powered-by {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            color: #7396b7;
            font-size: 8px;
        }

        .powered-by strong {
            color: #bcd2e8;
            font-size: 9px;
        }

        /* ===== MAIN AREA ===== */
        .main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 900;
            padding: 14px 24px;
            backdrop-filter: blur(16px);
            background: rgba(247, 251, 255, .78);
            border-bottom: 1px solid rgba(220, 232, 247, .62);
        }

        .topbar-inner {
            min-height: 58px;
            background: rgba(255, 255, 255, .86);
            border: 1px solid rgba(255, 255, 255, .96);
            border-radius: 18px;
            box-shadow: var(--shadow);
            padding: 8px 12px;
        }

        .menu-toggle {
            display: none;
        }

        .search {
            max-width: 420px;
            flex: 1;
        }

        .search .input-group-text,
        .search .form-control {
            border: 0;
            background: #f4f8fd;
        }

        .search .input-group-text {
            border-radius: 12px 0 0 12px;
            color: #7890a8;
        }

        .search .form-control {
            height: 42px;
            border-radius: 0 12px 12px 0;
            font-size: 12px;
            box-shadow: none;
        }

        .top-icon {
            width: 40px;
            height: 40px;
            border: 1px solid #e4edf6;
            background: #fff;
            color: #58718f;
            border-radius: 12px;
            display: grid;
            place-items: center;
            position: relative;
            transition: .2s ease;
        }

        .notification-dot {
            position: absolute;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #ee5d76;
            top: 8px;
            right: 8px;
            border: 2px solid #fff;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 9px;
            padding-left: 6px;
        }

        .profile-avatar {
            width: 39px;
            height: 39px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            color: #0b67db;
            background: linear-gradient(145deg, #e2f3ff, #fff);
            border: 1px solid #d7eaf9;
            font-weight: 900;
            font-size: 11px;
        }

        .profile-name {
            font-size: 11px;
            font-weight: 800;
            line-height: 1.1;
        }

        .profile-role {
            color: #8a9caf;
            font-size: 9px;
            margin-top: 3px;
        }

        .content {
            flex: 1;
            padding: 10px 24px 36px;
        }

        /* ===== DASHBOARD CONTENT COMPONENTS CSS ===== */
        .welcome {
            padding: 10px 2px 22px;
        }

        .welcome-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 11px;
            background: #e8f5ff;
            border: 1px solid #d6ebff;
            color: #0877ef;
            font-size: 9px;
            font-weight: 900;
            letter-spacing: .9px;
            border-radius: 999px;
            text-transform: uppercase;
        }

        .welcome h1 {
            font-family: 'Space Grotesk', sans-serif;
            margin: 14px 0 6px;
            font-size: clamp(28px, 3.3vw, 46px);
            letter-spacing: -1.5px;
            line-height: 1.04;
        }

        .welcome p {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
        }

        .date-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 13px;
            border: 1px solid #deebf7;
            background: #fff;
            color: #627b96;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 800;
            box-shadow: 0 9px 24px rgba(27, 83, 134, .06);
        }

        /* KPI Cards */
        .kpi-card {
            height: 100%;
            border: 1px solid rgba(210, 228, 244, .88);
            background: rgba(255, 255, 255, .80);
            border-radius: 20px;
            padding: 19px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            transition: .25s ease;
        }

        .kpi-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .kpi-icon {
            width: 43px;
            height: 43px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            color: #fff;
            background: linear-gradient(145deg, #168af7, #58d5ff);
            box-shadow: 0 12px 23px rgba(25, 135, 244, .20);
        }

        .kpi-icon.green {
            background: linear-gradient(145deg, #10ad73, #4be0b0);
        }

        .kpi-icon.purple {
            background: linear-gradient(145deg, #7350e8, #b17cff);
        }

        .kpi-icon.orange {
            background: linear-gradient(145deg, #f18c24, #ffc96e);
        }

        .kpi-icon.pink {
            background: linear-gradient(145deg, #e65b85, #ff95bd);
        }

        .trend {
            padding: 6px 8px;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 900;
        }

        .trend.up {
            background: #eafaf3;
            color: #159366;
        }

        .trend.down {
            background: #fff0f3;
            color: #c84e68;
        }

        .kpi-label {
            color: #7b8fa4;
            font-size: 10px;
            font-weight: 700;
            margin-top: 16px;
        }

        .kpi-value {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 28px;
            font-weight: 700;
            margin-top: 3px;
            letter-spacing: -.9px;
        }

        .kpi-meta {
            color: #94a5b7;
            font-size: 9px;
            margin-top: 5px;
        }

        /* Panels */
        .panel {
            height: 100%;
            border: 1px solid rgba(210, 228, 244, .88);
            background: rgba(255, 255, 255, .80);
            border-radius: 22px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .panel-head {
            padding: 18px 19px 14px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            border-bottom: 1px solid #e9f0f7;
        }

        .panel-title {
            font-size: 13px;
            font-weight: 900;
        }

        .panel-sub {
            color: #8a9caf;
            font-size: 9px;
            margin-top: 4px;
        }

        .panel-action {
            color: #0c76e8;
            font-size: 10px;
            font-weight: 800;
        }

        /* Bar Chart */
        .chart-wrap {
            padding: 18px 18px 8px;
        }

        .chart-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }

        .chart-value {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 24px;
            font-weight: 700;
        }

        .chart-note {
            color: #8da0b3;
            font-size: 9px;
        }

        .bar-chart {
            height: 240px;
            display: flex;
            align-items: flex-end;
            gap: clamp(7px, 1.4vw, 16px);
            padding: 15px 6px 24px;
            background: linear-gradient(to bottom, transparent 24%, #edf3f8 25%, transparent 25%, transparent 49%, #edf3f8 50%, transparent 50%, transparent 74%, #edf3f8 75%, transparent 75%);
            position: relative;
            border-radius: 15px;
        }

        .bar-col {
            height: 100%;
            flex: 1;
            display: flex;
            align-items: flex-end;
            gap: 6px;
            position: relative;
        }

        .bar {
            width: 100%;
            min-height: 18px;
            border-radius: 8px 8px 3px 3px;
            background: linear-gradient(180deg, #1ba2ff, #55dcff);
            box-shadow: 0 12px 23px rgba(38, 162, 244, .16);
        }

        .bar.secondary {
            background: linear-gradient(180deg, #8b6cff, #bca0ff);
            box-shadow: 0 12px 23px rgba(122, 92, 242, .12);
        }

        .bar-label {
            position: absolute;
            bottom: -22px;
            left: 50%;
            transform: translateX(-50%);
            color: #93a2b3;
            font-size: 8px;
        }

        .chart-legend {
            display: flex;
            gap: 14px;
            margin-top: 12px;
            color: #7c91a7;
            font-size: 9px;
            font-weight: 700;
        }

        .legend-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .legend-blue {
            background: #27abff;
        }

        .legend-purple {
            background: #987bff;
        }

        /* Seat Map */
        .seat-map {
            padding: 18px;
        }

        .seat-summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 9px;
            margin-bottom: 14px;
        }

        .seat-stat {
            padding: 11px;
            border-radius: 14px;
            border: 1px solid #e3edf7;
            background: #fbfdff;
        }

        .seat-stat small {
            display: block;
            color: #8b9db0;
            font-size: 8px;
        }

        .seat-stat strong {
            display: block;
            margin-top: 3px;
            font-size: 15px;
        }

        .seat-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
        }

        .seat {
            height: 42px;
            border-radius: 11px;
            border: 1px solid #dfeaf5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            font-weight: 800;
            color: #5b7390;
            background: #f4f9fe;
            position: relative;
            transition: .2s;
        }

        .seat.available {
            border-color: #bfead9;
            background: #effbf6;
            color: #168963;
        }

        .seat.occupied {
            border-color: #c8ddf6;
            background: #edf6ff;
            color: #0d72e1;
        }

        .seat.reserved {
            border-color: #ead8ff;
            background: #f6efff;
            color: #7b57dc;
        }

        .seat i {
            font-size: 8px;
            margin-right: 4px;
        }

        .seat-legend {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            padding-top: 13px;
            color: #8395a8;
            font-size: 8px;
            font-weight: 700;
        }

        /* Student Table */
        .table-wrap {
            overflow: auto;
        }

        .student-table {
            margin: 0;
            min-width: 620px;
        }

        .student-table th {
            color: #8a9cad;
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .5px;
            border-bottom: 1px solid #edf2f7;
            padding: 12px 18px;
            white-space: nowrap;
        }

        .student-table td {
            padding: 12px 18px;
            border-bottom: 1px solid #f0f4f8;
            font-size: 10px;
            color: #536b85;
            vertical-align: middle;
        }

        .student {
            display: flex;
            align-items: center;
            gap: 9px;
            min-width: 160px;
        }

        .student-avatar {
            width: 31px;
            height: 31px;
            border-radius: 10px;
            background: linear-gradient(145deg, #e4f4ff, #fff);
            border: 1px solid #d8eaf8;
            display: grid;
            place-items: center;
            color: #1d75d4;
            font-size: 9px;
            font-weight: 900;
        }

        .student-name {
            font-weight: 800;
            color: #29445f;
            font-size: 10px;
        }

        .student-id {
            color: #9aabba;
            font-size: 8px;
            margin-top: 2px;
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 8px;
            border-radius: 999px;
            font-size: 8px;
            font-weight: 900;
        }

        .status.present {
            color: #12895f;
            background: #eafaf3;
        }

        .status.pending {
            color: #b47a1d;
            background: #fff7e9;
        }

        /* Recent Activity */
        .activity-list {
            padding: 8px 18px 14px;
        }

        .activity {
            display: flex;
            gap: 11px;
            padding: 11px 0;
            border-bottom: 1px solid #eef3f7;
        }

        .activity:last-child {
            border-bottom: 0;
        }

        .activity-icon {
            width: 31px;
            height: 31px;
            flex: 0 0 auto;
            border-radius: 10px;
            display: grid;
            place-items: center;
            color: #0c75e7;
            background: #edf6ff;
            font-size: 10px;
        }

        .activity-icon.green {
            background: #eafaf3;
            color: #168d65;
        }

        .activity-icon.purple {
            background: #f4efff;
            color: #7858e4;
        }

        .activity-icon.orange {
            background: #fff6e9;
            color: #c57c15;
        }

        .activity-text {
            flex: 1;
            font-size: 9px;
            color: #627890;
            line-height: 1.5;
        }

        .activity-text strong {
            color: #2c4863;
        }

        .activity-time {
            display: block;
            color: #a0adba;
            margin-top: 3px;
            font-size: 8px;
        }

        /* Quick Actions Grid */
        .quick-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            padding: 18px;
        }

        .quick {
            border: 1px solid #e3edf6;
            border-radius: 15px;
            padding: 13px;
            background: #fbfdff;
            color: #59728e;
            transition: .2s;
            display: block;
        }

        .quick:hover {
            transform: translateY(-3px);
            border-color: #c8ddf4;
            box-shadow: 0 10px 24px rgba(29, 96, 155, .07);
            color: #0c76e8;
        }

        .quick-icon {
            width: 35px;
            height: 35px;
            border-radius: 11px;
            display: grid;
            place-items: center;
            color: #0877ef;
            background: #eaf6ff;
            margin-bottom: 9px;
        }

        .quick-title {
            font-size: 10px;
            font-weight: 900;
            color: #2c4863;
        }

        .quick-sub {
            margin-top: 3px;
            font-size: 8px;
            color: #91a1b1;
            line-height: 1.4;
        }

        /* Performance Progress Rows */
        .mini-progress {
            padding: 18px;
        }

        .progress-row {
            margin-bottom: 15px;
        }

        .progress-head {
            display: flex;
            justify-content: space-between;
            font-size: 9px;
            font-weight: 800;
            color: #617991;
            margin-bottom: 6px;
        }

        .progress {
            height: 8px;
            background: #edf3f8;
            border-radius: 999px;
        }

        .progress-bar {
            border-radius: 999px;
            background: linear-gradient(90deg, #0f7cff, #50d8ff);
        }

        .progress-bar.purple {
            background: linear-gradient(90deg, #7352e8, #b18cff);
        }

        .progress-bar.green {
            background: linear-gradient(90deg, #11ad76, #54e6b6);
        }

        /* Upgrade Banner */
        .upgrade {
            padding: 19px;
            border-radius: 22px;
            min-height: 100%;
            background: radial-gradient(circle at 85% 14%, rgba(74, 228, 255, .26), transparent 25%), linear-gradient(135deg, #07172f, #0d55a9 67%, #0e8de8);
            color: #fff;
            box-shadow: 0 26px 60px rgba(7, 65, 130, .20);
            position: relative;
            overflow: hidden;
        }

        .upgrade-badge {
            display: inline-flex;
            padding: 6px 9px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .10);
            border: 1px solid rgba(255, 255, 255, .14);
            color: #95ebff;
            font-size: 8px;
            font-weight: 900;
            letter-spacing: .8px;
        }

        .upgrade h3 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 27px;
            letter-spacing: -.8px;
            margin: 15px 0 7px;
        }

        .upgrade p {
            color: #cce0f7;
            font-size: 10px;
            line-height: 1.65;
            max-width: 450px;
        }

        /* Mobile Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 1040;
            background: rgba(3, 22, 45, .42);
            backdrop-filter: blur(2px);
        }

        @media (max-width: 991.98px) {
            :root {
                --sidebar-width: 0px;
            }

            .sidebar {
                width: 290px;
                max-width: 86vw;
                transform: translateX(-105%);
                transition: transform .28s ease;
                padding: 8px;
                z-index: 1060;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
            }

            .main {
                margin-left: 0;
            }

            .menu-toggle {
                width: 40px;
                height: 40px;
                display: grid;
                place-items: center;
                border: 1px solid #e4edf6;
                background: #fff;
                color: #163a5d;
                border-radius: 12px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar Include -->
    @include('library.sidebar')

    <div class="main">
        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-inner">
                <div class="container-fluid p-0">
                    <div class="d-flex align-items-center gap-2">
                        <button class="menu-toggle" id="menuToggle" aria-label="Open navigation">
                            <i class="fa-solid fa-bars"></i>
                        </button>

                        <div class="search d-flex align-items-center">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                                <input type="search" class="form-control"
                                    placeholder="Search students, seats, payments...">
                            </div>
                        </div>

                        <div class="ms-auto d-flex align-items-center gap-2">
                            <button class="top-icon" title="Quick actions"><i class="fa-solid fa-plus"></i></button>
                            <button class="top-icon" title="Messages"><i
                                    class="fa-regular fa-comment-dots"></i></button>
                            <button class="top-icon" title="Notifications">
                                <span class="notification-dot"></span>
                                <i class="fa-regular fa-bell"></i>
                            </button>
                            <div class="profile">
                                <div class="profile-avatar">
                                    @php
                                        $name = trim(auth()->user()->name ?? 'User');
                                        $words = explode(' ', $name);
                                        $initials = strtoupper(
                                            substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''),
                                        );
                                    @endphp
                                    {{ $initials }}
                                </div>

                                <div class="profile-meta d-none d-md-block">
                                    <div class="profile-name">
                                        {{ auth()->user()->name ?? 'User' }}
                                    </div>

                                    <div class="profile-role">
                                        {{ auth()->user()->library->library_name ?? 'Library' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="content">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="py-3 px-4 bg-white border-top">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span style="font-size:9px;color:#93a3b3">© 2026 LMSP · Library Management SaaS Platform</span>
                <span style="font-size:9px;color:#93a3b3">
                    <i class="fa-solid fa-shield-halved text-success me-1"></i> Secure & Cloud Managed
                </span>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const menuToggle = document.getElementById('menuToggle');
        const overlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        menuToggle?.addEventListener('click', openSidebar);
        overlay?.addEventListener('click', closeSidebar);
    </script>
    @stack('scripts')
</body>

</html>
