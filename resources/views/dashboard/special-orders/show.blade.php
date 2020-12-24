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
                <div class="box-body">


                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>@lang('site.index')</th>
                            <th>@lang('site.value')</th>
                        </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <th>@lang('site.mobile')</th>
                                <td>{{ $order->client->mobile }}</td>
                            </tr>
                            <tr>
                                <th>@lang('site.notes')</th>
                                <td>{{ $order->description }}</td>
                            </tr>
                            <tr>
                                <th>@lang('site.created_at')</th>
                                <td>{{ $order->created_at->diffForHumans() }}</td>
                            </tr>
     
                            <tr>
                                <th>@lang('site.files')</th>
                                <td>
                                    @foreach($order->files_path as $file)
                                    <a href="{{$file}}" target="_blank">@lang('site.show')</a>
                                    @endforeach
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
