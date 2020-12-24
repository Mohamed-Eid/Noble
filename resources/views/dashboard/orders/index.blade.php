@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.orders')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active"></i> @lang('site.orders')</li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.orders')
                        {{-- <small>{{ $orders->total() }}</small> --}}
                    </h3>
                    <form action="{{ route('dashboard.orders.index') }}" method="get">
                        <div class="row">

                            <div class="col-md-2">
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}"
                                       placeholder="@lang('site.search')">
                            </div>
                            
                            <div class="col-md-2">
                                <select name="city_id" class="form-control cities">
                                    <option value="">@lang('site.all_cities')</option>
                                    @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ $city->id === request()->city_id ? 'selected' : '' }}>{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select name="district_id" class="form-control districts">
                                    <option value="">@lang('site.plz_choose_city')</option>
                                </select>
                            </div>
                            <script>
                                $( ".cities" ).change(function() {
                                    // $.get('https://90days-home.com/demo/public/ar/api/cities/'+this.value,function(one,two,three){
                                    //     console.log(one);
                                    //     console.log(two);
                                    //     console.log(three);
                                    // })
                                    $.ajax({
                                        type : 'GET',
                                        url : 'https://90days-home.com/demo/public/'+'{{ app()->getLocale() }}'+'/api/cities/'+this.value,  
                                        dataType: 'json',
                                        success: function (data) {
                                            console.log(data.data);
                                            List = data.data;
                                            $('.districts').empty();
                                            $('.districts').append("<option value=''>{{ __('site.districts') }}</option>");
                                            for (i in List ) {
                                                $('.districts').append('<option value="' + List[i].id + '">' + List[i].name + '</option>');
                                            }
                                        }
                                    });
                                
                                });

                        </script>


                            <div class="col-md-2">
                                <select name="status" class="form-control">
                                    <option value="">@lang('site.all_status')</option>
                                    @foreach($status as $key=>$val)
                                    <option value="{{ $key }}" {{ $key === request()->status ? 'selected' : '' }}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                        <div class="form-group">
                            <label >@lang('site.tafsil')</label>
                            <input type="checkbox" name="tafsil" >
                        </div>
                            
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-search"></i>@lang('site.search')</button>
                                @if(auth()->user()->hasPermission('create_orders'))
                                    <a href="{{ route('dashboard.orders.create') }}" class="btn btn-primary"><i
                                                class="fa fa-plus"></i>@lang('site.add')</a>
                                @else
                                    <a class="btn btn-info" href="#" disabled>@lang('site.add')</a>
                                @endif
                                
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
                                <th>@lang('site.status')</th>
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
                                    <td>{{ $order->status }}</td>
                                    <td>{{ $order->client->mobile }}</td>
                                    <td>{{ $order->client->address }}</td>
                                    <td>{{ $order->notes }}</td>
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

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
