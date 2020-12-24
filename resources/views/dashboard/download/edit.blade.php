@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.download')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="#">@lang('site.download')</a></li>
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
                    <form action="{{ route('dashboard.download.update') }}" method="post">

                        @csrf
                        @method('put')
                            <div class="form-group">
                                <label>@lang('site.play_store_link')</label>

                                <input class="form-control" type="text" name="play_store_link" value="{{ $download->play_store_link }}">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.app_store_link')</label>

                                <input class="form-control" type="text" name="app_store_link" value="{{ $download->app_store_link }}">
                            </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i>@lang('site.save')
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
