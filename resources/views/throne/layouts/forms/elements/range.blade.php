<li class="box" data-type="range">
    <div class="title-box">
        <div class="icon"><i class="fas fa-sliders-h"></i></div>
        <div class="title" data-orig-title="@lang('admin.forms.form.menu.range')">{{isset($item['title']) && !empty($item['title']) ? $item['title'] : trans('admin.forms.form.menu.range')}}</div>
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
        </div>
        <div class="row">
            <div class="col-md-6">
                @include('throne.layouts.forms.inputs.min', ['number' => true])
            </div>
            <div class="col-md-6">
                @include('throne.layouts.forms.inputs.max', ['number' => true])
            </div>
        </div>
        <div class="form-group">
            <label>@lang('admin.forms.form.elements.step')</label>
            <input type="number" class="form-control input-step" data-name="step" min="1" value="{{$item['step'] ?? '1'}}" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
        </div>
    </div>
</li>