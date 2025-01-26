@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'back' => route('throne.languages'),
                'sortSave' => route('throne.languages.sort'),
            ])
            <h1>@lang('admin.languages.title')</h1>
        </div>
        @if(count($languages))
            <div class="dd" data-nested="1">
                <ol class="dd-list">
                    @foreach($languages as $language)
                        <li class="dd-item dd3-item" data-id="{{$language['id']}}">
                            <div class="dd-handle dd3-handle fas">Drag</div>
                            <div class="dd3-content">{{$language['name']}}</div>
                        </li>
                    @endforeach
                </ol>
            </div>
        @else
            <div class="alert alert-info">@lang('admin.languages.not')</div>
        @endif
    </div>
@stop