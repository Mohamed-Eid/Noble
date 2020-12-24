<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.special_sizes')</h3>
        </div>
        <div class="box-body">

            @include('partials._errors')
        <form action="{{ route('dashboard.products.details.add_special_sizes',['product' => $product]) }}" method="post">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('site.length_cost')</label>
                            <input type="integer" name="length_cost" class="form-control" value="{{ old('length_cost') ?? $product->length_cost }}" >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('site.width_cost')</label>
                            <input type="integer" name="width_cost" class="form-control" value="{{ old('width_cost') ?? $product->width_cost }}" >
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('site.height_cost')</label>
                            <input type="integer" name="height_cost" class="form-control" value="{{ old('height_cost') ?? $product->height_cost }}" >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('site.depth_cost')</label>
                            <input type="integer" name="depth_cost" class="form-control" value="{{ old('depth_cost') ?? $product->depth_cost }}" >
                        </div>
                    </div>

                </div>

            

                <div class="form-group">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i>@lang('site.add')
                    </button>
                </div>
            </form>
        </div>
    </div>

</section><!-- end of content -->