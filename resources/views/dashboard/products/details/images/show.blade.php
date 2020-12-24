<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.details')
                {{-- <small>{{ $details->total() }}</small> --}}
            </h3>
        </div>
        <div class="box-body">

            @if($images->count() > 0)
            <div class="row" style="display: inline">
                
                @foreach ($images as $image)
                <div class="col-md-4">
                    <img src="{{ asset($image->image) }}"
                    class="img-thumbnail image-preview" style="width: 100px;">

                    <form method="post"
                    action="{{route('dashboard.products.details.delete_images' , [
                        'image' => $image,
                        'product' => $product
                    ])}}"
                    style="display: inline-block">
                    @csrf()
                    @method('delete')
                    <a type="submit" class="text-red delete"><i
                                class="fa fa-trash"></i></a>
                    </form>
                </div>
                @endforeach
            </div>
            @else
                <h2>@lang('site.no_data_found')</h2>
            @endif

        </div>
    </div>

</section><!-- end of content -->