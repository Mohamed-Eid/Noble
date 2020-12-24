@extends('web.layouts.app')

@section('body_class')
category
@endsection

@section('title')
@lang('site.cart')
@endsection

@section('header')
@include('web.layouts._custom_header',['title'=>__('site.cart')])
@endsection

@section('content')

    <link href="https://goSellJSLib.b-cdn.net/v1.4.1/css/gosell.css" rel="stylesheet" />
    <script type="text/javascript" src="https://goSellJSLib.b-cdn.net/v1.4.1/js/gosell.js"></script>


<div id="content" class="cart-products">
    <div class="container">
        @if(count_shopping_cart_items() > 0)
                <div class="row">
            <div class="col-sm-8">
                <h3 class="heading-title">@lang('site.order_menu')</h3>
            <div class="product-boxs">
                <script>
                    var cart_data = [];
                </script>
                @foreach ($data['carts'] as $item)
                    <div class="product-box">
                        <div class="product-image">
                            <img src="{{$item['product']['image_path']}}" />
                        </div>
                        <div class="product-content">
                            <div class="name">{{$item['product']['name']}} ({{$item['quantity'] }})</div>
                            <div class="caption">
                                @foreach ((object)$item['cart_data'] as $data)
                                <p>
                                    {{ $data['key'] .' : '. $data['value']  }}
                                </p>
                                @endforeach
                                @if (isset($item['special_sizes']) && $item['special_sizes'] != false)
                                    <p>مقاسات خاصه</p>
                                @endif
                            </div>
                        </div>
                        <div class="price">
                            <p>{{ number_format( $item['price'])}}</p>
                            <b>{{auth('client')->user()->district->city->currency }}</b>
                        </div>
                        <form method="POST" action="{{route('web.delete_from_cart',$item['id'])}}">
                            @method('DELETE')
                            @csrf
                            <button class="delete-button delete" data-product="95"><i class="fa fa-close"></i></button>
                        </form>
                    </div>
                    <script>
                        cart_data.push({
                          id: "{{$item['product']['id']}}",
                          name: "{{$item['product']['name']}}",
                          description: '',
                          quantity: "{{$item['quantity'] }}",
                          amount_per_unit: "{{ $item['price'] }}",
                          });
                    </script>
                @endforeach
            </div>
        </div>

        <div class="col-sm-4">
            <div class="checkout-product">
                <form id="checkout_form" action="{{route('web.checkout')}}" method="POST">

                @csrf
                @include('partials._errors')

                    <div class="option-table">
                        <div class="option-head">@lang('site.write_notes') <img src="{{asset('web/images/004-sticky-notes.png')}}" /></div>
                            <div class="option-content">
                                <textarea name="notes" rows="10" id="input-enquiry" class="form-control"></textarea>
                            </div>
                    </div>

                    <div class="delivery-site">
                        <div class="delivery-content">
                            <img src="{{asset('web/images/4245.png')}}" />
                            <div class="content">
                                <p class="name">@lang('site.delivery_site')</p>
                                <input type="hidden" name="location" value="30.019651308053827,31.255714780351674">
                                <button class="link-change" type="button" onclick="myFunction()">@lang('site.edit')</button>
                                <div class="map">
                                    <div class="form-group">
                                        <label>@lang('site.address')</label>
                                        <input type="text" id="pac-input" class="form-control" placeholder="" name="address" value="{{ old('address') }}" >
                                        <input type="hidden" id="latitude" name="lat" class="form-control" value="{{ old('lat') }}" required>
                                        <input type="hidden" id="longitude" name="lng" class="form-control" value="{{ old('lng') }}" required>
                                    </div>
                                </div>

                            </div>
                        </div>
                                    <div class="form-group">
                                        <div id="map" style="height: 300px;width: 100%;"></div>
                                    </div>
                    </div>

                    <div class="total-cost">
                        <div class="content">
                            <div class="total-line">
                                <div class="total-text"> @lang('site.order_total')</div>
                                <div class="total-price">{{ number_format($total_carts_price) }} {{ auth('client')->user()->district->city->currency }}</div>
                            </div>
                            <div class="total-line">
                                <div class="total-text">@lang('site.delivery_cost')</div>
                                <div class="total-price">{{number_format($delivery_cost)}} {{ auth('client')->user()->district->city->currency }}</div>
                            </div>
                            <div class="total-line">
                                <div class="total-text">@lang('site.tax')</div>
                                <div class="total-price">{{ number_format($tax) }} {{ auth('client')->user()->district->city->currency }}</div>
                            </div>
                            <div class="total-line total-footer">
                                <div class="total-text">@lang('site.total_pay')</div>
                                <div class="total-price">{{number_format( $total_price_after_adding_tax_and_delivery_cost) }} {{ auth('client')->user()->district->city->currency }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="coupons">
                        <div class="coupon-head">
                            <h4>@lang('site.coupon')</h4>
                            <span class="add-coupon">@lang('site.add_coupon') <i class="fa fa-plus"></i></span>
                        </div>
                        <div class="coupon-content">
                            <div class="coupon-form">
                                <input type="text" id="coupon" name="coupon" value="" placeholder="@lang('site.add_coupon')" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="banks-boxs">
                        {{-- <div class="bank-box">
                            <div class="radio-input">
                                <input type="radio" id="cash-on-delivery" name="payment_method" value="3" checked="">
                                <label for="cash-on-delivery">
                                    <div>
                                    <img class="payment-image" src="{{asset('web/images/cash-on-delivery.png')}}">
                                    </div>
                                    <div>@lang('site.cash')</div>
                                </label>
                            </div>
                        </div> --}}
                        <div class="bank-box">
                            <div class="radio-input">
                                <input type="radio" id="credit-card" name="payment_method" value="2" checked>
                                <label for="credit-card">
                                    <div>
                                    <img class="payment-image" src="{{asset('web/images/credit-card.png')}}">
                                    </div>
                                    <div>@lang('site.credit_card')</div>
                                </label>
                            </div>
                        </div>

                    <!--    <div class="bank-box">-->
                    <!--          <div class="radio-input">-->
                    <!--            <input type="radio" id="bank" name="payment_method" value="1">-->
                    <!--            <label for="bank">-->
                    <!--                <div>-->
                    <!--                <img class="payment-image" src="{{asset('web/images/bank.png')}}">-->
                    <!--                </div>-->
                    <!--                <div>@lang('site.bank_transfer')</div>-->
                    <!--            </label>-->
                    <!--        </div>-->
                    <!--    </div> -->
                    <!--</div>-->
                    <!--<div class="product-boxs" id="banks">-->
                    <!--    @foreach ($banks as $bank)-->
                    <!--    <div class="product-box">-->
                    <!--        <div class="product-image">-->
                    <!--        <img src="{{$bank->image_path}}" />-->
                    <!--        </div>-->
                    <!--        <div class="product-content">-->
                    <!--            <div class="name">{{ $bank->bank_name }}</div>-->
                    <!--            <div class="caption">-->
                    <!--                <p>الاسم : {{$bank->name}}</p>-->
                    <!--                <p>رقم الحساب : {{$bank->account}}</p>-->
                    <!--                <p>ابيان : {{$bank->iban}}</p>-->

                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>                            -->
                    <!--    @endforeach-->

                    <!--</div>-->

                </div>
                    <div class="footer-button">
                        <button type="submit" class="btn btn-block btn-yellow">@lang('site.confirm_order')</button>
                    </div>
                </form>
                    <!--<div id="root"></div>-->
                    <!--<div class="footer-button" >-->
                    <!--    <button  id="openPage" onclick="process_order()" class="btn btn-block btn-yellow">@lang('site.confirm_order')</button>-->
                    <!--</div>-->
            </div>
        </div>
        @else
        <h2>@lang('site.no_data_found')</h2>
        @endif



        
    </div>
</div>
	
</div>
@endsection

@section('scripts')


    <script>
       goSell.showResult({
           callback: response => {
           console.log("callback", response);
         }
      });
    </script>
    <script>

    //console.log(cart_data);
    
    function process_order(){
        goSell.openPaymentPage();
    }

    // $("#checkout_form").submit(function(e){
    //     return false;
    // });

    goSell.config({
      containerID:"root",
      gateway:{
        publicKey:"pk_live_xzYoCTPqn59OHXrI4NjeiAb7",
        merchantId: null,
        language:"ar",
        contactInfo:true,
        supportedCurrencies:"all",
        supportedPaymentMethods: "all",
        saveCardOption:false,
        customerCards: true,
        notifications:'standard',
        callback:(response) => {
            console.log('response', response);
        },
        onClose: () => {
            console.log("onClose Event");
        },
        backgroundImg: {
          opacity: '0.5'
        },
        labels:{
            cardNumber:"Card Number",
            expirationDate:"MM/YY",
            cvv:"CVV",
            cardHolder:"Name on Card",
            actionButton:"Pay"
        },
        style: {
            base: {
              color: '#535353',
              lineHeight: '18px',
              fontFamily: 'sans-serif',
              fontSmoothing: 'antialiased',
              fontSize: '16px',
              '::placeholder': {
                color: 'rgba(0, 0, 0, 0.26)',
                fontSize:'15px'
              }
            },
            invalid: {
              color: 'red',
              iconColor: '#fa755a '
            }
        }
      },
      customer:{
        id:null,
        first_name: "First Name",
        middle_name: "Middle Name",
        last_name: "Last Name",
        email: "demo@email.com",
        phone: {
            country_code: "965",
            number: "99999999"
        }
      },
      order:{
        amount: {{ $total_price_after_adding_tax_and_delivery_cost }},
        currency:"{{ auth('client')->user()->district->city->translate('en')->currency }}",
        items:cart_data,
        shipping:null,
        taxes: null
      },
     transaction:{
       mode: 'charge',
       charge:{
          saveCard: false,
          threeDSecure: true,
          description: "Test Description",
          statement_descriptor: "Sample",
          reference:{
            transaction: "txn_0001",
            order: "ord_0001"
          },
          metadata:{},
          receipt:{
            email: false,
            sms: true
          },
          redirect: "{{ route('web.redirect_after_payment') }}",
          post: null,
        }
     }
    });

    </script>



<script>



    $(document).ready(function(){
        var x = document.getElementById("banks");
        x.style.display = "none";
        $('#bank').change(function(){
            if(this.checked)
                $('#banks').show();
            else
                $('#banks').hide();
        });

        $('#credit-card').change(function(){
            if(this.checked){
                $('#banks').hide();
                $('#submit_button').attr('id', 'openPage');
                

                
                $('#submit_button').attr("onclick","new_function_name()");

            }
        });

        $('#cash-on-delivery').change(function(){
            if(this.checked)
                $('#banks').hide();
        });

    });
</script>

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

<script>
    function goBack() {
      window.history.back();
    }
</script> 

<script type="text/javascript">

    function myFunction() {
                    //console.log('test');
                    var x = document.getElementById("map");
                    if (x.style.display === "none") {
                        x.style.display = "block";
                    } else {
                        x.style.display = "none";
                    }
                } 

    $(document).ready(function() {
        var x = document.getElementById("map");
        x.style.display = "none";

        $('.option-head').on('click', function(e) { 
            $(this).parent().toggleClass('active');            
        }), 
	
        
        $('.coupon-head').on('click', function(e) {           
            $(this).parent().toggleClass('active');            
        });    	
        
        
    });
</script>

<script>
    $("#pac-input").focusin(function() {
        $(this).val('');
    });
    $('#latitude').val('');
    $('#longitude').val('');
    // This example adds a search box to a map, using the Google Place Autocomplete
    // feature. People can enter geographical searches. The search box will return a
    // pick list containing a mix of places and predicted search terms.
    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
    function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 24.740691, lng: 46.6528521 },
            zoom: 16,
            mapTypeId: 'roadmap'
        });
       
        // move pin and current location
        infoWindow = new google.maps.InfoWindow;
        geocoder = new google.maps.Geocoder();
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                map.setCenter(pos);
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(pos),
                    map: map,
                    title: 'موقعك الحالي'
                });
                markers.push(marker);
                marker.addListener('click', function() {
                    geocodeLatLng(geocoder, map, infoWindow,marker);
                });
                // to get current position address on load
                google.maps.event.trigger(marker, 'click');
            }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            console.log('dsdsdsdsddsd');
            handleLocationError(false, infoWindow, map.getCenter());
        }
        var geocoder = new google.maps.Geocoder();
        var marker;
        google.maps.event.addListener(map, 'click', function(event) {
            SelectedLatLng = event.latLng;
            console.log(SelectedLatLng);
            //added by me

            //map.setZoom(8);
            if(!marker || !marker.setPosition){
                deleteMarkers();

                marker = new google.maps.Marker({
                    position: SelectedLatLng,
                    map: map
                });
                $('#latitude').val(marker.position.lat());
                $('#longitude').val(marker.position.lng());
            }else{
                marker.setPosition(SelectedLatLng);
                $('#latitude').val(marker.position.lat());
                $('#longitude').val(marker.position.lng());
            }

            geocoder.geocode({
                'latLng': event.latLng
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        deleteMarkers();
                        addMarkerRunTime(event.latLng);
                        SelectedLocation = results[0].formatted_address;
                        console.log( results[0].formatted_address);
                        splitLatLng(String(event.latLng));
                        $("#pac-input").val(results[0].formatted_address);
                    }
                }
            });
        });
        function geocodeLatLng(geocoder, map, infowindow,markerCurrent) {
            var latlng = {lat: markerCurrent.position.lat(), lng: markerCurrent.position.lng()};
            /* $('#branch-latLng').val("("+markerCurrent.position.lat() +","+markerCurrent.position.lng()+")");*/
            $('#latitude').val(markerCurrent.position.lat());
            $('#longitude').val(markerCurrent.position.lng());
            geocoder.geocode({'location': latlng}, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        map.setZoom(8);
                        var marker = new google.maps.Marker({
                            position: latlng,
                            map: map
                        });
                        markers.push(marker);
                        infowindow.setContent(results[0].formatted_address);
                        SelectedLocation = results[0].formatted_address;
                        $("#pac-input").val(results[0].formatted_address);
                        infowindow.open(map, marker);
                    } else {
                        window.alert('No results found');
                    }
                } else {
                    window.alert('Geocoder failed due to: ' + status);
                }
            });
            SelectedLatLng =(markerCurrent.position.lat(),markerCurrent.position.lng());
        }
        function addMarkerRunTime(location) {
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
            markers.push(marker);
        }
        function setMapOnAll(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }
        function clearMarkers() {
            setMapOnAll(null);
        }
        function deleteMarkers() {
            clearMarkers();
            markers = [];
        }
        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        //$("#pac-input").val("ابحث عن منطقة  ");
        $("#pac-input").attr('placeholder', 'ابحث عن منطقة ');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
        });
        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();
            if (places.length == 0) {
                return;
            }
            // Clear out the old markers.
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];
            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                var icon = {
                    url: place.icon,
                    size: new google.maps.Size(100, 100),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };
                // Create a marker for each place.
                markers.push(new google.maps.Marker({
                    map: map,
                    icon: icon,
                    title: place.name,
                    position: place.geometry.location
                }));
                $('#latitude').val(place.geometry.location.lat());
                $('#longitude').val(place.geometry.location.lng());
                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });
    }
    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }
    function splitLatLng(latLng){
        var newString = latLng.substring(0, latLng.length-1);
        var newString2 = newString.substring(1);
        var trainindIdArray = newString2.split(',');
        var lat = trainindIdArray[0];
        var Lng  = trainindIdArray[1];
        $("#latitude").val(lat);
        $("#longitude").val(Lng);
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjuzA2dGe0KgLeVzjTGh9W6bvixhrjsQs&libraries=places&callback=initAutocomplete&language=ar&region=EG
     async defer"></script> 
     
<script>
    $('#checkout_form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
            e.preventDefault();
            return false;
        }
    });
</script>

@if (session('error'))

    <script>
   // swal("{{ session('error') }}", "", "error");
        // Swal.fire({
        //   icon: 'error',
        //   title: 'Oops...',
        //   text: 'Something went wrong!',
        //   footer: '<a href>Why do I have this issue?</a>'
        // })
        
        swal({
            title: "{{ __('site.error') }} !",
            text: "{{ session('error') }}",
            type: "error",
            confirmButtonText: "Cool"
      });
    </script>

@endif

@endsection