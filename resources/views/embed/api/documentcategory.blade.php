@if($folders)
    @foreach($folders as $fold)
        <div class="item folder inline-col" data-id="{{$fold['id']}}" data-type="document">
            @if(empty($fold['image']))
                <div class="icon-box"><i class="fas fa-folder"></i></div>
            @else
                <div class="image-box">
                    <img src="/uploads/documentitem/small-{{$fold['image']}}" alt="{{$fold['title']}}">
                </div>
            @endif
            <div class="title">{{$fold['title']}}</div>
        </div>
    @endforeach
@endif
@if($files)
    @foreach($files as $item)
        <div class="item inline-col">
            <a class="popup-document" href="{{route('download', ['folder'=>$item['category'], 'slug'=>$item['slug']])}}">
                @if(empty($item['image']))
                    <div class="icon-box">
                        {!! getIcon($item['file']) !!}
                        <div class="gallery-overlay"><i class="fas fa-cloud-download-alt"></i></div>
                    </div>
                @else
                    <div class="image-box">
                        <img src="/uploads/documentitem/{{$item['category']}}/image/small-{{$item['image']}}" alt="{{$item['title']}}">
                        <div class="gallery-overlay"><i class="fas fa-cloud-download-alt"></i></div>
                    </div>
                @endif
                <div class="title">{{$item['title']}}</div>
            </a>
        </div>
    @endforeach
@endif
@if(count($folders) == 0 && count($files) == 0)
    <div class="empty">@lang('public.embed.emptyfolder')</div>
@endif