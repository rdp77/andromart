<!DOCTYPE html>
<html>
    <head>
        <!-- Basic -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>@yield('title')</title>

        <meta name="keywords" content="HTML5 Template" />
        <meta name="description" content="Porto - Responsive HTML5 Template">
        <meta name="author" content="okler.net">

        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assetsfrontend/img/logo_nonbg.png') }}">
        <link rel="apple-touch-icon" href="img/apple-touch-icon.png">

        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

        <!-- Web Fonts  -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light%7CPlayfair+Display:400" rel="stylesheet" type="text/css">

        <!-- Vendor CSS -->
        <link rel="stylesheet" href="{{ asset('assetsfrontend/vendor/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assetsfrontend/vendor/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assetsfrontend/vendor/animate/animate.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assetsfrontend/vendor/simple-line-icons/css/simple-line-icons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assetsfrontend/vendor/owl.carousel/assets/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assetsfrontend/vendor/owl.carousel/assets/owl.theme.default.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assetsfrontend/vendor/magnific-popup/magnific-popup.min.css') }}">

        <!-- Theme CSS -->
        <link rel="stylesheet" href="{{ asset('assetsfrontend/css/theme.css') }}">
        <link rel="stylesheet" href="{{ asset('assetsfrontend/css/theme-elements.css') }}">
        <link rel="stylesheet" href="{{ asset('assetsfrontend/css/theme-blog.css') }}">
        <link rel="stylesheet" href="{{ asset('assetsfrontend/css/theme-shop.css') }}">

        <!-- Current Page CSS -->
        <link rel="stylesheet" href="{{ asset('assetsfrontend/vendor/rs-plugin/css/settings.css') }}">
        <link rel="stylesheet" href="{{ asset('assetsfrontend/vendor/rs-plugin/css/layers.css') }}">
        <link rel="stylesheet" href="{{ asset('assetsfrontend/vendor/rs-plugin/css/navigation.css') }}">

        <!-- Demo CSS -->
        <link rel="stylesheet" href="{{ asset('assetsfrontend/css/demos/demo-digital-agency.css') }}">

        <!-- Skin CSS -->
        <link rel="stylesheet" href="{{ asset('assetsfrontend/css/skins/skin-digital-agency.css') }}">

        <!-- Theme Custom CSS -->
        <link rel="stylesheet" href="{{ asset('assetsfrontend/css/custom.css') }}">

        <!-- Head Libs -->
        <script src="{{ asset('assetsfrontend/vendor/modernizr/modernizr.min.js') }}"></script>
        @stack('custom-css')
    </head>
    <body>
        <div class="body">
            @include('layouts.frontend.components.menu')
            @yield('content')
            @include('layouts.frontend.components.footer')
        </div>

        <!-- Vendor -->
        <script src="{{ asset('assetsfrontend/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assetsfrontend/vendor/jquery.appear/jquery.appear.min.js') }}"></script>
        <script src="{{ asset('assetsfrontend/vendor/jquery.easing/jquery.easing.min.js') }}"></script>
        <script src="{{ asset('assetsfrontend/vendor/jquery.cookie/jquery.cookie.min.js') }}"></script>
        <script src="{{ asset('assetsfrontend/vendor/popper/umd/popper.min.js') }}"></script>
        <script src="{{ asset('assetsfrontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assetsfrontend/vendor/common/common.min.js') }}"></script>
        <script src="{{ asset('assetsfrontend/vendor/jquery.validation/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('assetsfrontend/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
        <script src="{{ asset('assetsfrontend/vendor/jquery.gmap/jquery.gmap.min.js') }}"></script>
        <script src="{{ asset('assetsfrontend/vendor/jquery.lazyload/jquery.lazyload.min.js') }}"></script>
        <script src="{{ asset('assetsfrontend/vendor/isotope/jquery.isotope.min.js') }}"></script>
        <script src="{{ asset('assetsfrontend/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('assetsfrontend/vendor/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('assetsfrontend/vendor/vide/jquery.vide.min.js') }}"></script>
        <script src="{{ asset('assetsfrontend/vendor/vivus/vivus.min.js') }}"></script>

        <!-- Theme Base, Components and Settings -->
        <script src="{{ asset('assetsfrontend/js/theme.js') }}"></script>

        <!-- Current Page Vendor and Views -->
        <script src="{{ asset('assetsfrontend/js/views/view.contact.js') }}"></script>

        <!-- Current Page Vendor and Views -->
        <script src="{{ asset('assetsfrontend/vendor/rs-plugin/js/jquery.themepunch.tools.min.js') }}"></script>
        <script src="{{ asset('assetsfrontend/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js') }}"></script>

        <!-- Theme Custom -->
        <script src="{{ asset('assetsfrontend/js/custom.js') }}"></script>

        <!-- Theme Initialization Files -->
        <script src="{{ asset('assetsfrontend/js/theme.init.js') }}"></script>
        @stack('custom-scripts')
    </body>
</html>
