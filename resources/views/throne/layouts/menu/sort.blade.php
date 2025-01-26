@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'back' => route('throne.menu', $type),
                'sortSave' => route('throne.menu.sort', $type),
                'selectLanguage' => false,
            ])
            <h1>@lang('admin.menu.title')</h1>
        </div>
        @if($menu)
            <div class="dd" data-nested="{{$type =='footer' ? 1 : ($type == "side" ? 7 : 2)}}">
                <ol class="dd-list">
                    {!! $menu !!}
                </ol>
            </div>
        @else
            <div class="alert alert-info">@lang('admin.menu.not')</div>
        @endif
    </div>
@stop