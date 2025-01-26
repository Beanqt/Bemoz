@if(!empty($widget['data']))
    @section('widgetCategory-'.$id)
        @foreach($widget['data'] as $item)
            @if(isset($item['image']) && !empty($item['image']))
                <div class="col-xs-{{$widget['option']['column']==4 && empty($item['title']) ? 4 : 6}} col-sm-{{$widget['option']['column']==4 ? 4 : 6}} col-md-{{$widget['option']['column'] ?? 3}} widgetItemBox">
                    <div class="widgetItem">
                        <div class="widgetImage">
                            <div class="mask" style="background: {{$item['bgcolor'] ?? ''}}"></div>
                            <img class="img-responsive" src="/uploads/widget/category/small-{{$item['image']}}" alt="{{$item['title']}}">
                        </div>
                        <div class="infoBox">
                            @if(isset($item['icon']))
                                <img src="/uploads/widget/category/small-{{$item['icon']}}" alt="{{$item['title']}}" class="icon">
                            @endif
                            <div class="widgetTitle">{{$item['title']}}</div>
                            <div class="widgetContent">{!! $item['content'] ?? '' !!}</div>
                            @if(isset($item['url']) && isset($item['btn']))
                                <a href="{{$item['url']}}" {!! $item['target'] ? 'target="_blank"' : '' !!} class="btn btn-category-widget" style="border-color: {{$item['btncolor']}}">{{$item['btn']}}</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @stop
    <div class="widgetBox widgetBox-{{$id}} widgetCategory text-{{$widget['option']['align'] ?? 'center'}}">
        @if((isset($widget['style']['template']) && $widget['style']['template'] == 1) || $layout == 1)
            @section('widgetCategory-'.$id)
            @show
        @else
            <div class="container">
                @section('widgetCategory-'.$id)
                @show
            </div>
        @endif
    </div>
@endif