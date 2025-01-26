<li class="dynamic-element-add widgetItem box open">
    <div class="handle dd-handle dd3-handle fas"></div>
    <div class="title" data-title="@lang('admin.widget.default_title')">{{isset($item['title']) && !empty($item['title']) ? $item['title'] : trans('admin.widget.default_title')}}</div>
    <div class="widgetItemAction">
        <span class="edit btn btn-warning btn-xs"><i class="far fa-edit"></i></span>
        <span class="delete btn btn-danger btn-xs"><i class="far fa-trash-alt"></i></span>
    </div>
    <div class="inside">
        <div class="form-group">
            <label>@lang('admin.widget.tab.element.title')</label>
            <input type="text" class="form-control input-title" data-name="title" value="{{$item['title'] ?? ''}}">
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label>{{trans('admin.widget.tab.element.content')}}</label>
            <textarea class="form-control ck_textarea" data-name="content">{{$item['content'] ?? ''}}</textarea>
            <div class="help-block with-errors"></div>
        </div>
    </div>
</li>