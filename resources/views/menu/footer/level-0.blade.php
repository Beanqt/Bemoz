<ul class="footermenu">
    @foreach($menu as $row)
        <li>
            @if(empty($row['url']))
                <span>{{$row['title']}}</span>
            @else
                <a href="{{$row['url']}}" {{$row['external'] ? 'target="_blank"' : ''}}>{{$row['title']}}</a>
            @endif
        </li>
    @endforeach
    <li id="deleteCookie" class="{{!isset($_COOKIE['cookieBox']) || $_COOKIE['cookieBox'] == 'false' ? 'hidden' : ''}}">
        <a href="{{route('delete_cookie')}}">{{setting('cookie.delete_btn', true)}}</a>
    </li>
</ul>