<div class="feed-lists-inside">
    @foreach($feeds as $feed)
        @include('layouts.feed._item')
    @endforeach
</div>

{!! $feeds->withPath(route('api.feeds.page'))->links('paginate.paginate') !!}
