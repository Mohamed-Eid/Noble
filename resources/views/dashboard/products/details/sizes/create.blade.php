<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.sizes')</h3>
        </div>
        <div class="box-body">

            @include('partials._errors')
        <form action="{{ route('dashboard.products.details.add_sizes',['product' => $product]) }}" method="post">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('site.length')</label>
                            <input type="integer" name="length" class="form-control" value="{{ old('length') }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('site.width')</label>
                            <input type="integer" name="width" class="form-control" value="{{ old('width') }}" required>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('site.height')</label>
                            <input type="integer" name="height" class="form-control" value="{{ old('height') }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('site.depth')</label>
                            <input type="integer" name="depth" class="form-control" value="{{ old('depth') }}" required>
                        </div>
                    </div>

                </div>

                
                <div class="form-group">
                    <label>@lang('site.cost')</label>
                    <input type="integer" name="cost" class="form-control" value="{{ old('cost') }}" required>
                </div>
                
                                
                <div class="form-group">
                    <label>@lang('site.quantity')</label>
                    <input type="integer" name="quantity" class="form-control" value="{{ old('quantity') ?? 1 }}" required>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i>@lang('site.add')
                    </button>
                </div>
            </form>
        </div>
    </div>

</section><!-- end of content -->