@foreach($form_content as $item)
    <tr>
        <td>#{{$item['id']}}</td>
        <td>{{trans('admin.form_content.form.type.'.$item['type'])}}</td>
        <td>{{$item['created_at']}}</td>
        <td class="text-right">
            @include('throne.widgets.actions', [
                'permission' => 'form_content',
                'edit' => route('throne.form_content.edit', [$item['form'], $item['id']]),
                'delete' => route('throne.form_content.delete', [$item['form'], $item['id']])
            ])
        </td>
    </tr>
@endforeach