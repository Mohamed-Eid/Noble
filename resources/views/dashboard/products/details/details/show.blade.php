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

            @if($details->count() > 0)
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>@lang('site.name')</th>
                        <th>@lang('site.action')</th>
                    </tr>
                    </thead>

                    <tbody>
                        @php
                            $details = $details->sortBy('sort');
                        @endphp
                    @foreach($details as $index => $detail)
                        <tr>
                            <td>{{ $detail->sort }}</td>
                            <td>{{ $detail->name }}</td>
                            <td>
                                @if(auth()->user()->hasPermission('create_subdetails'))
                                <a class="btn btn-primary btn-sm"
                            href="{{route('dashboard.products.details.subdetails.index' , ['product' => $detail->product->id , 'detail' =>$detail->id ])}}"><i
                                         class="fa fa-plus"></i>@lang('site.add') @lang('site.sub_detail')
                                </a>
                                @else
                                <a class="btn btn-primary btn-sm"
                                href="#" disabled><i
                                         class="fa fa-plus"></i>@lang('site.add') @lang('site.sub_detail')
                                </a>
                                @endif


                                
                                @if(auth()->user()->hasPermission('update_details'))
                                <a class="btn btn-success btn-sm"
                            href="{{route('dashboard.products.details.edit_details',['product'=>$product,'detail'=>$detail])}}"><i
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
                                    action="{{ route('dashboard.products.details.delete_details' , [$product, $detail ]) }}"
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