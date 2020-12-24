<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.details')
                {{-- <small>{{ $details->total() }}</small> --}}
            </h3>
        </div>
        <div class="box-body">

            @if($videos->count() > 0)
            <div class="row" style="display: inline">
                
                @foreach ($videos as $video)
                <div class="col-md-4">
                    <video width="240" height="160" controls>
                      <source src="{{ asset($video->video) }}" type="video/mp4">
                    </video>
                    
                    <form method="post"
                    action="{{route('dashboard.products.details.delete_videos' , [
                        'video' => $video,
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