@if(count($slider) > 0)
    <div id="slider" class="slide slider carousel hidden-xs" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            @foreach($slider as $key => $item)
                <?php $item['data'] = json_decode($item['data'], true) ?>
                <div class="item {{$key == 0 ? 'active' : ''}} {{$item['type'] ? 'video-item' : ''}}">
                    @if($item['type'])
                        <div class="loader"><span class="loader-text">@lang('public.slider.loader')</span></div>
                        <video muted preload>
                            @if(!empty($item['mp4']))
                                <source src="/uploads/slider/{{$item['mp4']}}" type="video/mp4">
                            @endif
                            @if(!empty($item['webm']))
                                <source src="/uploads/slider/{{$item['webm']}}" type="video/webm">
                            @endif
                            Your browser does not support the video tag.
                        </video>
                        <div class="actions">
                            <i class="fas fa-pause fa-fw play"></i>
                            <i class="fas fa-volume-off fa-fw volume"></i>
                        </div>

                        @if(isset($item['data']['title']) && !empty($item['data']['title']))
                            <div class="carousel-caption">
                                @if(isset($item['data']['url']) && !empty($item['data']['url']))
                                    <a class="title" href="{{$item['data']['url']}}" {!! isset($item['data']['target']) && $item['data']['target'] ? 'target="_blank"' : '' !!}>{{$item['data']['title']}}</a>
                                @else
                                    <div class="title">{{$item['data']['title']}}</div>
                                @endif
                            </div>
                        @endif
                    @else
                        @if(isset($item['data']['title'], $item['data']['content']) && !empty($item['data']['title']) && !empty($item['data']['content']))
                            <img src="/uploads/slider/small-{{$item['image']}}" alt="{{$item['title']}}">
                            <div class="carousel-caption">
                                <div class="title">{{$item['data']['title']}}</div>
                                @if(!empty($item['data']['content']))
                                    <div class="desc">{!! str_replace(PHP_EOL,'<br>',$item['data']['content']) !!}</div>
                                @endif
                                @if(isset($item['data']['button'],$item['data']['url']) && !empty($item['data']['button']) && !empty($item['data']['url']))
                                    <a class="btn btn-more btn-slider" href="{{$item['data']['url']}}" {!! isset($item['data']['target']) && $item['data']['target'] ? 'target="_blank"' : '' !!}>{{$item['data']['button']}}</a>
                                @endif
                            </div>
                        @elseif(isset($item['data']['url']) && !empty($item['data']['url']))
                            <a href="{{$item['data']['url']}}" {!! isset($item['data']['target']) && $item['data']['target'] ? 'target="_blank"' : '' !!}>
                                <img src="/uploads/slider/small-{{$item['image']}}" alt="{{$item['title']}}">
                            </a>
                        @else
                            <img src="/uploads/slider/small-{{$item['image']}}" alt="{{$item['title']}}">
                        @endif
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif