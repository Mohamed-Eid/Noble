@extends('web.layouts.app')

@section('body_class')
product
@endsection

@section('title')
{{$product->name}}
@endsection

@section('styles')
<script src="{{asset('web/js/Drift.js')}}" type="text/javascript"></script>
<link href="{{asset('web/css/drift-basic.css')}}" type="text/css" rel="stylesheet" media="screen" />
<script src="{{asset('web/js/magnific-popup.min.js')}}" type="text/javascript"></script>
<link href="{{asset('web/css/magnific-popup.css')}}" type="text/css" rel="stylesheet" media="screen" />


@endsection

@section('header')
@include('web.layouts._custom_header',['title'=>$product->name])
@endsection

@section('content')
	<div id="content" class="products-product">
		<div class="container">
			<div class="row">
                
                <div class="col-sm-6">
                    @include('web.products._thumbnails')
                </div>
                

				<div class="col-sm-6">
					 <div class="description">
						<div class="name">
                            {{ $product->name }} 
                        </div>
                        
                    	<div class="tab-pane tab-description" id="tab-description">
                    	    <div class="tab-description-text">
                    	        <p>{!! nl2br($product->description) !!}</p>
                    	    </div>
                    	    <div class="btns-show-less">
                            	<a id="show-more" class="btn-more-less"><i class="fa fa-angle-double-down"></i></a>
                            	<a id="show-less" class="btn-more-less"><i class="fa fa-angle-double-up"></i></a>
                    	    </div>
                    	</div>                        
                        
						
                    </div> 

                    <div class="product-boxs products-boxs">
                        <div class="product-box">
                            {{-- <div class="product-image">
                            <img src="{{$product->image_path}}" />
                            </div> --}}
                            <div class="product-content">
                                <div class="caption">
                                    <div class="caption-footer">
                                        <div class="product-sku">
                                            رقم الموديل : <span>{{ $product->sku }}</span>
                                        </div>
                                        @if ($product->discount != 0)
                                        <span class="btn-s btn-sale">{{$product->discount}}% @lang('site.discount')</span>
                                        @endif
                                        @if ($product->tafsil == 1)
                                        <span class="btn-s btn-yellow">@lang('site.tafsil')</span>
                                        @endif
                    
                                        @if ($product->rate != 0)
                                        <span class="ratting"><i class="fa fa-star"></i> {{ $product->rate }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="price">

                                @if ($product->discount != 0)
                                <p class="price-after-discount price-new"></p>
                                @endif

                                @if ($product->discount != 0)
                                <p class="price-data price-old"></p>
                                @else
                                <p class="price-data"></p>
                                @endif

                                <b>{{auth('client')->user()->district->city->currency ?? default_currency()}}</b>
                            </div>
                        </div>  
                    
                    </div>

                    <div class="delivery">
                        
                        <h3><img src="{{asset('web/images/delivery.png')}}" class="img-responsive" /> مدة التسليم 90 يوم من وقت الدفع</h3>
                        
                    </div>
                    <div class="options">
                        @include('web.products._form')
					</div>
					<div class="table-ratting">
                        @include('web.products._comments')
					</div>
				</div>
				<div class="col-sm-12">
                    @include('web.products._related_products')
				</div>
			</div>
		</div>
	</div>

@endsection

@section('scripts')
    <script>
    function goBack() {
      window.history.back();
    }
    </script> 
	<script>
		new Drift(document.querySelector('.drift-demo-trigger'), {
			paneContainer: document.querySelector('.detail'),
			inlinePane: 900,
			inlineOffsetY: -85,
			containInline: true,
			hoverBoundingBox: true
		});
	</script>
    
    <script type="text/javascript">
        $(document).ready(function() {
            $('.thumbnailss').magnificPopup({
                type:'image',
                delegate: 'a',
                gallery: {
                    enabled: true
                }
            });
            
            $('.option-head').on('click', function(e) {           
                $(this).parent().toggleClass('active');            
            });    	 
            
    $("#show-more").click(function() {
		$("#tab-description").addClass('loadmore');
	});
	$("#show-less").click(function() {
		$("#tab-description").removeClass('loadmore');
	});
        });
    </script>
    <script type="text/javascript">    
    $('.btn-number').click(function(e){
        e.preventDefault();
        
        fieldName = $(this).attr('data-field');
        type      = $(this).attr('data-type');
        var input = $("input[name='"+fieldName+"']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if(type == 'minus') {
                
                if(currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                } 
                if(parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }
    
            } else if(type == 'plus') {
    
                if(currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if(parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }
    
            }
        } else {
            input.val(0);
        }
        change_price();
    });
    $('.input-number').focusin(function(){
       $(this).data('oldValue', $(this).val());
    });
    $('.input-number').change(function() {
        
        minValue =  parseInt($(this).attr('min'));
        maxValue =  parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());
        
        name = $(this).attr('name');
        if(valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if(valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        
        
    });
    $(".input-number").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                 // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) || 
                 // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                     // let it happen, don't do anything
                     return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    </script>

    <script>
            // $('.price-data').html(123);
            // $('.price-after-discount').html(calc_discount(100,{{$product->discount}}));
            $('.size_check:radio:checked').each(function(){
                    price = $(this).attr('data-value');
                    float_price = parseFloat(price);
                    $('.price-data').html(float_price.toLocaleString());
                   // $('.price-after-discount').html(calc_discount($(this).attr('data-value'),{{$product->discount}}));  
                    calc_discount($(this).attr('data-value')) ;         
            });

            old_price = parseFloat($('.price-data').html());

            $(document).ready(function(){
                $(".size_check").change(function() {
                if(this.checked) {
                    price = $(this).attr('data-value');
                    float_price = parseFloat(price);
                    $('.price-data').html(float_price.toLocaleString());
                    calc_discount($(this).attr('data-value')) ;         
                    old_price = parseFloat($('.price-data').html());
                    get_detail_price();
                }

            });
            });

            get_detail_price();
            $(".detail_check").change(function() {
                get_detail_price()
            });

            function get_detail_price()
            {
                var cost = 0;
                ids.forEach(element => {
                    if($("#"+element).is(':checked'))
                    {
                        cost += parseFloat($("#"+element).attr('data-value'));
                    } 
                    float_price = cost+old_price;
                    $('.price-data').html(float_price.toLocaleString());
                    calc_discount(cost+old_price)
                    //$('.price-after-discount').html(calc_discount($(this).attr('data-value'),{{$product->discount}}));            
                });
            }

            function calc_discount(price){
                discount = {{$product->discount}};
                new_price =  price - price*(discount/100);
                float_price = parseFloat(new_price);
                $('.price-after-discount').html(float_price.toLocaleString());            
            }

    </script>
<script>

    var dim = {
        depth : 0,
        height : 0,
        length : 0,
        width : 0,
    };

    var costs = {
        depth_cost : {{ $product->depth_cost ?? 0 }},
        height_cost : {{ $product->height_cost ?? 0}},
        length_cost : {{ $product->length_cost ?? 0}},
        width_cost : {{ $product->width_cost ?? 0}}
    };

    $('.total-price').html(calc_price());


    if($('#depth').length){
        var depth = document.getElementById('depth');
        depth.addEventListener('keyup',function(){
            dim.depth = depth.value;
            calc_price();
            change_price();
        }); 
    }

    if($('#height').length){
    var height = document.getElementById('height');
    height.addEventListener('keyup',function(){
        dim.height = height.value;
        calc_price();
        change_price();
    }); 
    }

    if($('#length').length){
    var length = document.getElementById('length');
    length.addEventListener('keyup',function(){
        dim.length = length.value;
        calc_price();
        change_price();
    }); 
    }

    if($('#width').length){
    var width = document.getElementById('width');
    width.addEventListener('keyup',function(){
        dim.width = width.value;
        calc_price();
        change_price();
    });    
    }
    function calc_price()
    {
        qty = $('#input-quantity').val();
        total = (dim.depth * costs.depth_cost) 
                + (dim.length * costs.length_cost) 
                + (dim.height * costs.height_cost) 
                + (dim.width * costs.width_cost);
        //console.log(costs);
        //console.log('total : '+total);
        //console.log(dim);
        return (total * qty).toFixed(2);
    }

    function change_price()
    {
        $('.total-price').html(calc_price());
    }
</script>  
<style type="text/css">
#content.products-product #zoom-fig.app-figure > #Zoom-1.MagicZoom > figure.mz-figure > * > a {font-size: 0px !important;}
</style>
<script>

$('.image-additional').delegate('img','click', function(){
	$('#largeImage').attr('src',$(this).attr('src').replace('thumb','large'));
	$('#largeImage').attr("data-zoom",$(this).attr('src'));;
});

</script>
<script>

    $(".image_color").change(function() {
        
        ids.forEach(element => {

            if($("#"+element).is(':checked') && $("#"+element).hasClass("image_color"))
            {
            console.log( $("#"+element).attr('data-image'));
            $(".drift-demo-trigger").attr("data-zoom",$("#"+element).attr('data-image'));


            $(".drift-demo-trigger").attr("src",$("#"+element).attr('data-image'));
            


            } 
        });

    });
</script>

<script>
        $("#first-0").click(function() {
            
            console.log('first_item'); 
            

            $(".base_a").attr("href",$("#first-0").attr('data-image')+"?h=1400");

            $(".base_a").attr("data-zoom-image-2x",$("#first-0").attr('data-image')+"?h=2800");

            $(".base_a").attr("data-image-2x",$("#first-0").attr('data-image')+"?h=800");

            $(".base_img").attr("src",$("#first-0").attr('data-image')+"?h=400");
            
            $(".base_img").attr("srcset",$("#first-0").attr('data-image')+"?h=800 2x");


        
        

            

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

