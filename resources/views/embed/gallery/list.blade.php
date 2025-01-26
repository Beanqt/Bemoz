@section('galleryListBox-'.$id)
    <div class="galleryBox popup-gallery row">
        @foreach($images as $item)
            <div class="col-md-4 col-sm-6 col-xs-12 galleryItem">
                <a class="first-image preload" title="{{$item['title']}}" href="/uploads/gallery/{{$item['category']}}/{{$item['image']}}">
                    <img class="img-responsive" src="/uploads/gallery/{{$item['category']}}/small-{{$item['image']}}" alt="{{empty($item['alt']) ? $item['title'] : $item['alt']}}">
                    <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
                </a>
            </div>
        @endforeach
    </div>
@stop

<div class="widgetBox">
    @if($layout == 1)
        @section('galleryListBox-'.$id)
        @show
    @else
        <div class="container">
            @section('galleryListBox-'.$id)
            @show
        </div>
    @endif
</div>