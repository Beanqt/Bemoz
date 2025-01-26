<li class="dynamic-element-content widgetItem box {{!isset($layout_grid) ? 'open' : ''}}">
    <div class="handle dd3-handle fas"></div>
    <div class="title">@lang('admin.widget.modules.element.content')</div>
    <div class="widgetItemAction">
        <span class="edit btn btn-warning btn-xs"><i class="far fa-edit"></i></span>
        <span class="delete btn btn-danger btn-xs"><i class="far fa-trash-alt"></i></span>
    </div>
    <div class="inside">
        <div class="form-group no-margin">
            <input type="hidden" data-name="type" value="content">
            <textarea class="form-control ck_textarea" data-name="content">{{$item['content'] ?? ''}}</textarea>
        </div>
    </div>
</li>