@foreach(${$service->default} as $item)
    <tr>
        @foreach($service->model->lists as $list)
            <?php
                $array = explode('.', $list);
                $value = '';

                if(count($array) == 1){
                    $value = $item[$array[0]];
                }elseif(method_exists($item, $array[0])){
                    if(isset($item->{$array[0]}->{$array[1]})){
                        $value = $item->{$array[0]}->{$array[1]};
                    }elseif($item->{$array[0]} && ($current_items = $item->{$array[0]}->pluck($array[1])->all())){
                        $value = implode(',<br>', $current_items);
                    }
                }
            ?>
            <td>{{$list == 'id' ? '#' : ''}}{!! $value ?? '' !!}</td>
        @endforeach
        <td class="text-right">
            @include('throne.widgets.actions', [
                'permission' => $service->default,
                'status' => Route::has('throne.'.$service->default.'.status') ? route('throne.'.$service->default.'.status', isset($service->boss[1]) ? [$service->boss[1], $item['id']] : $item['id']) : '',
                'edit' => Route::has('throne.'.$service->default.'.edit') ? route('throne.'.$service->default.'.edit', isset($service->boss[1]) ? [$service->boss[1], $item['id']] : $item['id']) : '',
                'delete' => Route::has('throne.'.$service->default.'.delete') ? route('throne.'.$service->default.'.delete', isset($service->boss[1]) ? [$service->boss[1], $item['id']] : $item['id']) : '',
                'featured' => Route::has('throne.'.$service->default.'.featured') ? route('throne.'.$service->default.'.featured', isset($service->boss[1]) ? [$service->boss[1], $item['id']] : $item['id']) : '',
                'preview' => Route::has('throne.'.$service->default.'.preview') ? route('throne.'.$service->default.'.preview', isset($service->boss[1]) ? [$service->boss[1], $item['id']] : $item['id']) : '',
                'show' => Route::has('throne.'.$service->default.'.show') ? route('throne.'.$service->default.'.show', isset($service->boss[1]) ? [$service->boss[1], $item['id']] : $item['id']) : '',
            ])
        </td>
    </tr>
@endforeach

{!! ${$service->default}->links('throne.paginate.paginate') !!}