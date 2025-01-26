@foreach($widget as $item)
    <tr>
        <td>#{{$item['id']}}</td>
        <td>{{$item['title']}}</td>
        <td>@lang('admin.widget.'.$item['type'].'.title')</td>
        <td class="text-right">
            @include('throne.widgets.actions', [
                'permission' => 'widget',
                'status' => route('throne.widget.status', $item['id']),
                'edit' => route('throne.widget.edit', $item['id']),
                'delete' => route('throne.widget.delete', $item['id']),
            ])
        </td>
    </tr>
@endforeach

{!! $widget->links('throne.paginate.paginate', ['col' => 4]) !!}