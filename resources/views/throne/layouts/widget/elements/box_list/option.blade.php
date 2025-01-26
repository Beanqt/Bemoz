<li class="dynamic-element-option widgetItem box open">
    <div class="handle">
        <div class="widgetItemAction">
            <span class="delete btn btn-danger btn-xs"><i class="far fa-trash-alt"></i></span>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('admin.widget.box_list.element.options.title')</label>
                    <input type="text" class="form-control" data-name="title" value="{{$item['title'] ?? ''}}">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('admin.widget.box_list.element.options.url')</label>
                    <input type="text" class="form-control" data-name="url" value="{{$item['url'] ?? ''}}">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>@lang('admin.widget.box_list.element.options.target.title')</label>
            <select class="form-control form-dynamic-select" data-name="target">
                <option value="0" {{(isset($item['target']) && $item['target']==0) || !isset($item['target']) ? 'selected' : ''}}>@lang('admin.widget.box_list.element.options.target.window')</option>
                <option value="1" {{isset($item['target']) && $item['target']==1 ? 'selected' : ''}}>@lang('admin.widget.box_list.element.options.target.blank')</option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
</li>