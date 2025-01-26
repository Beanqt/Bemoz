@if(isset($row['items']))
    <span class="dropdown-sidemenu">{{$row['title']}}
        @if(isset($submenu))
            <span class="arrow-right"></span>
        @else
            <span class="icon icon-plus"></span>
        @endif
    </span>
@else
    @if(empty($row['url']))
        <span>{{$row['title']}}</span>
    @else
        <a href="{{$row['url']}}" {{$row['external'] ? 'target="_blank"' : ''}}>{{$row['title']}}</a>
    @endif
@endif