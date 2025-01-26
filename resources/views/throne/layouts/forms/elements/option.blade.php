<li class="option-template box">
    <span class="delete btn btn-danger btn-xs"><i class="far fa-trash-alt fa-fw"></i></span>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>@lang('admin.forms.form.elements.option.title')</label>
                <input type="text" class="form-control option-title" value="{{$option['title'] ?? ''}}" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>@lang('admin.forms.form.elements.option.value')</label>
                <input type="text" class="form-control option-value" value="{{$option['value'] ?? ''}}" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
            </div>
        </div>
    </div>
</li>