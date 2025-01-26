<div class="form-group">
    <label>@lang('admin.forms.form.elements.placeholder')</label>
    <input type="text" class="form-control input-placeholder" data-name="placeholder" value="{{$item['placeholder'] ?? ''}}" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
</div>