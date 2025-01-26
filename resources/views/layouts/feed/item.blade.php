@extends('layouts.master')

@section('start_content')
    <b>{{$data['short']}}</b><br><br>
@stop
@section('content')
    <section>
        @if(!empty($data['bg_image']))
            <div class="bg-image">
                <img class="img-responsive" src="/uploads/feed_items/bg/small-{{$data['bg_image']}}" alt="{{$data['title']}}">
            </div>
        @endif
        @include('partials.template', ['document' => $data])
    </section>
@stop