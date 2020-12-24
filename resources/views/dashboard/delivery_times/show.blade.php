<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.delivery_times')
            </h3>
        </div>
        <div class="box-body">

            @if($times->count() > 0)
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>@lang('site.name')</th>
                        <th>@lang('site.action')</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($times as $index => $time)
                        <tr>
                            <td>{{ $index +1 }}</td>
                            <td>{{ $time->name }}</td>
                            <td>
                                <form method="post"
                                    action="{{route('dashboard.times.destroy' , $time)}}"
                                    style="display: inline-block">
                                    @csrf()
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm delete"><i
                                        class="fa fa-trash"></i>@lang('site.delete')</button>
                                </form>
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