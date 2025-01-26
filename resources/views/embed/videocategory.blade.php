@section('videoCategory-'.$category['id'])
    <div class="embedBox videoGalleryBox videoGalleryBox-{{$category['id']}}" data-embedtype="videoGalleryBox-{{$category['id']}}" data-embedid="{{isset($start) ? $start : 'all'}}" id="{{$category['id']}}" {{isset($all) ? 'data-type="all"' : ''}} {{isset($start) ? 'data-start="'.$start.'"' : ''}} data-ajax-error="@lang('public.ajax.error')">
        <div class="loader"></div>
        <ul class="embedBreadcrumb">
            @if($breadcrumb)
                @foreach($breadcrumb as $item)
                    <li class="folder" data-id="{{$item['fold']}}" data-type="video">
                        {{$item['title']}}
                    </li>
                @endforeach
            @else
                <li>@lang('public.embed.videocategory.title')</li>
            @endif
        </ul>
        <div class="alert alert-danger hidden"></div>
        <div class="elements inline-row">
            @include('embed.api.videocategory')
        </div>
    </div>
@stop

<div class="widgetBox videoCategory">
    @if($layout == 1)
        @section('videoCategory-'.$category['id'])
        @show
    @else
        <div class="container">
            @section('videoCategory-'.$category['id'])
            @show
        </div>
    @endif
</div>