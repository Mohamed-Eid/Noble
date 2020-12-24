<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>@yield('title') | @lang('site.kbsh')</title>
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
{{--noty--}}
<link rel="stylesheet" href="{{ asset('dashboard/plugins/noty/noty.css') }}">
<script src="{{ asset('dashboard/plugins/noty/noty.min.js') }}"></script>
</head>
<body class="information-page">
	<div id="information-content">
		<div class="content">
            <div class="logo"><a href="/"><img src="{{asset('web/images/logo.png')}}" /></a></div>
            <h3 class="heading-title">@yield('title')</h3>
			<div class="information-box">
				<p> @yield('content') </p>
			</div>
		</div>
	</div>
</body>
</html>
