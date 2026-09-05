<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LMSP - Premium Study Library Management SaaS Platform">
    <title>LMSP — Smart Study Library Management SaaS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --navy: #07162e;
            --navy2: #0a2345;
            --ink: #10213d;
            --muted: #6d819d;
            --blue: #0f7cff;
            --cyan: #35d5ff;
            --line: #dce8f7;
            --soft: #f6faff;
            --glass: rgba(255, 255, 255, .72);
            --shadow: 0 25px 70px rgba(23, 70, 120, .12)
        }

        * {
            box-sizing: border-box
        }

        html {
            scroll-behavior: smooth
        }

        body {
            margin: 0;
            font-family: Inter, system-ui, sans-serif;
            color: var(--ink);
            background: #f8fbff;
            overflow-x: hidden
        }

        body:before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: -5;
            background: radial-gradient(circle at 10% 5%, rgba(55, 166, 255, .10), transparent 25%), radial-gradient(circle at 90% 15%, rgba(127, 80, 255, .09), transparent 28%), linear-gradient(180deg, #fbfdff 0%, #f5faff 100%)
        }

        a {
            text-decoration: none
        }

        .container-xxl {
            max-width: 1500px
        }

        /* navbar */
        .nav-shell {
            position: absolute;
            top: 16px;
            left: 50%;
            transform: translateX(-50%);
            width: min(1450px, calc(100% - 32px));
            z-index: 50
        }

        .navbar-premium {
            background: rgba(255, 255, 255, .68);
            border: 1px solid rgba(255, 255, 255, .95);
            box-shadow: 0 16px 40px rgba(6, 38, 77, .13);
            backdrop-filter: blur(18px);
            border-radius: 22px;
            padding: 10px 14px
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
            color: #10213d
        }

        .logo-box {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            color: #fff;
            background: linear-gradient(145deg, #0d64dc, #30cfff);
            box-shadow: inset 0 1px rgba(255, 255, 255, .65), 0 10px 20px rgba(19, 128, 255, .28);
            transform: translateZ(20px)
        }

        .brand strong {
            font-family: 'Space Grotesk';
            font-size: 21px;
            line-height: 1
        }

        .brand small {
            display: block;
            color: #7287a2;
            font-size: 9px;
            font-weight: 600;
            margin-top: 3px;
            letter-spacing: .1px
        }

        .nav-link {
            color: #223753 !important;
            font-weight: 700;
            font-size: 13px;
            padding: 11px 14px !important;
            position: relative
        }

        .nav-link:after {
            content: "";
            position: absolute;
            left: 14px;
            right: 14px;
            bottom: 3px;
            height: 2px;
            border-radius: 2px;
            background: #0d7aff;
            transform: scaleX(0);
            transition: .3s
        }

        .nav-link:hover:after,
        .nav-link.active:after {
            transform: scaleX(1)
        }

        .btn-main {
            background: linear-gradient(135deg, #1592ff, #0e66ef);
            color: #fff;
            border: 0;
            font-weight: 800;
            border-radius: 13px;
            padding: .75rem 1.1rem;
            box-shadow: 0 16px 30px rgba(13, 115, 246, .26);
            transition: .25s
        }

        .btn-main:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 20px 34px rgba(13, 115, 246, .32)
        }

        .btn-ghost {
            border: 1px solid #cae2fb;
            background: rgba(255, 255, 255, .8);
            color: #0d67dd;
            font-weight: 800;
            border-radius: 13px;
            padding: .75rem 1.1rem
        }

        /* hero */
        .hero {
            min-height: 900px;
            position: relative;
            overflow: hidden;
            padding: 165px 0 115px;
            color: #fff;
            background: radial-gradient(circle at 78% 22%, rgba(40, 178, 255, .42), transparent 23%), radial-gradient(circle at 92% 80%, rgba(109, 65, 255, .34), transparent 26%), linear-gradient(125deg, #05152f 0%, #082a53 52%, #0b5db8 100%)
        }

        .hero:before {
            content: "";
            position: absolute;
            inset: -20%;
            background: linear-gradient(120deg, transparent 40%, rgba(255, 255, 255, .055) 48%, transparent 56%);
            animation: sweep 9s linear infinite
        }

        .glow-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(2px);
            opacity: .55;
            animation: float 8s ease-in-out infinite
        }

        .orb1 {
            width: 180px;
            height: 180px;
            background: radial-gradient(circle, #5ae1ff, rgba(90, 225, 255, 0));
            top: 15%;
            right: 12%
        }

        .orb2 {
            width: 240px;
            height: 240px;
            background: radial-gradient(circle, #8b6cff, rgba(139, 108, 255, 0));
            bottom: -80px;
            left: 42%;
            animation-delay: -3s
        }

        .grid-fade {
            position: absolute;
            inset: 0;
            opacity: .18;
            background-image: linear-gradient(rgba(255, 255, 255, .25) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 255, 255, .25) 1px, transparent 1px);
            background-size: 42px 42px;
            mask-image: linear-gradient(to bottom, rgba(0, 0, 0, .75), transparent 85%)
        }

        .hero .container-xxl {
            position: relative;
            z-index: 4
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 8px 13px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, .18);
            background: rgba(255, 255, 255, .08);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .2px;
            box-shadow: inset 0 1px rgba(255, 255, 255, .16);
            backdrop-filter: blur(12px)
        }

        .hero h1 {
            font-family: 'Space Grotesk';
            font-size: clamp(48px, 6.1vw, 82px);
            line-height: .96;
            letter-spacing: -3.5px;
            font-weight: 700;
            margin: 24px 0 24px;
            max-width: 760px
        }

        .hero h1 .gradient {
            display: inline-block;
            color: #48dfff;
            background: linear-gradient(90deg, #43dfff, #8ea6ff, #54f6c0);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: textGlow 3s ease-in-out infinite
        }

        .hero-copy p {
            font-size: 18px;
            line-height: 1.65;
            color: #d8e9fb;
            max-width: 690px
        }

        .trust-line {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
            color: #dcecff;
            font-size: 12px;
            font-weight: 700;
            margin-top: 22px
        }

        .trust-line i {
            color: #39e2a1;
            margin-right: 7px
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 28px
        }

        /* 3D visual */
        .visual-wrap {
            perspective: 1600px;
            position: relative;
            min-height: 510px;
            display: flex;
            align-items: center;
            justify-content: center
        }

        .dashboard-scene {
            position: relative;
            width: min(650px, 100%);
            aspect-ratio: 650/420;
            height: auto;
            transform-style: preserve-3d;
            transform: rotateY(-12deg) rotateX(7deg) rotateZ(-1deg);
            transition: transform .35s ease;
            animation: sceneFloat 6s ease-in-out infinite
        }

        .dashboard-card {
            position: absolute;
            inset: 28px 0 0;
            border-radius: 28px;
            background: linear-gradient(145deg, rgba(255, 255, 255, .98), rgba(233, 244, 255, .94));
            border: 1px solid rgba(255, 255, 255, .8);
            box-shadow: 0 45px 100px rgba(0, 0, 0, .32), inset 0 1px rgba(255, 255, 255, 1);
            padding: 18px;
            overflow: hidden
        }

        .dashboard-card:before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 100% 0, rgba(81, 184, 255, .18), transparent 34%)
        }

        .dash-top {
            display: flex;
            gap: 7px;
            margin-bottom: 13px
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #bfd3ea
        }

        .dash-body {
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 14px
        }

        .dash-side {
            background: #071b38;
            border-radius: 17px;
            padding: 14px;
            color: #fff;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .05)
        }

        .dash-side .mini-brand {
            font-weight: 800;
            margin-bottom: 15px
        }

        .side-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 9px;
            color: #c8ddf8;
            margin: 11px 0
        }

        .side-item.active {
            background: #157cf7;
            color: #fff;
            padding: 8px;
            border-radius: 10px
        }

        .dash-main {
            display: flex;
            flex-direction: column;
            gap: 10px
        }

        .mini-title {
            font-weight: 800;
            font-size: 13px
        }

        .metric-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 9px
        }

        .metric {
            padding: 11px;
            border-radius: 13px;
            background: rgba(255, 255, 255, .82);
            border: 1px solid #e1edf8
        }

        .metric small {
            display: block;
            color: #7890a8;
            font-size: 8px
        }

        .metric strong {
            font-size: 18px
        }

        .chart {
            height: 125px;
            border-radius: 15px;
            background: rgba(255, 255, 255, .88);
            border: 1px solid #e1edf8;
            position: relative;
            overflow: hidden
        }

        .bars {
            position: absolute;
            inset: 20px 18px 18px;
            display: flex;
            align-items: flex-end;
            gap: 10px
        }

        .bar {
            flex: 1;
            border-radius: 7px 7px 2px 2px;
            background: linear-gradient(180deg, #1b9eff, #62d4ff);
            box-shadow: 0 8px 16px rgba(33, 156, 255, .18);
            animation: barPulse 2s ease-in-out infinite
        }

        .bar:nth-child(2) {
            height: 60%
        }

        .bar:nth-child(3) {
            height: 76%;
            animation-delay: .2s
        }

        .bar:nth-child(4) {
            height: 50%;
            animation-delay: .4s
        }

        .bar:nth-child(5) {
            height: 88%;
            animation-delay: .6s
        }

        .bar:nth-child(6) {
            height: 68%;
            animation-delay: .8s
        }

        .bar:nth-child(7) {
            height: 96%;
            animation-delay: 1s
        }

        .floating-chip {
            position: absolute;
            padding: 12px 16px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .18);
            box-shadow: 0 20px 50px rgba(0, 0, 0, .18);
            backdrop-filter: blur(16px);
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: chipFloat 5s ease-in-out infinite
        }

        .chip1 {
            top: 11%;
            right: -3%
        }

        .chip2 {
            left: -5%;
            bottom: 8%;
            animation-delay: -2s
        }

        .chip3 {
            right: 17%;
            bottom: -3%;
            animation-delay: -1s
        }

        .floating-chip i {
            color: #60e1ff
        }

        .placeholder-note {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            color: #6e8198;
            text-align: center;
            z-index: 5;
            font-size: 11px
        }

        .placeholder-note strong {
            display: block;
            font-size: 16px;
            color: #35516f;
            margin-bottom: 4px
        }

        .stats-strip {
            position: relative;
            z-index: 8;
            margin-top: -35px
        }

        .stat-shell {
            background: rgba(255, 255, 255, .82);
            border: 1px solid rgba(255, 255, 255, .95);
            box-shadow: 0 25px 60px rgba(30, 78, 126, .15);
            backdrop-filter: blur(18px);
            border-radius: 24px;
            padding: 15px
        }

        .stat-item {
            padding: 15px 18px;
            border-right: 1px solid #e5eef8
        }

        .stat-item:last-child {
            border-right: 0
        }

        .stat-number {
            font-family: 'Space Grotesk';
            font-size: 28px;
            font-weight: 700
        }

        .stat-text {
            font-size: 11px;
            color: #71869f;
            font-weight: 700
        }

        /* shared sections */
        .section {
            padding: 55px 0;
            position: relative
        }

        .section-soft {
            background: linear-gradient(180deg, #f8fbff, #eef7ff)
        }

        .section-head {
            text-align: center;
            max-width: 820px;
            margin: 0 auto 55px
        }

        .kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            border-radius: 999px;
            background: #e8f4ff;
            border: 1px solid #d6ebff;
            color: #0877ef;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: 1px
        }

        .section-head h2 {
            font-family: 'Space Grotesk';
            font-size: clamp(36px, 4vw, 58px);
            letter-spacing: -1.8px;
            line-height: 1.05;
            margin: 17px 0 12px;
            font-weight: 700
        }

        .section-head p {
            margin: 0;
            color: var(--muted);
            line-height: 1.7
        }

        .feature-card,
        .glass-card,
        .pricing,
        .quote-card {
            height: 100%;
            border: 1px solid rgba(207, 224, 241, .82);
            background: rgba(255, 255, 255, .72);
            backdrop-filter: blur(14px);
            border-radius: 24px;
            box-shadow: 0 18px 50px rgba(28, 83, 137, .07);
            transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
            position: relative;
            overflow: hidden
        }

        .feature-card:before,
        .glass-card:before,
        .pricing:before,
        .quote-card:before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, rgba(255, 255, 255, .66), transparent 45%);
            pointer-events: none
        }

        .feature-card {
            padding: 29px
        }

        .feature-card:hover,
        .glass-card:hover,
        .pricing:hover,
        .quote-card:hover {
            transform: translateY(-10px) rotateX(1deg);
            box-shadow: 0 30px 70px rgba(28, 83, 137, .14);
            border-color: #b9d9f7
        }

        .icon3d {
            width: 56px;
            height: 56px;
            border-radius: 17px;
            display: grid;
            place-items: center;
            font-size: 21px;
            color: #fff;
            background: linear-gradient(145deg, #1d8df5, #6b6eff);
            box-shadow: 0 12px 20px rgba(54, 118, 231, .24);
            transform: translateZ(22px)
        }

        .feature-card h5 {
            font-size: 17px;
            font-weight: 800;
            margin: 20px 0 9px
        }

        .feature-card p {
            font-size: 13px;
            line-height: 1.65;
            color: #72879f;
            margin: 0
        }

        .tone-green .icon3d {
            background: linear-gradient(145deg, #15bc78, #45e6b1)
        }

        .tone-purple .icon3d {
            background: linear-gradient(145deg, #7958ed, #b57aff)
        }

        .tone-orange .icon3d {
            background: linear-gradient(145deg, #f28a27, #ffc66d)
        }

        .tone-pink .icon3d {
            background: linear-gradient(145deg, #ee5b8a, #ff8fc0)
        }

        .split-visual {
            min-height: 490px;
            border-radius: 34px;
            background: linear-gradient(145deg, #eaf7ff, #f7fbff);
            border: 1px dashed #9fc9ea;
            position: relative;
            overflow: hidden;
            display: grid;
            place-items: center;
            box-shadow: inset 0 0 60px rgba(48, 153, 239, .06)
        }

        .split-visual:before {
            content: "";
            position: absolute;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(28, 153, 255, .18), rgba(28, 153, 255, 0));
            top: -130px;
            right: -80px;
            animation: blob 7s ease-in-out infinite
        }

        .split-visual:after {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(136, 91, 255, .13), rgba(136, 91, 255, 0));
            bottom: -90px;
            left: -90px;
            animation: blob 8s ease-in-out infinite reverse
        }

        .image-placeholder {
            width: 78%;
            height: 70%;
            border-radius: 28px;
            border: 2px dashed #b5d4ea;
            background: rgba(255, 255, 255, .6);
            display: grid;
            place-items: center;
            text-align: center;
            color: #6d879f;
            position: relative;
            z-index: 2;
            box-shadow: 0 25px 60px rgba(29, 96, 155, .08)
        }

        .bullet {
            display: flex;
            gap: 10px;
            margin: 13px 0;
            color: #4d6480;
            font-size: 14px
        }

        .bullet i {
            color: #12b878;
            margin-top: 3px
        }

        .section-copy h3 {
            font-family: 'Space Grotesk';
            font-size: 44px;
            letter-spacing: -1.3px;
            line-height: 1.05
        }

        .section-copy p {
            color: var(--muted);
            line-height: 1.75
        }

        .steps .step-card {
            padding: 28px;
            text-align: center
        }

        .step-card {
            height: 100%;
            border-radius: 22px;
            border: 1px solid #dce8f7;
            background: rgba(255, 255, 255, .78);
            box-shadow: 0 16px 40px rgba(35, 88, 140, .06);
            transition: .3s
        }

        .step-card:hover {
            transform: translateY(-7px)
        }

        .step-num {
            width: 48px;
            height: 48px;
            border-radius: 15px;
            display: grid;
            place-items: center;
            margin: 0 auto 17px;
            color: #fff;
            background: linear-gradient(145deg, #137df4, #50c7ff);
            font-weight: 900;
            box-shadow: 0 12px 20px rgba(19, 125, 244, .22)
        }

        .quote-card {
            padding: 28px
        }

        .stars {
            color: #ffb521;
            letter-spacing: 2px
        }

        .avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: linear-gradient(145deg, #dceeff, #f7fbff);
            font-weight: 800;
            color: #35607f;
            border: 1px solid #d3e8fa
        }

        .pricing {
            padding: 30px
        }

        .pricing.pop {
            border: 2px solid #1a82f7;
            box-shadow: 0 28px 65px rgba(23, 130, 247, .15);
            transform: translateY(-10px)
        }

        .pricing.pop:hover {
            transform: translateY(-15px)
        }

        .popular {
            position: absolute;
            top: 14px;
            right: 14px;
            border-radius: 999px;
            padding: 6px 10px;
            background: #e6f3ff;
            color: #0874ee;
            font-weight: 900;
            font-size: 10px
        }

        .price {
            font-family: 'Space Grotesk';
            font-size: 42px;
            font-weight: 700;
            letter-spacing: -1.5px
        }

        .plan-list {
            padding: 0;
            list-style: none
        }

        .plan-list li {
            font-size: 13px;
            color: #6b8199;
            margin: 12px 0
        }

        .plan-list i {
            color: #15b97a;
            margin-right: 8px
        }

        .faq .accordion-item {
            border: 1px solid #dbe7f4;
            border-radius: 16px !important;
            overflow: hidden;
            margin-bottom: 12px;
            background: rgba(255, 255, 255, .72)
        }

        .faq .accordion-button {
            background: transparent;
            font-weight: 800;
            padding: 21px
        }

        .faq .accordion-button:not(.collapsed) {
            color: #0d72f0;
            background: #f5faff;
            box-shadow: none
        }

        .faq .accordion-body {
            color: #6e829b
        }

        .cta {
            position: relative;
            overflow: hidden;
            border-radius: 32px;
            padding: 54px;
            background: radial-gradient(circle at 85% 10%, rgba(78, 231, 255, .24), transparent 24%), linear-gradient(120deg, #07172f, #0e55ab 65%, #0d8ce9);
            box-shadow: 0 35px 80px rgba(7, 61, 125, .24);
            color: #fff
        }

        .cta:after {
            content: "";
            position: absolute;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .07);
            right: -70px;
            top: -100px
        }

        .cta h2 {
            font-family: 'Space Grotesk';
            font-size: clamp(32px, 4vw, 54px);
            letter-spacing: -1.4px
        }

        footer {
            background: #05152c;
            color: #dbe8f8
        }

        .footer-link {
            color: #94aac3;
            font-size: 13px
        }

        .footer-link:hover {
            color: #fff
        }

        /* reveal + animations */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .75s ease, transform .75s ease
        }

        .reveal.show {
            opacity: 1;
            transform: none
        }

        .delay-1 {
            transition-delay: .08s
        }

        .delay-2 {
            transition-delay: .16s
        }

        .delay-3 {
            transition-delay: .24s
        }

        .delay-4 {
            transition-delay: .32s
        }

        @keyframes float {
            50% {
                transform: translate3d(0, 28px, 0) scale(1.06)
            }
        }

        @keyframes sweep {
            0% {
                transform: translateX(-35%)
            }

            100% {
                transform: translateX(35%)
            }
        }

        @keyframes sceneFloat {

            0%,
            100% {
                transform: rotateY(-12deg) rotateX(7deg) rotateZ(-1deg) translateY(0)
            }

            50% {
                transform: rotateY(-10deg) rotateX(5deg) rotateZ(-.5deg) translateY(-14px)
            }
        }

        @keyframes chipFloat {

            0%,
            100% {
                transform: translateY(0)
            }

            50% {
                transform: translateY(-12px)
            }
        }

        @keyframes barPulse {
            50% {
                transform: scaleY(.88);
                opacity: .82
            }
        }

        @keyframes textGlow {
            50% {
                filter: drop-shadow(0 0 16px rgba(66, 214, 255, .25))
            }
        }

        @keyframes blob {
            50% {
                transform: translate(25px, -18px) scale(1.08)
            }
        }

        /* Responsive layout: Bootstrap handles the grid; these rules tune spacing, typography and the 3D preview */
        @media (max-width: 1399.98px) {
            .nav-shell {
                width: min(1320px, calc(100% - 28px))
            }

            .hero {
                min-height: 820px;
                padding-top: 150px
            }

            .hero h1 {
                font-size: clamp(46px, 5.8vw, 72px)
            }

            .dashboard-scene {
                width: min(610px, 100%)
            }

            .chip1 {
                right: -1%
            }

            .chip2 {
                left: -2%
            }

            .chip3 {
                right: 13%
            }
        }

        @media (max-width: 1199.98px) {
            .nav-shell {
                top: 12px;
                width: calc(100% - 24px)
            }

            .navbar-premium {
                border-radius: 18px;
                padding: 9px 12px
            }

            .nav-link {
                font-size: 12px;
                padding: 10px 9px !important
            }

            .nav-link:after {
                left: 9px;
                right: 9px
            }

            .hero {
                min-height: auto;
                padding: 142px 0 95px
            }

            .hero h1 {
                letter-spacing: -2.4px
            }

            .hero-copy p {
                font-size: 17px
            }

            .visual-wrap {
                min-height: 460px;
                margin-top: 20px
            }

            .dashboard-scene {
                width: min(590px, 100%);
                transform: rotateY(-8deg) rotateX(5deg) rotateZ(-1deg)
            }

            .metric strong {
                font-size: 16px
            }

            .section {
                padding: 90px 0
            }

            .section-copy h3 {
                font-size: 40px
            }

            .feature-card {
                padding: 25px
            }

            .pricing {
                padding: 26px
            }
        }

        @media (max-width: 991.98px) {
            .nav-shell {
                position: fixed
            }

            .navbar-premium {
                background: rgba(255, 255, 255, .90);
                backdrop-filter: blur(20px)
            }

            .desktop-nav {
                margin-top: 10px !important
            }

            .navbar-collapse {
                padding: 10px 4px 4px
            }

            .navbar-nav .nav-link {
                padding: 10px 8px !important;
                border-radius: 10px
            }

            .navbar-nav .nav-link:hover {
                background: #f2f8ff
            }

            .navbar-nav .nav-link:after {
                display: none
            }

            .hero {
                padding-top: 125px;
                padding-bottom: 80px
            }

            .hero .row {
                --bs-gutter-y: 2rem
            }

            .hero h1 {
                font-size: clamp(44px, 8vw, 66px);
                max-width: 900px
            }

            .hero-copy p {
                max-width: 760px
            }

            .visual-wrap {
                min-height: 440px;
                margin-top: 4px
            }

            .dashboard-scene {
                width: min(650px, 92vw);
                transform: rotateY(-7deg) rotateX(4deg)
            }

            .floating-chip {
                padding: 10px 13px;
                font-size: 10px
            }

            .chip1 {
                top: 8%;
                right: 0
            }

            .chip2 {
                left: 0;
                bottom: 8%
            }

            .chip3 {
                right: 10%;
                bottom: 0
            }

            .stats-strip {
                margin-top: 10px
            }

            .stat-shell {
                border-radius: 20px
            }

            .stat-item {
                border-right: 0;
                border-bottom: 1px solid #e5eef8
            }

            .stat-item:last-child {
                border-bottom: 0
            }

            .section {
                padding: 78px 0
            }

            .section-head {
                margin-bottom: 42px
            }

            .section-copy h3 {
                font-size: 38px
            }

            .split-visual {
                min-height: 420px
            }

            .pricing.pop {
                transform: none
            }

            .pricing.pop:hover {
                transform: translateY(-8px)
            }
        }

        @media (max-width: 767.98px) {
            body {
                font-size: 15px
            }

            .container-xxl {
                width: 100%
            }

            .nav-shell {
                top: 8px;
                width: calc(100% - 14px)
            }

            .navbar-premium {
                border-radius: 16px;
                padding: 8px 10px
            }

            .logo-box {
                width: 38px;
                height: 38px;
                border-radius: 12px
            }

            .brand strong {
                font-size: 19px
            }

            .brand small {
                font-size: 8px
            }

            .hero {
                padding: 112px 0 68px
            }

            .hero h1 {
                font-size: clamp(38px, 10vw, 56px);
                line-height: 1;
                letter-spacing: -1.8px;
                margin-top: 18px
            }

            .hero-copy p {
                font-size: 15px;
                line-height: 1.6
            }

            .hero-actions {
                gap: 10px;
                margin-top: 22px
            }

            .hero-actions .btn {
                width: 100%;
                justify-content: center
            }

            .trust-line {
                gap: 10px 18px;
                font-size: 11px
            }

            .visual-wrap {
                min-height: 360px;
                margin-top: 0;
                overflow: visible
            }

            .dashboard-scene {
                width: min(640px, 100%);
                transform: rotateY(-4deg) rotateX(2deg) rotateZ(-.5deg)
            }

            .dashboard-card {
                inset: 18px 0 0;
                border-radius: 22px;
                padding: 12px
            }

            .dash-body {
                grid-template-columns: 105px minmax(0, 1fr);
                gap: 9px
            }

            .dash-side {
                border-radius: 13px;
                padding: 9px
            }

            .side-item {
                font-size: 7px;
                margin: 8px 0
            }

            .side-item.active {
                padding: 6px;
                border-radius: 8px
            }

            .dash-main {
                gap: 7px
            }

            .mini-title {
                font-size: 10px
            }

            .metric-row {
                gap: 6px
            }

            .metric {
                padding: 8px;
                border-radius: 10px
            }

            .metric small {
                font-size: 6px
            }

            .metric strong {
                font-size: 13px
            }

            .chart {
                height: 95px;
                border-radius: 11px
            }

            .bars {
                inset: 15px 11px 13px;
                gap: 6px
            }

            .floating-chip {
                padding: 8px 10px;
                border-radius: 12px;
                font-size: 8px;
                white-space: nowrap
            }

            .chip1 {
                top: 3%;
                right: 0
            }

            .chip2 {
                left: 0;
                bottom: 8%
            }

            .chip3 {
                right: 5%;
                bottom: -2%
            }

            .stats-strip {
                margin-top: 4px
            }

            .stat-shell {
                padding: 8px;
                border-radius: 18px
            }

            .stat-item {
                padding: 12px 10px
            }

            .stat-number {
                font-size: 22px
            }

            .stat-text {
                font-size: 10px
            }

            .section {
                padding: 64px 0
            }

            .section-head {
                margin-bottom: 34px
            }

            .section-head h2 {
                font-size: clamp(30px, 8vw, 44px);
                letter-spacing: -1px
            }

            .section-head p {
                font-size: 14px
            }

            .feature-card {
                padding: 23px;
                border-radius: 20px
            }

            .feature-card h5 {
                font-size: 16px;
                margin-top: 17px
            }

            .feature-card p {
                font-size: 12px
            }

            .icon3d {
                width: 50px;
                height: 50px;
                border-radius: 15px;
                font-size: 19px
            }

            .split-visual {
                min-height: 330px;
                border-radius: 26px
            }

            .image-placeholder {
                width: 88%;
                height: 72%;
                border-radius: 22px
            }

            .section-copy h3 {
                font-size: 32px
            }

            .section-copy p {
                font-size: 14px
            }

            .bullet {
                font-size: 13px
            }

            .step-card {
                padding: 23px
            }

            .step-card p {
                font-size: 12px
            }

            .quote-card {
                padding: 23px
            }

            .quote-card p {
                font-size: 13px
            }

            .pricing {
                padding: 23px;
                border-radius: 20px
            }

            .price {
                font-size: 36px
            }

            .cta {
                padding: 34px 22px;
                border-radius: 24px
            }

            .cta h2 {
                font-size: 34px
            }

            footer {
                padding-top: 42px !important
            }
        }

        @media (max-width: 575.98px) {
            .hero {
                padding-top: 104px;
                padding-bottom: 58px
            }

            .eyebrow {
                font-size: 9px;
                padding: 7px 10px;
                max-width: 100%
            }

            .hero h1 {
                font-size: clamp(35px, 11.5vw, 48px);
                margin-bottom: 18px
            }

            .hero-actions .btn {
                font-size: 14px;
                padding: .72rem 1rem
            }

            .trust-line span {
                flex: 0 0 calc(50% - 9px)
            }

            .visual-wrap {
                min-height: 292px
            }

            .dashboard-scene {
                width: 112%;
                max-width: none;
                transform: scale(.88) rotateY(-3deg) rotateX(2deg);
                transform-origin: center
            }

            .dashboard-card {
                inset: 12px 0 0;
                padding: 9px;
                border-radius: 18px
            }

            .dash-body {
                grid-template-columns: 83px minmax(0, 1fr);
                gap: 7px
            }

            .dash-side {
                padding: 7px;
                border-radius: 10px
            }

            .dash-side .mini-brand {
                font-size: 9px;
                margin-bottom: 10px
            }

            .side-item {
                font-size: 6px;
                gap: 5px;
                margin: 6px 0
            }

            .side-item.active {
                padding: 5px
            }

            .dash-top {
                margin-bottom: 7px
            }

            .dot {
                width: 6px;
                height: 6px
            }

            .mini-title {
                font-size: 8px
            }

            .metric {
                padding: 6px
            }

            .metric strong {
                font-size: 10px
            }

            .metric small {
                font-size: 5px
            }

            .chart {
                height: 72px
            }

            .bars {
                inset: 11px 8px 10px;
                gap: 4px
            }

            .bar {
                border-radius: 4px 4px 1px 1px
            }

            .floating-chip {
                padding: 6px 8px;
                font-size: 6.8px;
                border-radius: 9px
            }

            .chip1 {
                top: 0
            }

            .chip2 {
                bottom: 7%;
                left: -1%
            }

            .chip3 {
                bottom: -5%;
                right: 2%
            }

            .section {
                padding: 56px 0
            }

            .section-head {
                margin-bottom: 30px
            }

            .section-copy h3 {
                font-size: 29px
            }

            .split-visual {
                min-height: 280px
            }

            .stat-number {
                font-size: 20px
            }

            .stat-text {
                font-size: 9px
            }

            .cta {
                padding: 28px 18px
            }

            .cta h2 {
                font-size: 29px
            }
        }

        @media (max-width: 359.98px) {
            .brand small {
                display: none
            }

            .brand strong {
                font-size: 18px
            }

            .logo-box {
                width: 35px;
                height: 35px
            }

            .hero {
                padding-top: 98px
            }

            .hero h1 {
                font-size: 34px
            }

            .hero-copy p {
                font-size: 14px
            }

            .trust-line span {
                flex-basis: 100%
            }

            .visual-wrap {
                min-height: 260px
            }

            .dashboard-scene {
                width: 125%;
                transform: scale(.80) rotateY(-2deg) rotateX(1deg)
            }

            .floating-chip {
                font-size: 6.2px;
                padding: 5px 6px
            }

            .split-visual {
                min-height: 250px
            }
        }

        @media (min-width: 1600px) {
            .container-xxl {
                max-width: 1540px
            }

            .hero {
                min-height: 920px
            }

            .section {
                padding: 125px 0
            }
        }

        @media(prefers-reduced-motion:reduce) {

            *,
            *:before,
            *:after {
                animation: none !important;
                transition: none !important;
                scroll-behavior: auto !important
            }
        }
    </style>
</head>

<body>

    <div class="nav-shell">
        <nav class="navbar navbar-expand-lg navbar-premium">
            <a class="brand me-lg-4" href="#home">
                <span class="logo-box"><i class="fa-solid fa-book-open"></i></span>
                <span><strong>LMSP</strong><small>Library Management SaaS Platform</small></span>
            </a>
            <button class="navbar-toggler border-0 shadow-none d-lg-none" data-bs-toggle="collapse"
                data-bs-target="#mainNav" aria-label="Toggle navigation"><i class="fa-solid fa-bars"></i></button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto desktop-nav">
                    <li><a class="nav-link active" href="#home">Home</a></li>
                    <li><a class="nav-link" href="#features">Features</a></li>
                    <li><a class="nav-link" href="#how">How It Works</a></li>
                    <li><a class="nav-link" href="#pricing">Pricing</a></li>
                    <li><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
                <div class="d-flex gap-2 ms-lg-auto mt-3 mt-lg-0"><a href="#login" class="btn btn-ghost">Login</a><a
                        href="#register" class="btn btn-main">Get Started <i
                            class="fa-solid fa-arrow-right ms-1"></i></a></div>
            </div>
        </nav>
    </div>

    <header class="hero" id="home">
        <div class="glow-orb orb1"></div>
        <div class="glow-orb orb2"></div>
        <div class="grid-fade"></div>
        <div class="container-xxl px-4 px-lg-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 reveal">
                    <div class="eyebrow"><i class="fa-solid fa-wand-magic-sparkles"></i> Smart Management for Modern
                        Study Libraries</div>
                    <h1>Manage Your Study Library <span class="gradient">Smarter & Better.</span></h1>
                    <p>One powerful SaaS platform to manage students, attendance, seats, memberships, fees and your
                        complete study-library operations — from anywhere.</p>
                    <div class="hero-actions"><a href="#register" class="btn btn-main btn-lg">Start Free <i
                                class="fa-solid fa-arrow-right ms-2"></i></a><a href="#features"
                            class="btn btn-outline-light btn-lg rounded-4 px-4"><i class="fa-solid fa-play me-2"></i>
                            Explore Platform</a></div>
                    <div class="trust-line"><span><i class="fa-solid fa-circle-check"></i> Easy Setup</span><span><i
                                class="fa-solid fa-circle-check"></i> No Complex Software</span><span><i
                                class="fa-solid fa-circle-check"></i> Cloud Based</span></div>
                </div>
                <div class="col-lg-6 reveal delay-2">
                    <div class="visual-wrap" id="heroVisual">
                        <div class="dashboard-scene" id="dashScene">
                            <div class="floating-chip chip1"><i class="fa-solid fa-user-check"></i> 180 Students Present
                            </div>
                            <div class="floating-chip chip2"><i class="fa-solid fa-chair"></i> 82% Seats Occupied</div>
                            <div class="floating-chip chip3"><i class="fa-solid fa-indian-rupee-sign"></i> ₹42,500
                                Collected</div>
                            <div class="dashboard-card">
                                <div class="placeholder-note"><strong>Your Library Dashboard Image</strong>Add your
                                    actual dashboard screenshot here</div>
                                <div class="dash-top"><span class="dot"></span><span class="dot"></span><span
                                        class="dot"></span></div>
                                <div class="dash-body">
                                    <div class="dash-side">
                                        <div class="mini-brand"><i class="fa-solid fa-book-open me-1"></i> LMSP</div>
                                        <div class="side-item active"><i class="fa-solid fa-grid-2"></i> Dashboard</div>
                                        <div class="side-item"><i class="fa-solid fa-users"></i> Students</div>
                                        <div class="side-item"><i class="fa-solid fa-calendar-check"></i> Attendance
                                        </div>
                                        <div class="side-item"><i class="fa-solid fa-chair"></i> Seats</div>
                                        <div class="side-item"><i class="fa-solid fa-wallet"></i> Payments</div>
                                        <div class="side-item"><i class="fa-solid fa-chart-line"></i> Reports</div>
                                    </div>
                                    <div class="dash-main">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="mini-title">Welcome back, Library Admin 👋</div><span
                                                class="badge text-bg-light">Today</span>
                                        </div>
                                        <div class="metric-row">
                                            <div class="metric"><small>Total Students</small><strong>250</strong></div>
                                            <div class="metric"><small>Present Today</small><strong>180</strong></div>
                                            <div class="metric"><small>Available Seats</small><strong>40</strong></div>
                                        </div>
                                        <div class="chart">
                                            <div class="bars"><span class="bar" style="height:56%"></span><span
                                                    class="bar"></span><span class="bar"></span><span
                                                    class="bar"></span><span class="bar"></span><span
                                                    class="bar"></span><span class="bar"></span></div>
                                        </div>
                                        <div class="metric-row">
                                            <div class="metric"><small>Monthly Revenue</small><strong>₹42.5K</strong>
                                            </div>
                                            <div class="metric"><small>Expiring Soon</small><strong>12</strong></div>
                                            <div class="metric"><small>Active Plans</small><strong>4</strong></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="stats-strip">
        <div class="container-xxl px-3 px-lg-5">
            <div class="stat-shell">
                <div class="row g-0">
                    <div class="col-6 col-lg stat-item">
                        <div class="stat-number">1,000+</div>
                        <div class="stat-text">Libraries Ready to Join</div>
                    </div>
                    <div class="col-6 col-lg stat-item">
                        <div class="stat-number">200K+</div>
                        <div class="stat-text">Students Managed</div>
                    </div>
                    <div class="col-6 col-lg stat-item">
                        <div class="stat-number">99.9%</div>
                        <div class="stat-text">Reliable Cloud Platform</div>
                    </div>
                    <div class="col-6 col-lg stat-item">
                        <div class="stat-number">24×7</div>
                        <div class="stat-text">Access from Anywhere</div>
                    </div>
                    <div class="col-12 col-lg stat-item">
                        <div class="stat-number">4.9/5</div>
                        <div class="stat-text">Owner Experience</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="features">
        <div class="container-xxl px-4 px-lg-5">
            <div class="section-head reveal"><span class="kicker"><i class="fa-solid fa-bolt"></i> POWERFUL
                    FEATURES</span>
                <h2>Everything Your Study Library Needs.</h2>
                <p>Built specifically for study libraries and reading rooms — not book-lending libraries.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3 reveal">
                    <div class="feature-card tone-green">
                        <div class="icon3d"><i class="fa-solid fa-users"></i></div>
                        <h5>Student Management</h5>
                        <p>Add, manage, search and track every student from one clean workspace.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal delay-1">
                    <div class="feature-card">
                        <div class="icon3d"><i class="fa-solid fa-calendar-check"></i></div>
                        <h5>Smart Attendance</h5>
                        <p>Quick check-in, check-out, QR attendance and complete attendance history.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal delay-2">
                    <div class="feature-card tone-purple">
                        <div class="icon3d"><i class="fa-solid fa-chair"></i></div>
                        <h5>Seats & Rooms</h5>
                        <p>Visual seat layout, allocation, occupancy, room management and seat history.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal delay-3">
                    <div class="feature-card tone-orange">
                        <div class="icon3d"><i class="fa-solid fa-id-card"></i></div>
                        <h5>Membership Plans</h5>
                        <p>Create monthly, quarterly, half-yearly and yearly plans for your students.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal">
                    <div class="feature-card tone-pink">
                        <div class="icon3d"><i class="fa-solid fa-indian-rupee-sign"></i></div>
                        <h5>Fees & Payments</h5>
                        <p>Track dues, collections, receipts, online payments and payment history.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal delay-1">
                    <div class="feature-card">
                        <div class="icon3d"><i class="fa-solid fa-file-lines"></i></div>
                        <h5>Study Material</h5>
                        <p>Share notes, PDFs and useful resources with your student community.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal delay-2">
                    <div class="feature-card tone-purple">
                        <div class="icon3d"><i class="fa-solid fa-chart-column"></i></div>
                        <h5>Reports & Analytics</h5>
                        <p>See attendance, revenue, memberships, seat occupancy and growth insights.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal delay-3">
                    <div class="feature-card tone-green">
                        <div class="icon3d"><i class="fa-solid fa-user-gear"></i></div>
                        <h5>Staff Management</h5>
                        <p>Manage team members, roles, permissions and day-to-day operations.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-soft">
        <div class="container-xxl px-4 px-lg-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 reveal">
                    <div class="split-visual">
                        <div class="image-placeholder">
                            <div><i class="fa-regular fa-image fs-1 mb-3 d-block"></i><strong class="d-block">Library
                                    Image Placeholder</strong><small>Replace this area with your real study-library
                                    photo</small></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 reveal delay-1">
                    <div class="section-copy"><span class="kicker">WHY LMSP</span>
                        <h3 class="mt-3">Give Every Student a Better Place to Study.</h3>
                        <p>Stop managing attendance registers, seat lists, fee notebooks and Excel sheets separately.
                            LMSP brings your complete study-library operation into one modern dashboard.</p>
                        <div class="mt-4">
                            <div class="bullet"><i class="fa-solid fa-circle-check"></i><span>Instant student onboarding
                                    & profile management</span></div>
                            <div class="bullet"><i class="fa-solid fa-circle-check"></i><span>QR check-in and live seat
                                    occupancy</span></div>
                            <div class="bullet"><i class="fa-solid fa-circle-check"></i><span>Membership renewal & fee
                                    reminders</span></div>
                            <div class="bullet"><i class="fa-solid fa-circle-check"></i><span>Real-time reports for
                                    smarter decisions</span></div>
                            <div class="bullet"><i class="fa-solid fa-circle-check"></i><span>Cloud access from mobile,
                                    tablet or desktop</span></div>
                        </div><a href="#register" class="btn btn-main mt-3 px-4">Start Managing Your Library <i
                                class="fa-solid fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="how">
        <div class="container-xxl px-4 px-lg-5">
            <div class="section-head reveal"><span class="kicker"><i class="fa-solid fa-route"></i> HOW IT WORKS</span>
                <h2>From Registration to Running Library.</h2>
                <p>Everything is designed to get a library owner live in minutes.</p>
            </div>
            <div class="row g-4 steps">
                <div class="col-md-6 col-lg-3 reveal">
                    <div class="step-card">
                        <div class="step-num">01</div>
                        <h5 class="fw-bold">Register Library</h5>
                        <p class="text-muted small mb-0">Enter library, owner and basic setup details.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal delay-1">
                    <div class="step-card">
                        <div class="step-num">02</div>
                        <h5 class="fw-bold">Choose Plan</h5>
                        <p class="text-muted small mb-0">Select the plan that fits your student capacity.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal delay-2">
                    <div class="step-card">
                        <div class="step-num">03</div>
                        <h5 class="fw-bold">Configure Library</h5>
                        <p class="text-muted small mb-0">Add rooms, seats, memberships and staff.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal delay-3">
                    <div class="step-card">
                        <div class="step-num">04</div>
                        <h5 class="fw-bold">Go Live</h5>
                        <p class="text-muted small mb-0">Add students and start managing your library.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-soft">
        <div class="container-xxl px-4 px-lg-5">
            <div class="section-head reveal"><span class="kicker">OWNER EXPERIENCE</span>
                <h2>Designed to Feel Premium.</h2>
                <p>A simple interface that looks modern enough to match the library you are building.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 reveal">
                    <div class="quote-card">
                        <div class="stars mb-3">★★★★★</div>
                        <p class="text-muted">“Attendance and seat management became much easier. I can check the status
                            of my library in seconds.”</p>
                        <div class="d-flex align-items-center gap-3 mt-4">
                            <div class="avatar">AK</div>
                            <div><strong>Amit Kumar</strong>
                                <div class="small text-secondary">Study Library Owner</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 reveal delay-1">
                    <div class="quote-card">
                        <div class="stars mb-3">★★★★★</div>
                        <p class="text-muted">“The fee tracking and expiry reminders save a lot of daily manual work for
                            my staff.”</p>
                        <div class="d-flex align-items-center gap-3 mt-4">
                            <div class="avatar">NS</div>
                            <div><strong>Neha Sharma</strong>
                                <div class="small text-secondary">Reading Room Owner</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 reveal delay-2">
                    <div class="quote-card">
                        <div class="stars mb-3">★★★★★</div>
                        <p class="text-muted">“Students love the QR attendance and the whole dashboard feels fast and
                            professional.”</p>
                        <div class="d-flex align-items-center gap-3 mt-4">
                            <div class="avatar">RV</div>
                            <div><strong>Rakesh Verma</strong>
                                <div class="small text-secondary">Study Center Owner</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="pricing">
        <div class="container-xxl px-4 px-lg-5">
            <div class="section-head reveal"><span class="kicker"><i class="fa-solid fa-crown"></i> PRICING</span>
                <h2>Start Small. Scale Without Limits.</h2>
                <p>Example pricing — change the numbers as per your final business model.</p>
            </div>
            <div class="row g-4 align-items-stretch">
                <div class="col-md-6 col-lg-3 reveal">
                    <div class="pricing">
                        <h5 class="fw-bold">Free</h5>
                        <div class="price">₹0 <small class="fs-6 text-muted">/ 30 days</small></div>
                        <ul class="plan-list mt-4">
                            <li><i class="fa-solid fa-check"></i>Up to 50 students</li>
                            <li><i class="fa-solid fa-check"></i>Basic attendance</li>
                            <li><i class="fa-solid fa-check"></i>Basic seat management</li>
                        </ul><a href="#register" class="btn btn-ghost w-100">Get Started</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal delay-1">
                    <div class="pricing">
                        <h5 class="fw-bold">Starter</h5>
                        <div class="price">₹999 <small class="fs-6 text-muted">3 Month</small></div>
                        <ul class="plan-list mt-4">
                            <li><i class="fa-solid fa-check"></i>Up to 200 students</li>
                            <li><i class="fa-solid fa-check"></i>All core features</li>
                            <li><i class="fa-solid fa-check"></i>Fee & expiry tracking</li>
                        </ul><a href="#register" class="btn btn-main w-100">Start Free Trial</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal delay-2">
                    <div class="pricing pop"><span class="popular">MOST POPULAR</span>
                        <h5 class="fw-bold">Professional</h5>
                        <div class="price">₹1,499 <small class="fs-6 text-muted">6 Month</small></div>
                        <ul class="plan-list mt-4">
                            <li><i class="fa-solid fa-check"></i>Up to 500 students</li>
                            <li><i class="fa-solid fa-check"></i>Advanced analytics</li>
                            <li><i class="fa-solid fa-check"></i>Priority support</li>
                        </ul><a href="#register" class="btn btn-main w-100">Start Free Trial</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal delay-3">
                    <div class="pricing">
                        <h5 class="fw-bold">Business</h5>
                        <div class="price">₹2,499 <small class="fs-6 text-muted">1 Year</small></div>
                        <ul class="plan-list mt-4">
                            <li><i class="fa-solid fa-check"></i>Unlimited students</li>
                            <li><i class="fa-solid fa-check"></i>Multi-branch support</li>
                            <li><i class="fa-solid fa-check"></i>Dedicated support</li>
                        </ul><a href="#register" class="btn btn-ghost w-100">Contact Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-5" id="register">
        <div class="container-xxl px-4 px-lg-5">
            <div class="cta reveal">
                <div class="row align-items-center g-4">
                    <div class="col-lg-8">
                        <div class="small text-uppercase fw-bold opacity-75 mb-2">Ready to digitize your study library?
                        </div>
                        <h2 class="mb-3">Run Your Library Like a Modern Business.</h2>
                        <p class="mb-0 opacity-75">Register once, configure your seats and memberships, and manage your
                            entire study space from one powerful dashboard.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end"><a href="#"
                            class="btn btn-light btn-lg rounded-4 px-4 fw-bold">Create My Library <i
                                class="fa-solid fa-arrow-right ms-2"></i></a></div>
                </div>
            </div>
        </div>
    </section>

    <footer id="contact" class="pt-5 pb-4">
        <div class="container-xxl px-4 px-lg-5">
            <div class="row g-4">
                <div class="col-lg-5"><a class="brand text-white d-inline-flex" href="#home"><span class="logo-box"><i
                                class="fa-solid fa-book-open"></i></span><span><strong
                                class="text-white">LMSP</strong><small style="color:#89a2bf">Library Management SaaS
                                Platform</small></span></a>
                    <p class="text-white-50 small mt-3" style="max-width:430px">A premium management platform built for
                        study libraries, reading rooms and modern student spaces.</p>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="fw-bold">Product</h6>
                    <div class="d-flex flex-column gap-2 mt-3"><a class="footer-link" href="#features">Features</a><a
                            class="footer-link" href="#how">How It Works</a><a class="footer-link"
                            href="#pricing">Pricing</a></div>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="fw-bold">Company</h6>
                    <div class="d-flex flex-column gap-2 mt-3"><a class="footer-link" href="#contact">Contact</a><a
                            class="footer-link" href="#faq">FAQ</a><a class="footer-link" href="#register">Get
                            Started</a></div>
                </div>
                <div class="col-12 col-lg-3">
                    <h6 class="fw-bold">Platform</h6>
                    <p class="small text-white-50 mb-0 mt-3">Students · Attendance · Seats · Memberships · Fees ·
                        Reports · Staff</p>
                </div>
            </div>
            <hr class="border-secondary-subtle my-4">
            <div class="d-flex justify-content-between flex-wrap gap-2 small text-white-50"><span>© 2026 LMSP. All
                    rights reserved.</span><span><i class="fa-brands fa-facebook me-3"></i><i
                        class="fa-brands fa-instagram me-3"></i><i class="fa-brands fa-linkedin me-3"></i><i
                        class="fa-brands fa-x-twitter"></i></span></div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth reveal on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('show'); observer.unobserve(entry.target); } });
        }, { threshold: .12 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // Small 3D mouse parallax for desktop
        const visual = document.getElementById('heroVisual');
        const scene = document.getElementById('dashScene');
        if (visual && scene && window.matchMedia('(min-width: 992px)').matches) {
            visual.addEventListener('mousemove', (e) => {
                const r = visual.getBoundingClientRect();
                const x = (e.clientX - r.left) / r.width - .5;
                const y = (e.clientY - r.top) / r.height - .5;
                scene.style.animation = 'none';
                scene.style.transform = `rotateY(${(-12 + x * 7).toFixed(2)}deg) rotateX(${(7 - y * 6).toFixed(2)}deg) rotateZ(-1deg) translateY(-2px)`;
            });
            visual.addEventListener('mouseleave', () => {
                scene.style.animation = 'sceneFloat 6s ease-in-out infinite';
                scene.style.transform = '';
            });
        }
    </script>
</body>

</html>