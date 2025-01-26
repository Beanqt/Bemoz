@extends('layouts.master')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @include('partials.headline', ['title' => trans('public.events.title')])

                    <div class="calendar">
                        <div class="calendarControl">
                            <div class="row">
                                <div id="first_day" class="col-lg-4 col-md-2 col-sm-3 currentDate"></div>
                                <div class="col-lg-8 col-md-10 col-sm-9">
                                    <div class="text-right">
                                        <div class="btn-group btn-group-gray">
                                            <button class="btn btn-calendar prebutton button" data-calendar-nav="prev">@lang('public.events.prev')</button>
                                            <button class="btn btn-calendar defbutton button" data-calendar-nav="today">@lang('public.events.today')</button>
                                            <button class="btn btn-calendar pributton button" data-calendar-nav="next">@lang('public.events.next')</button>
                                        </div>
                                        <div class="btn-group btn-group-blue">
                                            <button class="btn btn-calendar yearbutton" data-calendar-view="year">@lang('public.events.year')</button>
                                            <button class="btn btn-calendar active monthbutton" data-calendar-view="month">@lang('public.events.month')</button>
                                            <button class="btn btn-calendar weekbutton" data-calendar-view="week">@lang('public.events.week')</button>
                                            <button class="btn btn-calendar daybutton" data-calendar-view="day">@lang('public.events.day')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="calendar" data-category="{{$category}}"></div>
                    </div>
                </div>
            </div>
            @if(count($events) > 0)
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 events">
                        @foreach($events as $event)
                            @include('layouts.event._item')
                        @endforeach
                        {!! $events->links('paginate.paginate') !!}
                    </div>
                </div>
            @else
                <br>
            @endif
        </div>
    </section>

    <script src="/assets/scripts/vendor/bootstrap-calendar/language/{{App::getLocale()}}-{{strtoupper(App::getLocale())}}.js"></script>
    <script src="/assets/scripts/vendor/underscore/underscore.js"></script>
    <script src="/assets/scripts/vendor/bootstrap-calendar/calendar.js"></script>
    <script src="/assets/scripts/vendor/bootstrap-calendar/_calendar.js"></script>
@stop