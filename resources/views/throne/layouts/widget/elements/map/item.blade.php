<li class="dynamic-element-marker widgetItem box open" {!! isset($key) && !is_null($key) ? 'data-key="'.$key.'"' : '' !!}>
    <div class="handle dd-handle dd3-handle fas"></div>
    <div class="widgetItemAction">
        <span class="delete btn btn-danger btn-xs"><i class="far fa-trash-alt"></i></span>
    </div>
    <div class="inside">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('admin.widget.map.form.marker.lat')</label>
                    <input type="text" class="form-control input-marker-lat" readonly value="{{$item['marker-lat'] ?? ''}}">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('admin.widget.map.form.marker.lng')</label>
                    <input type="text" class="form-control input-marker-lng" readonly value="{{$item['marker-lng'] ?? ''}}">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>@lang('admin.widget.map.form.marker.title')</label>
            <input type="text" class="form-control input-marker-title" value="{{$item['marker-title'] ?? ''}}">
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label>@lang('admin.widget.map.form.marker.content')</label>
            <textarea class="form-control input-marker-desc">{{$item['marker-desc'] ?? ''}}</textarea>
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label>@lang('admin.widget.map.form.marker.url')</label>
            <input type="text" class="form-control input-marker-url" value="{{$item['marker-url'] ?? ''}}">
            <div class="help-block with-errors"></div>
        </div>
    </div>
</li>