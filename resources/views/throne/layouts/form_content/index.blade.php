@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'permission' => 'form_content',
                'back' => route('throne.forms'),
                'new' => route('throne.form_content.new', $form),
            ])
            <h1>@lang('admin.form_content.title')</h1>
        </div>
        <div class="box">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th width="80">{{trans('admin.form_content.table.id')}}</th>
                    <th width="500">{{trans('admin.form_content.table.type')}}</th>
                    <th width="500">{{trans('admin.form_content.table.created_at')}}</th>
                    <th width="220">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                    @include('throne.layouts.form_content.content')
                </tbody>
            </table>
        </div>
    </div>
@stop