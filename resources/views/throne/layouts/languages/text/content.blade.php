@foreach($translates as $item)
    <tr>
        <td>{{$item['item']}}</td>
        <td>{{strip_tags($item['text'])}}</td>
        <td class="text-right">
            @include('throne.widgets.actions', [
                'permission' => 'languages',
                'edit' => route('throne.language_text.edit', $item['id']),
            ])
        </td>
    </tr>
@endforeach

{!! $translates->links('throne.paginate.paginate', ['col' => 3]) !!}