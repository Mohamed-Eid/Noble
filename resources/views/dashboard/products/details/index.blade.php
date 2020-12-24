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
                <h3 class="box-title" style="margin-bottom: 10px;">{{ $product->name }}
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                        <img src="{{ $product->image_path }}" class="img-thumbnail" style="height:100px;">
                        </div>
                        <div class="col-md-4">
                            <h3>@lang('site.name') : {{ $product->name }}</h3>
                            <h3>{{ $product->created_at->diffForHumans() }}</h3>
                        </div>
                    </div>
                    <br>
                    {{-- images --}}
                    <div class="row">
                        <div class="col-md-6">
                            @include('dashboard.products.details.images.create')
                        </div>
                        <div class="col-md-6">
                            @include('dashboard.products.details.images.show' , ['images' => $product->images])
                        </div>
                    </div>
                    
                    {{-- videos --}}
                    <div class="row">
                        <div class="col-md-6">
                            @include('dashboard.products.details.videos.create')
                        </div>
                        <div class="col-md-6">
                            @include('dashboard.products.details.videos.show' , ['videos' => $product->videos])
                        </div>
                    </div>
                    

                    {{-- sizes --}}
                    <div class="row">
                        <div class="col-md-6">
                            @if($size_edit)
                                @include('dashboard.products.details.sizes.edit' ,  ['size' => $size])
                            @else
                                @include('dashboard.products.details.sizes.create' ,  ['product' => $product])
                            @endif
                        </div>
                        <div class="col-md-6">
                            @include('dashboard.products.details.sizes.show' , ['sizes' => $product->sizes])
                        </div>
                    </div>

                    {{-- special sizes --}}
                    @if ($product->tafsil)
                    <div class="row">
                        <div class="col-md-12">
                            @include('dashboard.products.details.special_sizes.create' ,  ['product' => $product])
                        </div>
                    </div>  
                    @endif


                    {{-- colors --}}
                    {{-- <div class="row">
                        <div class="col-md-6">
                            @if($color_edit)
                                @include('dashboard.products.details.colors.edit' ,  ['color' => $color])
                            @else
                                @include('dashboard.products.details.colors.create' ,  ['product' => $product])
                            @endif
                        </div>
                        <div class="col-md-6">
                            @include('dashboard.products.details.colors.show' , ['colors' => $product->colors])
                        </div>
                    </div> --}}

                    {{-- details --}}
                    <div class="row">
                        <div class="col-md-6">
                            @if($edit)
                                @include('dashboard.products.details.details.edit' ,  ['detail' => $detail])
                            @else
                                @include('dashboard.products.details.details.create' ,  ['product' => $product])
                            @endif
                        </div>
                        <div class="col-md-6">
                            @include('dashboard.products.details.details.show' , ['details' => $product->details])
                        </div>
                    </div>
                    

                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
