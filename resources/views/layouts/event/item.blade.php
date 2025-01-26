@extends('layouts.master')

@section('start_content')
    <div class="time-frame">
        @if(isset($event['event_start']))
            <div>@lang('public.events.start')<span>{{$event['event_start']}}</span></div>
        @endif
        @if(isset($event['event_end']))
            <div>@lang('public.events.end')<span>{{$event['event_end']}}</span></div>
        @endif
        @if(isset($event['place']))
            <div>@lang('public.events.place')<span>{{$event['place']}}</span></div>
        @endif
    </div>
    <b>{{$event['short']}}</b><br><br>
@stop
@section('content')
    <section class="default">
        @include('partials.template', ['document' => $event])
    </section>
@stop