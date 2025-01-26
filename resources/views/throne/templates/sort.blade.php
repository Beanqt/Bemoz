@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'back' => route('throne.'.$service->default, isset($service->boss[1]) ? [$service->boss[1]] : []),
                'sortSave' => route('throne.'.$service->default.'.sort', isset($service->boss[1]) ? [$service->boss[1]] : []),
                'selectLanguage' => isset($service->lang) ? true : null
            ])
            <h1>@lang('admin.'.$service->default.'.title')</h1>
        </div>
        @if(isset($service->multi_order) && ${$service->default})
            <div class="dd" data-nested="{{$service->multi_order}}">
                <ol class="dd-list">
                    {!! ${$service->default} !!}
                </ol>
            </div>
        @elseif(!isset($service->multi_order) && count(${$service->default}))
            <div class="dd" data-nested="1">
                <ol class="dd-list">
                    @foreach(${$service->default} as $item)
                        <li class="dd-item dd3-item" data-id="{{$item['id']}}">
                            <div class="dd-handle dd3-handle fa">Drag</div>
                            <div class="dd3-content">{{$item['title']}}</div>
                        </li>
                    @endforeach
                </ol>
            </div>
        @else
            <div class="alert alert-info">@lang('admin.'.$service->default.'.not')</div>
        @endif
    </div>
@stop