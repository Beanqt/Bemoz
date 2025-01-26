<li class="dynamic-element-document widgetItem box open">
    <div class="handle dd-handle dd3-handle fas"></div>
    <div class="title">@lang('admin.widget.modules.element.document')</div>
    <div class="widgetItemAction">
        <span class="delete btn btn-danger btn-xs"><i class="far fa-trash-alt"></i></span>
    </div>
    <div class="inside">
        <input type="hidden" data-name="type" value="document">
        <input type="hidden" data-name="id" value="{{$item['id'] ?? ''}}">
        <div class="sub-title">{{isset($module['title']) ? '#'.$item['id'].' - '.$module['title'] : ''}}</div>
    </div>
</li>