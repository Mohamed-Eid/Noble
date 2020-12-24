<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.coupons')</h3>
        </div>
        <div class="box-body">

            @include('partials._errors')
            <form action="{{ route('dashboard.products.details.update_coupons' , ['product' => $product , 'coupon' => $coupon]) }}" method="post">
                @csrf
                @method('put')



                <div class="form-group">
                    <label>@lang('site.coupon')</label>
                    <input type="text" name="coupon" class="form-control" value="{{ $coupon->coupon }}" >
                </div>   

                <div class="form-group">
                    <label>@lang('site.offer')</label>
                    <input type="integer" name="offer" class="form-control" value="{{ $coupon->offer }}" >
                </div>


                <div class="form-group">
                    <label>@lang('site.expire_date')</label>
                <input type="date" name="expire_date" value="{{ $coupon->expire_date }}" class="form-control">
                </div>
               
                <div class="form-group">
                    <button class="btn btn-success" type="submit"><i class="fa fa-plus"></i>@lang('site.save')
                    </button>
                </div>
            </form>
        </div>
    </div>

</section><!-- end of content -->