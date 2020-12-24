<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.add')</h3>
        </div>
        <div class="box-body">

            @include('partials._errors')
            <form action="{{ route('dashboard.products.details.subdetails.update' , [$product, $detail,$subdetail ]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                @foreach(config('translatable.locales') as $locale)
                    <div class="form-group">
                        <label>@lang('site.'.$locale.'.name')</label>
                        <input type="text" name="{{$locale}}[name]" class="form-control" value="{{ $subdetail->translate($locale)->name }}" >
                    </div>
                @endforeach
                <div class="form-group">
                    <label>@lang('site.sort')</label>
                    <input type="integer" name="sort" class="form-control" value="{{ $subdetail->sort }}" >
                </div>
                <div class="form-group">
                    <label>@lang('site.price')</label>
                    <input type="text" name="price" class="form-control" value="{{ $subdetail->price }}" >
                </div>
                
                <div class="form-group">
                    <label>@lang('site.profit')</label>
                    <input type="number" name="profit" class="form-control" value="{{ $subdetail->profit }}" >
                </div>
                
                <div class="form-group">
                    <label>@lang('site.icon')</label>
                    <input type="file" name="icon" class="form-control">
                </div>

                <div class="form-group">
                <img src="{{$subdetail->icon_path}}"
                            class="img-thumbnail" style="width: 100px;">
                </div>

                <div class="form-group">
                    <label>@lang('site.image')</label>
                    <input type="file" name="image" class="form-control image">
                </div>

                <div class="form-group">
                <img src="{{$subdetail->image_path}}"
                            class="img-thumbnail image-preview" style="width: 100px;">
                </div>

                <div class="form-group">
                    <button class="btn btn-success" type="submit"><i class="fa fa-plus"></i>@lang('site.save')
                    </button>
                </div>
            </form>
        </div>
    </div>

</section><!-- end of content -->