@section('video-'.$video['id'])
    @if($video['type']==1)
        <a class="popup-youtube" href="https://www.youtube.com/watch?v={{$video['video_id']}}" target="_blank">
            @if(empty($video['image']))
                <div class="iconBox"><i class="fas fa-video"></i><div class="noimage">@lang('public.embed.noimagevideo')</div></div>
            @else
                <img class="img-responsive youtube" src="/uploads/video/{{$video['category']}}/small-{{$video['image']}}" alt="{{$video['title']}}">
            @endif
            <div class="gallery-overlay"><i class="fas fa-play"></i></div>
        </a>
    @elseif($video['type']==2)
        <a class="popup-vimeo" href="https://vimeo.com/{{$video['video_id']}}" target="_blank">
            @if(empty($video['image']))
                <div class="iconBox"><i class="fas fa-video"></i><div class="noimage">@lang('public.embed.noimagevideo')</div></div>
            @else
                <img class="img-responsive youtube" src="/uploads/video/{{$video['category']}}/small-{{$video['image']}}" alt="{{$video['title']}}">
            @endif
            <div class="gallery-overlay"><i class="fas fa-play"></i></div>
        </a>
    @elseif($video['type']==4)
        <img class="img-responsive gif" src="/uploads/video/{{$video['category']}}/{{$video['video_id']}}">
    @elseif($video['type']==5)
        <audio {{$video['autoplay'] ? 'autoplay' : ''}} {{$video['loop'] ? 'loop' : ''}} {{$video['mute'] ? '' : 'muted'}} controls>
            <source src="/uploads/video/{{$video['category']}}/{{$video['video_id']}}" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    @else
        <video width="100%" {{$video['autoplay'] ? 'autoplay' : ''}} {{$video['loop'] ? 'loop' : ''}} {{$video['mute'] ? '' : 'muted'}} controls {!! !empty($video['image']) ? 'poster="/uploads/video/'.$video['category'].'/small-'.$video['image'].'"' : '' !!}>
            @if(!empty($video['mp4']))
                <source src="/uploads/video/{{$video['category']}}/{{$video['mp4']}}" type="video/mp4">
            @endif
            @if(!empty($video['webm']))
                <source src="/uploads/video/{{$video['category']}}/{{$video['webm']}}" type="video/webm">
            @endif
            Your browser does not support the video tag.
        </video>
    @endif
@stop

<div class="widgetBox videoBox">
    @if($layout == 1)
    @section('video-'.$video['id'])
    @show
    @else
        <div class="container">
            @section('video-'.$video['id'])
            @show
        </div>
    @endif
</div>