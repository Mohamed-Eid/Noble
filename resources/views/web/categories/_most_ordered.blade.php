<div class="categores">
    <h3 class="heading-title">@lang('site.most_ordered_products')</h3>
    <div class="row">
        @foreach ($most_ordered_products as $product)
        <div class="col-xs-6">
            <a class="category-link" href="{{ route('web.get_product',$product) }}"><img src="{{$product->image_path}}" class="img-responsive" /></a>
        </div>
        @endforeach
    </div>
</div>
