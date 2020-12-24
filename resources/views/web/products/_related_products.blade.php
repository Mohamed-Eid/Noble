<div class="container-carousel">
    <h3 class="heading-title"> @lang('site.related_products') </h3>
    <div id="related-products" class="owl-carousel" style="opacity: 1;">
        @foreach ($related_products as $product)
        <a class="category-link" href="{{ route('web.get_product',$product) }}">
            <div class="item text-center">
                <img src="{{ $product->image_path }}" class="img-responsive" />
            </div>
        </a>
        @endforeach
      </div>
</div>
<script>
$('#related-products').owlCarousel({
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