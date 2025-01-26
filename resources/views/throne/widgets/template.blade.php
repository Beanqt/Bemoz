@if(env('MULTI_TEMPLATE'))
    <div class="form-group">
        <label for="template">@lang('admin.widget.template.title')<span class="required">*</span></label>
        <select class="form-control form-custom-select" id="template" required>
            <option value="1" {{!isset($data['layout']) || (isset($data['layout']) && is_array($data['layout']) && ((isset($data['layout'][count($data['layout'])-1]['template']) && $data['layout'][count($data['layout'])-1]['template'] == 1) || !isset($data['layout'][count($data['layout'])-1]['template']))) ? 'selected' : ''}}>@lang('admin.widget.template.side')</option>
            <option value="2" {{isset($data['layout']) && is_array($data['layout']) && isset($data['layout'][count($data['layout'])-1]['template']) && $data['layout'][count($data['layout'])-1]['template'] == 2 ? 'selected' : ''}}>@lang('admin.widget.template.full')</option>
        </select>
        <div class="help-block with-errors"></div>
    </div>
@endif