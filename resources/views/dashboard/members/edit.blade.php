@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.members')
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.members.index')}}">@lang('site.members')</a></li>
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
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route('dashboard.members.update' , $client->id) }}" method="post" >
        
                                @csrf
                                @method('put')
        
                                <div class="form-group">
                                    <label>@lang('site.phone')</label>
                                    <input type="text" name="mobile" class="form-control" value="{{ $client->mobile }}" >
                                </div>
        
                                <div class="form-group">
                                    <label>@lang('site.city')</label>
                                    <select name="city_id" class="form-control cities">
                                        <option value="">@lang('sit.all_cities')</option>
                                        @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ $city->id == $client->district->city->id ? 'selected' : '' }} >{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                
                                <script>
                                    $( ".cities" ).change(function() {
                                        $.ajax({
                                            type : 'GET',
                                            url : 'https://90days-home.com/demo/public/'+'{{ app()->getLocale() }}'+'/api/cities/'+this.value,  
                                            dataType: 'json',
                                            success: function (data) {
                                                console.log(data.data);
                                                List = data.data;
                                                $('.districts').empty();
                                                $('.districts').append("<option value=''>{{ __('site.districts') }}</option>");
                                                for (i in List ) {
                                                    $('.districts').append('<option value="' + List[i].id + '">' + List[i].name + '</option>');
                                                }
                                            }
                                        });
                                    
                                    });
                                </script>
                                
                                
                                <div class="form-group">
                                    <label>@lang('site.district')</label>
                                    <select name="district_id" class="form-control districts">
                                        <option value="">@lang('sit.all_districts')</option>
                                        @foreach($client->district->city->districts as $district)
                                        <option value="{{ $district->id }}" {{ $district->id == $client->district->id ? 'selected' : '' }} >{{$district->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
        
                                <div class="form-group">
                                    <label>@lang('site.street')</label>
                                    <input type="text" name="street" class="form-control" value="{{ $client->street }}" >
                                </div>
        
                                <div class="form-group">
                                    <label >@lang('site.active')</label>
                                    <input type="checkbox" name="active" {{ $client->active_status == 1 ? 'checked' : '' }} />
                                </div>
        
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i>@lang('site.edit')
                                    </button>
                                </div>
        
                            </form>
                        </div>
                        
                        <div class="col-md-6">
                            <form action="{{ route('dashboard.members.update_password' , $client->id) }}" method="post" >
        
                                @csrf
                                @method('put')
        
                                <div class="form-group">
                                    <label>@lang('site.new_password')</label>
                                    <input type="text" name="password" class="form-control"  />
                                </div>
        
                                <div class="form-group">
                                    <label>@lang('site.password_confirmation')</label>
                                    <input type="text" name="password_confirmation" class="form-control" />
                                </div>
        
        
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i>@lang('site.edit')
                                    </button>
                                </div>
        
                            </form>
                        </div>                        
                    </div>
                </div>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
