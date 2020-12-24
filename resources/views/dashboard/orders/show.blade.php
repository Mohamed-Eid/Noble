@extends('layouts.dashboard.app')
 
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.orders')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.orders.index')}}">@lang('site.orders')</a></li>
                <li class="active"></i> @lang('site.update')</li>
            </ol>
        </section>

        <section class="content">
            

            <div class="box box-primary">
                <div class="box-header with-border">

                    <div class="row"> 
                        <div class="col-md-6">
                            <h3 class="box-title" style="margin-bottom: 10px;">{{ $order->mobile }}</h3>
                            <button class="btn btn-primary col-12" id="printBtn"><i class="fa fa-print"></i> @lang('site.print')</button>
                            
                            @push('scripts')
                                <script>
                                    $(document).on('click','#printBtn',function(){
                                        $('.product-link').attr("href","");
                                        $('#order-page').printThis({
                                              importCSS: true,
                                              header: "<center><img src='http://90days-home.com/web/images/logo.png' width='200' height='200'></center>"
                                        });
                                    })

                                </script>
                            @endpush
                                      
                        </div>
                        <div class="col-md-4">
                            @include('dashboard.orders.edit' , ['order'=>$order])
                        </div>
                    </div>
                </div>
                <div class="box-body" id="order-page">


                    <table class="table table-bordered ">
                        <thead>
                        <tr>
                            <th>@lang('site.index')</th>
                            <th>@lang('site.value')</th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <th>@lang('site.status')</th>
                                <td>{{ $order->status }}</td>
                            </tr>

                            <tr>
                                <th>@lang('site.mobile')</th>
                                <td>{{ $order->client->mobile }}</td>
                            </tr>
                            <tr>
                                <th>@lang('site.notes')</th>
                                <td>{{ $order->notes }}</td>
                            </tr>
                            <tr>
                                <th>@lang('site.created_at')</th>
                                <td>{{ $order->created_at->diffForHumans() }}</td>
                            </tr>
     
                            <tr>
                                <th>@lang('site.payment_method')</th>
                                <td>{{ $order->payment_method}}</td>
                            </tr>
     
                            <tr>
                                <th>@lang('site.order')</th>
                                <td>
                                    @foreach ($order->carts as $cart)
 
                                    <div class="col-md-4">
                                        <!-- Widget: user widget style 1 -->
                                        <div class="box box-widget widget-user-2">
                                          <div class="box-footer no-padding">
                                            <ul class="nav nav-stacked">
                                                <li><a class="product-link" href="https://90days-home.com/public/ar/dashboard/products?search={{$cart['product']['name']}}" target="_blank">{{$cart['product']['name']}} <span class="pull-right badge bg-blue">x{{$cart['quantity']}}</span></a></li>
                                                <li><a href="#">@lang('site.price') <span class="pull-right badge bg-blue">{{$cart['price']}} <i class="fa fa-fw fa-money"></i> </span></a></li>
                                                @foreach($cart['cart_data'] as $cart_data)
                                                <li><a href="#">{{ $cart_data['key'] }} <span class="pull-right badge pull-right badge bg-green">{{$cart_data['value']}}</span></a></li>     
                                                @endforeach
 
                                                @if(isset($cart['special_sizes']) && $cart['special_sizes']!=false)
                                                <li>
                                                    <div class="p-3 mb-2 bg-info text-white">
                                                    <a href="#">
                                                    @lang('site.tafsil')
                                                </a>
                                                    </div>
                                                </li>     
                                                
                                                <li><a href="#">@lang('site.length') <span class="pull-right badge pull-right badge bg-green">{{$cart['special_sizes_data']['length']}}</span></a></li>     
                                                <li><a href="#">@lang('site.width')<span class="pull-right badge pull-right badge bg-green">{{$cart['special_sizes_data']['width']}}</span></a></li>     
                                                <li><a href="#">@lang('site.height')<span class="pull-right badge pull-right badge bg-green">{{$cart['special_sizes_data']['height']}}</span></a></li>     
                                                <li><a href="#">@lang('site.depth')<span class="pull-right badge pull-right badge bg-green">{{$cart['special_sizes_data']['depth']}}</span></a></li>     
                                                @elseif(isset($cart['size']))
                                                <li><a href="#">@lang('site.length') <span class="pull-right badge pull-right badge bg-green">{{$cart['size']['length']}}</span></a></li>     
                                                <li><a href="#">@lang('site.width')<span class="pull-right badge pull-right badge bg-green">{{$cart['size']['width']}}</span></a></li>     
                                                <li><a href="#">@lang('site.height')<span class="pull-right badge pull-right badge bg-green">{{$cart['size']['height']}}</span></a></li>     
                                                <li><a href="#">@lang('site.depth')<span class="pull-right badge pull-right badge bg-green">{{$cart['size']['depth']}}</span></a></li>     
                                                @endif
                                            </ul>
                                          </div>
                                        </div>
                                        <!-- /.widget-user -->
                                      </div>
                                    @endforeach
                                </td>
                            </tr>

                            
                            <tr>
                                <th>@lang('site.discount')</th>
                                <td>{{ $order->discount }}</td>
                            </tr>
                            
                            <tr>
                                <th>@lang('site.total_price_after_discount')</th>
                                <td>{{ $order->total_price }} {{$order->client->district->city->currency}}</td>
                            </tr>

                            <tr>
                                <th>@lang('site.location')</th>
                                <td>

                                    <iframe 
                                        width="300" 
                                        height="170" 
                                        frameborder="0" 
                                        scrolling="no" 
                                        marginheight="0" 
                                        marginwidth="0" 
                                    src="https://maps.google.com/maps?q={{$order->location.'&hl='.app()->getLocale()}}&z=14&amp;output=embed"></iframe>
                                </td>
                            </tr>
                        </tbody>
                        
                    
                    </table>
                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
