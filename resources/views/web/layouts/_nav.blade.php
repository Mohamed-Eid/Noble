<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-xs-3">
                <ul class="menu">
                    <li><a title="" class="sub-nav-menu"><i class="fa fa-bars"></i></a>
                    </li>
                </ul>
            </div>
            <div class="col-xs-6">
                <div id="logo">
                <a class="logo" href="#"><img src="{{asset('web/images/logo.png')}}" class="img-responsive" /></a>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="cart">
                    @if(auth('client')->user())
                    <a href="{{route('web.cart')}}"><img src="{{asset('web/images/cart.png')}}" class="img-responsive" /><span id="cart-total">{{ count_shopping_cart_items() }}</span></a>
                    @else
                    <a href="#"><img src="{{asset('web/images/cart.png')}}" class="img-responsive" /><span id="cart-total">{{ count_shopping_cart_items() }}</span></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>