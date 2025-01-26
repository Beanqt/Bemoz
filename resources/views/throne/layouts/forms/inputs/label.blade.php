<div class="form-group">
    <label>@lang('admin.forms.form.elements.label')</label>
    <input type="text" class="form-control input-label" data-name="label" value="{{$item['label'] ?? ''}}" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
</div>