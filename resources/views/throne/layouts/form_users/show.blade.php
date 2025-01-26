@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'back' => route('throne.form_users', $form),
            ])
            <h1>@lang('admin.form_users.show')</h1>
        </div>
        <div class="box">
            @foreach($data['data'] as $key => $item)
                @if(!is_array($item))
                    {{$key}}: <b>{{$item}}</b><br>
                @endif
            @endforeach
        </div>
        @include('throne.widgets.actions', [
            'cancel' => route('throne.form_users', $form),
        ])
    </div>
@stop