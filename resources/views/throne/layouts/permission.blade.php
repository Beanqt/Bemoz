@extends('throne.partials.master')

@section('content')
    <div class="container">
        <h1 class="page-header">@lang('admin.notPermission.title')</h1>
        <div class="box">
            @lang('admin.notPermission.text')
        </div>
    </div>
@stop