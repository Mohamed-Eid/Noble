<div class="option-table">
    <div class="option-head">@lang('site.comments') <i class="fa fa-angle-down"></i></div>
    <div class="option-content">
        @foreach ($product->rates as $rate)
        <div class="ratting-box">
            <div class="box-image">
                <img src="{{asset('web/images/user.png')}}"/>
            </div>
            <div class="box-content">
                <h3>#{{ $rate->id }}</h3>
                <p>{{$rate->text}}</p>
                <div class="ratting-stars">
                    @for ($i = 0; $i < $rate->rate; $i++)
                        <i class="fa fa-star"></i>
                    @endfor
                    @for ($i = 0; $i < 5-$rate->rate; $i++)
                        <i class="fa fa-star-o"></i>
                    @endfor
                </div>
            </div>
        </div>            
        @endforeach

    </div>
</div>