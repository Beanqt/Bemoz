@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'permission' => 'users',
                'new' => route('throne.users.new'),
                'export' => route('throne.users.export'),
            ])
            <h1>@lang('admin.users.title')</h1>
        </div>
        <div class="staticBoxs row">
            <div class="staticItem col-lg-2 col-sm-4 col-xs-12">
                <div class="box helpItem" data-help="usersHits">
                    <div class="huge result-reg">{{$reg}}</div>
                    <div>@lang('admin.users.table.reg')</div>
                </div>
            </div>
            <div class="staticItem col-lg-2 col-sm-4 col-xs-12">
                <div class="box helpItem" data-help="usersLoginNow">
                    <div class="huge result-login_now">{{$login_now}}</div>
                    <div>@lang('admin.users.table.login_now')</div>
                </div>
            </div>
        </div>
        <div class="box">
            <form method="post" class="default-form filterForm" data-url="{{route('throne.users.api')}}">
                <div class="relativeBox">
                    <div class="loader loader-table"></div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="80">@lang('admin.users.table.id')</th>
                                <th>@lang('admin.users.table.name')</th>
                                <th>@lang('admin.users.table.email')</th>
                                <th width="135">@lang('admin.users.table.group')</th>
                                <th>@lang('admin.users.table.last_login')</th>
                                <th>@lang('admin.users.table.created_at')</th>
                                <th width="160">&nbsp;</th>
                            </tr>

                            <tr class="filter">
                                <th><input type="text" class="form-control" value="{{session('log_input_users.id')}}" name="id"></th>
                                <th><input type="text" class="form-control" value="{{session('log_input_users.name')}}" name="name"></th>
                                <th><input type="text" class="form-control" value="{{session('log_input_users.email')}}" name="email"></th>
                                <th>
                                    <select class="form-control form-custom-select" name="group">
                                        <option value="" {{!session('log_input_users.group') ? 'selected' : ''}}>@lang('admin.users.table.groups.all')</option>
                                        <option value="1" {{session('log_input_users.group') == 1 ? 'selected' : ''}}>@lang('admin.users.table.groups.1')</option>
                                    </select>
                                </th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th class="text-right">
                                    @include('throne.widgets.actions', [
                                        'filter' => true,
                                    ])
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('throne.layouts.users.content')
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
@stop