@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'back' => route('throne.'.$service->default, isset($service->boss[1]) ? [$service->boss[1]] : []),
                'selectLanguage' => isset($service->lang) ? true : null
            ])
            <h1>@lang('admin.'.$service->default.'.new')</h1>
        </div>

        @if(View::exists('throne.layouts.'.$service->default.'.form'))
            @include('throne.layouts.'.$service->default.'.form')
        @else
            @include('throne.templates.form')
        @endif
    </div>
@stop