@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.categories')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active"></i> @lang('site.categories')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.categories')
                        <small>{{ $categories->total() }}</small>
                    </h3>
                    <form action="{{ route('dashboard.categories.index') }}" method="get">
                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}"
                                       placeholder="@lang('site.search')">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-search"></i>@lang('site.search')</button>
                                @if(auth()->user()->hasPermission('create_categories'))
                                    <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary"><i
                                                class="fa fa-plus"></i>@lang('site.add')</a>
                                @else
                                    <a class="btn btn-info" href="#" disabled>@lang('site.add')</a>
                                @endif

                            </div>
                        </div>

                    </form>
                </div>
                <div class="box-body">

                    @if($categories->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.image')</th>
                                <th>@lang('site.products_count')</th>
                                <th>@lang('site.related_products')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($categories as $index => $category)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <img src="{{ $category->image_path }}" class="img-thumbnail" style="width: 50px;">
                                    </td>
                                    <td>{{ $category->products->count() }}</td>
                                    <td>
                                    @if(auth()->user()->hasPermission('read_products'))
                                        <a href="{{ route('dashboard.products.index' , ['category_id' => $category->id]) }}" class="btn btn-warning btn-sm">@lang('site.related_products')</a>

                                    @else
                                        <a href="#" class="btn btn-warning btn-sm" disabled>@lang('site.related_products')</a>

                                    @endif

                                    </td>
                                    <td>
                                        @if(auth()->user()->hasPermission('update_categories'))
                                            <a class="btn btn-info btn-sm"
                                               href="{{route('dashboard.categories.edit' , $category->id)}}"><i
                                                        class="fa fa-edit"></i>@lang('site.edit')</a>
                                        @else
                                            <a class="btn btn-info btn-sm" href="#" disabled><i
                                                        class="fa fa-edit"></i>@lang('site.edit')</a>
                                        @endif
                                        @if(auth()->user()->hasPermission('delete_categories'))
                                            <form method="post"
                                                  action="{{route('dashboard.categories.destroy' , $category->id)}}"
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
                        {{ $categories->appends(request()->query())->links() }}
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
