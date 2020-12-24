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
                <h3 class="box-title" style="margin-bottom: 10px;">{{ $product->name.'-'.$detail->name }}
                    </h3>
                </div>
                <div class="box-body">
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            @if($edit)
                            @include('dashboard.products.details.subdetails.edit' ,  ['product' => $product])
                        @else
                        @include('dashboard.products.details.subdetails.create' ,  ['product' => $product])
                        @endif
                        </div>
                        <div class="col-md-6">
                            @include('dashboard.products.details.subdetails.show' , [
                                'subdetails' => $detail->subdetails,
                                'product' => $product,
                                'detail'  => $detail
                                ])
                        </div>
                    </div>

                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
