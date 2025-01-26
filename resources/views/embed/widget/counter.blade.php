@if(!empty($widget['data']))
    @section('widgetCounter-'.$id)
        @foreach($widget['data'] as $item)
            <div class="col-xs-{{$widget['option']['column']==4 && empty($item['title']) ? 4 : 6}} col-sm-{{$widget['option']['column']==4 ? 4 : 6}} col-md-{{$widget['option']['column'] ?? 3}} widgetItem">
                @if(isset($item['image']))
                    <div class="image">
                        <img class="img-responsive" src="/uploads/widget/counter/small-{{$item['image']}}" alt="{{$item['title'] ?? ''}}">
                    </div>
                @endif
                <div class="stat-number" data-number="{{$item['number'] ?? 0}}">0</div>
                @if(isset($item['title']))
                    <div class="title">{!! $item['title'] !!}</div>
                @endif
            </div>
        @endforeach
    @stop

    <div class="widgetBox widgetBox-{{$id}} widgetCounter text-{{$widget['option']['align'] ?? 'center'}}">
        @if((isset($widget['style']['template']) && $widget['style']['template'] == 1) || $layout == 1)
            @section('widgetCounter-'.$id)
            @show
        @else
            <div class="container">
                @section('widgetCounter-'.$id)
                @show
            </div>
        @endif
    </div>
@endif