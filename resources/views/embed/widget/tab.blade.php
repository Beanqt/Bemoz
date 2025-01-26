@section('widgetTab-'.$id)
    <ul class="tabs-menu">
        <?php $i = 0; ?>
        @foreach($widget['data'] as $key => $item)
            <li class="item {{$i == 0 ? 'active' : ''}}" data-tab="{{$key}}">{{$item['title']}}</li>
            <?php $i++; ?>
        @endforeach
    </ul>
    <ul class="tabs-content">
        <?php $i = 0; ?>
        @foreach($widget['data'] as $key => $item)
            <li class="item item-{{$key}} {{$i == 0 ? 'active' : ''}}">
                {!! app('HelperService')->getSimpleContent($item['content']) !!}
            </li>
            <?php $i++; ?>
        @endforeach
    </ul>
@stop

<div class="widgetBox widgetBox-{{$id}} widgetTab">
    @if((isset($widget['style']['template']) && $widget['style']['template'] == 1) || $layout == 1)
        @section('widgetTab-'.$id)
        @show
    @else
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-xs-12">
                    @section('widgetTab-'.$id)
                    @show
                </div>
            </div>
        </div>
    @endif
</div>