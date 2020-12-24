<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 10px;">@lang('site.subdetails')
                {{-- <small>{{ $subdetails->total() }}</small> --}}
            </h3>
        </div>
        <div class="box-body">

            @if($subdetails->count() > 0)
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>@lang('site.name')</th>
                        <th>@lang('site.price')</th>
                        <th>@lang('site.profit')</th>
                        <th>@lang('site.image')</th>                        
                        <th>@lang('site.action')</th>

                    </tr>
                    </thead>

                    <tbody> 
                        @php
                            $subdetails = $subdetails->sortBy('sort');
                        @endphp
                    @foreach($subdetails as $index => $subdetail)
                        <tr>
                            <td>{{ $subdetail->sort }}</td>
                            <td>{{ $subdetail->name }}</td>
                            <td>{{ $subdetail->price }}</td>
                            <td>{{ $subdetail->profit }}</td>
                            <td>
                                @if ($subdetail->image)
                                <img src="{{ $subdetail->image_path }}" class="img-thumbnail" style="width: 50px;">
                                @else
                                no image
                                @endif
                            </td>
                            <td>
                                @if ($subdetail->icon)
                                <img src="{{ $subdetail->icon_path }}" class="img-thumbnail" style="width: 50px;">
                                @else
                                no image
                                @endif
                            </td>
                            <td>  
                                <a class="btn btn-success btn-sm"
                                href="{{route('dashboard.products.details.subdetails.edit' , ['product' => $detail->product->id , 'detail' =>$detail->id ,'subdetail' =>$subdetail->id ])}}"><i
                                         class="fa fa-plus"></i>@lang('site.edit')
                                </a>                                       
                                <form method="post"
                                    action="{{route('dashboard.products.details.subdetails.destroy' , ['product'=>$detail->product->id,'detail'=>$detail->id,'subdetail'=>$subdetail])}}"
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