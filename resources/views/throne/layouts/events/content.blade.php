@foreach($events as $item)
    <tr>
        <td>#{{$item['id']}}</td>
        <td>{{$item['title']}}</td>
        <td>{{$item->throneCategories->title ?? ''}}</td>
        <td class="text-right">
            @include('throne.widgets.actions', [
                'permission' => 'events',
                'status' => route('throne.events.status', $item['id']),
                'edit' => route('throne.events.edit', $item['id']),
                'delete' => route('throne.events.delete', $item['id']),
            ])
        </td>
    </tr>
@endforeach

{!! $events->links('throne.paginate.paginate') !!}