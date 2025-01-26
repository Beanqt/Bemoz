@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1>@lang('admin.profile.edit')</h1>
        </div>
        @include('throne.layouts.profile.form')
    </div>
@stop