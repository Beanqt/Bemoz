<div class="form-group">
    <label>@lang('admin.forms.form.elements.help')</label>
    <input type="text" class="form-control input-help" data-name="help" value="{{$item['help'] ?? ''}}" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
</div>