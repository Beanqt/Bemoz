@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'permission' => 'events',
                'new' => route('throne.events.new'),
                'trash' => [
                    'url' => route('throne.events.trash'),
                    'count' => $trash
                ],
                'selectLanguage' => true,
            ])
            <h1>@lang('admin.events.title')</h1>
        </div>
        <div class="box">
            <form method="post" class="default-form filterForm" data-url="{{route('throne.events.api')}}">
                <div class="relativeBox">
                    <div class="loader loader-table"></div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="100">@lang('admin.events.table.id')</th>
                                <th>@lang('admin.events.table.title')</th>
                                <th width="210">@lang('admin.events.table.category.title')</th>
                                <th width="280">&nbsp;</th>
                            </tr>

                            <tr class="filter">
                                <th><input type="text" class="form-control" value="{{session('log_input_events.id')}}" name="id"></th>
                                <th><input type="text" class="form-control" value="{{session('log_input_events.title')}}" name="title"></th>
                                <th>
                                    <select class="form-control form-custom-select" name="category">
                                        <option value="" {{!session('log_input_events.category') ? 'selected' : ''}}>@lang('admin.events.table.category.all')</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category['id']}}" {{session('log_input_events.category') == $category['id'] ? 'selected' : ''}}>{{$category['title']}}</option>
                                        @endforeach
                                    </select>
                                </th>
                                <th class="text-right">
                                    @include('throne.widgets.actions', [
                                        'filter' => true,
                                    ])
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('throne.layouts.events.content')
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
@stop