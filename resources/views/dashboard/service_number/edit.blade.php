@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.service_number')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="#">@lang('site.service_number')</a></li>
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
                    <form action="{{ route('dashboard.service_number.update') }}" method="post">

                        @csrf
                        @method('put')
                            <div class="form-group">
                                <label>@lang('site.service_number')</label>
                                <input class="form-control" type="text" name="mobile" value="{{ $service_number->number }}">
                            </div>
                            
                            <div class="form-group">
                                <label>@lang('site.email')</label>
                                <input class="form-control" type="text" name="email" value="{{ $service_number->email }}">
                            </div>

                        <div class="form-group">
                            @if(auth()->user()->hasPermission('update_service_numbers'))
                            <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i>@lang('site.save')
                            </button>
                            @else
                            <a class="btn btn-primary" href="#" disabled><i class="fa fa-plus"></i>@lang('site.save')
                            </a>
                            @endif

                        </div>

                    </form>
                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
