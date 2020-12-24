@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.members')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active"></i> @lang('site.members')</li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.members')
                        {{-- <small>{{ $members->total() }}</small> --}}
                    </h3>
                    <form action="{{ route('dashboard.members.index') }}" method="get">
                        <div class="row">
                            <div class="col-md-2">
                                <select name="city_id" class="form-control">
                                    <option value="">@lang('site.all_cities')</option>
                                    @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ $city->id === request()->city_id ? 'selected' : '' }}>{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                    @lang('site.search')
                                </button>
    
                            </div>
                        </div>

                    </form>
                </div>
                <div class="box-body">

                    @if($members->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>@lang('site.phone')</th>
                                <th>@lang('site.status')</th>
                                <th>@lang('site.address')</th>
                                <th>@lang('site.street')</th>
                                <th>@lang('site.orders_count')</th>
                                <th>@lang('site.action')</th>

                            </tr>
                            </thead>

                            <tbody>
                            @php
                            $index = 1;
                            $page =  0 ;
                            if(request()->page){
                                $page = request()->page - 1;
                            }
                            @endphp
                            
                            @foreach($members as $index => $user)
                                <tr>
                                    <td>{{ (($page*10))+($index +1)  }}</td>
                                    <td>{{ $user->mobile }}</td>  
                                    <td>{{ $user->active }}</td>  
                                    <td>{{ $user->address }}</td> 
                                    <td>{{ $user->street }}</td>  
                                    <td>{{ $user->orders->count() }}</td> 
                                    <td>
                                        <a href="{{ route('dashboard.members.show',['client'=>$user->id]) }}" class="btn btn-warning btn-sm">@lang('site.read')</a>
                                        
                                        <a class="btn btn-info btn-sm"
                                               href="{{ route('dashboard.members.edit',$user->id) }}"><i
                                                        class="fa fa-edit"></i>@lang('site.edit')</a>
                                                        
                                            <form method="post"
                                                  action="{{route('dashboard.members.delete' , $user->id)}}"
                                                  style="display: inline-block">
                                                @csrf()
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm delete"><i
                                                            class="fa fa-trash"></i>@lang('site.delete')</button>
                                            </form>
                                    </td> 

                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                        {{ $members->appends(request()->query())->links() }}
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
