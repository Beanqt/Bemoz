<form method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="box">
        <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
            <label for="name">@lang('admin.languages.form.name')<span class="required">*</span></label>
            <input type="text" class="form-control" data-focus="true" name="name" id="name" value="{{$data['name'] ?? ''}}" required>
            <div class="help-block with-errors">
                {!! $errors->first('name', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group {{$errors->has('locale') ? 'has-error' : ''}}">
            <label for="locale">@lang('admin.languages.form.locale')<span class="required">*</span></label>
            <input type="text" class="form-control" name="locale" id="locale" value="{{$data['locale'] ?? ''}}" required>
            <div class="help-block with-errors">
                {!! $errors->first('locale', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
    </div>

    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
        'saveNew' => true,
        'cancel' => route('throne.languages'),
    ])
</form>