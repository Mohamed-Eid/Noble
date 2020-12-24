<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>تسجيل دخول | 90days home </title>
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
</head>
<body class="login-page">
	<div id="login-content">
		<div class="content">
			<div class="logo"><a href="/"><img src="{{ asset('web/images/logo.png') }}" /></a></div>
			<div class="login-box">
      <form action="{{ route('web.client_login') }}" method="POST">
          @csrf
          @include('partials._errors')

					<div class="form-group">
            {{-- <input type="tel" name="phone" value="" id="input-phone" class="form-control"> --}}
            <input type="text" name="phone" value="" id="#" class="form-control" placeholder="رقم الهاتف">

					</div>
					<div class="form-group">
						<input type="password" name="password" value="" placeholder="كلمة المرور" id="input-password" class="form-control">
					</div>
          <a class="forget" href="{{ route('web.forget_password') }}">نسيت كلمه المرور؟</a>
					<div class="login-box-footer">
						<button type="submit" class="btn btn-block btn-lg btn-yellow">تسجيل الدخول</button>
						<div class="text-hr"><span>أو</span></div>
            <p><a href="{{route('web.register')}}" class="link-register">تسجيل الأن</a></p>
            <p><a href="{{ route('web.index') }}" class="link-skip"><i class="fa fa-arrow-right"></i> تخطي</a></p>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
  <script src="{{ asset('web/js/intlTelInput.js') }}"></script>
  <script>
    var input = document.querySelector("#input-phone");
    window.intlTelInput(input, {
      // allowDropdown: false,
      // autoHideDialCode: false,
      // autoPlaceholder: "off",
      // dropdownContainer: document.body,
      // excludeCountries: ["us"],
      // formatOnDisplay: false,
      // geoIpLookup: function(callback) {
      //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
      //     var countryCode = (resp && resp.country) ? resp.country : "";
      //     callback(countryCode);
      //   });
      // },
      // hiddenInput: "full_number",
      // initialCountry: "auto",
      // localizedCountries: { 'de': 'Deutschland' },
      // nationalMode: false,
      // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
      // placeholderNumberType: "MOBILE",
      // preferredCountries: ['cn', 'jp'],
      // separateDialCode: true,
      utilsScript: "{{ asset('web/js/utils.js') }}",
    });
  </script>

</html>
