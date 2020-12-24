<div class="option-table table-option-special">
    <div class="option-head"><span class="small-icon"><img src="{{asset('web/images/3d.png')}}"/></span> @lang('site.request_special_size') <i class="fa fa-angle-down"></i></div>
    <div class="option-special option-content">

        @if ($product->depth_cost != null || $product->depth_cost != 0 || $product->depth_cost != '')
        <div class="form-group">
            <div class="col-xs-9"><label for="depth" class="control-label">@lang('site.depth')</label></div>
            <div class="col-xs-3"><input type="text" id="depth" name="special_sizes[depth]" value="0" class="form-control"></div>
        </div>            
        @endif

        @if ($product->height_cost != null || $product->height_cost != 0 || $product->height_cost != '')
        <div class="form-group">
            <div class="col-xs-9"><label for="height" class="control-label">@lang('site.height')</label></div>
            <div class="col-xs-3"><input type="text" id="height" name="special_sizes[height]" value="0" class="form-control"></div>
        </div>
        @endif

        @if ($product->length_cost != null || $product->lengthcost != 0 || $product->length_cost != '')
        <div class="form-group">
            <div class="col-xs-9"><label for="length" class="control-label">@lang('site.length')</label></div>
            <div class="col-xs-3"><input type="text" id="length" name="special_sizes[length]" value="0" class="form-control"></div>
        </div>
        @endif

        @if ($product->width_cost != null || $product->width_cost != 0 || $product->width_cost != '')
        <div class="form-group">
            <div class="col-xs-9"><label for="width" class="control-label">@lang('site.width')</label></div>
            <div class="col-xs-3"><input type="text" id="width" name="special_sizes[width]" value="0" class="form-control"></div>
        </div>
        @endif
        
        <div class="option-footer">
            <div class="form-group">
                <div class="col-xs-8"><div class="total-text">@lang('site.total')</div></div>
                <div class="col-xs-4"><div class="total-price"></div></div>
            </div>
            <div class="add-to-cart">
                <div class="qty-field--custom">
                    <a class="fr add right btn-number" data-type="plus" data-field="quantity">
                    <i class="fa fa-plus"></i>
                    </a>
                    <input id="input-quantity" type="text" name="quantity" class="fr item-count form-control input-number" value="1" min="1" max="9999">
                    <a class="fr reduce left btn-number" data-type="minus" data-field="quantity" disabled="disabled">
                    <i class="fa fa-minus"></i>
                    </a>
                </div>
                <div class="btn-add submit-btn">
                    <button href="#" class="btn btn-yellow btn-block" name="special_sizes_btn" value="1">@lang('site.add_to_cart')</button>
                </div>
            </div>
        </div>
    </div>
</div>

