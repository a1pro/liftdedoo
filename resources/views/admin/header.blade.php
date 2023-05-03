<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description"
        content="LetStart Admin is a full featured, multipurpose, premium bootstrap admin template built with Bootstrap 4 Framework, HTML5, CSS and JQuery.">
    <meta name="keywords"
        content="admin, panels, dashboard, admin panel, multipurpose, bootstrap, bootstrap4, all type of dashboards">
    <meta name="author" content="MatrrDigital">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lift Dedoo</title>
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon" />

    <!-- ================== BEGIN PAGE LEVEL CSS START ================== -->
    <link rel="stylesheet" href="{{ asset('admin/css/icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/libs/wave-effect/css/waves.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/libs/owl-carousel/css/owl.carousel.min.css') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('front/images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('front/images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('front/images/favicon-16x16.png') }}">
    <!-- ================== BEGIN PAGE LEVEL END ================== -->
    <!-- ================== Plugins CSS  ================== -->
    <link href="{{ asset('admin/libs/datatables/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('admin/libs/datatables/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('admin/libs/datatables/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('admin/libs/datatables/css//select.bootstrap4.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('admin/libs/flatpicker/css/flatpickr.min.css') }}">

    <!-- ================== Plugins CSS ================== -->
    <!-- ================== BEGIN APP CSS  ================== -->
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" />
    <!-- ================== END APP CSS ================== -->

    <script src="{{ asset('admin/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
    <link href="{{ asset('admin/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" media="screen">


    <!-- ================== BEGIN POLYFILLS  ================== -->
    <!--[if lt IE 9]>
      <script src="assets/libs/html5shiv/js/html5shiv.js"></script>
      <script src="assets/libs/respondjs/js/respond.min.js"></script>
   <![endif]-->
    <!-- ================== END POLYFILLS  ================== -->
</head>

<body>
    <!-- Begin Page -->
    <div class="page-wrapper">
        <!-- Begin Header -->
        <!-- Begin Header -->
        <header id="page-topbar" class="topbar-header">
            <div class="navbar-header">
                <div class="left-bar">
                    <div class="navbar-brand-box">
                        <a href="index.html" class="logo logo-dark">

                        </a>
                        <a href="#" class="logo logo-light">
                            <span class="logo-sm"><img src="{{ asset('front/images/logo-sm.png') }}"
                                alt="Lettstart Admin"></span>
                            <span class="logo-lg"><img src="{{ asset('front/images/logo.png') }}"
                                    alt="Lettstart Admin"></span>
                        </a>
                    </div>
                    <button type="button" id="vertical-menu-btn" class="btn hamburg-icon">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </div>
                <div class="right-bar">
                    <div class="d-none d-lg-inline-flex ml-2">
                        <button type="button" data-toggle="fullscreen" class="btn header-item notify-icon"
                            id="full-screen">
                            <i class="bx bx-fullscreen"></i>
                        </button>
                    </div>
                    <div class="d-inline-flex ml-0 ml-sm-2 dropdown">
                        <button data-toggle="dropdown" aria-haspopup="true" type="button"
                            id="page-header-profile-dropdown" aria-expanded="false" class="btn header-item">
                            <img src="{{ asset('images/default.jpg') }}" alt="Header Avatar"
                                class="avatar avatar-xs mr-0">
                            <span class="d-none d-xl-inline-block ml-1">{{ Auth::user()->name }}</span>
                            <i class="bx bx-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div aria-labelledby="page-header-profile-dropdown" class="dropdown-menu-right dropdown-menu">
                            <a href="javascript: void(0);" class="dropdown-item">
                                <i class="bx bx-user mr-1"></i> Profile
                            </a>
                            <a href="{{url('admin-change-password')}}" class="dropdown-item">
                                <i class="bx bx-key"></i>  Change Password
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="text-danger dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                                <i class="bx bx-log-in mr-1 text-danger"></i> {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header End -->
        <!-- Header End -->
