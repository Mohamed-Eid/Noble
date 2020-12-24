@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.banks')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active"></i> @lang('site.bank')</li>

            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.banks')
                    </h3>

                    <form action="{{ route('dashboard.banks.index') }}" method="get">
                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}"
                                       placeholder="@lang('site.search')">
                            </div>


                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-search"></i>@lang('site.search')</button>

                                                
                                @if(auth()->user()->hasPermission('create_banks'))
                                    <a href="{{ route('dashboard.banks.create') }}" class="btn btn-primary"><i
                                                class="fa fa-plus"></i>@lang('site.add')</a>
                                @else
                                    <a class="btn btn-primary" href="#" disabled>@lang('site.add')</a>
                                @endif
                            </div>
                        </div>

                    </form>
                </div>
                <div class="box-body">

                    @if($banks->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>@lang('site.image')</th>
                                <th>@lang('site.bank_name')</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.iban')</th>
                                <th>@lang('site.action')</th>

                            </tr>
                            </thead>

                            <tbody>
                            @foreach($banks as $index => $bank)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>
                                        <img src="{{ $bank->image_path }}" class="img-thumbnail" style="width: 50px;">
                                    </td>
                                    <td>{{ $bank->bank_name }}</td>
                                    <td>{{ $bank->name }}</td>
                                    <td>{{ $bank->iban }}</td>
                                    <td>
                                            
                                        @if(auth()->user()->hasPermission('update_banks'))
                                            <a class="btn btn-info btn-sm"
                                               href="{{route('dashboard.banks.edit' , $bank->id)}}"><i
                                                        class="fa fa-edit"></i>@lang('site.edit')</a>
                                        @else
                                            <a class="btn btn-info btn-sm" href="#" disabled><i
                                                        class="fa fa-edit"></i>@lang('site.edit')</a>
                                        @endif
                                        @if(auth()->user()->hasPermission('delete_banks'))
                                           <form method="post"
                                                  action="{{route('dashboard.banks.destroy' , $bank->id)}}"
                                                  style="display: inline-block">
                                                @csrf()
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm delete"><i
                                                            class="fa fa-trash"></i>@lang('site.delete')</button>
                                            </form
                                        @else
                                            <button type="submit" class="btn btn-danger btn-sm" disabled><i
                                                        class="fa fa-trash"></i>@lang('site.delete')</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                        {{ $banks->appends(request()->query())->links() }}
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
