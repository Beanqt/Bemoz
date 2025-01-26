@section('grid-'.$id)
    @if(count($images['main']) == 1 && isset($grids['styles']['option-animation']))
        <div class="grid-background"></div>
    @endif
    @if(count($images['main']) > 1)
        <div class="grid-bg-images">
            @foreach($images['main'] as $image)
                <img src="/uploads/gallery/{{$image['category']}}/small-{{$image['image']}}" alt="{{empty($image['alt']) ? $image['title'] : $image['alt']}}">
            @endforeach
        </div>
    @endif
    <div class="row grid-row">
        <?php $column = 0; ?>
        @foreach($grids['grids'] as $key => $grid)
            <?php $current_column = isset($grid['options']['column']) ? $grid['options']['column'] : 6; ?>
            @if($column+$current_column > 12)
    </div>
    <div class="row grid-row">
        <?php $column = $current_column; ?>
        @else
            <?php $column += $current_column ?>
        @endif

        <div class="col-sm-{{$current_column}} grid-item-{{$key}} {{$grid['options']['class'] ?? ''}}">
            @if(isset($images[$key]) && count($images[$key]) == 1 && isset($grid['styles']['option-animation']))
                <div class="grid-background"></div>
            @endif
            @if(isset($grid['items']) && is_array($grid['items']))
                @foreach($grid['items'] as $item)
                    {!! $service->loadModules($item, 1) !!}
                @endforeach
            @endif
        </div>
        @endforeach
    </div>
@stop

<div class="container{{(isset($grids['options']['template']) && $grids['options']['template'] == 1) || $layout == 1 ? '-fluid' : ''}} grid-main-{{$id}} {{$grids['options']['class'] ?? ''}}">
    @if((isset($grids['options']['template']) && $grids['options']['template'] == 1) || $layout == 1)
    @section('grid-'.$id)
    @show
    @else
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-xs-12">
                @section('grid-'.$id)
                @show
            </div>
        </div>
    @endif
</div>