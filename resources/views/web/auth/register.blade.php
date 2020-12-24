<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>تسجيل جديد | 90days home </title>
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
<body class="register-page login-page">
	<div id="login-content">
		<div class="content">
            <div class="logo"><a href="{{ route('web.index') }}"><img src="{{asset('web/images/logo.png')}}" /></a></div>
			<div class="login-box">
                @include('partials._errors')

                <form method="POST" action="{{ route('web.register') }}">
                    @csrf
					<div class="form-group">
						<input type="tel" name="mobile" value="" placeholder="رقم الهاتف" id="input-phone" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        {{-- <input type="text" name="country" value="" placeholder="الدولة" id="input-country" class="form-control"> --}}

                        <select name="city_id" class="form-control cities" placeholder="الدولة" required>
                            <option value="" selected disabled>الدولة</option>
                            @foreach ($countries as $country)
                            <option value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>
					</div>

					<div class="form-group">
                        <select name="district_id" class="form-control districts" placeholder="المدينه" required>
                            <option value="" selected disabled>المدينه</option>
                        </select>
                    </div>
                    
                    <script>
                        $( ".cities" ).change(function() {

                            $.ajax({
                                type : 'GET',
                                url : '{{ route('api.all_cities') }}'+'/'+this.value,  
                                dataType: 'json',
                                success: function (data) {
                                    console.log(data.data);
                                    List = data.data;
                                    $('.districts').empty();
                                    $('.districts').append("<option value='' selected disabled>المدينه</option>");
                                    for (i in List ) {
                                        $('.districts').append('<option value="' + List[i].id + '">' + List[i].name + '</option>');
                                    }
                                }
                            });
                        
                        });

                    </script>
					<div class="form-group">
						<input type="text" name="street" value="" placeholder="الشارع" id="input-street" class="form-control" required>
					</div>
					<div class="form-group">
						<input type="text" name="email" value="" placeholder="البريد الإلكتروني" id="input-email" class="form-control" required>
					</div>
					<div class="form-group">
						<input type="password" name="password" value="" placeholder="كلمة المرور" id="input-password" class="form-control" required>
                    </div>
                    <div class="form-group">
						<input type="password" name="password_confirmation" value="" placeholder="تأكيد كلمة المرور" id="input-password" class="form-control" required>
					</div>
					<div class="login-box-footer">
						<button type="submit" class="btn btn-block btn-lg btn-yellow">تسجيل</button>
						<div class="text-hr"><span>أو</span></div>
                        <p><a href="{{route('web.login')}}" class="link-register">تسجيل الدخول</a></p>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
