<form method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="box">
        <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
            <label for="name">@lang('admin.users.form.name')<span class="required">*</span></label>
            <input type="text" class="form-control" data-focus="true" name="name" id="name" value="{{$data['name'] ?? ''}}" required>
            <div class="help-block with-errors">
                {!! $errors->first('name', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group {{$errors->has('email') ? 'has-error' : ''}}">
            <label for="email">@lang('admin.users.form.email')<span class="required">*</span></label>
            <input type="email" class="form-control" name="email" id="email" value="{{$data['email'] ?? ''}}" required>
            <div class="help-block with-errors">
                {!! $errors->first('email', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group {{$errors->has('password') ? 'has-error' : ''}}">
            <label for="password">@lang('admin.users.form.password'){!! isset($edit) ? '' : '<span class="required">*</span>' !!}</label>
            <div class="input-group">
                <input type="password" class="form-control" name="password" id="password" {{isset($edit) ? '' : 'required'}}>
                <div class="input-group-addon generate" style="cursor: pointer;" title="@lang('admin.admins.form.generate')"><i class="fas fa-cogs"></i></div>
            </div>
            <div class="help-block with-errors">
                {!! $errors->first('password', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group {{$errors->has('password_confirmation') ? 'has-error' : ''}}">
            <label for="password2">@lang('admin.users.form.password_confirmation'){!! isset($edit) ? '' : '<span class="required">*</span>' !!}</label>
            <input type="password" class="form-control" name="password_confirmation" id="password2" data-match="#password" data-match-error="@lang('admin.alert.password_confirmed')" {{isset($edit) ? '' : 'required'}}>
            <div class="help-block with-errors">
                {!! $errors->first('password_confirmation', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group {{$errors->has('phone') ? 'has-error' : ''}}">
            <label for="phone">@lang('admin.users.form.phone') <small>(06xxxxxxxxx)</small></label>
            <input type="text" class="form-control" name="phone" id="phone" value="{{$data['phone'] ?? ''}}" pattern="^06+[0-9]{9}$">
            <div class="help-block with-errors">
                {!! $errors->first('phone', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group {{$errors->has('group') ? 'has-error' : ''}}">
            <label for="group">@lang('admin.users.form.group.title')<span class="required">*</span></label>
            <select class="form-control form-custom-select" name="group" id="group" required>
                <option value="" {{!isset($data['group']) || (isset($data['group']) && empty($data['group'])) ? 'selected' : ''}}>@lang('admin.users.form.group.placeholder')</option>
                <option value="1" {{isset($data['group']) && $data['group'] == 1 ? 'selected' : ''}}>@lang('admin.users.form.group.1')</option>
            </select>
            <div class="help-block with-errors">
                {!! $errors->first('group', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <label for="send_email">@lang('admin.users.form.send_email')</label><br>
        <label class="switch">
            <input type="checkbox" name="send_email" id="send_email" {{isset($data['send_email']) && $data['send_email'] ? 'checked' : (!isset($data['send_email']) ? 'checked' : '')}}>
            <span class="slider round"></span>
        </label>
    </div>

    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
        'saveNew' => true,
        'cancel' => route('throne.users'),
    ])
</form>

<script>
    $('document').ready(function(){
        $('.generate').click(function(){
            $('#password, #password2').val(generatePassword()).trigger('change');
        });
    });

    function generatePassword() {
        var length = 8,
                charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
                retVal = "",
                min = 10,
                max = 99,
                random_number = Math.floor(Math.random() * (max - min)) + min;

        for (var i = 0, n = charset.length; i < length; ++i) {
            retVal += charset.charAt(Math.floor(Math.random() * n));
        }

        return retVal+random_number;
    }
</script>
