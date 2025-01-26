@section('documentGalleryBox-'.$category['id'])
    <div class="embedBox documentGalleryBox documentGalleryBox-{{$category['id']}}" data-embedtype="documentGalleryBox-{{$category['id']}}" data-embedid="{{$start}}" id="{{$category['id']}}" data-start="{{$start}}" data-ajax-error="@lang('public.ajax.error')">
        <div class="loader"></div>
        <ul class="embedBreadcrumb">
            @if($breadcrumb)
                @foreach($breadcrumb as $item)
                    <li class="folder" data-id="{{$item['fold']}}" data-type="document">
                        {{$item['title']}}
                    </li>
                @endforeach
            @else
                <li>@lang('public.embed.documentcategory.title')</li>
            @endif
        </ul>
        <div class="alert alert-danger hidden"></div>
        <div class="elements inline-row">
            @include('embed.api.documentcategory')
        </div>
    </div>
@stop
<div class="widgetBox documentCategory">
    @if($layout == 1)
        @section('documentGalleryBox-'.$category['id'])
        @show
    @else
        <div class="container">
            @section('documentGalleryBox-'.$category['id'])
            @show
        </div>
    @endif
</div>