@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="media-manager gallery-manager" data-type="gallery" data-boss="{{$boss ?? 0}}">
            @include('throne.widgets.media_manager.gallery.index', ['type' => 'gallery'])
        </div>
    </div>
    <script>
        $(function(){
            $('.gallery-manager').mediaManager();
        });
    </script>
@stop