<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-xs-2">
            <a onclick="goBack()" class="goback"><img src="{{asset('web/images/right-arrow.png')}}" class="img-responsive" /></a>
            </div>
            <div class="col-xs-8">
                <div id="page-title">
                    <h2>{{$title}}</h2>
                </div>
            </div>
            <div class="col-xs-2">
                <div class="cart">
                <a href="{{route('web.cart')}}"><img src="{{asset('web/images/cart.png')}}" class="img-responsive" /><span id="cart-total">{{count_shopping_cart_items()}}</span></a>
                </div>
            </div>
        </div>
    </div>
</div>