@extends('web.layouts.app')

@section('header')
@include('web.layouts._nav')
@endsection

@section('content')

<div class="container-carousel">
    <h3 class="heading-title">@lang('site.latest_products')</h3>
    <div id="carousel-top" class="owl-carousel" style="opacity: 1;">
        @foreach ($products as $product)
        <div class="item text-center">
            <a class="category-link" href="{{ route('web.get_product',$product) }}">
            <img src="{{$product->image_path}}" height="20" class="img-responsive" />
            </a>
        </div>
        @endforeach     
    </div>
</div>
<script>
$('#carousel-top').owlCarousel({
    items: 4,   
    itemsDesktop : [1199,4],
    itemsDesktopSmall : [980,4],
    itemsTablet: [768,3],
    itemsTabletSmall: false,
    itemsMobile : [479,3],
    autoPlay: 3000,
    navigation: true,
    navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
    pagination: true
});
</script>

<div class="categores">
    <h3 class="heading-title">@lang('site.categories')</h3>
    <div class="row">

        @foreach ($categories as $category)
        <div class="col-md-3 col-sm-4 col-xs-6">
        <a class="category-link" href="{{ route('web.get_products_by_category',$category) }}"><img src="{{$category->image_path}}" class="img-responsive" /></a>
        </div>           
        @endforeach
    
    </div>
</div>

@endsection
