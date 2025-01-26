@if(isset($widget['option']['image']))
    <div class="widgetBox widgetParallax" style="height: {{isset($widget['option']['height']) && !empty($widget['option']['height']) ? $widget['option']['height'] : '500px'}}">
        <div class="widgetParallaxInside" style="background: url(/uploads/widget/parallax/small-{{$widget['option']['image']}}) center center{{isset($widget['option']['animation']) ? ' fixed' : ''}}; height: {{isset($widget['option']['height']) && !empty($widget['option']['height']) ? $widget['option']['height'] : '500px'}}">
        </div>
    </div>
@endif