@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'back' => route('throne.'.$service->default, isset($service->boss[1]) ? [$service->boss[1]] : []),
                'selectLanguage' => isset($service->lang) ? true : null
            ])
            <h1>@lang('admin.trash.title')</h1>
        </div>
        <div class="box">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        @foreach($service->model->lists as $item)
                            <th{!! $item == 'id' ? ' width="100"' : '' !!}>@lang('admin.'.$service->default.'.table.'.$item)</th>
                        @endforeach
                        <th>@lang('admin.'.$service->default.'.table.deleted_at')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count(${$service->default}))
                        @foreach(${$service->default} as $item)
                            <tr>
                                @foreach($service->model->lists as $list)
                                    <td>{{$list == 'id' ? '#' : ''}}{{$item[$list] ?? ''}}</td>
                                @endforeach
                                <td>{{$item['deleted_at']}}</td>
                                <td class="text-right">
                                    @include('throne.widgets.actions', [
                                        'permission' => $service->default,
                                        'restore' => route('throne.'.$service->default.'.trash.restore', isset($service->boss[1]) ? [$service->boss[1], $item['id']] : $item['id']),
                                        'forceDelete' => route('throne.'.$service->default.'.trash.delete', isset($service->boss[1]) ? [$service->boss[1], $item['id']] : $item['id']),
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="{{count($service->model->lists)+2}}">@lang('admin.trash.not')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop