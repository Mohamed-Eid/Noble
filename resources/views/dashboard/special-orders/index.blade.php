@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.special_orders')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active"></i> @lang('site.special_orders')</li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.special_orders')
                        {{-- <small>{{ $orders->total() }}</small> --}}
                    </h3>
                </div>
                <div class="box-body">

                    @if($orders->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>@lang('site.mobile')</th>
                                <th>@lang('site.address')</th>
                                <th>@lang('site.notes')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($orders as $index => $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->client->mobile }}</td>
                                    <td>{{ $order->client->address }}</td>
                                    <td>{{ $order->description }}</td>
                                    <td>
                                    <a href="{{ route('dashboard.special-orders.show' , $order->id) }}" class="btn btn-warning btn-sm">@lang('site.view_order')</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                        {{ $orders->appends(request()->query())->links() }}
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
