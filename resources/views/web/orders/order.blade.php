@extends('web.layouts.app')

@section('body_class')
category
@endsection

@section('header')
@include('web.layouts._custom_header',['title'=>__('site.order')])
@endsection

@section('content')
<div id="content" class="cart-products">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <h3 class="heading-title">@lang('site.order_menu')</h3>
            <div class="product-boxs">
                @php
                @endphp
                @foreach ($order['carts'] as $item)
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
                            </div>
                        </div>
                        <div class="price">
							<a class="ratting" data-toggle="modal" data-target="#RateOrderId1"><i class="fa fa-star"></i></a>
                            <p>{{$item['price']}}</p>
                            <b>{{$item['product']['currency']}}</b>
                        </div>
                        <form method="post" action="{{ route('web.rate_product',[$item['product']['id'],$order]) }}">
                            @csrf
						<div class="modal fade" id="RateOrderId1" tabindex="-1" role="dialog" aria-labelledby="RateOrderId1Label" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="RateOrderId1Label">تقييم المنتج</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body">
								  <div class="ratting">
								      
                            <input type="radio" id="star5" name="rate" value="5" />
                            <label for="star5" title="text"><i class="fa fa-star"></i></label>
                            <input type="radio" id="star4" name="rate" value="4" />
                            <label for="star4" title="text"><i class="fa fa-star"></i></label>
                            <input type="radio" id="star3" name="rate" value="3" />
                            <label for="star3" title="text"><i class="fa fa-star"></i></label>
                            <input type="radio" id="star2" name="rate" value="2" />
                            <label for="star2" title="text"><i class="fa fa-star"></i></label>
                            <input type="radio" id="star1" name="rate" value="1" />
                            <label for="star1" title="text"><i class="fa fa-star"></i></label>
								  </div>
								  <div class="comment">
									<label for="comment">اكتب تعليق</label>
									<textarea name="text" class="form-control" id="comment" rows="3"></textarea>
								  </div>
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
								<button type="submit" class="btn btn-yellow">إرسال التقييم</button>
							  </div>
							</div>
						  </div>
						</div>						

                        </form>
                    </div>
                    
                @endforeach
            </div>

        </div>
        <div class="col-sm-4">
            <div class="checkout-product">
                    <div class="option-table active">
                        <div class="option-head">@lang('site.write_notes') <img src="{{asset('web/images/004-sticky-notes.png')}}" /></div>
                            <div class="option-content">
                                <textarea name="notes" rows="10" id="input-enquiry" class="form-control" disabled>
                                  {{ $order->notes }}
                                </textarea>
                            </div>
                    </div>

                    <div class="delivery-site">
                        <div class="delivery-content">
                            <img src="{{asset('web/images/4245.png')}}" />
                            <div class="content">
                                <p class="name">@lang('site.delivery_site')</p>
                                <input type="hidden" name="location" value="{{ $order->location }}">
                                {{-- <p>شارع عبد العزيز الملك عبدالله</p> --}}
                                <div class="map">
                                    <div class="form-group">
                                        <input type="hidden" id="pac-input" class="form-control" placeholder="" name="address" value="{{ old('address') }}">
                                        <input type="hidden" id="latitude" name="lat" class="form-control" value="{{ old('lat') }}" >
                                        <input type="hidden" id="longitude" name="lng" class="form-control" value="{{ old('lng') }}" >
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
                                <div class="total-text">@lang('site.order_total')</div>
                                <div class="total-price">{{ $order['total_price'] - ($delivery_cost + calc_tax_on_price($order['total_price'])) }} {{auth('client')->user()->district->city->currency ?? default_currency()}}</div>
                            </div>
                            <div class="total-line">
                                <div class="total-text">@lang('site.delivery_cost')</div>
                                <div class="total-price">{{$delivery_cost}} {{auth('client')->user()->district->city->currency ?? default_currency()}}</div>
                            </div>
                            <div class="total-line">
                                <div class="total-text">@lang('site.tax')</div>
                                <div class="total-price">{{ calc_tax_on_price($order['total_price']) }} {{auth('client')->user()->district->city->currency ?? default_currency()}}</div>
                            </div>
                            <div class="total-line total-footer">
                                <div class="total-text">@lang('site.total_pay')</div>
                                <div class="total-price">{{ $order['total_price'] }} {{auth('client')->user()->district->city->currency ?? default_currency()}}</div>
                            </div>
                        </div>
                    </div>

                    <div class="banks-boxs">
                        <div class="bank-box">
                            <div class="radio-input">
                                <input type="radio" id="cash-on-delivery" name="payment_method" value="3" {{ $order->payment_method_id == '3' ? 'checked' : '' }} disabled >
                                <label for="cash-on-delivery">
                                    <div>
                                    <img class="payment-image" src="{{asset('web/images/cash-on-delivery.png')}}">
                                    </div>
                                    <div>@lang('site.cash')</div>
                                </label>
                            </div>
                        </div>
                        <div class="bank-box">
                            <div class="radio-input">
                                <input type="radio" id="credit-card" name="payment_method" value="2" {{ $order->payment_method_id == '2' ? 'checked' : '' }} disabled>
                                <label for="credit-card">
                                    <div>
                                    <img class="payment-image" src="{{asset('web/images/credit-card.png')}}">
                                    </div>
                                    <div>@lang('site.credit_card')</div>
                                </label>
                            </div>
                        </div>
                        <div class="bank-box">
                            <div class="radio-input">
                                <input type="radio" id="bank" name="payment_method" value="1" {{ $order->payment_method_id == '1' ? 'checked' : '' }} disabled>
                                <label for="bank">
                                    <div>
                                    <img class="payment-image" src="{{asset('web/images/bank.png')}}">
                                    </div>
                                    <div>@lang('site.bank_transfer')</div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
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


    $(document).ready(function() {
var body = document.body;

body.classList.add("my-order-page");

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
  // This example adds a search box to a map, using the Google Place Autocomplete
  // feature. People can enter geographical searches. The search box will return a
  // pick list containing a mix of places and predicted search terms.
  // This example requires the Places library. Include the libraries=places
  // parameter when you first load the API. For example:
  // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
  function initAutocomplete() {
      var pos = {lat:  {{ $lat }} ,  lng: {{ $lng }} };
      map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: pos
      });
      infoWindow = new google.maps.InfoWindow;
      geocoder = new google.maps.Geocoder();
      marker = new google.maps.Marker({
          position: pos,
          map: map,
          title: '{{ $order->name }}'
      });
      infoWindow.setContent('{{ $order->name }}');
      infoWindow.open(map, marker);
      // move pin and current location
      infoWindow = new google.maps.InfoWindow;
      geocoder = new google.maps.Geocoder();
      var geocoder = new google.maps.Geocoder();
      google.maps.event.addListener(map, 'click', function(event) {
          SelectedLatLng = event.latLng;
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
      $("#pac-input").val("{{ $order->location }}");
      var searchBox = new google.maps.places.SearchBox(input);
      //map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);
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
@endsection