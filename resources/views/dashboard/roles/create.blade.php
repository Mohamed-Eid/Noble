@extends('layouts.dashboard.app')

@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>@lang('site.roles')
        </h1>

        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i>
                    @lang('site.dashboard')</a>
            </li>
            <li><a href="{{ route('dashboard.roles.index') }}">@lang('site.roles')</a></li>
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
                <form action="{{ route('dashboard.roles.store') }}" method="post">
                    @csrf

                    <div class="form-group">
                        <label>@lang('site.name')</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label>@lang('site.display_name')</label>
                        <input type="text" name="display_name" class="form-control"
                            value="{{ old('display_name') }}" required>
                    </div>

                    <div class="form-group">
                        <label>@lang('site.description')</label>
                        <input type="name" name="description" class="form-control"
                            value="{{ old('description') }}" required>
                    </div>

                    <!-- SELECT2 EXAMPLE -->
                    <div class="box box-default">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <!-- /.col -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Permissions</label>
                                        <select class="form-control select2" multiple="multiple"
                                            data-placeholder="Select Permissions" style="width: 100%;" name="permissions[]">
                                            @foreach ($permissions as $permission)
                                            <option value="{{ $permission->id }}">{{ $permission->display_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.form-group -->

                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.box-body -->

                    </div>
                    <!-- /.box -->


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
