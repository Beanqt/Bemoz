@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1>@lang('admin.logs.title')</h1>
        </div>
        <div class="box">
            <form method="post" class="default-form filterForm" data-url="{{route('throne.logs.api')}}">
                <div class="relativeBox">
                    <div class="loader loader-table"></div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="80">@lang('admin.logs.table.id')</th>
                                <th>@lang('admin.logs.table.name')</th>
                                <th>@lang('admin.logs.table.type_id')</th>
                                <th width="210">@lang('admin.logs.table.type')</th>
                                <th width="210">@lang('admin.logs.table.action')</th>
                                <th width="130">@lang('admin.logs.table.created_at')</th>
                            </tr>

                            <tr class="filter">
                                <th><input type="text" class="form-control" value="{{session('log_input_logs.id')}}" name="id"></th>
                                <th><input type="text" class="form-control" value="{{session('log_input_logs.name')}}" name="name"></th>
                                <th><input type="text" class="form-control" value="{{session('log_input_logs.element_id')}}" name="element_id"></th>
                                <th>
                                    <select name="type" class="form-control form-custom-select">
                                        <option value="" {{!session('log_input_logs.type') ? 'selected' : ''}}>@lang('admin.logs.table.all')</option>
                                        @foreach($types as $type)
                                            <option value="{{$type}}" {{session('log_input_logs.type') == $type ? 'selected' : ''}}>@lang('admin.'.str_replace('widget_', 'widget.', $type).'.title')</option>
                                        @endforeach
                                    </select>
                                </th>
                                <th>
                                    <select name="action" class="form-control form-custom-select">
                                        <option value="" {{!session('log_input_logs.action') ? 'selected' : ''}}>@lang('admin.logs.table.all')</option>
                                        @foreach($actions as $action)
                                            <option value="{{$action}}" {{session('log_input_logs.action') == $action ? 'selected' : ''}}>@lang('admin.logs.table.actions.'.$action)</option>
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
                            @include('throne.layouts.logs.content')
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
@stop