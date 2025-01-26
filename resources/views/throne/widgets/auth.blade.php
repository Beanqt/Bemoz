@if(env('PUBLIC_AUTH'))
    <div class="form-group no-margin">
        <label for="auth">@lang('admin.widget.auth.title')<span class="required">*</span></label>
        <select class="form-control form-custom-select" name="auth" id="auth" required>
            <option value="0" {{!isset($data['auth']) || (isset($data['auth']) && $data['auth'] == 0) ? 'selected' : ''}}>@lang('admin.widget.auth.public')</option>
            <option value="1" {{isset($data['auth']) && $data['auth'] == 1 ? 'selected' : ''}}>@lang('admin.widget.auth.reg')</option>
        </select>
        <div class="help-block with-errors"></div>
    </div>
@endif