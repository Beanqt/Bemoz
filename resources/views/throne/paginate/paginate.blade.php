@if($paginator->hasPages())
    <tr class="paginate-tr">
        <td colspan="{{isset($col) ? $col : count($service->model->lists)+1}}">
            <ul class="pagination">
                @if($paginator->onFirstPage())
                    <li class="left disabled"><span>&laquo;</span></li>
                @else
                    <li class="left"><a href="{{$paginator->previousPageUrl()}}" class="default-link" rel="prev">&laquo;</a></li>
                @endif

                @foreach($elements as $element)
                    @if(is_string($element))
                        <li class="disabled"><span>{{$element}}</span></li>
                    @endif

                    @if(is_array($element))
                        @foreach($element as $page => $url)
                            @if($page == $paginator->currentPage())
                                <li class="active"><span>{{$page}}</span></li>
                            @else
                                <li><a href="{{$url}}" class="default-link">{{$page}}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if($paginator->hasMorePages())
                    <li class="right"><a href="{{$paginator->nextPageUrl()}}" class="default-link" rel="next">&raquo;</a></li>
                @else
                    <li class="right disabled"><span>&raquo;</span></li>
                @endif
            </ul>
        </td>
    </tr>
@endif
