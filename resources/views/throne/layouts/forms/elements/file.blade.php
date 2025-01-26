<li class="box" data-type="file">
    <div class="title-box">
        <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
        <div class="title" data-orig-title="@lang('admin.forms.form.menu.file')">{{isset($item['title']) && !empty($item['title']) ? $item['title'] : trans('admin.forms.form.menu.file')}}</div>
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
                    <label>@lang('admin.forms.form.elements.max_file')</label>
                    <input type="number" class="form-control input-max" data-name="max" min="1" value="{{$item['max'] ?? '1'}}" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>@lang('admin.forms.form.elements.max_size')</label>
                    <input type="number" class="form-control input-max_size" data-name="max_size" value="{{$item['max_size'] ?? '3'}}" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>@lang('admin.forms.form.elements.extension')</label>
            <input type="text" class="form-control input-extension" data-name="extension" value="{{$item['extension'] ?? 'jpg,png,pdf,doc'}}" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
        </div>
    </div>
</li>