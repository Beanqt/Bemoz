<li class="dynamic-element-widget widgetItem box open">
    <div class="handle dd-handle dd3-handle fas"></div>
    <div class="title">@lang('admin.widget'.(isset($module['type']) ? '.'.$module['type'] : '').'.title')</div>
    <div class="widgetItemAction">
        <a href="{{route('throne.widget.edit', isset($item['id']) ? $item['id'] : '')}}" target="_blank" class="btn btn-warning btn-xs default-link"><i class="far fa-edit"></i></a>
        <span class="delete btn btn-danger btn-xs"><i class="far fa-trash-alt"></i></span>
    </div>
    <div class="inside">
        <input type="hidden" data-name="type" value="widget">
        <input type="hidden" data-name="id" value="{{$item['id'] ?? ''}}">
        <div class="sub-title">{{isset($module['title']) ? '#'.$item['id'].' - '.$module['title'] : ''}}</div>
    </div>
</li>