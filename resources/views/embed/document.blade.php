@if($document)
    @section('documentBox-'.$document['id'])
        <a class="documentBox" href="{{route('download', ['folder'=>$document['category'], 'slug'=>$document['slug']])}}">
            <div class="icon-box">{!! $document['icon'] !!}</div>
            <div class="title">{{$document['title']}}</div>
            <ul class="other">
                <li>{{replaceDate('Y-m-d', $document['created_at'])}}</li>
                <li>{{fileExtension($document['file'])}}</li>
            </ul>
        </a>
    @stop
    <div class="widgetBox documentBoxRow">
        @if($layout == 1)
            @section('documentBox-'.$document['id'])
            @show
        @else
            <div class="container">
                @section('documentBox-'.$document['id'])
                @show
            </div>
        @endif
    </div>
@endif