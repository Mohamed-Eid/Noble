{{-- @php
dd($details->first()->id)
@endphp --}}
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.details')
                {{-- <small>{{ $details->total() }}</small> --}}
            </h3>
        </div>
        <div class="box-body">

            @if($colors->count() > 0)
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>@lang('site.name')</th>
                        <th>@lang('site.cost')</th>
                        <th>@lang('site.action')</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($colors as $index => $color)
                        <tr>
                            <td>{{ $color->name }}</td>
                            <td>{{ $color->cost }}</td>
                            <td>

                                @if(auth()->user()->hasPermission('update_details'))
                                <a class="btn btn-success btn-sm"
                                href="{{route('dashboard.products.details.edit_colors' , ['product' => $color->product, 'color'=>$color])}}"><i
                                         class="fa fa-plus"></i>@lang('site.edit')
                                </a>
                                @else
                                <a class="btn btn-success btn-sm"
                                href="#" disabled><i
                                         class="fa fa-plus"></i>@lang('site.edit')
                                </a>
                                @endif     
                                
                                @if(auth()->user()->hasPermission('delete_details'))
                                <form method="post"
                                    action="{{route('dashboard.products.details.delete_colors' , ['product' => $color->product, 'color'=>$color])}}"
                                    style="display: inline-block">
                                    @csrf()
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm delete"><i
                                        class="fa fa-trash"></i>@lang('site.delete')</button>
                                </form>
                                @else
                                <a href="#" class="btn btn-danger btn-sm" disabled><i
                                        class="fa fa-trash"></i>@lang('site.delete')</a>
                                
                                @endif     
                                
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