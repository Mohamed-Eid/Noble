<div class="product-boxs">
    @foreach ($products as $product)
    <a href="{{route('web.get_product',$product)}}" class="product-box">
        <div class="product-image">
        <img src="{{$product->image_path}}" />
        </div>
        <div class="product-content">
            <div class="name">
                {{$product->name}}
            </div>
            <div class="caption">
                <p>{{ $product->description }}</p>
                <div class="caption-footer">
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
            <del><p>{{ number_format( converted_currency($product->lowest_price())) }}</p></del>
            @else
            <p class="price-data">{{number_format(converted_currency($product->lowest_price())) }}</p>
            @endif

            @if ($product->discount != 0)
            <p class="price-after-discount">{{ number_format( discount(converted_currency($product->lowest_price()),$product->discount) ) }}</p>
            @endif

            <b>{{auth('client')->user()->district->city->currency ?? default_currency()}}</b>
        </div>
    </a>  
    @endforeach      

</div>
{{$products->appends(request()->query())->links()}}
