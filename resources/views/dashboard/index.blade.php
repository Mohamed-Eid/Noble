@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.dashboard')
            </h1>

            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</li>
            </ol>
        </section>

        <section class="content">

            
            <div class="row">

                {{--cities--}}
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $cities_count }}</h3>

                            <p>@lang('site.cities')</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-truck"></i>
                        </div>
                        @if(auth()->user()->hasPermission('read_cities'))
                        <a href="{{ route('dashboard.cities.index') }}" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>
                        @endif
                    </div>
                </div>


                {{--products--}}
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{ $products_count }}</h3>

                            <p>@lang('site.products')</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        @if(auth()->user()->hasPermission('read_products'))
                        <a href="{{ route('dashboard.products.index') }}" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>
                        @endif
                    </div>
                </div>

                
                {{--orders--}}
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-orange ">
                        <div class="inner">
                            <h3>{{ $orders_count }}</h3>

                            <p>@lang('site.orders')</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        @if(auth()->user()->hasPermission('read_orders'))
                        <a href="{{ route('dashboard.orders.index') }}" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>
                        @endif
                    </div>
                </div>

                {{--users--}}
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-olive">
                        <div class="inner">
                            <h3>{{ $users_count }}</h3>

                            <p>@lang('site.users')</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        @if(auth()->user()->hasPermission('read_users'))
                        <a href="{{ route('dashboard.users.index') }}" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>
                        @endif
                    </div>
                </div>

            </div><!-- end of row -->
            
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">@lang('site.active_users') ({{count($active_users)}})</h3>
            </div>
            <!-- /.box-header -->
            @if(count($active_users) > 0 )
            <div class="box-body no-padding">
              <table class="table table-striped">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>ip</th>
                  <th>@lang('site.city')</th>
                  <th>@lang('site.district')</th>
                  <th>lat,lang</th>
                </tr>
                @foreach($active_users as $index=>$user)
                <tr>
                  <td>{{ $index+1 }}</td>
                  <td>{{ $user['ip'] }}</td>
                  <td><img src="{{ $user['flag'] ?? '' }}" /> {{ $user['country'] }}</td>
                  <td>{{ $user['city'] }}</td>
                  <td><a href="https://www.google.com/maps/{{'@'. $user['location'] }}" target="_blank"> Go To Map </a></a></td>
                </tr>
                @endforeach
              </table>
            </div>
            @endif
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
