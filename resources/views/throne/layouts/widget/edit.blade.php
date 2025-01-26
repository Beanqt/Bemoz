@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'back' => route('throne.widget'),
                'selectLanguage' => false,
            ])
            <h1>@lang('admin.widget.edit')</h1>
        </div>
        @include('throne.layouts.widget.forms.'.$widget)
    </div>
@stop