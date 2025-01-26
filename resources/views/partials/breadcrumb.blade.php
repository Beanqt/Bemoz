@if(isset($breadcrumbs))
    <div class="breadcrumbs {{$class ?? ''}}">
        <ul>
            <li><a href="{{route('index')}}"><i class="fas fa-home"></i></a></li>
            @foreach($breadcrumbs as $item)
                <li>
                    @if(empty($item['slug']) || end($breadcrumbs)['slug'] == $item['slug'])
                        <span>{{$item['title']}}</span>
                    @else
                        <a href="{{$item['slug']}}">{{$item['title']}}</a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endif