@extends('layouts.master')

@section('content')
    <section>
        <div class="container">
            <h1 class="text-center">@lang('public.404.title')</h1>
            <div class="page-content text-center">
                <p>@lang('public.404.content')</p>
            </div>
        </div>
    </section>
@stop