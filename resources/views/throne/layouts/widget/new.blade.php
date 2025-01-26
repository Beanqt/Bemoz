@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'back' => route('throne.widget'),
                'selectLanguage' => false,
            ])
            <h1>@lang('admin.widget.new')</h1>
        </div>
        <form method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="box">
                <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
                    <label for="title">@lang('admin.widget.form.title')<span class="required">*</span></label>
                    <input type="text" class="form-control" data-focus="true" name="title" id="title" value="{{$data['title'] ?? ''}}" required>

                    <div class="help-block with-errors">
                        {!! $errors->first('title', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
                <div class="form-group no-margin {{$errors->has('type') ? 'has-error' : ''}}">
                    <label for="type">@lang('admin.widget.form.type.title')</label>
                    <select class="form-control form-custom-select" name="type" id="type" required>
                        <option value="" selected>@lang('admin.widget.form.type.select')</option>
                        <option value="box_list">@lang('admin.widget.box_list.title')</option>
                        <option value="category">@lang('admin.widget.category.title')</option>
                        <option value="counter">@lang('admin.widget.counter.title')</option>
                        <option value="parallax">@lang('admin.widget.parallax.title')</option>
                        <option value="tab">@lang('admin.widget.tab.title')</option>
                        <option value="faq">@lang('admin.widget.faq.title')</option>
                        @if(setting('map'))
                            <option value="map">@lang('admin.widget.map.title')</option>
                        @endif
                    </select>

                    <div class="help-block with-errors">
                        {!! $errors->first('type', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">@lang('admin.btn.next')</button>
        </form>
    </div>
@stop