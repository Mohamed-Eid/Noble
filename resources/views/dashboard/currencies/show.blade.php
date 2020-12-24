{{-- @php
dd($details->first()->id)
@endphp --}}
<section class="content">

    <div class="box box-primary">
        <div class="box-body">

            @if($cities->count() > 0)
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>@lang('site.city')</th>
                        <th>@lang('site.currency')</th>
                        <th>@lang('site.currency_value_for') {{default_currency()}}</th>
                        <th>@lang('site.action')</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($cities as $index => $city)
                        <tr>
                            <td>{{ $city->name }}</td>

                            @if( $city->is_default )
                            <td>
                                <strong>
                                    {{ $city->currency }} 
                                    (@lang('site.defualt'))
                                </strong>
                            </td>
                            @else
                            <td>
                                    {{ $city->currency }} 
                            </td>
                            @endif

 
                            <td>{{ $city->value }}</td>
                            <td>
                                <a class="btn btn-success btn-sm"
                                    href="{{ route('dashboard.cities.edit',$city)}}"><i class="fa fa-plus"></i>@lang('site.edit')
                                </a>
                                <form method="post"
                                action="{{ route('dashboard.currencies.make_defualt',$city)}}"
                                style="display: inline-block">
                                @csrf()
                                @method('put')
                                <button type="submit" class="btn btn-primary btn-sm">@lang('site.defualt')</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            @else
                <h2>@lang('site.no_data_found')</h2>
            @endif

        </div>
    </div>

</section><!-- end of content -->