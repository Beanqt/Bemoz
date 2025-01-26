@section('galleryBox-'.$id)
    <div id="carousel-gallery-{{$id}}" class="carousel slide" data-ride="carousel">
        @if(count($images) > 1)
            <ol class="carousel-indicators">
                @foreach($images as $key => $item)
                    <li data-target="#carousel-gallery-{{$id}}" data-slide-to="{{$key}}" {{$key==0 ? 'class="active"' : ''}}></li>
                @endforeach
            </ol>
        @endif

        <div class="carousel-inner" role="listbox">
            @foreach($images as $key => $item)
                <div class="item {{$key==0 ? 'active' : ''}}">
                    <img class="img-responsive" src="/uploads/{{isset($path) ? $path : 'gallery/'.$item['category']}}/small-{{$item['image']}}" alt="{{empty($item['alt']) ? $item['title'] : $item['alt']}}">
                </div>
            @endforeach
        </div>

        @if(count($images) > 1)
            <a class="left carousel-control" href="#carousel-gallery-{{$id}}" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            </a>
            <a class="right carousel-control" href="#carousel-gallery-{{$id}}" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            </a>
        @endif
    </div>
@stop
<div class="widgetBox galleryBox">
    @if($layout == 1)
        @section('galleryBox-'.$id)
        @show
    @else
        <div class="container">
            @section('galleryBox-'.$id)
            @show
        </div>
    @endif
</div>