@if(setting('map'))
    @section('widgetMap-'.$id)
        <div class="map" {!! isset($widget['option']['height']) && !empty($widget['option']['height']) ? 'style="height: '.$widget['option']['height'].'px;"' : '' !!} data-style="{{ isset($widget['option']['style']) ? preg_replace('/\s+/', '', $widget['option']['style']) : '' }}" data-lat="{{$widget['option']['lat'] ?? ''}}" data-lng="{{$widget['option']['lng'] ?? ''}}" data-zoom="{{$widget['option']['zoom'] ?? ''}}" {!! isset($widget['option']['markers']) ? 'data-markers="'.htmlentities($widget['option']['markers']).'"' : '' !!} {!! isset($widget['option']['image']) && !empty($widget['option']['image']) ? 'data-icon="/uploads/widget/map/small-'.$widget['option']['image'].'"' : '' !!}>
            <div class="loader active"></div>
        </div>
    @stop
    <div class="widgetBox widgetMap">
        @if(isset($widget['option']['width']) && $widget['option']['width'] == 2 && $layout != 1)
            <div class="container">
                @section('widgetMap-'.$id)
                @show
            </div>
        @else
            @section('widgetMap-'.$id)
            @show
        @endif
    </div>
@endif