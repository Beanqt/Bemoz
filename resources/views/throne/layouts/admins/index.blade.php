@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'permission' => 'admins',
                'new' => route('throne.admins.new'),
            ])
            <h1>@lang('admin.admins.users')</h1>
        </div>
        <div class="box">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>@lang('admin.admins.table.name')</th>
                        <th>@lang('admin.admins.table.email')</th>
                        <th>@lang('admin.admins.table.permission')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($admins as $item)
                    <tr {!! is_null($item['ban']) ? '' : 'class="danger"' !!}>
                        <td>{{$item['name']}}</td>
                        <td>{{$item['email']}}</td>
                        <td>{{$item->permissions->title ?? ''}}</td>
                        <td class="text-right">
                            @include('throne.widgets.actions', [
                                'permission' => 'admins',
                                is_null($item['ban']) ? '' : 'ban' => route('throne.admins.ban', $item['id']),
                                'edit' => route('throne.admins.edit', $item['id']),
                                'delete' => route('throne.admins.delete', $item['id']),
                            ])
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop