@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.details')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.details')}}">@lang('site.details')</a></li>
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
                <form action="{{ route('dashboard.details.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                @foreach(config('translatable.locales') as $locale)
                                <div class="form-group">
                                    <label>@lang('site.'.$locale.'.name')</label>
                                    <input type="text" name="{{$locale}}[name]" class="form-control" value="{{ old($locale.'.name') }}" >
                                </div>
                                @endforeach                          
                            </div>
                        </div>






                        <div class="box-body">
                            <div class="box-group" id="accordion">
                              <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                              <div class="panel box box-primary">
                                <div class="box-header with-border">
                                  <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="collapsed" aria-expanded="false">
                                        @lang('site.add') @lang('site.subdetails')
                                    </a>
                                  </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse" aria-expanded="false">
                                  <div class="box-body">

                                    @for($i=0;$i<5;$i++)
                                    <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.subdetail') {{$i+1}}</h3>
                                    @foreach(config('translatable.locales') as $locale)
                                    <div class="form-group">
                                        <label>@lang('site.'.$locale.'.name')</label>
                                        <input type="text" name="subdetails[{{$i}}][{{$locale}}][name]" class="form-control" value="{{ old($locale.'.name') }}" >
                                    </div>
                                    @endforeach
                    
                                    <div class="form-group">
                                        <label>@lang('site.price')</label>
                                        <input type="number" name="subdetails[{{$i}}][price]" class="form-control" value="{{ old('price') ?? 0 }}" >
                                    </div>
                                    <hr>
                                    @endfor


                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>






                        <div class="form-group">
                            <label>@lang('site.products')</label>

                            <div class="nav-tabs-custom">

                                <ul class="nav nav-tabs">
                                    @foreach($cities as $index=>$city)
                                        <li class="{{ $index == 0 ? 'active' : '' }}">
                                            <a href="#{{$city->id}}"
                                                data-toggle="tab">{{$city->name}}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content">
                                    @foreach($cities as $index=>$city)
                                        <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="{{$city->id}}">
                                            @foreach($city->products as $product)
                                                <label>
                                                    <input type="checkbox" name="products[]"
                                                            value="{{$product->id}}"> 
                                                    {{$product->name}}
                                                </label>
                                                <img src="{{ $product->image_path }}" class="img-thumbnail" style="width: 50px;">

                                            @endforeach
                                        </div><!-- /.tab-pane -->
                                    @endforeach

                                </div>
                                <!-- /.tab-content -->
                            </div>
                            <!-- nav-tabs-custom -->

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
