<div class="col-sm-2">
    <ul class="subMenu links small">
        @foreach($archived as $key => $archive)
            @if($key == 0)
                <li class="{{!isset($archive_id) ? 'active' : ''}}">
                    <a href="{{$archive_route}}">@lang('admin.archived.current') - <small>{{$archive['users']['name']}}</small><br><small>{{$archive['created_at']}}</small></a>
                </li>
            @else
                <li class="{{isset($archive_id) && $archive_id == $archive['id'] ? 'active' : ''}} {{$key >= 6 ? 'hidden' : ''}}">
                    <a href="{{$archive_route}}/{{$archive['id']}}">{{$archive['created_at']}}<br><small>{{$archive['users']['name']}}</small></a>
                </li>
            @endif
        @endforeach
        @if(count($archived) > 6)
            <li class="more-archived"><span>@lang('admin.logs.more')</span></li>
        @endif
    </ul>
</div>