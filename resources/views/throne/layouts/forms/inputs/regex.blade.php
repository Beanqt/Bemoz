<div class="form-group">
    <label>@lang('admin.forms.form.elements.regex')</label>
    <input type="text" class="form-control input-regex" data-name="regex" value="{{$item['regex'] ?? ''}}" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
</div>