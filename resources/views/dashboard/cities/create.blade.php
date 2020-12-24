@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.users')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.cities.index')}}">@lang('site.cities')</a></li>
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
                    <form action="{{ route('dashboard.cities.store') }}" method="post" enctype="multipart/form-data">

                        @csrf

                        @foreach(config('translatable.locales') as $locale)
                        <div class="form-group">
                            <label>@lang('site.'.$locale.'.name')</label>
                            <input type="text" name="{{$locale}}[name]" class="form-control" value="{{ old($locale.'.name') }}" >
                        </div>
                        <div class="form-group">
                            <label>@lang('site.'.$locale.'.currency')</label>
                            <input type="text" name="{{$locale}}[currency]" class="form-control" value="{{ old($locale.'.currency') }}" >
                        </div>
                        @endforeach

                        <div class="form-group">
                            <label>@lang('site.currency_value_for') {{default_currency()}}</label>
                            <input type="text" name="value" class="form-control" value="{{ old('value') }}" >
                        </div>

                        <div class="form-group">
                            <label>@lang('site.code')</label>
                            <input type="text" name="code" class="form-control" value="{{ old('code') }}" >
                        </div>
                        
                        <div class="form-group">
                            <label>@lang('site.image')</label>
                            <input type="file" name="image" class="form-control image">
                        </div>

                        <div class="form-group">
                            <img src="{{ asset('uploads/city_images/default.png') }}"
                                 class="img-thumbnail image-preview" style="width: 100px;">
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i>@lang('site.add')
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
