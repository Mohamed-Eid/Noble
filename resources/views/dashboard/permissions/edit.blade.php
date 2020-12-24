@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.permissions')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.permissions.index')}}">@lang('site.permissions')</a></li>
                <li class="active"></i> @lang('site.edit')</li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.add')</h3>
                </div>
                <div class="box-body">

                    @include('partials._errors')
                    <form action="{{ route('dashboard.permissions.update',$permission) }}" method="post" >
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>@lang('site.name')</label>
                            <input type="text" name="name" class="form-control" value="{{ $permission->name }}"
                                   required>
                        </div>

                        <div class="form-group">
                            <label>@lang('site.display_name')</label>
                            <input type="text" name="display_name" class="form-control" value="{{ $permission->display_name }}" required>
                        </div> 

                        <div class="form-group">
                            <label>@lang('site.description')</label>
                            <input type="name" name="description" class="form-control" value="{{ $permission->description }}" required>
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
