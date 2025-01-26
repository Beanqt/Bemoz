<li class="dynamic-element-images widgetItem box open">
    <div class="handle dd-handle dd3-handle fas"></div>
    <div class="title">@lang('admin.widget.modules.element.images')</div>
    <div class="widgetItemAction">
        <span class="show-image btn btn-warning btn-xs" data-image="{!! isset($module['category']) ? '/uploads/gallery/'.$module['category'].'/small-'.$module['image'] : '' !!}"><i class="fas fa-eye"></i></span>
        <span class="delete btn btn-danger btn-xs"><i class="far fa-trash-alt"></i></span>
    </div>
    <div class="inside">
        <input type="hidden" data-name="type" value="images">
        <input type="hidden" data-name="id" value="{{$item['id'] ?? ''}}">
        <div class="sub-title">{{isset($module['title']) ? '#'.$item['id'].' - '.$module['title'] : ''}}</div>
    </div>
</li>