<div class="feed-item clearfix">
    <div class="col-xs-4">
        <div class="img">
            <a href="{{route('feeds.item', ['category'=> $feed->categories->slug, 'slug' => $feed['slug']])}}">
                @include('partials.image', ['no_image' => 'no-feed-item.png', 'src' => '/uploads/feed_items/small-', 'item' => ['image' => $feed['image'], 'title' => $feed['title']]])
            </a>
        </div>
    </div>
    <div class="col-xs-8">
        <div class="info">
            <div class="title"><a href="{{route('feeds.item', ['category'=> $feed->categories->slug, 'slug' => $feed['slug']])}}">{{$feed['title']}}</a></div>
            @if(count($feed->labels))
                <ul class="labels">
                    @foreach($feed->labels as $label)
                        <li><a href="{{route('feeds.label', $label['slug'])}}">{{\Illuminate\Support\Str::lower($label['title'])}}</a></li>
                    @endforeach
                </ul>
            @endif
            <p class="public-at">{{replaceDate('Y.M.d',$feed['public_at'])}}. {{replaceDate('D',$feed['public_at'])}}</p>
            <div class="desc">{{$feed['short']}}</div>
        </div>
    </div>
</div>