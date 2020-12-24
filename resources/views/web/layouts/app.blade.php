<!DOCTYPE html>
<html dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>@yield('title',__('site.tafsil_'))</title>
<link href="{{asset('web/images/logo1.png')}}" rel="icon">
<script src="{{ asset('web/js/jquery-2.1.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('web/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<link href="{{ asset('web/css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('web/bootstrap/css/bootstrap-a.css') }}" rel="stylesheet" media="screen" />
<link href="{{ asset('web/owl-carousel/owl.carousel.css') }}" type="text/css" rel="stylesheet" media="screen" />
<link href="{{ asset('web/owl-carousel/owl.transitions.css') }}" type="text/css" rel="stylesheet" media="screen" />
<script src="{{ asset('web/owl-carousel/owl.carousel.js') }}" type="text/javascript"></script>
<link rel="stylesheet" href="{{ asset('web/css/intlTelInput.css') }}">
<link href="{{ asset('web/css/stylesheet.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

{{--noty--}}
<link rel="stylesheet" href="{{ asset('dashboard/plugins/noty/noty.css') }}">
<script src="{{ asset('dashboard/plugins/noty/noty.min.js') }}"></script>
  
@yield('styles')
</head>
<body class="@yield('body_class', 'home-page') padding">
    <div class="nav-overlay"></div>

    @yield('header')

    @include('web.layouts._aside')

    <div id="content" class="container">
        @include('web.partials._session')

        @yield('content')
    </div>

    @include('web.layouts._footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        $('.sub-nav-menu').on('click', function () {
            $('.sub-nav-content').toggleClass('is-active');
            $('.sub-nav-menu').toggleClass('is-active');
            $('.home-page').toggleClass('nav-is-active');
            $('.nav-overlay').toggleClass('is-active');
            toggleBodyScroll();
        });
        $('.nav-overlay').on('click', function () {
            $('.sub-nav-content').toggleClass('is-active');
            $('.sub-nav-menu').toggleClass('is-active');
            $('.home-page').toggleClass('nav-is-active');
            $('.nav-overlay').toggleClass('is-active');
            toggleBodyScroll(false);
        });
        $('.link-icon-menu').on('click', function () {
            $('.sub-nav-content').toggleClass('is-active');
            $('.sub-nav-menu').toggleClass('is-active');
            $('.home-page').toggleClass('nav-is-active');
            $('.nav-overlay').toggleClass('is-active');
            toggleBodyScroll(false);
        });
    });
    </script>

    @yield('scripts')
</body>
</html>
