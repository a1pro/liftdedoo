<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('resources/js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="{{ asset('resources/css/app.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon" />

    <!-- ================== BEGIN PAGE LEVEL CSS START ================== -->
    <link rel="stylesheet" href="{{ asset('admin/css/icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/libs/wave-effect/css/waves.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/libs/owl-carousel/css/owl.carousel.min.css') }}" />
    <!-- ================== BEGIN PAGE LEVEL END ================== -->

    <!-- ================== Plugins CSS  ================== -->
    <link rel="stylesheet" href="{{ asset('admin/libs/owl-carousel/css/owl.carousel.min.css') }}" />
    <!-- ================== Plugins CSS end ================== -->

    <!-- ================== BEGIN APP CSS  ================== -->
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" />
    <!-- ================== END APP CSS ================== -->

    <!-- ================== BEGIN POLYFILLS  ================== -->
    <!--[if lt IE 9]>
     <script src="assets/libs/html5shiv/js/html5shiv.js"></script>
     <script src="assets/libs/respondjs/js/respond.min.js"></script>
    <![endif]-->
    <!-- ================== END POLYFILLS  ================== -->
</head>

<body>

    <div class="auth-pages">

        @yield('content')

    </div>


    <!-- ================== BEGIN BASE JS ================== -->
    <script src="{{ asset('admin/js/vendor.min.js') }}"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <!-- ================== END BASE JS ================== -->

    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="{{ asset('admin/js/utils/colors.js') }}"></script>
    <script src="{{ asset('admin/libs/owl-carousel/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('admin/libs/jquery-validation/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/libs/jquery-validation/js/additional-methods.min.js') }}"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->

    <!-- ================== BEGIN PAGE JS ================== -->
    <script src="{{ asset('admin/js/app.js') }}"></script>
    <!-- ================== END PAGE JS ================== -->

    <script>
        $(".auth-user-testimonial .owl-carousel").owlCarousel({
            loop: true,
            margin: 0,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 4000,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
        //Initialize form

    </script>
</body>
</html>
