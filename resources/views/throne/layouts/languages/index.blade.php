@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'permission' => 'languages',
                'new' => route('throne.languages.new'),
                'sort' => route('throne.languages.sort'),
                'publish' => route('throne.languages.publish'),
                'text' => route('throne.language_text'),
            ])
            <h1>@lang('admin.languages.title')</h1>
        </div>
        <div class="box">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>@lang('admin.languages.table.name')</th>
                        <th>@lang('admin.languages.table.locale')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($languages as $item)
                        <tr>
                            <td>{{$item['name']}}</td>
                            <td>{{$item['locale']}}</td>
                            <td class="text-right">
                                @include('throne.widgets.actions', [
                                    'permission' => 'languages',
                                    'status' => route('throne.languages.status', $item['id']),
                                    'edit' => route('throne.languages.edit', $item['id']),
                                    'delete' => route('throne.languages.delete', $item['id']),
                                ])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop