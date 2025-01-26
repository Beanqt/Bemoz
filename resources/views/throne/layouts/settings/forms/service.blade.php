<div class="form-group">
    <label for="service">@lang('admin.settings.form.service.welcome')</label>
    <textarea class="form-control" rows="6" name="data[service]" id="service">{{$data['service'] ?? ''}}</textarea>
    <div class="help-block with-errors"></div>
</div>