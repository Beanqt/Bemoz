<li class="dynamic-element-gallery widgetItem box open">
    <div class="handle dd-handle dd3-handle fas"></div>
    <div class="title">@lang('admin.widget.modules.element.gallery.title')</div>
    <div class="widgetItemAction">
        <span class="delete btn btn-danger btn-xs"><i class="far fa-trash-alt"></i></span>
    </div>
    <div class="inside">
        <input type="hidden" data-name="type" value="gallery">
        <input type="hidden" data-name="id" value="{{$item['id'] ?? ''}}">
        <div class="sub-title">{{isset($module['title']) ? '#'.$item['id'].' - '.$module['title'] : ''}}</div>

        <div class="checkbox-group iconCheckBox-group">
            <input type="hidden" data-name="mode" value="{{$item['mode'] ?? 'simple'}}">

            <label class="iconCheckBox">
                <input type="radio" value="simple" {{(isset($item['mode']) && $item['mode'] == 'simple') || (!isset($item['mode'])) ? 'checked' : ''}}>
                <i class="fas fa-folder" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.widget.modules.element.gallery.simple')"></i>
            </label>
            <label class="iconCheckBox">
                <input type="radio" value="list" {{isset($item['mode']) && $item['mode'] == 'list' ? 'checked' : ''}}>
                <i class="fas fa-th-large" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.widget.modules.element.gallery.list')"></i>
            </label>
            <label class="iconCheckBox">
                <input type="radio" value="box" {{isset($item['mode']) && $item['mode'] == 'box' ? 'checked' : ''}}>
                <i class="far fa-image" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.widget.modules.element.gallery.box')"></i>
            </label>
        </div>
    </div>
</li>