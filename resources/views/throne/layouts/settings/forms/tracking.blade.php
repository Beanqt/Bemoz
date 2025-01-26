<div class="form-group">
    <label for="ga">@lang('admin.settings.form.ga')</label>
    <input type="text" class="form-control" name="data[ga]" id="ga" value="{{$data['ga'] ?? ''}}">
    <div class="help-block with-errors"></div>
</div>
<div class="form-group">
    <label for="ga4">@lang('admin.settings.form.ga4')</label>
    <input type="text" class="form-control" name="data[ga4]" id="ga4" value="{{$data['ga4'] ?? ''}}">
    <div class="help-block with-errors"></div>
</div>
<div class="form-group">
    <label for="gtm">@lang('admin.settings.form.gtm')</label>
    <input type="text" class="form-control" name="data[gtm]" id="gtm" value="{{$data['gtm'] ?? ''}}">
    <div class="help-block with-errors"></div>
</div>
<div class="form-group">
    <label for="pixel">@lang('admin.settings.form.pixel')</label>
    <input type="text" class="form-control" name="data[pixel]" id="pixel" value="{{$data['pixel'] ?? ''}}">
    <div class="help-block with-errors"></div>
</div>