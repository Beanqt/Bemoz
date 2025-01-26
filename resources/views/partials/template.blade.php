@if($template == 1)
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                {!! app("MenuService")->left() !!}
            </div>
            <div class="col-md-9">
                @include('partials.headline', ['title' => str_replace('<br>', ' ', $document['title'])])
                @if(isset($document->labels) && $document->labels)
                    <div class="info-data">
                        <ul class="labels">
                            @foreach($document->labels as $label)
                                <li><a href="{{route((isset($label_route_name) ? $label_route_name : 'feeds.label'), $label['slug'])}}">{{$label['title']}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="page-content">
                    @section('start_content')
                    @show
                    {!! $document['content'] !!}
                    @section('end_content')
                    @show
                </div>
            </div>
        </div>
    </div>
@else
    <div class="container">
        @include('partials.headline', ['title' => str_replace('<br>', ' ', $document['title'])])
        @if(isset($document->labels) && $document->labels)
            <div class="info-data">
                <ul class="labels">
                    @foreach($document->labels as $label)
                        <li><a href="{{route((isset($label_route_name) ? $label_route_name : 'feeds.label'), $label['slug'])}}">{{$label['title']}}</a></li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="page-content">
        @section('start_content')
        @show
        {!! $document['content'] !!}
        @section('end_content')
        @show
    </div>
@endif