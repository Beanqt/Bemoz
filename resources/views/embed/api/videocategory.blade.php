@if($folders)
    @foreach($folders as $fold)
        <div class="item folder inline-col" data-id="{{$fold['id']}}" data-type="video">
            @if(empty($fold['image']))
                <div class="icon-box"><i class="fas fa-video"></i></div>
            @else
                <div class="image-box">
                    <img src="/uploads/video/small-{{$fold['image']}}" alt="{{$fold['title']}}">
                </div>
            @endif
            <div class="title">{{$fold['title']}}</div>
            <div class="date"><span class="icon icon-video"></span>@lang('public.embed.album')</div>
        </div>
    @endforeach
@endif
@if($files)
    @foreach($files as $item)
@section('video-'.$item['id'])
    @if($item['type'] == 4)
        <div class="image-box">
            <img src="/uploads/video/{{$item['category']}}/{{$item['video_id']}}" alt="{{$item['title']}}">
        </div>
    @else
        @if(empty($item['image']))
            <div class="icon-box">
                <i class="fas fa-video"></i>
                <div class="gallery-overlay"><i class="fas fa-play-circle"></i></div>
            </div>
        @else
            <div class="image-box">
                <img src="/uploads/video/{{$item['category']}}/small-{{$item['image']}}" alt="{{$item['title']}}">
                <div class="gallery-overlay"><i class="fas fa-play-circle"></i></div>
            </div>
        @endif
    @endif

    <div class="title">{{$item['title']}}</div>
    <div class="date"><i class="far fa-file-alt"></i>{{replaceDate('Y. M', $item['created_at'])}}</div>
@stop

<div class="item inline-col">
    @if($item['type']==1)
        <a class="popup-youtube" href="https://www.youtube.com/watch?v={{$item['video_id']}}" target="_blank">
            @section('video-'.$item['id'])@show
        </a>
    @elseif($item['type']==2)
        <a class="popup-vimeo" href="https://vimeo.com/{{$item['video_id']}}" target="_blank">
            @section('video-'.$item['id'])@show
        </a>
    @elseif($item['type']==4)
    @section('video-'.$item['id'])@show
    @elseif($item['type']==5)
        <a class="popup-audio" href="/uploads/video/{{$item['category']}}/{{$item['video_id']}}">
            @section('video-'.$item['id'])@show
        </a>
    @else
        <a class="popup-html5" href="/uploads/video/{{$item['category']}}/{{$item['mp4']}}" data-webm="/uploads/video/{{$item['category']}}/{{$item['webm']}}">
            @section('video-'.$item['id'])@show
        </a>
    @endif
</div>
@endforeach
@endif
@if(count($folders) == 0 && count($files) == 0)
    <div class="empty">@lang('public.emptyfolder')</div>
@endif