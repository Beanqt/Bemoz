@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'permission' => 'widget',
                'new' => route('throne.widget.new'),
                'trash' => [
                    'url' => route('throne.widget.trash'),
                    'count' => $trash
                ],
                'selectLanguage' => true,
            ])
            <h1>@lang('admin.widget.title')</h1>
        </div>
        <div class="box">
            <form method="post" class="default-form filterForm" data-url="{{route('throne.widget.api')}}">
                <div class="relativeBox">
                    <div class="loader loader-table"></div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="150">@lang('admin.widget.table.id')</th>
                                <th width="310">@lang('admin.widget.table.title')</th>
                                <th width="210">@lang('admin.widget.table.type.title')</th>
                                <th width="346">&nbsp;</th>
                            </tr>

                            <tr class="filter">
                                <th><input type="text" class="form-control" value="{{session('log_input_widget.id')}}" name="id"></th>
                                <th><input type="text" class="form-control" value="{{session('log_input_widget.title')}}" name="title"></th>
                                <th>
                                    <select class="form-control form-custom-select" name="type">
                                        <option value="" {{!session('log_input_widget.type') ? 'selected' : ''}}>@lang('admin.widget.table.type.all')</option>
                                        <option {{session('log_input_widget.type') == 'box_list' ? 'selected' : ''}} value="box_list">@lang('admin.widget.box_list.title')</option>
                                        <option {{session('log_input_widget.type') == 'category' ? 'selected' : ''}} value="category">@lang('admin.widget.category.title')</option>
                                        <option {{session('log_input_widget.type') == 'counter' ? 'selected' : ''}} value="counter">@lang('admin.widget.counter.title')</option>
                                        <option {{session('log_input_widget.type') == 'parallax' ? 'selected' : ''}} value="parallax">@lang('admin.widget.parallax.title')</option>
                                        <option {{session('log_input_widget.type') == 'faq' ? 'selected' : ''}} value="faq">@lang('admin.widget.faq.title')</option>
                                        <option {{session('log_input_widget.type') == 'tab' ? 'selected' : ''}} value="tab">@lang('admin.widget.tab.title')</option>
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
                            @include('throne.layouts.widget.content')
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
@stop