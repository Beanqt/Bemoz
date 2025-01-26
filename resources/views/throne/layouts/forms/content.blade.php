@foreach($forms as $item)
    <tr>
        <td>#{{$item['id']}}</td>
        <td>{{$item['title']}}</td>
        <td class="text-right">
            @if($item['live'])
                <span class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="@lang('admin.forms.live')"><i class="fas fa-eye"></i></span>
            @else
                <a class="btn btn-default btn-xs no-follow" href="{{route('throne.forms.live', $item['id'])}}" data-toggle="tooltip" data-placement="top" title="@lang('admin.forms.notlive')"><i class="far fa-eye-slash"></i></a>
            @endif
            @if(can('form_content.read'))
                <a href="{{route('throne.form_content', $item['id'])}}" class="btn btn-info btn-xs btn-load" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.form_content.title')"><i class="fas fa-file-alt"></i></a>
            @endif
            @if(can('form_users.read'))
                <a href="{{route('throne.form_users', $item['id'])}}" class="btn btn-info btn-xs btn-load" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.form_users.title')"><i class="fas fa-users"></i> ({{count($item['users'])}})</a>
            @endif
            @if(can('forms.edit'))
                <div class="dropdown copy-dropdown" style="display: inline-block" data-toggle="tooltip" data-placement="top" title="@lang('admin.forms.copy')">
                    <button class="btn btn-success btn-xs dropdown-toggle" type="button" id="dropdown-live-{{$item['id']}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="far fa-copy"></i>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" style="max-width: 50px">
                        @foreach(\App\Models\Languages::get() as $lang)
                            <li><a class="no-follow" href="{{route('throne.forms.copy', [$item['id'], $lang['id']])}}">{{$lang['locale']}}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @include('throne.widgets.actions', [
                'permission' => 'forms',
                'status' => route('throne.forms.status', $item['id']),
                'edit' => route('throne.forms.edit', $item['id']),
                'delete' => route('throne.forms.delete', $item['id'])
            ])
        </td>
    </tr>
@endforeach

{!! $forms->links('throne.paginate.paginate') !!}