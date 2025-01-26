<div class="form-group">
    <label>@lang('admin.forms.form.elements.required')</label>&nbsp;
    <label class="switch">
        <input type="checkbox" class="input-required" data-name="required" {{isset($item['required']) && $item['required'] ? 'checked' : ''}} {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
        <span class="slider round"></span>
    </label>
</div>