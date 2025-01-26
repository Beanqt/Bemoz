<div class="col-md-4 col-xs-6 inline-col feed-item-box">
    <div class="inside">
        @include('partials.image', ['no_image' => 'no-feed-item.png', 'src' => '/uploads/feed_items/small-', 'item' => ['image' => $feed['image'], 'title' => $feed['title']]])

        <div class="info">
            <a href="{{route('feeds.item', ['category'=> $feed->categories->slug, 'slug' => $feed['slug']])}}">
                <div class="title">{{$feed['title']}}</div>
            </a>
        </div>
    </div>
</div>