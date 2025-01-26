<li class="box" data-type="map">
    <div class="title-box">
        <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
        <div class="title" data-orig-title="@lang('admin.forms.form.menu.map')">{{isset($item['title']) && !empty($item['title']) ? $item['title'] : trans('admin.forms.form.menu.map')}}</div>
    </div>
    <ul class="actions">
        <li class="edit btn btn-warning btn-xs"><i class="far fa-edit fa-fw"></i></li>
        <li class="delete btn btn-danger btn-xs"><i class="far fa-trash-alt fa-fw"></i></li>
    </ul>
    <div class="more">
        @include('throne.layouts.forms.inputs.title')
        @include('throne.layouts.forms.inputs.required')
        <div class="row">
            <div class="col-md-6">
                @include('throne.layouts.forms.inputs.label')
            </div>
            <div class="col-md-6">
                @include('throne.layouts.forms.inputs.help')
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>@lang('admin.forms.form.elements.lat')</label>
                    <input type="text" class="form-control input-lat" data-name="lat" value="{{$item['lat'] ?? '47.4962259'}}" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>@lang('admin.forms.form.elements.lng')</label>
                    <input type="text" class="form-control input-lng" data-name="lng" value="{{$item['lng'] ?? '19.0345682'}}" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>@lang('admin.forms.form.elements.height')</label>
                    <input type="number" class="form-control input-height" data-name="height" value="{{$item['height'] ?? '400'}}" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>@lang('admin.forms.form.elements.zoom')</label>
                    <input type="number" class="form-control input-zoom" data-name="zoom" max="16" value="{{$item['zoom'] ?? '11'}}" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>@lang('admin.widget.map.form.style')</label>
            <textarea class="form-control input-style" rows="6" data-name="style" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>{{$item['style'] ?? ''}}</textarea>
            <div class="help-block with-errors"></div>
        </div>
    </div>
</li>