<!DOCTYPE html>
<html lang="en">


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CreditFlow | Smart Loan & EMI Management</title>

    <meta name="description"
        content="CreditFlow provides both investment and loan services on a single platform, helping users manage loans, EMIs, and investments easily and transparently.">
    <meta name="keywords" content="CreditFlow, Loan Management, EMI Tracker, Investment Platform, Fintech Services">
    <meta name="author" content="CreditFlow">

    <meta name="theme-color" content="#392c70">

    <link rel="icon" type="image/png" href="/images/minilogo.png">
    <link rel="apple-touch-icon" href="/images/minilogo.png">

    <link rel="stylesheet" href="/vendors/iconfonts/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="http://www.urbanui.com/" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }

    :root {
        --cf-primary: #392c70;
        --cf-secondary: #6a005b;
        --cf-accent: #ff6b35;
    }

    .bg-creditflow {
        background: linear-gradient(85deg, var(--cf-primary), var(--cf-secondary));
    }

    .text-creditflow {
        color: var(--cf-primary);
    }

    .btn-creditflow {
        background: linear-gradient(85deg, var(--cf-primary), var(--cf-secondary));
        color: #fff;
        border: none;
    }

    .btn-creditflow:hover {
        opacity: 0.9;
        color: #fff;
    }

    .bgcolor {
        background: linear-gradient(85deg, #392c70, #6a005b) !important;
        color: #fff !important;
    }

    .badge-admin {
        background: linear-gradient(135deg, #5f2c82, #49a09d);
        color: #fff;
    }

    .card .card-body {
        padding: 0.5rem 1.5rem !important;
    }

    .bgcolor {
        background: linear-gradient(85deg, #392c70, #6a005b) !important;
        color: #fff !important;
    }

    .badge-admin {
        background: linear-gradient(135deg, #5f2c82, #49a09d);
        color: #fff;
    }
</style>

<body>
    <div class="container-scroller">
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row default-layout-navbar">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href="/admin"><img src="/images/logoo.png" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="/admin"><img src="/images/minilogo.png"
                        alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="fas fa-bars"></span>
                </button>
                <ul class="navbar-nav">
                    <li class="nav-item nav-search d-none d-md-flex">
                        <div class="nav-link">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" placeholder="Search" aria-label="Search">
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <!-- <li class="nav-item d-none d-lg-flex">
                        <a class="nav-link" href="#">
                            <span class="btn btn-primary">+ Create new</span>
                        </a>
                    </li> -->
                    <li class="nav-item dropdown d-none d-lg-flex">
                        <div class="nav-link">
                            <span class="dropdown-toggle btn btn-outline-dark" id="languageDropdown"
                                data-toggle="dropdown">English</span>
                            <div class="dropdown-menu navbar-dropdown" aria-labelledby="languageDropdown">
                                <a class="dropdown-item font-weight-medium" href="#">
                                    French
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item font-weight-medium" href="#">
                                    Espanol
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item font-weight-medium" href="#">
                                    Latin
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item font-weight-medium" href="#">
                                    Arabic
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                            data-toggle="dropdown">
                            <i class="fas fa-bell mx-0"></i>
                            <span class="count">16</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                            aria-labelledby="notificationDropdown">
                            <a class="dropdown-item">
                                <p class="mb-0 font-weight-normal float-left">You have 16 new notifications
                                </p>
                                <span class="badge badge-pill badge-warning float-right">View all</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-danger">
                                        <i class="fas fa-exclamation-circle mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-medium">Application Error</h6>
                                    <p class="font-weight-light small-text">
                                        Just now
                                    </p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-warning">
                                        <i class="fas fa-wrench mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-medium">Settings</h6>
                                    <p class="font-weight-light small-text">
                                        Private message
                                    </p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-info">
                                        <i class="far fa-envelope mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-medium">New user registration</h6>
                                    <p class="font-weight-light small-text">
                                        2 days ago
                                    </p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#"
                            data-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-envelope mx-0"></i>
                            <span class="count">25</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                            aria-labelledby="messageDropdown">
                            <div class="dropdown-item">
                                <p class="mb-0 font-weight-normal float-left">You have 7 unread mails
                                </p>
                                <span class="badge badge-info badge-pill float-right">View all</span>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="/images/faces/face4.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="preview-item-content flex-grow">
                                    <h6 class="preview-subject ellipsis font-weight-medium">David Grey
                                        <span class="float-right font-weight-light small-text">1 Minutes ago</span>
                                    </h6>
                                    <p class="font-weight-light small-text">
                                        The meeting is cancelled
                                    </p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="/images/faces/face2.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="preview-item-content flex-grow">
                                    <h6 class="preview-subject ellipsis font-weight-medium">Tim Cook
                                        <span class="float-right font-weight-light small-text">15 Minutes ago</span>
                                    </h6>
                                    <p class="font-weight-light small-text">
                                        New product launch
                                    </p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="/images/faces/face3.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="preview-item-content flex-grow">
                                    <h6 class="preview-subject ellipsis font-weight-medium"> Johnson
                                        <span class="float-right font-weight-light small-text">18 Minutes ago</span>
                                    </h6>
                                    <p class="font-weight-light small-text">
                                        Upcoming board meeting
                                    </p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <!-- <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <img src="/images/faces/face5.jpg" alt="profile" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <a class="dropdown-item">
                                <i class="fas fa-cog text-primary"></i>
                                Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('admin.logout') }}" class="dropdown-item">
                                <i class="fas fa-power-off text-primary"></i>
                                Logout
                            </a>
                        </div>
                    </li> -->
                    <li class="nav-item nav-settings">
                        <a class="nav-link" href="#">
                            <i class="fas fa-ellipsis-h"></i>
                        </a>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center ml-auto" type="button"
                    data-toggle="offcanvas">
                    <span class="fas fa-bars"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel -->
            <div class="theme-setting-wrapper">
                <div id="settings-trigger"><i class="fas fa-fill-drip"></i></div>
                <div id="theme-settings" class="settings-panel">
                    <i class="settings-close fa fa-times"></i>
                    <p class="settings-heading">SIDEBAR SKINS</p>
                    <div class="sidebar-bg-options selected" id="sidebar-light-theme">
                        <div class="img-ss rounded-circle bg-light border mr-3"></div>Light
                    </div>
                    <div class="sidebar-bg-options" id="sidebar-dark-theme">
                        <div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark
                    </div>
                    <p class="settings-heading mt-2">HEADER SKINS</p>
                    <div class="color-tiles mx-0 px-4">
                        <div class="tiles primary"></div>
                        <div class="tiles success"></div>
                        <div class="tiles warning"></div>
                        <div class="tiles danger"></div>
                        <div class="tiles info"></div>
                        <div class="tiles dark"></div>
                        <div class="tiles default"></div>
                    </div>
                </div>
            </div>
            @if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->email)
                @include('components.admin.chats')
            @endif
            <!-- partial -->
            @include('components.admin.sidebar')
