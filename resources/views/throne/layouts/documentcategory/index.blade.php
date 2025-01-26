@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="media-manager document-manager" data-type="documents" data-boss="{{$boss ?? 0}}">
            @include('throne.widgets.media_manager.documents.index', ['type' => 'documents'])
        </div>
    </div>
    <script>
        $(function(){
            $('.document-manager').mediaManager();
        });
    </script>
@stop