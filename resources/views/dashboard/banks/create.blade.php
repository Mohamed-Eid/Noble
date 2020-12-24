@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.banks')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.banks.index')}}">@lang('site.banks')</a></li>
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
                    <form action="{{ route('dashboard.banks.store') }}" method="post" enctype="multipart/form-data">

                        @csrf


                        @foreach(config('translatable.locales') as $locale)
                        <div class="form-group">
                            <label>@lang('site.'.$locale.'.bank_name')</label>
                            <input type="text" name="{{$locale}}[bank_name]" class="form-control" value="{{ old($locale.'.bank_name') }}" >
                        </div>
                        @endforeach
                        <hr>
                        @foreach(config('translatable.locales') as $locale)
                        <div class="form-group">
                            <label>@lang('site.'.$locale.'.name')</label>
                            <input type="text" name="{{$locale}}[name]" class="form-control" value="{{ old($locale.'.name') }}" >
                        </div>
                        @endforeach
                        <hr>


                        <div class="form-group">
                            <label>@lang('site.account')</label>
                            <input type="text" name="account" class="form-control" value="{{ old($locale.'.account') }}">
                        </div>
                        <div class="form-group">
                            <label>@lang('site.iban')</label>
                            <input type="text" name="iban" class="form-control" value="{{ old($locale.'.iban') }}">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.image')</label>
                            <input type="file" name="image" class="form-control image">
                        </div>

                        <div class="form-group">
                            <img src="{{ asset('uploads/bank_images/default.png') }}"
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
