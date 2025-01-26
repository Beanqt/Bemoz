@if(isset($without_sortable))
    <div class="widget-creator">
        @include('throne.widgets.modules', $widgets)
    </div>
@else
    <div class="dynamic-elements-box" data-output=".{{$name}}" data-close="false" data-editor="content">
        <input type="hidden" class="{{$name}}" name="{{$name}}">

        <ul class="dynamic-elements sortable">
            @if(isset($data[$name]) && (is_array($data[$name]) ? true : ($data[$name] = json_decode($data[$name], true))))
                @foreach($data[$name] as $item)
                    @if(isset($item['type']) && ($type = $item['type']))
                        @include('throne.widgets.creator._loader_templates')
                    @elseif(isset($item['grids']))
                        @include('throne.widgets.creator.grid', ['grid' => $item['grids'], 'options' => $item['options'], 'styles' => $item['styles']])
                    @endif
                @endforeach
            @else
                @include('throne.widgets.creator.content')
            @endif
        </ul>
        <div class="widget-box widget-creator">
            @include('throne.widgets.modules', $widgets)
        </div>
        <ul class="template hidden">
            @include('throne.widgets.creator.grid', ['item' => []])
            <li class="dynamic-element-grid-option">
                @include('throne.widgets.creator._grid_item', ['grid_item' => []])
            </li>
            @include('throne.widgets.creator.content', ['item' => []])
            @include('throne.widgets.creator.gallery', ['item' => []])
            @include('throne.widgets.creator.images', ['item' => []])
            @include('throne.widgets.creator.document_category', ['item' => []])
            @include('throne.widgets.creator.document', ['item' => []])
            @include('throne.widgets.creator.video', ['item' => []])
            @include('throne.widgets.creator.video_category', ['item' => []])
            @include('throne.widgets.creator.forms', ['item' => []])
            @include('throne.widgets.creator.widget', ['item' => []])
        </ul>
    </div>
@endif