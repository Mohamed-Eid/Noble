@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.permissions')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active"></i> @lang('site.permissions')</li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.permissions')
                        <small>{{ $permissions->total() }}</small>
                    </h3>
                    <form action="{{ route('dashboard.permissions.index') }}" method="get">
                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}"
                                       placeholder="@lang('site.search')">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-search"></i>@lang('site.search')</button>
                                    <a href="{{ route('dashboard.permissions.create') }}" class="btn btn-primary"><i
                                                class="fa fa-plus"></i>@lang('site.add')</a>


                            </div>
                        </div>

                    </form>
                </div>
                <div class="box-body">

                    @if($permissions->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.display_name')</th>
                                <th>@lang('site.description')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($permissions as $index => $permission)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->display_name }}</td>
                                    <td>{{ $permission->description }}</td>
                                    </td>
                                    <td>
                                            <a class="btn btn-info btn-sm"
                                               href="{{route('dashboard.permissions.edit' , $permission->id)}}"><i
                                                        class="fa fa-edit"></i>@lang('site.edit')</a>
                                            <form method="post"
                                                  action="{{route('dashboard.permissions.destroy' , $permission->id)}}"
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
                        {{ $permissions->appends(request()->query())->links() }}
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
