<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="fullscreen-bg" ng-app="app">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Doggy Dan') }}</title>
    <link rel="icon" sizes="16x16 32x32" type="image/png" href="{{ asset('TheOnlineDogTrainer-Favicon-RED.png') }}">
    <link rel="shortcut icon" sizes="16x16 32x32" type="image/png" href="{{ asset('TheOnlineDogTrainer-Favicon-RED.png') }}">

    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
      WebFont.load({
        google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700","Asap+Condensed:500"]},
        active: function() {
            sessionStorage.fonts = true;
        }
      });
    </script>
    <!--end::Web font -->

    <!--begin::Page Vendors -->
    @yield('page-styles')
    <!--end::Page Vendors -->
    <link href="/template/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/template/demo/demo10/base/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Base Styles -->

</head>
<body class="m-page--fluid m-page--loading-enabled m-page--loading m-header--fixed m-header--fixed-mobile m-footer--push m-aside--offcanvas-default">

    <!-- begin::Page loader -->
    <div class="m-page-loader m-page-loader--base">
        <div class="m-blockui">
            <span>
                Please wait...
            </span>
            <span>
                <div class="m-loader m-loader--brand"></div>
            </span>
        </div>
    </div>
    <!-- end::Page Loader -->
    
    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
        @include('partials.header')

        <div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop m-page__container m-body">
            <div class="m-grid__item m-grid__item--fluid m-wrapper">
                @yield('content')
            </div>
        </div>

        @include('partials.footer')
    </div>
    <!-- end:: Page -->

    <!--begin::Base Scripts -->
    <!-- <script src="/template/core/vendors/base/vendors.bundle.js" type="text/javascript"></script> -->
    <script src="/template/vendors/base/vendors.bundle.js" type="text/javascript"></script>
    <script src="/template/demo/demo10/base/scripts.bundle.js" type="text/javascript"></script>
    <!--end::Base Scripts -->  

    <script src="/template/core/demo/default/custom/components/base/blockui.js" type="text/javascript"></script>
    <script src="/template/demo/demo10/base/sweetalert2.js" type="text/javascript"></script>

    @yield('page-scripts')

    @yield('page-snippets')

    <!-- Framework -->
    <script src="{{ asset('framework/angular.js') }}"></script>
    <script src="{{ asset('framework/angular-animate.js') }}"></script>
    <script src="{{ asset('framework/angular-ui-router.js') }}"></script>
    <script src="{{ asset('framework/angular-cookies.js') }}"></script>
    <script src="{{ asset('framework/angular-ui-bootstrap.js') }}"></script>
    
    <script src="{{ asset('app/components/Order.js?v=1') }}"></script>
    <script src="{{ asset('app/components/Domain.js?v=1') }}"></script>
    <script src="{{ asset('app/components/SystemSetting.js?v=1') }}"></script>
    <script src="{{ asset('app/components/Products.js?v=1') }}"></script>
    <script src="{{ asset('app/components/Users.js?v=1') }}"></script>
    <script src="{{ asset('app/components/Dashboard.js?v=1') }}"></script>
    <script src="{{ asset('app/app.js?v=1') }}"></script>

    <script>
           $(document).ready(function() {
              $("#session-message").delay(2500).slideUp(300);
           });
    </script>
</body>
</html>
