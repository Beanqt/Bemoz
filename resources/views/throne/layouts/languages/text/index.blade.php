@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'permission' => 'languages',
                'back' => route('throne.languages'),
            ])
            <h1>@lang('admin.translates.title')</h1>
        </div>
        <div class="box">
            <form method="post" class="default-form filterForm" data-url="{{route('throne.language_text.api')}}">
                <div class="relativeBox">
                    <div class="loader loader-table"></div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>@lang('admin.translates.table.name')</th>
                                <th>@lang('admin.translates.table.text')</th>
                                <th width="160">&nbsp;</th>
                            </tr>
                            <tr class="filter">
                                <th><input type="text" class="form-control" value="{{session('log_input_language_text.item')}}" name="item"></th>
                                <th><input type="text" class="form-control" value="{{session('log_input_language_text.text')}}" name="text"></th>
                                <th class="text-right">
                                    @include('throne.widgets.actions', [
                                        'filter' => true,
                                    ])
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('throne.layouts.languages.text.content')
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
@stop