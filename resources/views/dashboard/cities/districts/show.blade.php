<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.districts')
                {{-- <small>{{ $districts->total() }}</small> --}}
            </h3>
        </div>
        <div class="box-body">

            @if($districts->count() > 0)
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>@lang('site.name')</th>
                        <th>@lang('site.delivered_cost')</th>
                        <th>@lang('site.action')</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($districts as $index => $district)
                        <tr>
                            <td>{{ $index +1 }}</td>
                            <td>{{ $district->name }}</td>
                            <td>{{ $district->delivered_cost }}</td>
                            <td>
                                <form method="post"
                                    action="{{route('dashboard.cities.districts.destroy' , ['city'=>$district->city->id,'district'=>$district->id])}}"
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
                {{ $districts->appends(request()->query())->links() }}

            @else
                <h2>@lang('site.no_data_found')</h2>
            @endif

        </div>
    </div>

</section><!-- end of content -->