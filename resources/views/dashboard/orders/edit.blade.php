
<form action="{{ route('dashboard.orders.update' , $order) }}" method="post">

    {{ csrf_field() }}
    {{ method_field('put') }}

    <div class="row">
        <div class="col-md-2">
            <label>@lang('site.status')</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select name="status" class="form-control">
                    @foreach ($order->status_values as $key => $val)
                        <option value="{{ $key }}" {{ $val == $order->status ? 'selected' : '' }}>{{ $val }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
        @if(auth()->user()->hasPermission('update_orders'))
                <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i>@lang('site.update')</button>
        @else
                <a href="#" class="btn btn-primary" disabled><i class="fa fa-plus"></i>@lang('site.update')</a>
        @endif
        </div>
    </div>



</form><!-- end of form -->

