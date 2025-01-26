@foreach($slider as $item)
    <tr>
        <td>#{{$item['id']}}</td>
        <td>{{$item['title']}}</td>
        <td class="text-right">
            @include('throne.widgets.actions', [
                'permission' => 'slider',
                'status' => route('throne.slider.status', $item['id']),
                'edit' => route('throne.slider.edit', $item['id']),
                'delete' => route('throne.slider.delete', $item['id']),
            ])
        </td>
    </tr>
@endforeach

{!! $slider->links('throne.paginate.paginate') !!}