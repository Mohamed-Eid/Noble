@extends('layouts.dashboard.app')
 
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.members')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.members.index')}}">@lang('site.members')</a></li>
                <li class="active"></i> @lang('site.read')</li>
            </ol>
        </section>

        <section class="content">
            
            <div class="row">
                <div class="box box-primary">

                <div class="box-body">


                    <table class="table table-bordered">

                        <tbody>
                            <tr>
                                <th>@lang('site.mobile')</th>
                                <td>{{ $client->mobile }}</td>
                            </tr>

                            <tr>
                                <th>@lang('site.status')</th>
                                <td>{{ $client->active }}</td>
                            </tr>

                            <tr>
                                <th>@lang('site.address')</th>
                                <td>{{ $client->address }}</td>
                            </tr>
                            
                            <tr>
                                <th>@lang('site.street')</th>
                                <td>{{ $client->street }}</td>
                            </tr>
                            
                            <tr>
                                <th>@lang('site.orders_count')</th>
                                <td>{{ $orders->total() }}</td>
                            </tr>
                            
                            <tr>
                                <th>@lang('site.joined_date')</th>
                                <td>{{ $client->created_at->diffForHumans() }}</td>
                            </tr>
     
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
            
            <div class="row">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title" style="margin-bottom: 10px;">
                            @lang('site.orders')
                        </h3>
                    </div>
                    <div class="box-body">

                    @if($orders->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>@lang('site.status')</th>
                                <th>@lang('site.notes')</th>
                                <th>@lang('site.created_at')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($orders as $index => $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ $order->notes }}</td>
                                    <td>{{ $order->created_at->diffForHumans() }}</td>

                                    <td>
                                    <a href="{{ route('dashboard.orders.show' , $order->id) }}" class="btn btn-warning btn-sm">@lang('site.view_order')</a>


                                    @if(auth()->user()->hasPermission('delete_orders'))
                                    <form method="post"
                                                  action="{{route('dashboard.orders.destroy' , $order->id)}}"
                                                  style="display: inline-block">
                                                @csrf()
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm delete"><i
                                                            class="fa fa-trash"></i>@lang('site.delete')</button>
                                    </form>
                                    @else
                                    <button type="submit" class="btn btn-danger btn-sm" disabled><i
                                                class="fa fa-trash"></i>@lang('site.delete')</button>
                                    @endif

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
                {{--users--}}
                {{-- <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>@lang('site.name')</th>
                            <th>@lang('site.user')</th>
                            <th>@lang('site.city')</th>
                            <th>@lang('site.available_for')</th>
                            <th>@lang('site.cost')</th>
                            <th>@lang('site.offer')</th>
                            <th>@lang('site.action')</th>

                        </tr>
                        </thead>

                        <tbody>
                        @foreach($halls as $index => $hall)
                            <tr>
                                <td>{{ $index +1 }}</td>
                                <td>{{ $hall->name }}</td>
                                <td>{{ $hall->user->first_name .' '.$hall->user->last_name}}</td>
                                <td>{{ $hall->city->name }}</td>
                                <td>{{ $hall->available_for->name }}</td>
                                <td>{{ $hall->cost }}</td>
                                <td>{{ $hall->offer .' %' }}</td>
                                <td>
                                    @if(auth()->user()->hasPermission('read_halls'))
                                        <a class="btn btn-warning btn-sm"
                                            href="{{route('dashboard.halls.show' , $hall->id)}}"></i>@lang('site.read')</a>
                                    @else
                                        <a class="btn btn-warning btn-sm" href="#" disabled>>@lang('site.read')</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div> --}}

            </div><!-- end of row -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
