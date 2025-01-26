<form method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="box">
        <div class="form-group {{$errors->has('old') ? 'has-error' : ''}}">
            <label for="old">@lang('admin.redirects.form.old')<span class="required">*</span></label>
            <input type="text" class="form-control" data-focus="true" name="old" id="old" value="{{$data['old'] ?? ''}}" required>
            <div class="help-block with-errors">
                {!! $errors->first('old', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group {{$errors->has('new') ? 'has-error' : ''}}">
            <label for="new">@lang('admin.redirects.form.new')<span class="required">*</span></label>
            <div class="input-group">
                <div class="input-group-addon">{{url('/')}}</div>
                <input type="text" class="form-control" name="new" id="new" value="{{$data['new'] ?? ''}}" required>
            </div>
            <div class="help-block with-errors">
                {!! $errors->first('new', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
    </div>
    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
        'saveNew' => true,
        'cancel' => route('throne.redirects'),
    ])
</form>