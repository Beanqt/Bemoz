<ul class="col-sm-{{$grid_item['options']['column'] ?? '6'}} sortable grid-elements">
    <li class="actions">
        <div class="grid-title">col-sm-{{$grid_item['options']['column'] ?? '6'}}</div>
        <span class="option btn btn-info btn-xs"><i class="fas fa-cogs"></i></span>
        <span class="delete btn btn-danger btn-xs"><i class="far fa-trash-alt"></i></span>
    </li>
    <li class="option-box">
        @include('throne.widgets.creator._grid_options', ['type' => 'sub', 'options' => isset($grid_item['options']) ? $grid_item['options'] : [], 'styles' => isset($grid_item['styles']) ? $grid_item['styles'] : []])
    </li>
    @if(isset($grid_item['items']) && is_array($grid_item['items']))
        @foreach($grid_item['items'] as $item)
            @if(isset($item['type']) && ($type = $item['type']))
                @include('throne.widgets.creator._loader_templates', ['layout_grid' => true])
            @endif
        @endforeach
    @endif
</ul>