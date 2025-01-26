@extends('layouts.master')

@section('content')
    <section>
        @include('partials.template', ['document' => $page])
    </section>
@stop