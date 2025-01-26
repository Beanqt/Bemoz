<div class="panel panel-style">
    <div class="box">
        <div class="form-group group-options">
            <label>@lang('admin.widget.style.template.title')</label>
            <select class="form-control form-custom-select" name="style[template]">
                <option value="1" {{(isset($data['style']['template']) && $data['style']['template'] == 1) || !isset($data['style']['template']) ? 'selected' : '' }}>@lang('admin.widget.style.template.1')</option>
                <option value="2" {{isset($data['style']['template']) && $data['style']['template'] == 2 ? 'selected' : ''}}>@lang('admin.widget.style.template.2')</option>
            </select>
        </div>
        <div class="form-group group-styles">
            <label>@lang('admin.widget.style.background.color')</label>
            <div class="input-group color-picker">
                <span class="input-group-addon"><i></i></span>
                <input type="text" class="form-control" name="style[background-color]" value="{{$data['style']['background-color'] ?? ''}}">
            </div>
        </div>
        <div class="form-group">
            @include('throne.widgets.slim', ['title' => trans('admin.widget.style.background.image.title'),'imageremove'=>true,'width'=>1920,'height'=>430,'name'=>'style[slim]','url'=>'widget/'.$widget,'data'=>isset($data['style']) ? $data['style'] : ''])
        </div>
        <div class="form-group">
            <label>@lang('admin.widget.style.background.image.parallax')</label><br>
            <label class="switch">
                <input type="checkbox" name="style[parallax]" {{isset($data['style']['parallax']) && $data['style']['parallax'] == 'on' ? 'checked' : ''}}>
                <span class="slider round"></span>
            </label>
        </div>
        <hr>
        <label>@lang('admin.widget.style.padding.title')</label>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group group-styles">
                    <label>@lang('admin.widget.style.padding.top')</label>
                    <input type="text" class="form-control" name="style[padding-top]" value="{{$data['style']['padding-top'] ?? ''}}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group group-styles">
                    <label>@lang('admin.widget.style.padding.bottom')</label>
                    <input type="text" class="form-control" name="style[padding-bottom]" value="{{$data['style']['padding-bottom'] ?? ''}}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group group-styles">
                    <label>@lang('admin.widget.style.padding.right')</label>
                    <input type="text" class="form-control" name="style[padding-right]" value="{{$data['style']['padding-right'] ?? ''}}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group group-styles">
                    <label>@lang('admin.widget.style.padding.left')</label>
                    <input type="text" class="form-control" name="style[padding-left]" value="{{$data['style']['padding-left'] ?? ''}}">
                </div>
            </div>
        </div>
        <hr>
        <label>@lang('admin.widget.style.margin.title')</label>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group group-styles">
                    <label>@lang('admin.widget.style.margin.top')</label>
                    <input type="text" class="form-control" name="style[margin-top]" value="{{$data['style']['margin-top'] ?? ''}}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group group-styles">
                    <label>@lang('admin.widget.style.margin.bottom')</label>
                    <input type="text" class="form-control" name="style[margin-bottom]" value="{{$data['style']['margin-bottom'] ?? ''}}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group group-styles">
                    <label>@lang('admin.widget.style.margin.right')</label>
                    <input type="text" class="form-control" name="style[margin-right]" value="{{$data['style']['margin-right'] ?? ''}}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group group-styles">
                    <label>@lang('admin.widget.style.margin.left')</label>
                    <input type="text" class="form-control" name="style[margin-left]" value="{{$data['style']['margin-left'] ?? ''}}">
                </div>
            </div>
        </div>
    </div>
</div>