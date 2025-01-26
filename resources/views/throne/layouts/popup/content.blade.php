@foreach($popup as $item)
    <tr>
        <td>#{{$item['id']}}</td>
        <td>{{$item['title']}}</td>
        <td class="text-right">
            @include('throne.widgets.actions', [
                'permission' => 'popup',
                'status' => route('throne.popup.status', $item['id']),
                'edit' => route('throne.popup.edit', $item['id']),
                'delete' => route('throne.popup.delete', $item['id']),
            ])
        </td>
    </tr>
@endforeach

{!! $popup->links('throne.paginate.paginate') !!}