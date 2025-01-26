<div class="form-group">
    <label>@lang('admin.forms.form.elements.max'.(isset($number) ? '_number' : ''))</label>
    <input type="number" class="form-control input-max" min="0" data-name="max" value="{{$item['max'] ?? ''}}" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
</div>