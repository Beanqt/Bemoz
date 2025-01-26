<li class="dynamic-element-grid widgetItem box open">
    <div class="handle dd-handle dd3-handle fas"></div>
    <div class="title">@lang('admin.widget.modules.element.grid')</div>
    <div class="widgetItemAction">
        <span class="add-grid btn btn-success btn-xs"><i class="fas fa-plus"></i></span>
        <span class="main-option btn btn-info btn-xs"><i class="fas fa-cogs"></i></span>
        <span class="delete btn btn-danger btn-xs"><i class="far fa-trash-alt"></i></span>
    </div>
    @include('throne.widgets.creator._grid_options', ['class' => 'option-box main-grid', 'type' => 'main', 'options' => isset($options) ? $options : [], 'styles' => isset($styles) ? $styles : []])
    <div class="inside">
        <div class="row grid-box">
            @if(isset($grid))
                @foreach($grid as $key => $grid_item)
                    @include('throne.widgets.creator._grid_item', ['grid_item' => $grid_item, 'key' => $key])
                @endforeach
            @else
                @include('throne.widgets.creator._grid_item', ['grid_item' => []])
                @include('throne.widgets.creator._grid_item', ['grid_item' => []])
            @endif
        </div>
    </div>
</li>