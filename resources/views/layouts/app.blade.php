<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">


<!-- Mirrored from themesbrand.com/velzon/html/master/pages-starter.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Aug 2024 07:47:01 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Admin | Prediksi KEK</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />

    <link rel="shortcut icon" href="{{ asset('assets/img/logo-unja.png') }}">

    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.cs') }}s" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    @livewireStyles
    <style>
        body {
            background-image: url("{{ asset('assets/img/bgmain-desktop.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
        }

        .main-content {
            background-color: transparent;
        }

        .page-content {
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 16px;
            backdrop-filter: blur(2px);
        }

        @media (max-width: 768px) {
            body {
                background-image: url("{{ asset('assets/img/bgmain-mobile.png') }}");
            }
        }
    </style>
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('layouts.top_bar')
        <!-- ========== App Menu ========== -->
        @include('layouts.nav_bar')
        <!-- Left Sidebar End -->

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            @yield('content')
                        </div>
                    </div>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->


    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    @livewireScripts

</body>


<!-- Mirrored from themesbrand.com/velzon/html/master/pages-starter.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Aug 2024 07:47:02 GMT -->

</html>
