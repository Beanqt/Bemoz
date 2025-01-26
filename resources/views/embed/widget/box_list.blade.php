@if(!empty($widget['data']))
    @section('widgetBoxs-'.$id)
        <div class="row">
            @foreach($widget['data'] as $item)
                @if(isset($item['active']) && $item['active'])
                    <div class="col-xs-12 col-sm-6 col-md-{{$widget['option']['column'] ?? 4}} widget-box-item">
                        <div class="inside">
                            @if(!empty($item['image']))
                                <div class="img_title hidden-xs"><img class="img-responsive" src="/uploads/widget/box_list/small-{{$item['image']}}" alt="{{$widget['title']}}"></div>
                            @endif
                            <ul>
                                @foreach($item['options'] as $option_item)
                                    <li>
                                        @if(array_key_exists('url', $option_item) && empty($option_item['url']))
                                            <span>{{$option_item['title']}}</span>
                                        @elseif(array_key_exists('url', $option_item))
                                            <a href="{{$option_item['url']}}" {{isset($option_item['target']) && $option_item['target'] ? 'target="_blank"' : ''}}>{{$option_item['title']}} <span class="icon icon-box-arrow"></span></a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @stop

    <div class="widgetBox widgetBox-{{$id}} widget-boxs">
        @if((isset($widget['style']['template']) && $widget['style']['template'] == 1) || $layout == 1)
            @section('widgetBoxs-'.$id)
            @show
        @else
            <div class="container">
                @section('widgetBoxs-'.$id)
                @show
            </div>
        @endif
    </div>
@endif