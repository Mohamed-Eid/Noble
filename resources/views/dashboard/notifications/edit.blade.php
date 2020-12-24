@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.notifications')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.notifications.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="#">@lang('site.notifications')</a></li>
                <li class="active"></i> @lang('site.send')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.add')</h3>
                </div>
                <div class="box-body">

                    @include('partials._errors')
                    <form action="{{ route('dashboard.notifications.send') }}" method="post" enctype="multipart/form-data">

                        @csrf
                        <div class="form-group">
                            <label>@lang('site.title')</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('site.body')</label>
                            <textarea class="form-control" type="text" name="body">
                            </textarea>
                        </div>
                       
                       <div class="form-group">
                            <label>@lang('site.image')</label>
                            <input type="file" name="image" class="form-control image">
                        </div>
                        <div class="form-group">
                            <img src="{{ asset('uploads/product_images/default.png') }}"
                                 class="img-thumbnail image-preview" style="width: 100px;">
                        </div>


                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"> <i class="fa fa-send"> </i> @lang('site.send')
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
