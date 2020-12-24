<div class="sub-nav">
    <div class="sub-nav-content">
        <div class="content-menu">
            <ul>
                @if(auth('client')->user())
                <li><a href="{{ route('web.logout') }}"><i class="fa fa-sign-in"></i> @lang('site.logout')</a></li>
                <li><a href="{{ route('web.my_orders') }}"><i class="fa fa-shopping-cart"></i> @lang('site.my_orders')</a></li>
                <li><a href="{{ route('web.notifications') }}"><i class="fa fa-bell"></i> @lang('site.notifications') <span class="num">0</span></a></li>
                @else                  
                <li><a href="{{ route('web.login') }}"><i class="fa fa-user"></i>@lang('site.login')</a></li>
                <li><a href="{{route('web.register')}}"><i class="fa fa-sign-in"></i>@lang('site.register')</a></li>
                @endif
                <li><a href="{{ route('web.special_order') }}"><i class="fa fa-tags"></i>@lang('site.special_order')</a></li>
                <li><a href="{{ route('web.about_us') }}"><i class="fa fa-link"></i>@lang('site.about_us')</a></li>
                <li><a href="{{ route('web.terms') }}"><i class="fa fa-link"></i> @lang('site.terms')</a></li>
            
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                @if (app()->getLocale() != $localeCode)
                <li>
                    <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                    <i class="fa fa-language"></i>
                    {{ $properties['native'] }}
                    </a>
                </li>
                @endif
                @endforeach

            
            </ul>
        </div>
        <div class="maroof">
            <a target="_blank" href="https://maroof.sa/151312"><img src="{{asset('web/images/maroof.png')}}" /></a>
            
        </div>
    </div>
</div>