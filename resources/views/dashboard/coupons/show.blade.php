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

            @if($coupons->count() > 0)
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>@lang('site.coupon')</th>
                        <th>@lang('site.offer')</th>
                        <th>@lang('site.expire_date')</th>
                        <th>@lang('site.action')</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($coupons as $index => $coupon)
                        <tr>
                            <td>{{ $coupon->coupon }}</td>
                            <td>{{ $coupon->offer }}</td>
                            <td>{{ $coupon->expire_date }}</td>

                            <td>

                                @if(auth()->user()->hasPermission('update_coupons'))
                                <a class="btn btn-success btn-sm"
                                href="{{route('dashboard.coupons.edit_coupons' , ['coupon'=>$coupon])}}"><i
                                         class="fa fa-plus"></i>@lang('site.edit')
                                </a>
                                @else
                                <a class="btn btn-success btn-sm"
                                href="#" disabled><i
                                         class="fa fa-plus"></i>@lang('site.edit')
                                </a>
                                @endif     
                                
                                @if(auth()->user()->hasPermission('delete_dcoupons'))
                                <form method="post"
                                    action="{{route('dashboard.coupons.delete_coupons' , ['coupon'=>$coupon])}}"
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