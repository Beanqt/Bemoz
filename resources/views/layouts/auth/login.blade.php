@extends('layouts.master')

@section('content')
    <section class="big-padding">
        <div class="container">
            <div class="row form-box">
                @include('layouts.auth._login')
            </div>
        </div>
    </section>
@stop