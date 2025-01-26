@foreach($caches as $item)
    <tr>
        <td>{{$item['key']}}</td>
        <td>{{$item['created_at']}}</td>
        <td class="text-right">
            @include('throne.widgets.actions', [
                'permission' => 'caches',
                'delete' => route('throne.caches.delete', $item['key']),
            ])
        </td>
    </tr>
@endforeach