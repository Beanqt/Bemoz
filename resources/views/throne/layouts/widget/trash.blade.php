@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'back' => route('throne.widget'),
                'selectLanguage' => false,
            ])
            <h1>@lang('admin.trash.title')</h1>
        </div>
        <div class="box">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="100">@lang('admin.widget.table.id')</th>
                        <th>@lang('admin.widget.table.title')</th>
                        <th>@lang('admin.widget.table.type.title')</th>
                        <th>@lang('admin.widget.table.deleted_at')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($widget))
                        @foreach($widget as $item)
                            <tr>
                                <td>#{{$item['id']}}</td>
                                <td>{{$item['title']}}</td>
                                <td>@lang('admin.widget.'.$item['type'].'.title')</td>
                                <td>{{$item['deleted_at']}}</td>
                                <td class="text-right">
                                    <a href="{{route('throne.widget.trash.restore', $item['id'])}}" class="btn btn-info btn-xs btn-load" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.again')"><i class="fas fa-sync-alt"></i></a>
                                    <a href="{{route('throne.widget.trash.delete', $item['id'])}}" class="btn btn-danger btn-xs btn-load" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.forceDelete')"><i class="far fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">@lang('admin.trash.not')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop