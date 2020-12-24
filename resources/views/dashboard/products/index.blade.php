@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.products')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active"></i> @lang('site.products')</li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.products')
                        <small>({{ $products->total() }})</small>
                    </h3>

                    <form action="{{ route('dashboard.products.index') }}" method="get">
                        <div class="row">

                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}"
                                       placeholder="@lang('site.search')">
                            </div>


                            <div class="col-md-3">
                                <select name="category_id" class="form-control">
                                    <option value="">@lang('site.categories')</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id === request()->category_id ? 'selected' : '' }}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-search"></i>@lang('site.search')</button>
                                @if(auth()->user()->hasPermission('create_products'))
                                    <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary"><i
                                                class="fa fa-plus"></i>@lang('site.add')</a>
                                @else
                                    <a class="btn btn-info" href="#" disabled>@lang('site.add')</a>
                                @endif

                            </div>
                        </div>

                    </form>
                </div>
                <div class="box-body">

                    @if($products->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.image')</th>
                                <th>@lang('site.category')</th>
                                <th>@lang('site.status')</th>
                                <th>@lang('site.rate')</th>
                                <th>@lang('site.view_rates')</th>
                                <th>sku</th>
                                <th>@lang('site.details')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($products as $index => $product)
                                <tr>
                                    <td>{{ $product->sort }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        <img src="{{ $product->image_path }}" class="img-thumbnail" style="width: 50px;">
                                    </td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->active }}</td>  
                                    <td>
                                        {{ $product->rate}}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-default-{{$product->id}}">
                                            @lang('site.view_rates')                                              
                                        </button> 
                                    </td>
                                    <div class="modal fade" id="modal-default-{{$product->id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                  <h4 class="modal-title">{{ $product->rate }}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    @foreach($product->rates as $rate)
                                                    <div class="box-footer box-comments">
                                                        <div class="box-comment">
                                                        <!-- User image -->
                                                            <div class="comment-text">
                                                                <span class="username">
                                                                    <a href="{{route('dashboard.members.show',$rate->client_id)}}">@lang('site.view_client') ({{$rate->rate}})</a>
                                                                    <span class="text-muted pull-right">{{$rate->created_at->diffForHumans()}}</span>
                                                                </span><!-- /.username -->
                                                                {{$rate->text}}
                                                            </div>
                                                        <!-- /.comment-text -->
                                                        </div>
                                                      <!-- /.box-comment -->
                                                    </div>                    
                                                    @endforeach
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                              <!-- /.modal-content -->
                                        </div>
                                            <!-- /.modal-dialog -->
                                    </div>
                                    
                                    <td>{{ $product->sku }}</td>


                                    @if(auth()->user()->hasPermission('update_products'))
                                    <td><a class="btn btn-info btn-sm"
                                        href="{{route('dashboard.products.details.index' , $product->id)}}"><i
                                                 class="fa fa-edit"></i>@lang('site.details')</a></td>
                                    <td>
                                    @else
                                    <td><a class="btn btn-info btn-sm"
                                        href="#" disabled><i class="fa fa-edit"></i>@lang('site.details')</a></td>
                                    <td>
                                    @endif

                                        @if(auth()->user()->hasPermission('update_products'))
                                            <a class="btn btn-info btn-sm"
                                               href="{{route('dashboard.products.edit' , $product->id)}}"><i
                                                        class="fa fa-edit"></i>@lang('site.edit')</a>
                                        @else
                                            <a class="btn btn-info btn-sm" href="#" disabled><i
                                                        class="fa fa-edit"></i>@lang('site.edit')</a>
                                        @endif
                                        @if(auth()->user()->hasPermission('delete_products'))
                                            <form method="post"
                                                  action="{{route('dashboard.products.destroy' , $product->id)}}"
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
                        {{ $products->appends(request()->query())->links() }}
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
