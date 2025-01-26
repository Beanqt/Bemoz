@if($folders)
    @foreach($folders as $fold)
        <div class="item folder inline-col" data-id="{{$fold['id']}}" data-type="gallery">
            @if(isset($fold['first_image']))
                <div class="image-box">
                    <img src="/uploads/gallery/{{$fold['first_image']['category']}}/small-{{$fold['first_image']['image']}}" alt="{{empty($fold['first_image']['alt']) ? $fold['first_image']['title'] : $fold['first_image']['alt']}}">
                </div>
            @elseif(empty($fold['image']))
                <div class="icon-box"><i class="far fa-image"></i></div>
            @else
                <div class="image-box">
                    <img src="/uploads/gallery/small-{{$fold['image']}}" alt="{{$fold['title']}}">
                </div>
            @endif
            <div class="title">{{$fold['title']}}</div>
        </div>
    @endforeach
@endif
@if($images)
    @foreach($images as $item)
        <div class="item inline-col">
            <a class="first-image preload" title="{{$item['title']}}" href="/uploads/gallery/{{$item['category']}}/{{$item['image']}}">
                <div class="image-box">
                    <img src="/uploads/gallery/{{$item['category']}}/small-{{$item['image']}}" alt="{{empty($item['alt']) ? $item['title'] : $item['alt']}}">
                    <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
                </div>
                <div class="title">{{$item['title']}}</div>
            </a>
        </div>
    @endforeach
@endif
@if(count($folders) == 0 && count($images) == 0)
    <div class="empty">@lang('public.embed.emptyfolder')</div>
@endif