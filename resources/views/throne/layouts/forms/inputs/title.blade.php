<div class="form-group">
    <label>@lang('admin.forms.form.elements.title')</label>
    <input type="text" class="form-control input-title" data-name="title" value="{{$item['title'] ?? ''}}" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
</div>