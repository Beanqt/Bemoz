@if(empty($row['url']))
    <span>{{$row['title']}}</span>
@else
    <a href="{{$row['url']}}" {{$row['external'] ? 'target="_blank"' : ''}}>{{$row['title']}}</a>
@endif