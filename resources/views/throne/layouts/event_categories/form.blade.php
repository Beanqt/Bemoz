<form method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="box">
        <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
            <label for="title">@lang('admin.event_categories.form.title')<span class="required">*</span></label>
            <input type="text" class="form-control" data-focus="true" name="title" id="title" value="{{$data['title'] ?? ''}}" required>
            <div class="help-block with-errors">
                {!! $errors->first('title', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group {{$errors->has('slug') ? 'has-error' : ''}}">
            <label for="slug">@lang('admin.event_categories.form.slug')<span class="required">*</span></label>
            <input type="text" class="form-control" name="slug" id="slug" value="{{$data['slug'] ?? ''}}" required>
            <div class="help-block with-errors">
                {!! $errors->first('slug', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group {{$errors->has('color') ? 'has-error' : ''}}">
            <label for="color">{{trans('admin.event_categories.form.color')}}</label>
            <div class="input-group color-picker">
                <span class="input-group-addon"><i></i></span>
                <input type="text" class="form-control" name="color" id="color" value="{{$data['color'] ?? '#ed1c24'}}">
            </div>
            <div class="help-block with-errors">
                {!! $errors->first('color', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group {{$errors->has('color2') ? 'has-error' : ''}}">
            <label for="color2">{{trans('admin.event_categories.form.color2')}}</label>
            <div class="input-group color-picker">
                <span class="input-group-addon"><i></i></span>
                <input type="text" class="form-control" name="color2" id="color2" value="{{$data['color2'] ?? '#fff'}}">
            </div>
            <div class="help-block with-errors">
                {!! $errors->first('color2', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
    </div>

    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
        'saveNew' => true,
        'cancel' => route('throne.event_categories'),
    ])
</form>
