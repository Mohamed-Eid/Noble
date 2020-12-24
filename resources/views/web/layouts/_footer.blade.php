<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 hidden-xs">
                <div class="links">
                    <h5>@lang('site.info')</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('web.about_us') }}">@lang('site.about_us')</a></li>
                        {{-- <li><a href="#">الخصوصية</a></li> --}}
                        <li><a href="{{ route('web.terms') }}">@lang('site.terms')</a></li>
                        </ul>
                </div>
            </div>
            <div class="col-md-4 hidden-xs">
                <div class="social">
                    <h5>@lang('site.follow_us_on')</h5>
                    <div class="clearfix"></div>
                    <a href="#" class="link-facebook"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="link-twitter"><i class="fa fa-twitter"></i></a>
                    <a href="#" class="link-google-plus"><i class="fa fa-google-plus"></i></a>
                    <a href="#" class="link-youtube"><i class="fa fa-youtube"></i></a>
                    <a href="#" class="link-instagram"><i class="fa fa-instagram"></i></a>
                    <a href="#" class="link-rss"><i class="fa fa-rss"></i></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="apps">
                    <h5>@lang('site.donwload_app_now')</h5>
                <a href="{{ get_download_links()->app_store_link }}"><img src="{{asset('web/images/appstore.png')}}" class="img-responsive" /></a>
                    <a href="{{ get_download_links()->play_store_link }}"><img src="{{asset('web/images/googleplay.png')}}" class="img-responsive" /></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer-icons">
    <div class="link-icon">
        <a href="{{ route('web.index') }}">
            <img src="{{asset('web/images/home.png')}}" />
            <p>@lang('site.home')</p>
        </a>
    </div>
    <div class="link-icon">
        <a href="{{ route('web.my_orders') }}">
            <img src="{{asset('web/images/furniture.png')}}" />
            <p>@lang('site.my_orders')</p>
        </a>
    </div>
    <div class="link-icon">
        <a href="{{ route('web.notifications') }}">
            <img src="{{asset('web/images/004-megaphone.png')}}" />
            <p>@lang('site.notifications')</p>
        </a>
    </div>
    <div class="link-icon">
        <a class="link-icon-menu">
            <img src="{{asset('web/images/user.png')}}" />
            <p>@lang('site.profile')</p>
        </a>
    </div>
    <div class="link-icon">
        <a href="{{ route('web.special_order') }}">
            <img src="{{asset('web/images/color-palette.png')}}" />
            <p>@lang('site.special_order')</p>
        </a>
    </div>
</div>
    <a href="https://wa.me/966564295448" class="fa fa-whatsapp go-to-whatsapp"></a>
