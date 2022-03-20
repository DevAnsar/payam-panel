<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>پنل مدیریت</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="پنل مدیریت وب اپلیکیشن ارسال لینک به شماره موبایل" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">

    <!-- datepicker -->
    <link href="{{asset('assets/libs/air-datepicker/css/datepicker.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- jvectormap -->
    <link href="{{asset('assets/libs/jqvmap/jqvmap.min.css')}}" rel="stylesheet" />

    <!-- Bootstrap Css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

    @yield('css-files')

    <!-- App Css-->
    <link href="{{asset('assets/css/app-rtl.min.css')}}" rel="stylesheet" type="text/css" />

</head>

<body data-topbar="colored">

<div id="app">
<!-- Begin page -->
<div id="layout-wrapper">

    @include('admin.layouts.top-bar')
    @include('admin.layouts.right-sidebar')

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        @yield('content')
        @include('admin.layouts.footer')
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->
</div>

{{--@include('admin.layouts.left-bar')--}}



<!-- JAVASCRIPT -->
<script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>

<script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>

<!-- datepicker -->
<script src="{{asset('assets/libs/air-datepicker/js/datepicker.min.js')}}"></script>
<script src="{{asset('assets/libs/air-datepicker/js/i18n/datepicker.en.js')}}"></script>

<!-- apexcharts -->
<script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>

<script src="{{asset('assets/libs/jquery-knob/jquery.knob.min.js')}}"></script>

<!-- Jq vector map -->
<script src="{{asset('assets/libs/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('assets/libs/jqvmap/maps/jquery.vmap.usa.js')}}"></script>


@yield('js-files')

<script src="{{asset('assets/js/app.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
