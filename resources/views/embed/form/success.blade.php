@extends('layouts.master')

@section('content')
    <section>
        <div class="container">
            <div class="row page-content">
                <div class="col-md-10 col-md-offset-1 inside">
                    {!! $page['content'] !!}
                </div>
            </div>
        </div>
    </section>
@stop