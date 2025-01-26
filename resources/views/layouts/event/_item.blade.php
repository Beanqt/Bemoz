<div class="event-item clearfix">
    <div class="col-sm-4">
        <a href="{{route('event.item', ['category'=> $event->categories->slug, 'slug' => $event['slug']])}}">
            @include('partials.image', ['no_image' => 'no-feed-item.png', 'src' => '/uploads/events/small-', 'item' => ['image' => $event['image'], 'title' => $event['title']]])
        </a>
    </div>
    <div class="col-sm-8 info">
        <div class="title"><a href="{{route('event.item', ['category'=> $event->categories->slug, 'slug' => $event['slug']])}}">{{$event['title']}}</a></div>
        <ul class="eventData">
            <li>{{date('Y-m-d', strtotime($event['event_start']))}}</li>
            <li>{{date('H:i', strtotime($event['event_start']))}}</li>
            <li>{{$event['place']}}</li>
        </ul>
        <div class="desc">{{$event['short']}}</div>
        <a href="{{route('event.item', ['category'=> $event->categories->slug, 'slug' => $event['slug']])}}" class="btn btn-default">@lang('public.events.more')</a>
    </div>
</div>