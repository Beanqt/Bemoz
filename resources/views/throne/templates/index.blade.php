@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'permission' => $service->default,
                'back' => isset($service->main_model) ? route('throne.'.$service->main_model) : '',
                'new' => Route::has('throne.'.$service->default.'.new') ? route('throne.'.$service->default.'.new', isset($service->boss[1]) ? [$service->boss[1]] : []) : '',
                'sort' => Route::has('throne.'.$service->default.'.sort') && !isset($service->uploads) ? route('throne.'.$service->default.'.sort', isset($service->boss[1]) ? [$service->boss[1]] : []) : '',
                'sortSave' => isset($service->uploads) ? route('throne.'.$service->default.'.sort', isset($service->boss[1]) ? [$service->boss[1]] : []) : '',
                'export' => Route::has('throne.'.$service->default.'.export') ? route('throne.'.$service->default.'.export', isset($service->boss[1]) ? [$service->boss[1]] : []) : '',
                'trash' => isset($trash) ? [
                    'url' => route('throne.'.$service->default.'.trash', isset($service->boss[1]) ? [$service->boss[1]] : []),
                    'count' => $trash
                ] : '',
                'selectLanguage' => isset($service->lang) ? true : null
            ])
            <h1>@lang('admin.'.$service->default.'.title')</h1>
        </div>
        @include('throne.widgets.stats')

        @if(isset($service->multi_order))
            <ol class="dd-list nodrag">
                {!! ${$service->default} !!}
            </ol>
        @elseif(isset($service->uploads))
            @if(can($service->default.'.new'))
                @include('throne.widgets.dropzone', ['url' => route('throne.'.$service->default.'.fileUpload', isset($service->boss[1]) ? [$service->boss[1]] : [])])
            @endif
            <div class="{{can($service->default.'.edit') ? 'dd':''}}" data-nested="1" data-drag="dd-dragel dd-drag">
                <ol class="dd-list dd-box fileContent">
                    @if(View::exists('throne.layouts.'.$service->default.'._item'))
                        @foreach(${$service->default} as $item)
                            @include('throne.layouts.'.$service->default.'._item')
                        @endforeach
                    @else
                        @foreach(${$service->default} as $item)
                            @include('throne.templates._item')
                        @endforeach
                    @endif
                </ol>
            </div>
        @else
            <div class="box">
                <form method="post" class="default-form filterForm" {!! Route::has('throne.'.$service->default.'.api') ? 'data-url="'.route('throne.'.$service->default.'.api', isset($service->boss[1]) ? [$service->boss[1]] : []).'"' : ''!!}>
                    <div class="relativeBox">
                        <div class="loader loader-table"></div>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    @foreach($service->model->lists as $item)
                                        <th{!! $item == 'id' ? ' width="100"' : '' !!}>
                                            @lang('admin.'.$service->default.'.table.'.$item)
                                            @if($item == 'created_at')
                                                <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{trans('admin.info.created_at')}}"></i>
                                            @endif
                                        </th>
                                    @endforeach
                                    <th width="280">&nbsp;</th>
                                </tr>
                                @if(Route::has('throne.'.$service->default.'.api'))
                                    <tr class="filter">
                                        @foreach($service->model->lists as $item)
                                            <?php $array = explode('.', $item); ?>

                                            @if(count($array) == 1)
                                                <th><input type="text" class="form-control" value="{{session('log_input_'.$service->default.'.'.$item)}}" name="{{$item}}"></th>
                                            @elseif(method_exists(${$service->default}->first(), $array[0]) && ($current_item = ${$service->default}->first()->{$array[0]}()->getRelated()))
                                                <th width="200px">
                                                    @if(class_basename($current_item) == 'Collection')
                                                        <select class="form-control form-custom-select" name="{{$item}}">
                                                            <option value="" {{!session('log_input_'.$service->default.'.'.$item) ? 'selected' : ''}}>@lang('admin.'.$service->default.'.table.'.$array[0].'.all')</option>
                                                            @if(count($current_item))
                                                                @foreach((isset($current_lang) ? $current_item->first()->where('lang', $current_lang['id'])->pluck($array[1], 'id')->all() : $current_item->first()->pluck($array[1], 'id')->all()) as $key => $select)
                                                                    <option value="{{$key}}" {{session('log_input_'.$service->default.'.'.$item) == $key ? 'selected' : ''}}>{{$select}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    @else
                                                        <select class="form-control form-custom-select" data-search="true" name="{{$item}}">
                                                            <option value="" {{!session('log_input_'.$service->default.'.'.$item) ? 'selected' : ''}}>@lang('admin.'.$service->default.'.table.'.$array[0].'.all')</option>
                                                            @foreach((isset($current_lang) ? $current_item->where('lang', $current_lang['id'])->pluck($array[1], 'id')->all() : $current_item->pluck($array[1], 'id')->all()) as $key => $select)
                                                                <option value="{{$key}}" {{session('log_input_'.$service->default.'.'.$item) == $key ? 'selected' : ''}}>{{$select}}</option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                </th>
                                            @else
                                                <th>&nbsp;</th>
                                            @endif
                                        @endforeach
                                        <th class="text-right">
                                            @include('throne.widgets.actions', [
                                                'filter' => true,
                                            ])
                                        </th>
                                    </tr>
                                @endif
                            </thead>
                            <tbody>
                                @if(View::exists('throne.layouts.'.$service->default.'.content'))
                                    @include('throne.layouts.'.$service->default.'.content')
                                @else
                                    @include('throne.templates.content')
                                @endif
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        @endif
    </div>
@stop