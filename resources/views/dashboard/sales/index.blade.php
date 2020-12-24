@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.sales')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active"></i> @lang('site.sales')</li>

            </ol>
        </section>

        <section class="content">

            <div class="row">

                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.sales')
                                {{-- <small>{{ $orders->total() }}</small> --}}
                            </h3>
                            <form action="{{ route('dashboard.sales.index') }}" method="get">
                                <div class="row">
        
                                    
                                    <div class="col-md-6">
                                        <select name="city_id" class="form-control">
                                            @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ $city->id == request()->city_id ? 'selected' : '' }}>{{$city->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary"><i
                                                    class="fa fa-search"></i>@lang('site.search')</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="box-body">
                            @if($orders->count() > 0)
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>@lang('site.address')</th>
                                        <th>@lang('site.status')</th>
                                        <th>@lang('site.mobile')</th>
                                        <th>@lang('site.action')</th>
                                    </tr>
                                    </thead>
        
                                    <tbody>
                                    @foreach($orders as $index => $order)
                                        <tr>
                                            <td>{{ $index +1 }}</td>
                                            <td>{{ $order->client->address }}</td>
                                            <td>{{ $order->status }}</td>
                                            <td>{{ $order->client->mobile }}</td>
        
                                            <td>
                                            <!--<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-default-{{$order->id}}">-->
                                            <!--    @lang('site.view_order')                                              -->
                                            <!--    </button> -->
                                            <a href="{{ route('dashboard.orders.show' , $order->id) }}" class="btn btn-warning btn-sm">@lang('site.view_order')</a>

                                            </td>
                                            <div class="modal fade" id="modal-default-{{$order->id}}">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                      <h4 class="modal-title">{{ $order->created_at->diffForHumans() }}</h4>
                                                    </div>
                                                    <div class="modal-body">


                                                    </div>
                                                    <div class="modal-footer">
                                                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                    </div>
                                                  </div>
                                                  <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                              </div>
                                        </tr>
                                    @endforeach
                                    </tbody>
        
                                </table>
                            @else
                                <h2>@lang('site.no_data_found')</h2>
                            @endif
        
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                        <div class="small-box bg-orange">
                            <div class="inner">
                                <h3>{{ number_format((int)$total) }}<span style="font-size: small;">{{$currency}}</span></h3>
    
                                <p>@lang('site.sales')</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>

                        </div>


                        <div class="small-box bg-green ">
                            <div class="inner">
                            <h3>{{ number_format( (int)$profit) }}<span style="font-size: small;">{{$currency}}</span></h3>
    
                                <p>@lang('site.profits')</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                </div>

            </div>



        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
