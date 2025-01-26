@section('imageGalleryBox-'.$gallery['id'])
    <div class="embedBox imageGalleryBox imageGalleryBox-{{$gallery['id']}}" data-embedtype="imageGalleryBox-{{$gallery['id']}}" data-embedid="{{$start}}" id="{{$gallery['id']}}" data-start="{{$start}}" data-ajax-error="@lang('public.ajax.error')">
        <div class="loader"></div>
        <ul class="embedBreadcrumb">
            @if($breadcrumb)
                @foreach($breadcrumb as $item)
                    <li class="folder" data-id="{{$item['fold']}}" data-type="gallery">
                        {{$item['title']}}
                    </li>
                @endforeach
            @else
                <li>@lang('public.embed.gallery.title')</li>
            @endif
        </ul>
        <div class="alert alert-danger hidden"></div>
        <div class="elements popup-gallery inline-row">
            @include('embed.api.gallery')
        </div>
    </div>
@stop
<div class="widgetBox gallerySimple">
    @if($layout == 1)
        @section('imageGalleryBox-'.$gallery['id'])
        @show
    @else
        <div class="container">
            @section('imageGalleryBox-'.$gallery['id'])
            @show
        </div>
    @endif
</div>