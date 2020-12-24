<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.videos')</h3>
        </div>
        <script src="{{asset('dashboard/js/dropzone.js ')}}"></script>
        <link rel="stylesheet" href="{{ asset('dashboard/css/dropzone.css') }}">

        <div class="box-body">

            @include('partials._errors')
        <form action="{{ route('dashboard.products.details.upload_videos', ['product' => $product]) }}" class="dropzone" method="post">
            @csrf
        </form>
        <a  class="btn btn-primary" href="{{ route('dashboard.products.details.index',['product'=>$product]) }}">@lang('site.refresh')</a>
        </div>
    </div>

</section><!-- end of content -->