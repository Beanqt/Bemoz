<li class="dd-item col-sm-3 col-md-3 dd3-item" data-id="{{$item['id']}}">
    <div class="dd-handle dd3-handle fa">Drag</div>
    <div class="dd-actions">
        @include('throne.widgets.actions', [
            'permission' => $service->default,
            'status' => route('throne.'.$service->default.'.status', isset($service->boss[1]) ? [$service->boss[1], $item['id']] : $item['id']),
            'edit' => route('throne.'.$service->default.'.edit', isset($service->boss[1]) ? [$service->boss[1], $item['id']] : $item['id']),
            'delete' => route('throne.'.$service->default.'.delete', isset($service->boss[1]) ? [$service->boss[1], $item['id']] : $item['id']),
        ])
    </div>
    <div class="dd3-content">
        <div class="image">
            {!! getIcon("/uploads/".$service->default."/".(isset($item['image']) ? 'small-'.$item['image'] : $item['file']), isset($service->uploads['image']) ? true : false) !!}
        </div>
        <div class="title">{{$item['title']}}</div>
    </div>
</li>