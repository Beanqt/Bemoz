@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1>@lang('admin.caches.title')</h1>
        </div>
        <div class="box">
            <form method="post" class="filterForm" data-url="{{route('throne.caches.api')}}">
                <div class="relativeBox">
                    <div class="loader loader-table"></div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>@lang('admin.caches.table.key')</th>
                                <th>@lang('admin.caches.table.created_at')</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('throne.layouts.caches.content')
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
@stop