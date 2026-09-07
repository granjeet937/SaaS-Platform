<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LMSP Study Library Management Dashboard">
    <title>LMSP — Library Dashboard</title>

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
            box-sizing: border-box
        }

        html {
            scroll-behavior: smooth
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, system-ui, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 8% 0%, rgba(53, 213, 255, .07), transparent 24%),
                radial-gradient(circle at 94% 10%, rgba(120, 88, 235, .06), transparent 24%),
                #f7fbff;
            overflow-x: hidden;
        }

        a {
            text-decoration: none
        }

        button,
        input,
        select {
            font-family: inherit
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
            background:
                radial-gradient(circle at 90% 8%, rgba(53, 213, 255, .13), transparent 25%),
                linear-gradient(160deg, #07162e 0%, #08264b 57%, #0b5fa9 100%);
            box-shadow: 0 25px 70px rgba(8, 42, 80, .23);
            color: #fff;
            padding: 17px 14px 14px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
        }

        .sidebar-shell::before {
            content: "";
            position: absolute;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            right: -130px;
            bottom: -120px;
            background: radial-gradient(circle, rgba(120, 88, 235, .20), transparent 65%);
            pointer-events: none;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            padding: 4px 6px 18px;
            position: relative;
            z-index: 2;
        }

        .logo-box {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            flex: 0 0 auto;
            color: #fff;
            background: linear-gradient(145deg, #0d64dc, #30cfff);
            box-shadow: inset 0 1px rgba(255, 255, 255, .65), 0 10px 22px rgba(19, 128, 255, .28);
        }

        .brand strong {
            display: block;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 20px;
            line-height: 1;
        }

        .brand small {
            display: block;
            margin-top: 4px;
            color: #93b0ce;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: .05px;
        }

        .library-card {
            margin: 0 2px 15px;
            padding: 12px;
            border: 1px solid rgba(255, 255, 255, .11);
            background: rgba(255, 255, 255, .07);
            border-radius: 17px;
            position: relative;
            z-index: 2;
            backdrop-filter: blur(12px);
        }

        .library-avatar {
            width: 40px;
            height: 40px;
            border-radius: 13px;
            display: grid;
            place-items: center;
            background: linear-gradient(145deg, #fff, #dff4ff);
            color: #0e78e8;
            font-weight: 900;
        }

        .library-card .title {
            font-size: 11px;
            font-weight: 800;
        }

        .library-card .sub {
            color: #9bb8d6;
            font-size: 9px;
            margin-top: 3px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #38e2a2;
            box-shadow: 0 0 0 4px rgba(56, 226, 162, .10);
        }

        .sidebar-nav {
            flex: 1;
            overflow: auto;
            padding: 3px 1px 3px;
            scrollbar-width: thin;
            position: relative;
            z-index: 2;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, .15);
            border-radius: 99px
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
            padding: 10px 11px;
            margin: 4px 0;
            color: #c6d9ed;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
            transition: .22s ease;
            position: relative;
        }

        .side-link i {
            width: 18px;
            text-align: center;
            color: #7fa7cd;
            transition: .22s ease;
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
            color: #fff
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
            position: relative;
            z-index: 2;
        }

        .version {
            color: #7293b2;
            font-size: 9px;
        }



        .static-demo-note {
            margin: 0 2px 10px;
            padding: 7px 10px;
            border-radius: 10px;
            background: rgba(53, 213, 255, .08);
            border: 1px solid rgba(53, 213, 255, .14);
            color: #9eddf0;
            font-size: 8px;
            font-weight: 800;
            text-align: center;
            letter-spacing: .2px;
            position: relative;
            z-index: 2;
        }

        /* ===== LIBRARY BRANDING ===== */
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
            box-shadow:
                0 12px 28px rgba(0, 0, 0, .20),
                inset 0 1px rgba(255, 255, 255, .9);
        }

        .library-brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .library-brand-fallback {
            width: 100%;
            height: 100%;
            display: none;
            place-items: center;
            color: #0d7bf3;
            background: linear-gradient(145deg, #ffffff, #e8f7ff);
            font-size: 20px;
        }

        .library-brand-info {
            min-width: 0;
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

        .library-mini-avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            flex: 0 0 40px;
            display: grid;
            place-items: center;
            color: #58dfff;
            border: 1px solid rgba(255, 255, 255, .10);
            background: rgba(255, 255, 255, .08);
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
            letter-spacing: .6px;
        }

        /* Keep all scrolling available but remove visible scrollbars. */
        html,
        body,
        * {
            scrollbar-width: none;
        }

        html::-webkit-scrollbar,
        body::-webkit-scrollbar,
        *::-webkit-scrollbar {
            width: 0;
            height: 0;
            display: none;
        }

        /* No accidental horizontal page overflow. */
        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
        }

        .sidebar-nav,
        .table-wrap {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        /* Slightly tighter sidebar so the full navigation feels cleaner. */
        .side-link {
            padding: 9px 11px;
            margin: 3px 0;
        }

        .nav-title {
            padding-top: 10px;
            padding-bottom: 6px;
        }

        /* ===== MAIN ===== */
        .main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
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

        .top-icon:hover {
            color: var(--blue);
            border-color: #bcdafa;
            transform: translateY(-1px);
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

        /* ===== CONTENT ===== */
        .content {
            padding: 10px 24px 36px;
        }

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

        /* KPI CARDS */
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

        .kpi-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .kpi-card::after {
            content: "";
            position: absolute;
            width: 130px;
            height: 130px;
            border-radius: 50%;
            right: -55px;
            bottom: -70px;
            background: radial-gradient(circle, rgba(53, 213, 255, .13), transparent 65%);
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
            background: linear-gradient(145deg, #10ad73, #4be0b0)
        }

        .kpi-icon.purple {
            background: linear-gradient(145deg, #7350e8, #b17cff)
        }

        .kpi-icon.orange {
            background: linear-gradient(145deg, #f18c24, #ffc96e)
        }

        .kpi-icon.pink {
            background: linear-gradient(145deg, #e65b85, #ff95bd)
        }

        .trend {
            padding: 6px 8px;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 900;
        }

        .trend.up {
            background: #eafaf3;
            color: #159366
        }

        .trend.down {
            background: #fff0f3;
            color: #c84e68
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

        /* PANELS */
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

        /* CHART */
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
            background:
                linear-gradient(to bottom, transparent 24%, #edf3f8 25%, transparent 25%, transparent 49%, #edf3f8 50%, transparent 50%, transparent 74%, #edf3f8 75%, transparent 75%);
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
            animation: grow .9s ease both;
            transform-origin: bottom;
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
            background: #27abff
        }

        .legend-purple {
            background: #987bff
        }

        /* SEAT MAP */
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

        .seat:hover {
            transform: translateY(-2px)
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

        /* STUDENT TABLE */
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

        .student-table tbody tr:hover {
            background: #fbfdff
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
            background: #eafaf3
        }

        .status.pending {
            color: #b47a1d;
            background: #fff7e9
        }

        .status.expired {
            color: #c95269;
            background: #fff0f3
        }

        /* ACTIVITY */
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
            border-bottom: 0
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
            color: #168d65
        }

        .activity-icon.purple {
            background: #f4efff;
            color: #7858e4
        }

        .activity-icon.orange {
            background: #fff6e9;
            color: #c57c15
        }

        .activity-text {
            flex: 1;
            font-size: 9px;
            color: #627890;
            line-height: 1.5;
        }

        .activity-text strong {
            color: #2c4863
        }

        .activity-time {
            display: block;
            color: #a0adba;
            margin-top: 3px;
            font-size: 8px;
        }

        /* QUICK ACTIONS */
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
        }

        .quick:hover {
            transform: translateY(-3px);
            border-color: #c8ddf4;
            box-shadow: 0 10px 24px rgba(29, 96, 155, .07);
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

        /* RIGHT INFO */
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
            background: linear-gradient(90deg, #7352e8, #b18cff)
        }

        .progress-bar.green {
            background: linear-gradient(90deg, #11ad76, #54e6b6)
        }

        /* CTA */
        .upgrade {
            padding: 19px;
            border-radius: 22px;
            min-height: 100%;
            background:
                radial-gradient(circle at 85% 14%, rgba(74, 228, 255, .26), transparent 25%),
                linear-gradient(135deg, #07172f, #0d55a9 67%, #0e8de8);
            color: #fff;
            box-shadow: 0 26px 60px rgba(7, 65, 130, .20);
            position: relative;
            overflow: hidden;
        }

        .upgrade::after {
            content: "";
            position: absolute;
            width: 190px;
            height: 190px;
            right: -80px;
            bottom: -85px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
            pointer-events: none;
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

        .upgrade .btn {
            border-radius: 12px;
            font-size: 10px;
            font-weight: 900;
            padding: .72rem 1rem;
        }

        /* ===== OVERLAY / MOBILE ===== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 1040;
            background: rgba(3, 22, 45, .42);
            backdrop-filter: blur(2px);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width:1199.98px) {
            :root {
                --sidebar-width: 245px
            }

            .content {
                padding-left: 19px;
                padding-right: 19px
            }

            .topbar {
                padding-left: 19px;
                padding-right: 19px
            }

            .sidebar {
                padding: 12px
            }

            .kpi-value {
                font-size: 25px
            }

            .seat-grid {
                grid-template-columns: repeat(4, 1fr)
            }
        }

        @media (max-width:991.98px) {
            :root {
                --sidebar-width: 0px
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
                transform: translateX(0)
            }

            .sidebar-overlay.show {
                display: block
            }

            .main {
                margin-left: 0
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

            .search {
                max-width: none
            }

            .welcome {
                padding-top: 8px;
            }

            .visual-chart {
                order: 1;
            }

            .visual-seat {
                order: 2;
            }
        }


        @media (max-width:767.98px) {
            .library-brand-info strong {
                max-width: 145px;
                font-size: 12px;
            }

            .library-brand-logo {
                width: 44px;
                height: 44px;
                flex-basis: 44px;
                border-radius: 13px;
            }

            .topbar-inner {
                box-shadow: 0 10px 26px rgba(23, 70, 120, .08);
            }

            .topbar {
                padding: 8px 10px;
            }

            .topbar-inner {
                border-radius: 15px;
                padding: 7px;
            }

            .topbar .container-fluid {
                padding: 0;
            }

            .profile-meta,
            .search {
                display: none !important;
            }

            .content {
                padding: 4px 10px 28px;
            }

            .welcome {
                padding: 11px 2px 18px;
            }

            .welcome h1 {
                font-size: 30px;
            }

            .welcome p {
                font-size: 11px;
                max-width: 290px;
            }

            .date-pill {
                font-size: 9px;
                padding: 8px 10px;
            }

            .kpi-card {
                padding: 15px;
                border-radius: 17px;
            }

            .kpi-icon {
                width: 39px;
                height: 39px;
                border-radius: 12px;
            }

            .kpi-label {
                margin-top: 12px
            }

            .kpi-value {
                font-size: 24px
            }

            .panel {
                border-radius: 18px;
            }

            .panel-head {
                padding: 15px;
            }

            .chart-wrap,
            .seat-map,
            .activity-list,
            .quick-grid,
            .mini-progress {
                padding-left: 14px;
                padding-right: 14px;
            }

            .bar-chart {
                height: 205px;
            }

            .seat-grid {
                grid-template-columns: repeat(4, 1fr);
            }

            .seat {
                height: 40px;
            }

            .upgrade {
                padding: 17px;
            }
        }

        @media (max-width:479.98px) {
            .top-icon {
                width: 36px;
                height: 36px;
            }

            .profile-avatar {
                width: 36px;
                height: 36px;
            }

            .logo-box {
                width: 38px;
                height: 38px;
                border-radius: 12px;
            }

            .brand strong {
                font-size: 18px
            }

            .brand small {
                display: none
            }

            .welcome h1 {
                font-size: 27px;
                letter-spacing: -1px;
            }

            .welcome p {
                font-size: 10px
            }

            .date-pill {
                display: none;
            }

            .kpi-value {
                font-size: 22px;
            }

            .trend {
                font-size: 8px;
                padding: 5px 7px;
            }

            .seat-summary {
                gap: 6px;
            }

            .seat-stat {
                padding: 9px;
            }

            .seat-stat strong {
                font-size: 13px;
            }

            .seat-grid {
                gap: 6px;
            }

            .seat {
                height: 37px;
                font-size: 8px;
            }

            .seat i {
                display: none
            }

            .quick-grid {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }
        }


        .quick {
            padding: 11px;
        }
        }

        @media (max-width:359.98px) {
            .content {
                padding-left: 7px;
                padding-right: 7px
            }

            .welcome h1 {
                font-size: 25px
            }

            .kpi-card {
                padding: 13px
            }

            .kpi-value {
                font-size: 20px
            }

            .seat-grid {
                grid-template-columns: repeat(3, 1fr)
            }

            .quick-grid {
                grid-template-columns: 1fr
            }
        }

        @keyframes grow {
            from {
                transform: scaleY(0);
                opacity: 0
            }

            to {
                transform: scaleY(1);
                opacity: 1
            }
        }

        @media(prefers-reduced-motion:reduce) {

            *,
            *::before,
            *::after {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="main">
        @include('library.sidebar')
        <header class="topbar">
            <div class="topbar-inner">
                <div class="container-fluid p-0">
                    <div class="d-flex align-items-center gap-2">

                        <button class="menu-toggle" id="menuToggle" aria-label="Open navigation">
                            <i class="fa-solid fa-bars"></i>
                        </button>

                        <div class="search d-flex align-items-center">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                                <input type="search" class="form-control"
                                    placeholder="Search students, seats, payments...">
                            </div>
                        </div>

                        <div class="ms-auto d-flex align-items-center gap-2">

                            <button class="top-icon" title="Quick actions">
                                <i class="fa-solid fa-plus"></i>
                            </button>

                            <button class="top-icon" title="Messages">
                                <i class="fa-regular fa-comment-dots"></i>
                            </button>

                            <button class="top-icon" title="Notifications">
                                <span class="notification-dot"></span>
                                <i class="fa-regular fa-bell"></i>
                            </button>

                            <div class="profile">
                                <div class="profile-avatar">RG</div>
                                <div class="profile-meta">
                                    <div class="profile-name">Ranjeet Gupta</div>
                                    <div class="profile-role">Riyansh Digital Library</div>
                                </div>
                                <i class="fa-solid fa-chevron-down small text-secondary d-none d-md-block"></i>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </header>

        <main class="content">

            <!-- WELCOME -->
            <section class="welcome">
                <div class="row align-items-end g-3">
                    <div class="col-md-8">
                        <span class="welcome-kicker">
                            <i class="fa-solid fa-sparkles"></i>
                            Library Overview
                            <span class="ms-1 d-inline-flex align-items-center gap-1 text-success"
                                style="font-size:8px;">
                                <span class="rounded-circle bg-success d-inline-block"
                                    style="width:5px;height:5px;"></span>
                                LIVE
                            </span>
                        </span>
                        <h1>Good morning, {{ $user->name }} 👋</h1>
                        <p>Here’s what’s happening in your study library today.</p>
                    </div>

                    <div class="col-md-4 text-md-end">
                        <span class="date-pill">
                            <i class="fa-regular fa-calendar"></i>
                            {{ now()->format('l, d F Y') }}
                        </span>
                    </div>
                </div>
            </section>

            <!-- KPIs -->
            <section class="mb-4">
                <div class="row g-3">

                    <div class="col-6 col-xl">
                        <div class="kpi-card">
                            <div class="kpi-top">
                                <div class="kpi-icon"><i class="fa-solid fa-users"></i></div>
                                <span class="trend up">+8.4%</span>
                            </div>
                            <div class="kpi-label">Total Students</div>
                            <div class="kpi-value">250</div>
                            <div class="kpi-meta">18 new this month</div>
                        </div>
                    </div>

                    <div class="col-6 col-xl">
                        <div class="kpi-card">
                            <div class="kpi-top">
                                <div class="kpi-icon green"><i class="fa-solid fa-user-check"></i></div>
                                <span class="trend up">+5.2%</span>
                            </div>
                            <div class="kpi-label">Present Today</div>
                            <div class="kpi-value">180</div>
                            <div class="kpi-meta">72% attendance rate</div>
                        </div>
                    </div>

                    <div class="col-6 col-xl">
                        <div class="kpi-card">
                            <div class="kpi-top">
                                <div class="kpi-icon purple"><i class="fa-solid fa-chair"></i></div>
                                <span class="trend up">82%</span>
                            </div>
                            <div class="kpi-label">Seats Occupied</div>
                            <div class="kpi-value">210/250</div>
                            <div class="kpi-meta">40 seats available</div>
                        </div>
                    </div>

                    <div class="col-6 col-xl">
                        <div class="kpi-card">
                            <div class="kpi-top">
                                <div class="kpi-icon orange"><i class="fa-solid fa-indian-rupee-sign"></i></div>
                                <span class="trend up">+12.6%</span>
                            </div>
                            <div class="kpi-label">This Month Revenue</div>
                            <div class="kpi-value">₹42.5K</div>
                            <div class="kpi-meta">₹6.8K pending</div>
                        </div>
                    </div>

                    <div class="col-6 col-xl">
                        <div class="kpi-card">
                            <div class="kpi-top">
                                <div class="kpi-icon pink"><i class="fa-solid fa-clock"></i></div>
                                <span class="trend down">12</span>
                            </div>
                            <div class="kpi-label">Expiring Soon</div>
                            <div class="kpi-value">12</div>
                            <div class="kpi-meta">Next 7 days</div>
                        </div>
                    </div>

                </div>
            </section>

            <!-- CHART + SEAT -->
            <section class="mb-4">
                <div class="row g-3">

                    <div class="col-xl-8 visual-chart">
                        <div class="panel">
                            <div class="panel-head">
                                <div>
                                    <div class="panel-title">Attendance Overview</div>
                                    <div class="panel-sub">Daily attendance for the current week</div>
                                </div>
                                <a href="#" class="panel-action">View Report <i
                                        class="fa-solid fa-arrow-right ms-1"></i></a>
                            </div>

                            <div class="chart-wrap">
                                <div class="chart-summary">
                                    <div>
                                        <div class="chart-value">1,146</div>
                                        <div class="chart-note">Total check-ins this week</div>
                                    </div>
                                    <span class="badge rounded-pill text-bg-light">Last 7 Days</span>
                                </div>

                                <div class="bar-chart">
                                    <div class="bar-col">
                                        <div class="bar" style="height:52%;animation-delay:.03s"></div>
                                        <div class="bar secondary" style="height:39%;animation-delay:.06s"></div>
                                        <span class="bar-label">Mon</span>
                                    </div>
                                    <div class="bar-col">
                                        <div class="bar" style="height:66%;animation-delay:.10s"></div>
                                        <div class="bar secondary" style="height:45%;animation-delay:.13s"></div>
                                        <span class="bar-label">Tue</span>
                                    </div>
                                    <div class="bar-col">
                                        <div class="bar" style="height:74%;animation-delay:.16s"></div>
                                        <div class="bar secondary" style="height:57%;animation-delay:.19s"></div>
                                        <span class="bar-label">Wed</span>
                                    </div>
                                    <div class="bar-col">
                                        <div class="bar" style="height:69%;animation-delay:.22s"></div>
                                        <div class="bar secondary" style="height:49%;animation-delay:.25s"></div>
                                        <span class="bar-label">Thu</span>
                                    </div>
                                    <div class="bar-col">
                                        <div class="bar" style="height:86%;animation-delay:.28s"></div>
                                        <div class="bar secondary" style="height:63%;animation-delay:.31s"></div>
                                        <span class="bar-label">Fri</span>
                                    </div>
                                    <div class="bar-col">
                                        <div class="bar" style="height:80%;animation-delay:.34s"></div>
                                        <div class="bar secondary" style="height:58%;animation-delay:.37s"></div>
                                        <span class="bar-label">Sat</span>
                                    </div>
                                    <div class="bar-col">
                                        <div class="bar" style="height:92%;animation-delay:.40s"></div>
                                        <div class="bar secondary" style="height:68%;animation-delay:.43s"></div>
                                        <span class="bar-label">Sun</span>
                                    </div>
                                </div>

                                <div class="chart-legend">
                                    <span><span class="legend-dot legend-blue"></span>Check-in</span>
                                    <span><span class="legend-dot legend-purple"></span>Check-out</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 visual-seat">
                        <div class="panel">
                            <div class="panel-head">
                                <div>
                                    <div class="panel-title">Live Seat Occupancy</div>
                                    <div class="panel-sub">Current seating status</div>
                                </div>
                                <a href="#" class="panel-action">Manage</a>
                            </div>

                            <div class="seat-map">
                                <div class="seat-summary">
                                    <div class="seat-stat">
                                        <small>Occupied</small>
                                        <strong>210</strong>
                                    </div>
                                    <div class="seat-stat">
                                        <small>Available</small>
                                        <strong>40</strong>
                                    </div>
                                    <div class="seat-stat">
                                        <small>Reserved</small>
                                        <strong>8</strong>
                                    </div>
                                </div>

                                <div class="seat-grid">
                                    <div class="seat occupied"><i class="fa-solid fa-user"></i>01</div>
                                    <div class="seat occupied"><i class="fa-solid fa-user"></i>02</div>
                                    <div class="seat available"><i class="fa-solid fa-check"></i>03</div>
                                    <div class="seat occupied"><i class="fa-solid fa-user"></i>04</div>
                                    <div class="seat reserved"><i class="fa-solid fa-lock"></i>05</div>

                                    <div class="seat occupied"><i class="fa-solid fa-user"></i>06</div>
                                    <div class="seat available"><i class="fa-solid fa-check"></i>07</div>
                                    <div class="seat occupied"><i class="fa-solid fa-user"></i>08</div>
                                    <div class="seat available"><i class="fa-solid fa-check"></i>09</div>
                                    <div class="seat occupied"><i class="fa-solid fa-user"></i>10</div>

                                    <div class="seat occupied"><i class="fa-solid fa-user"></i>11</div>
                                    <div class="seat reserved"><i class="fa-solid fa-lock"></i>12</div>
                                    <div class="seat occupied"><i class="fa-solid fa-user"></i>13</div>
                                    <div class="seat occupied"><i class="fa-solid fa-user"></i>14</div>
                                    <div class="seat available"><i class="fa-solid fa-check"></i>15</div>

                                    <div class="seat available"><i class="fa-solid fa-check"></i>16</div>
                                    <div class="seat occupied"><i class="fa-solid fa-user"></i>17</div>
                                    <div class="seat occupied"><i class="fa-solid fa-user"></i>18</div>
                                    <div class="seat available"><i class="fa-solid fa-check"></i>19</div>
                                    <div class="seat occupied"><i class="fa-solid fa-user"></i>20</div>
                                </div>

                                <div class="seat-legend">
                                    <span><span class="legend-dot" style="background:#2fcf96"></span>Available</span>
                                    <span><span class="legend-dot" style="background:#27abff"></span>Occupied</span>
                                    <span><span class="legend-dot" style="background:#967aff"></span>Reserved</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <!-- STUDENTS + ACTIVITY + PERFORMANCE -->
            <section class="mb-4">
                <div class="row g-3">

                    <div class="col-xl-8">
                        <div class="panel">
                            <div class="panel-head">
                                <div>
                                    <div class="panel-title">Recent Students</div>
                                    <div class="panel-sub">Latest admissions and membership activity</div>
                                </div>
                                <a href="#" class="panel-action">View All</a>
                            </div>

                            <div class="table-wrap">
                                <table class="table student-table">
                                    <thead>
                                        <tr>
                                            <th>Student</th>
                                            <th>Plan</th>
                                            <th>Seat</th>
                                            <th>Attendance</th>
                                            <th>Status</th>
                                            <th>Joined</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="student">
                                                    <div class="student-avatar">AS</div>
                                                    <div>
                                                        <div class="student-name">Aarav Sharma</div>
                                                        <div class="student-id">STU-1024</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Monthly</td>
                                            <td>A-12</td>
                                            <td>96%</td>
                                            <td><span class="status present"><i
                                                        class="fa-solid fa-circle"></i>Active</span>
                                            </td>
                                            <td>05 Sep</td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="student">
                                                    <div class="student-avatar">PN</div>
                                                    <div>
                                                        <div class="student-name">Priya Nair</div>
                                                        <div class="student-id">STU-1023</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>3 Months</td>
                                            <td>B-08</td>
                                            <td>91%</td>
                                            <td><span class="status present"><i
                                                        class="fa-solid fa-circle"></i>Active</span>
                                            </td>
                                            <td>04 Sep</td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="student">
                                                    <div class="student-avatar">RK</div>
                                                    <div>
                                                        <div class="student-name">Rahul Kumar</div>
                                                        <div class="student-id">STU-1022</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Monthly</td>
                                            <td>C-15</td>
                                            <td>84%</td>
                                            <td><span class="status pending"><i class="fa-solid fa-circle"></i>Fee
                                                    Due</span></td>
                                            <td>03 Sep</td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="student">
                                                    <div class="student-avatar">SM</div>
                                                    <div>
                                                        <div class="student-name">Sneha Mishra</div>
                                                        <div class="student-id">STU-1021</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>6 Months</td>
                                            <td>A-04</td>
                                            <td>97%</td>
                                            <td><span class="status present"><i
                                                        class="fa-solid fa-circle"></i>Active</span>
                                            </td>
                                            <td>02 Sep</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="panel">
                            <div class="panel-head">
                                <div>
                                    <div class="panel-title">Recent Activity</div>
                                    <div class="panel-sub">Latest updates from your library</div>
                                </div>
                                <a href="#" class="panel-action">All</a>
                            </div>

                            <div class="activity-list">
                                <div class="activity">
                                    <div class="activity-icon green"><i class="fa-solid fa-user-plus"></i></div>
                                    <div class="activity-text">
                                        <strong>Aarav Sharma</strong> was added as a new student.
                                        <span class="activity-time">12 minutes ago</span>
                                    </div>
                                </div>

                                <div class="activity">
                                    <div class="activity-icon"><i class="fa-solid fa-money-bill-wave"></i></div>
                                    <div class="activity-text">
                                        Payment of <strong>₹999</strong> received from Priya Nair.
                                        <span class="activity-time">34 minutes ago</span>
                                    </div>
                                </div>

                                <div class="activity">
                                    <div class="activity-icon purple"><i class="fa-solid fa-chair"></i></div>
                                    <div class="activity-text">
                                        Seat <strong>B-14</strong> was marked available.
                                        <span class="activity-time">1 hour ago</span>
                                    </div>
                                </div>

                                <div class="activity">
                                    <div class="activity-icon orange"><i class="fa-solid fa-bell"></i></div>
                                    <div class="activity-text">
                                        <strong>12 memberships</strong> are expiring this week.
                                        <span class="activity-time">2 hours ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <!-- PERFORMANCE + QUICK ACTION -->
            <section class="mb-4">
                <div class="row g-3">

                    <div class="col-lg-4">
                        <div class="panel">
                            <div class="panel-head">
                                <div>
                                    <div class="panel-title">Library Performance</div>
                                    <div class="panel-sub">Current plan utilization</div>
                                </div>
                            </div>

                            <div class="mini-progress">
                                <div class="progress-row">
                                    <div class="progress-head">
                                        <span>Student Capacity</span>
                                        <span>83%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" style="width:83%"></div>
                                    </div>
                                </div>

                                <div class="progress-row">
                                    <div class="progress-head">
                                        <span>Seat Utilization</span>
                                        <span>82%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar purple" style="width:82%"></div>
                                    </div>
                                </div>

                                <div class="progress-row">
                                    <div class="progress-head">
                                        <span>Monthly Collection</span>
                                        <span>91%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar green" style="width:91%"></div>
                                    </div>
                                </div>

                                <div class="progress-row mb-0">
                                    <div class="progress-head">
                                        <span>Attendance Goal</span>
                                        <span>88%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" style="width:88%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="panel">
                            <div class="panel-head">
                                <div>
                                    <div class="panel-title">Quick Actions</div>
                                    <div class="panel-sub">Common library operations</div>
                                </div>
                            </div>

                            <div class="quick-grid">
                                <a href="#" class="quick">
                                    <div class="quick-icon"><i class="fa-solid fa-user-plus"></i></div>
                                    <div class="quick-title">Add Student</div>
                                    <div class="quick-sub">Create new student profile</div>
                                </a>

                                <a href="#" class="quick">
                                    <div class="quick-icon"><i class="fa-solid fa-user-check"></i></div>
                                    <div class="quick-title">Mark Attendance</div>
                                    <div class="quick-sub">Check-in students quickly</div>
                                </a>

                                <a href="#" class="quick">
                                    <div class="quick-icon"><i class="fa-solid fa-chair"></i></div>
                                    <div class="quick-title">Assign Seat</div>
                                    <div class="quick-sub">Manage seat allocation</div>
                                </a>

                                <a href="#" class="quick">
                                    <div class="quick-icon"><i class="fa-solid fa-indian-rupee-sign"></i></div>
                                    <div class="quick-title">Collect Fee</div>
                                    <div class="quick-sub">Record a payment</div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="upgrade">
                            <span class="upgrade-badge"><i class="fa-solid fa-crown me-1"></i> GROW WITH LMSP</span>
                            <h3>Run your study library like a modern business.</h3>
                            <p>
                                Unlock advanced analytics, automated reminders, additional staff accounts
                                and higher student capacity with your next LMSP plan.
                            </p>
                            <a href="#" class="btn btn-light mt-2">
                                View Plans <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </section>
            <!-- FOOTER -->
            <footer class="pt-1">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 px-1">
                    <span style="font-size:9px;color:#93a3b3">© 2026 LMSP · Library Management SaaS Platform</span>
                    <span style="font-size:9px;color:#93a3b3">
                        <i class="fa-solid fa-shield-halved text-success me-1"></i>
                        Secure & Cloud Managed
                    </span>
                </div>
            </footer>

        </main>
    </div>

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

        document.querySelectorAll('.side-link').forEach(link => {
            link.addEventListener('click', () => {
                document.querySelectorAll('.side-link').forEach(item => item.classList.remove('active'));
                link.classList.add('active');

                if (window.innerWidth < 992) {
                    closeSidebar();
                }
            });
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 992) {
                closeSidebar();
            }
        });
    </script>
</body>

</html>