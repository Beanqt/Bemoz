<form method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="box">
        <div class="form-group {{$errors->has('password') ? 'has-error' : ''}}">
            <label for="password">@lang('admin.profile.password')</label>
            <input type="password" class="form-control" name="password" id="password">
            <div class="help-block with-errors">
                {!! $errors->first('password', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group {{$errors->has('password_confirmation') ? 'has-error' : ''}}">
            <label for="password_confirmation">@lang('admin.profile.password2')</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" data-match="#password" data-match-error="@lang('admin.alert.matchpassword')">
            <div class="help-block with-errors">
                {!! $errors->first('password_confirmation', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
    </div>
    <div class="box">
        <div class="form-group no-margin">
            <label for="tutorial">@lang('admin.profile.tutorial')</label><br>
            <label class="switch">
                <input type="checkbox" name="tutorial" id="tutorial" {{isset($data['tutorial']) && $data['tutorial'] ? 'checked' : ''}} {{auth()->guard('admin')->user()->tutorial ? 'checked' : ''}}>
                <span class="slider round"></span>
            </label>
        </div>
    </div>
    @if($tutorials)
        <label>@lang('admin.profile.complete.tutorial')</label>
        <div class="box">
            @foreach($tutorials as $key => $item)
                <div class="form-group">
                    <label class="switch">
                        <input type="checkbox" name="tutorials[{{$key}}]" id="tutorials[{{$key}}]" {{isset($data['tutorial']) && $data['tutorial'] ? 'checked' : ''}} checked>
                        <span class="slider round"></span>
                    </label>
                    <label style="margin-left: 10px;" for="tutorials[{{$key}}]">@lang('help.'.$key.'.title')</label>
                </div>
            @endforeach
        </div>
    @endif

    @include('throne.widgets.actions', [
        'save' => true,
    ])
</form>