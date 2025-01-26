@if($paginator->hasPages())
    <ul class="pagination text-center">
        @if($paginator->onFirstPage())
            <li class="left disabled"><span><span class="icon icon-paginate-left-disabled"></span></span></li>
        @else
            <li class="left"><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><span class="icon icon-paginate-left"></span></a></li>
        @endif

        @foreach($elements as $element)
            @if(is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            @if(is_array($element))
                @foreach($element as $page => $url)
                    @if($page == $paginator->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if($paginator->hasMorePages())
            <li class="right"><a href="{{ $paginator->nextPageUrl() }}" rel="next"><span class="icon icon-paginate-right"></span></a></li>
        @else
            <li class="right disabled"><span><span class="icon icon-paginate-right-disabled"></span></span></li>
        @endif
    </ul>
@endif
