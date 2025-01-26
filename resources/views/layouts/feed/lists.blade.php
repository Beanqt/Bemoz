@extends('layouts.master')

@section('content')
    <section>
        <div class="container feed-lists">
            <div class="row">
                <div class="col-md-3">
                    {!! app("MenuService")->left() !!}
                </div>
                <div class="col-md-9">
                    @include('partials.headline', ['title' => isset($category['title']) ? $category['title'] : trans('public.feeds.title')])
                    <div class="row list-content text-center">
                        @include('layouts.feed._content')
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop