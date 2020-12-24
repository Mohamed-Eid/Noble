<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ auth()->user()->image_path }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>                                    
                    {{ auth()->user()->first_name .' '. auth()->user()->last_name }}
                </p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-th"></i><span>@lang('site.dashboard')</span></a></li>

            @if(auth()->user()->hasPermission('read_users'))
            <li><a href="{{ route('dashboard.users.index') }}"><i class="fa fa-users"></i><span>@lang('site.users')</span></a></li>
            @endif

            @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasPermission('read_roles'))
            <li><a href="{{ route('dashboard.roles.index') }}"><i class="fa fa-lock"></i><span>@lang('site.roles')</span></a></li>
            @endif

            @if(auth()->user()->hasPermission('read_cities'))
            <li><a href="{{ route('dashboard.cities.index') }}"><i class="fa fa-truck"></i><span>@lang('site.cities')</span></a></li>
            @endif

            @if(auth()->user()->hasPermission('read_categories'))
            <li><a href="{{ route('dashboard.categories.index') }}"><i class="fa  fa-cube"></i><span>@lang('site.categories')</span></a></li>
            @endif
            
            @if(auth()->user()->hasPermission('read_products'))
            <li><a href="{{ route('dashboard.products.index') }}"><i class="fa  fa-shopping-cart"></i><span>@lang('site.products')</span></a></li>
            @endif
            

            @if(auth()->user()->hasPermission('read_orders'))
            <li><a href="{{ route('dashboard.orders.index') }}"><i class="fa fa-paypal"></i><span>@lang('site.orders')</span><span class="text-danger"> ({{$orders_waiting}})</span></a></li>
            @endif  
            
            @if(auth()->user()->hasPermission('read_sales'))
            <li><a href="{{ route('dashboard.sales.index') }}"><i class="fa fa-shopping-cart"></i><span>@lang('site.sales')</span></a></li>
            @endif  
      
      
            @if(auth()->user()->hasPermission('read_special_order'))
            <li><a href="{{ route('dashboard.special-orders.index') }}"><i class="fa fa-paypal"></i><span>@lang('site.special_orders')</span></a></li>
            @endif
            
            @if(auth()->user()->hasPermission('read_members'))
            <li><a href="{{ route('dashboard.members.index') }}"><i class="fa fa-child"></i><span>@lang('site.clients')</span></a></li>
            @endif        
            
            @if(auth()->user()->hasPermission('create_notifications'))
            <li><a href="{{ route('dashboard.notifications.index') }}"><i class="fa fa-bell"></i><span>@lang('site.notifications')</span></a></li>
            @endif        

            @if(auth()->user()->hasPermission('read_coupons'))
            <li><a href="{{ route('dashboard.coupons.index') }}"><i class="fa fa-ticket"></i><span>@lang('site.coupons')</span></a></li>
            @endif 
    
            @if(auth()->user()->hasPermission('read_tax'))
            <li><a href="{{ route('dashboard.tax') }}"><i class="fa fa-money"></i><span>@lang('site.tax')</span></a></li>
            @endif 

    
            @if(auth()->user()->hasPermission('read_banks'))
            <li><a href="{{ route('dashboard.banks.index') }}"><i class="fa fa-bank"></i><span>@lang('site.banks')</span></a></li>
            @endif        

            @if(auth()->user()->hasPermission('read_currencies'))
            <li><a href="{{ route('dashboard.currencies.index') }}"><i class="fa fa-money"></i><span>@lang('site.currencies')</span></a></li>
            @endif
            
            @if(auth()->user()->hasPermission('read_download_links'))
            <li><a href="{{ route('dashboard.download') }}"><i class="fa fa-download"></i><span>@lang('site.download')</span></a></li>
            @endif
            
            @if(auth()->user()->hasPermission('read_service_number'))
            <li><a href="{{ route('dashboard.service_number') }}"><i class="fa fa-phone-square"></i><span>@lang('site.service_number')</span></a></li>
            @endif
            
            @if(auth()->user()->hasPermission('update_terms'))
            <li><a href="{{ route('dashboard.terms') }}"><i class="fa  fa-bars"></i><span>@lang('site.terms')</span></a></li>
            @endif 
            
            @if(auth()->user()->hasPermission('update_about_us'))
            <li><a href="{{ route('dashboard.abouts') }}"><i class="fa fa-registered"></i><span>@lang('site.about_us')</span></a></li>
            @endif 
        </ul>

    </section>

</aside>

