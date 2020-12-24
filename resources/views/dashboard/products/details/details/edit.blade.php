<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.add')</h3>
        </div>
        <div class="box-body">

            @include('partials._errors')
            {{-- <form action="#" method="post"> --}}
            <form action="{{ route('dashboard.products.details.update_details' , [$product, $detail ]) }}" method="post">
                @csrf
                @method('put')
                @foreach(config('translatable.locales') as $locale)
                    <div class="form-group">
                        <label>@lang('site.'.$locale.'.name')</label>
                        <input type="text" name="{{$locale}}[name]" class="form-control" value="{{ $detail->translate($locale)->name }}" >
                    </div>
                @endforeach
                    <div class="form-group">
                        <label>@lang('site.sort')</label>
                        <input type="integer" name="sort" class="form-control" value="{{  $detail->sort }}" >
                    </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit"><i class="fa fa-plus"></i>@lang('site.save')
                    </button>
                </div>
            </form>
        </div>
    </div>

</section><!-- end of content -->