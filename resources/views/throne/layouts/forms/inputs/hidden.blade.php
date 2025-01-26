<div class="form-group">
    <label>@lang('admin.forms.form.elements.hidden')</label>&nbsp;
    <label class="switch">
        <input type="checkbox" class="input-hidden" data-name="hidden" {{isset($item['hidden']) && $item['hidden'] ? 'checked' : ''}} {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
        <span class="slider round"></span>
    </label>
</div>