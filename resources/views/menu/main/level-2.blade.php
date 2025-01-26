<ul class="level-2">
    @foreach($menu as $row)
        <li class="{{!empty($row['image']) ? 'have-image' : ''}}">
            @if(!empty($row['image']))
                <span class="image"><img src="/uploads/menu/small-{{$row['image']}}"></span>
                <span class="title">@include('menu.main.link', ['row' => $row,'dropdown' => false])</span>
            @else
                @include('menu.main.link', ['row' => $row,'dropdown' => false])
            @endif

            @if(!isset($row['data']['desc']) && empty($row['data']['desc']))
                <span class="icon icon-menu-arrow"></span>
            @endif

            @if(isset($row['data']['desc']) && !empty($row['data']['desc']))
                <span class="desc">{!! str_limit($row['data']['desc'], 60, '...') !!}</span>
            @endif
            @if(isset($row['data']['button']) && !empty($row['data']['button']) && !empty($row['url']))
                <a href="{{$row['url']}}" {!! $row['external'] ? 'target="_blank"' : '' !!} class="button">{!! $row['data']['button'] !!} <span class="icon icon-menu-arrow"></span></a>
            @endif
        </li>
    @endforeach
</ul>