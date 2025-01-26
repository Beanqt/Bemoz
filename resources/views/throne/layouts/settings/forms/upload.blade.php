<div class="form-group">
    <label for="data[upload_image]">@lang('admin.settings.form.upload.image')</label>
    <div class="input-group">
        <div class="input-group-addon">MB</div>
        <input type="number" class="form-control" name="data[upload_image]" id="data[upload_image]" max="700" value="{{$data['upload_image'] ?? '100'}}">
    </div>
    <div class="help-block with-errors"></div>
</div>
<div class="form-group">
    <label for="data[upload_document]">@lang('admin.settings.form.upload.document')</label>
    <div class="input-group">
        <div class="input-group-addon">MB</div>
        <input type="number" class="form-control" name="data[upload_document]" id="data[upload_document]" max="700" value="{{$data['upload_document'] ?? '100'}}">
    </div>
    <div class="help-block with-errors"></div>
</div>
<div class="form-group">
    <label for="data[upload_video]">@lang('admin.settings.form.upload.video')</label>
    <div class="input-group">
        <div class="input-group-addon">MB</div>
        <input type="number" class="form-control" name="data[upload_video]" id="data[upload_video]" max="700" value="{{$data['upload_video'] ?? '100'}}">
    </div>
    <div class="help-block with-errors"></div>
</div>