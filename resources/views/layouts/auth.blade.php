<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="fullscreen-bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <link rel="icon" sizes="16x16 32x32" type="image/png" href="{{ asset('TheOnlineDogTrainer-Favicon-RED.png') }}">
    <link rel="shortcut icon" sizes="16x16 32x32" type="image/png" href="{{ asset('TheOnlineDogTrainer-Favicon-RED.png') }}">

    <!--begin::Base Styles -->
    <link href="/template/core/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/template/core/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Base Styles -->
    
</head>
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
    
    @yield('content')
    
    <!--begin::Base Scripts -->
    <script src="/template/core/vendors/base/vendors.bundle.js" type="text/javascript"></script>
    <script src="/template/core/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
    <!--end::Base Scripts -->   

    <!--begin::Page Snippets -->
    <script src="/template/core/snippets/custom/pages/user/login.js" type="text/javascript"></script>
    <!--end::Page Snippets -->

    @yield('custom-script')

    <script>
           $(document).ready(function() {
              $("#session-message").delay(2500).slideUp(300);
           });
    </script>
</body>
</html>
