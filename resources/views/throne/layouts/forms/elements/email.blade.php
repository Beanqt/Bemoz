<li class="box" data-type="email">
    <div class="title-box">
        <div class="icon"><i class="fas fa-at"></i></div>
        <div class="title" data-orig-title="@lang('admin.forms.form.menu.email')">{{isset($item['title']) && !empty($item['title']) ? $item['title'] : trans('admin.forms.form.menu.email')}}</div>
    </div>
    <ul class="actions">
        <li class="edit btn btn-warning btn-xs"><i class="far fa-edit fa-fw"></i></li>
        <li class="delete btn btn-danger btn-xs"><i class="far fa-trash-alt fa-fw"></i></li>
    </ul>
    <div class="more">
        @include('throne.layouts.forms.inputs.title')
        <div class="row">
            <div class="col-md-6">
                @include('throne.layouts.forms.inputs.required')
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>@lang('admin.forms.form.elements.unique')</label>&nbsp;
                    <label class="switch">
                        <input type="checkbox" class="input-unique" data-name="unique" {{isset($item['unique']) && $item['unique'] ? 'checked' : ''}} {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                @include('throne.layouts.forms.inputs.label')
            </div>
            <div class="col-md-6">
                @include('throne.layouts.forms.inputs.placeholder')
            </div>
        </div>
        @include('throne.layouts.forms.inputs.help')
    </div>
</li>