@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.products')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.products.index')}}">@lang('site.products')</a></li>
                <li class="active"></i> @lang('site.add')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.add')</h3>
                </div>
                <div class="box-body">

                    @include('partials._errors')
                    <form action="{{ route('dashboard.products.update' , $product->id) }}" method="post" enctype="multipart/form-data">

                        @csrf
                        @method('put')

                        @foreach(config('translatable.locales') as $locale)
                            <div class="form-group">
                                <label>@lang('site.'.$locale.'.name')</label>
                                <input type="text" name="{{$locale}}[name]" class="form-control" value="{{ $product->translate($locale)->name }}" >
                            </div>

                        @endforeach
                        
                        @foreach(config('translatable.locales') as $locale)
                            <div class="form-group">
                                <label>@lang('site.'.$locale.'.description')</label>
                                <textarea class="form-control" type="text" name="{{$locale}}[description]">
                                    {{ $product->translate($locale)->description }}
                                </textarea>
                            </div>
                        @endforeach

                        <div class="form-group">
                            <label>@lang('site.categories')</label>
                            <select name="category_id" class="form-control">
                                <option value="">@lang('sit.categories')</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $product->category->id ? 'selected' : '' }} >{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>SKU</label>
                            <input type="text" name="sku" class="form-control" value="{{ $product->sku }}" >
                        </div>
                        
                        <div class="form-group">
                            <label>@lang('site.sort')</label>
                            <input type="integer" name="sort" class="form-control" value="{{  $product->sort }}" >
                        </div>
                        
                        <div class="form-group">
                            <label>@lang('site.profit')</label>
                            <input type="integer" name="profit" class="form-control" value="{{ $product->profit }}" >
                        </div>
                        
                        <div class="form-group">
                            <label>@lang('site.discount')</label>
                            <input type="integer" name="discount" class="form-control" value="{{ $product->discount }}" >
                        </div>

                        <div class="form-group">
                            <label>@lang('site.image')</label>
                            <input type="file" name="image" class="form-control image">
                        </div>

                        <div class="form-group">
                            <img src="{{ $product->image_path }}"
                                 class="img-thumbnail image-preview" style="width: 100px;">
                        </div>

                        <div class="form-group">
                            <label >@lang('site.active')</label>
                            <input type="checkbox" name="active" {{ $product->active_status == 1 ? 'checked' : '' }} />
                        </div>

                        <div class="form-group">
                            <label >@lang('site.tafsil')</label>
                            <input type="checkbox" name="tafsil" {{ $product->tafsil == 1 ? 'checked' : '' }}>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i>@lang('site.edit')
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
