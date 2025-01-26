@section('imageBox-'.$image['id'])
    <div class="imageBox">
        <a class="image-popup preload" title="{{$image['title']}}" href="/uploads/gallery/{{$image['category']}}/{{$image['image']}}">
            <img class="img-responsive" src="/uploads/gallery/{{$image['category']}}/small-{{$image['image']}}" alt="{{empty($image['alt']) ? $image['title'] : $image['alt']}}">
            <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
        </a>
    </div>
@stop
<div class="widgetBox">
    @if($layout == 1)
        @section('imageBox-'.$image['id'])
        @show
    @else
        <div class="container">
            @section('imageBox-'.$image['id'])
            @show
        </div>
    @endif
</div>