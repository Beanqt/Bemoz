@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'permission' => 'menu',
                'new' => route('throne.menu.new', $type),
                'sort' => route('throne.menu.sort', $type),
                'trash' => [
                    'url' => route('throne.menu.trash', $type),
                    'count' => $trash
                ],
                'selectLanguage' => true,
            ])
            <h1>@lang('admin.menu.'.$type)</h1>
        </div>
        <ol class="dd-list nodrag">
            {!! $menu !!}
        </ol>
    </div>
@stop