@foreach($users as $item)
    <tr>
        <td>#{{$item['id']}}</td>
        <td>{{$item['name']}}</td>
        <td>{{$item['email']}}</td>
        <td>{{$item['group'] ? trans('admin.users.table.groups.'.$item['group']) : ''}}</td>
        <td>{{$item['last_login']}}</td>
        <td>{{$item['created_at']}}</td>
        <td class="text-right">
            @include('throne.widgets.actions', [
                'permission' => 'users',
                'status' => route('throne.users.status', $item['id']),
                'edit' => route('throne.users.edit', $item['id']),
                'delete' => route('throne.users.delete', $item['id']),
            ])
        </td>
    </tr>
@endforeach

{!! $users->links('throne.paginate.paginate', ['col' => 7]) !!}