@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1>@lang('admin.fixedcontent.title')</h1>
        </div>
        <div class="box">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>@lang('admin.fixedcontent.table.title')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fixedcontent as $item)
                        <tr>
                            <td>{{getLangString($item['title'], true)}}</td>
                            <td class="text-right">
                                @include('throne.widgets.actions', [
                                    'permission' => 'fixedcontent',
                                    'edit' => route('throne.fixedcontent.edit', $item['id']),
                                ])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop