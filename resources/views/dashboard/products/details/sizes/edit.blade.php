<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.sizes')</h3>
        </div>
        <div class="box-body">

            @include('partials._errors')
            <form action="{{ route('dashboard.products.details.update_sizes' , ['product'=>$product, 'size'=>$size ]) }}" method="post">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('site.length')</label>
                            <input type="integer" name="length" class="form-control" value="{{  $size->length }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('site.width')</label>
                            <input type="integer" name="width" class="form-control" value="{{  $size->width }}" required>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('site.height')</label>
                            <input type="integer" name="height" class="form-control" value="{{  $size->height }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('site.depth')</label>
                            <input type="integer" name="depth" class="form-control" value="{{  $size->depth }}" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>@lang('site.cost')</label>
                    <input type="integer" name="cost" class="form-control" value="{{  $size->cost }}" required>
                </div>

                <div class="form-group">
                    <label>@lang('site.quantity')</label>
                    <input type="integer" name="quantity" class="form-control" value="{{ $size->quantity }}" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit"><i class="fa fa-plus"></i>@lang('site.save')
                    </button>
                </div>
            </form>
        </div>
    </div>

</section><!-- end of content -->