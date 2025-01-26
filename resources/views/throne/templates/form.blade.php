<form method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="box">
        <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
            <label for="title">@lang('admin.'.$service->default.'.form.title')<span class="required">*</span></label>
            <input type="text" class="form-control" data-focus="true" name="title" id="title" value="{{$data['title'] ?? ''}}" required>
            <div class="help-block with-errors">
                {!! $errors->first('title', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group {{$errors->has('slug') ? 'has-error' : ''}}">
            <label for="slug">@lang('admin.'.$service->default.'.form.slug')<span class="required">*</span></label>
            <input type="text" class="form-control" name="slug" id="slug" value="{{$data['slug'] ?? ''}}" required>
            <div class="help-block with-errors">
                {!! $errors->first('slug', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
    </div>

    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
        'saveNew' => true,
        'cancel' => route('throne.'.$service->default, isset($boss) ? [$boss] : []),
    ])
</form>
