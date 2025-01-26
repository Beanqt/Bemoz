<div class="form-group">
    <label>@lang('admin.forms.form.elements.date')</label>
    <input type="text" class="form-control input-date" data-name="date" value="{{$item['date'] ?? ''}}" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
</div>