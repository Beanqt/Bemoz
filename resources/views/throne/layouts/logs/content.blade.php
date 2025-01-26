@foreach($logs as $item)
    <tr>
        <td>#{{$item['id']}}</td>
        <td>{{$item->users->name ?? ''}}</td>
        <td>{{$item['element_id'] == 0 ? '' : '#'.$item['element_id']}}</td>
        <td>@lang('admin.'.str_replace('widget_', 'widget.', $item['type']).'.title')</td>
        <td>@lang('admin.logs.table.actions.'.$item['action'])</td>
        <td>{{$item['created_at']}}</td>
    </tr>
@endforeach

{!! $logs->links('throne.paginate.paginate', ['col' => 6]) !!}