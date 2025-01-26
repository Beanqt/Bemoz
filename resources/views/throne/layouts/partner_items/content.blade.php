@foreach($partner_items as $item)
    <tr>
        <td>#{{$item['id']}}</td>
        <td>{{$item['title']}}</td>
        <td>{{$item->throneCategories->title ?? ''}}</td>
        <td class="text-right">
            @include('throne.widgets.actions', [
                'permission' => 'partner_items',
                'status' => route('throne.partner_items.status', $item['id']),
                'edit' => route('throne.partner_items.edit', $item['id']),
                'delete' => route('throne.partner_items.delete', $item['id']),
            ])
        </td>
    </tr>
@endforeach

{!! $partner_items->links('throne.paginate.paginate') !!}