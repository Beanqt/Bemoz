@foreach($data as $item)
    <li class="dd-item dd3-item" data-id="{{$item['id']}}">
        @if($orderPage)
            <div class="dd-handle dd3-handle fas">Drag</div>
        @endif
        <div class="dd3-content">
            {{$item['title']}}
            @if(!$orderPage)
                <div class="dd-actions pull-right">
                    @include('throne.widgets.actions', [
                        'permission' => $service->default,
                        'status' => route('throne.'.$service->default.'.status', isset($service->boss[1]) ? [$service->boss[1], $item['id']] : $item['id']),
                        'edit' => route('throne.'.$service->default.'.edit', isset($service->boss[1]) ? [$service->boss[1], $item['id']] : $item['id']),
                        'delete' => route('throne.'.$service->default.'.delete', isset($service->boss[1]) ? [$service->boss[1], $item['id']] : $item['id']),
                    ])
                </div>
            @endif
        </div>
        @if($child = $service->getOrderHtml($item['id'], $orderPage))
            <ol class="dd-list">
                {!! $child !!}
            </ol>
        @endif
    </li>
@endforeach