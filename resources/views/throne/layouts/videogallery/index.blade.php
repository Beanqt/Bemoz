@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="media-manager video-manager" data-type="video" data-boss="{{$boss ?? 0}}">
            @include('throne.widgets.media_manager.video.index', ['type' => 'video'])
        </div>
    </div>
    <script>
        $(function(){
            $('.video-manager').mediaManager();
        });
    </script>
@stop