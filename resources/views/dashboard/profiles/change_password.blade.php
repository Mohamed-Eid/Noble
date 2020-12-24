@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.users')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.users.index')}}">@lang('site.users')</a></li>
                <li class="active"></i> @lang('site.edit')</li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.edit')</h3>
                </div>
                <div class="box-body">

                    @include('partials._errors')
                    <form action="{{ route('dashboard.profiles.change_password_method') }}" method="post"
                          >
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label>@lang('site.old_password')</label>
                            <input type="password" name="old_password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('site.new_password')</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('site.password_confirmation')</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>


                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-edit"></i>@lang('site.edit')
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
