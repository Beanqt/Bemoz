@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'permission' => 'partner_items',
                'new' => route('throne.partner_items.new'),
                'sort' => route('throne.partner_items.sort'),
                'trash' => [
                    'url' => route('throne.partner_items.trash'),
                    'count' => $trash
                ],
            ])
            <h1>@lang('admin.partner_items.title')</h1>
        </div>
        <div class="box">
            <form method="post" class="default-form filterForm" data-url="{{route('throne.partner_items.api')}}">
                <div class="relativeBox">
                    <div class="loader loader-table"></div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="100">@lang('admin.partner_items.table.id')</th>
                                <th>@lang('admin.partner_items.table.title')</th>
                                <th width="210">@lang('admin.partner_items.table.category.title')</th>
                                <th width="280">&nbsp;</th>
                            </tr>

                            <tr class="filter">
                                <th><input type="text" class="form-control" value="{{session('log_input_partner_items.id')}}" name="id"></th>
                                <th><input type="text" class="form-control" value="{{session('log_input_partner_items.title')}}" name="title"></th>
                                <th>
                                    <select class="form-control form-custom-select" name="category">
                                        <option value="" {{!session('log_input_partner_items.category') ? 'selected' : ''}}>@lang('admin.partner_items.table.category.all')</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category['id']}}" {{session('log_input_partner_items.category') == $category['id'] ? 'selected' : ''}}>{{$category['title']}}</option>
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
                            @include('throne.layouts.partner_items.content')
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
@stop