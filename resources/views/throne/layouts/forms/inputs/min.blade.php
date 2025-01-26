<div class="form-group">
    <label>@lang('admin.forms.form.elements.min'.(isset($number) ? '_number' : ''))</label>
    <input type="number" class="form-control input-min" min="0" data-name="min" value="{{$item['min'] ?? ''}}" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
</div>