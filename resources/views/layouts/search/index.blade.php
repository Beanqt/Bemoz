@extends('layouts.master')

@section('content')
    <section>
        <div class="container searchPage">
            <div class="col-sm-12">
                @include('partials.headline', ['title' => trans('public.search.head')])
                <div class="filter visible-xs">
                    <form method="post" autocomplete="off" novalidate="true" action="{{route('search')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="input-group">
                            <input type="text" class="form-control filterSearch" value="{{$value ?? ''}}" name="search">
                            <div class="input-group-addon searchButton"><button type="submit"><i class="fas fa-search"></i></button></div>
                        </div>
                    </form>
                </div>
                <div class="row pageBox">
                    @if(count($array))
                        <div class="col-md-3 col-sm-4">
                            <div class="rightBox">
                                <div class="categories-frame simple">
                                    <ul class="resultHit">
                                        @foreach($array as $key => $hit)
                                            <li><a href="#{{slug($key)}}">{{$key}} <span>{{$hit['count']}}</span></a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-{{count($array) ? 9 : 12}} col-sm-8">
                        <div class="filter hidden-xs">
                            <form method="post" autocomplete="off" novalidate="true" action="{{route('search')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="input-group">
                                    <input type="text" class="form-control filterSearch" value="{{$value ?? ''}}" name="search" placeholder="@lang('public.search.head')">
                                    <div class="input-group-addon searchButton"><button type="submit"><i class="fas fa-search"></i></button></div>
                                </div>
                            </form>
                        </div>
                        <div class="results">
                            @foreach($array as $key => $item)
                                @if(isset($item['items']))
                                    <div class="fakeId" id="{{slug($key)}}"></div>
                                    <h2 class="resultTitle">{{$key}}</h2>
                                    <div class="resultInside">
                                        @foreach($item['items'] as $i)
                                            <div class="resultItem">
                                                <h3 class="title"><a class="url" href="{{$i['url']}}">{{str_replace('<br>', ' ', $i['title'])}}</a></h3>
                                                <div class="desc">{!! $i['content'] !!}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(!empty($value))
        <script>
            ga('send', 'pageview', '{{route('search')}}?s={{$value}}');
        </script>
    @endif
@stop
