<form method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="box">
        <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
            <label for="name">@lang('admin.admins.form.name')<span class="required">*</span></label>
            <input type="text" class="form-control" data-focus="true" name="name" id="name" value="{{$data['name'] ?? ''}}" required>
            <div class="help-block with-errors">
                {!! $errors->first('name', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group {{$errors->has('email') ? 'has-error' : ''}}">
            <label for="email">@lang('admin.admins.form.email')<span class="required">*</span></label>
            <input type="text" class="form-control" name="email" id="email" value="{{$data['email'] ?? ''}}" required>
            <div class="help-block with-errors">
                {!! $errors->first('email', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group {{$errors->has('password') ? 'has-error' : ''}}">
            <label for="password">@lang('admin.admins.form.password')<span class="required">*</span></label>
            <div class="input-group">
                <input type="password" class="form-control" name="password" id="password" {{isset($edit) ? '' : 'required'}} autocomplete="new-password">
                <div class="input-group-addon generate" style="cursor: pointer;" title="@lang('admin.admins.form.generate')"><i class="fas fa-cogs"></i></div>
            </div>
            <div class="help-block with-errors">
                {!! $errors->first('password', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group {{$errors->has('password_confirmation') ? 'has-error' : ''}}">
            <label for="password2">@lang('admin.admins.form.password2')<span class="required">*</span></label>
            <input type="password" class="form-control" name="password_confirmation" id="password2" data-match="#password" data-match-error="@lang('admin.alert.password_confirmed')" {{isset($edit) ? '' : 'required'}}>
            <div class="help-block with-errors">
                {!! $errors->first('password_confirmation', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group">
            <label for="group">@lang('admin.admins.form.permission')<span class="required">*</span></label>
            <select class="form-control form-custom-select" name="group" id="group" required>
                @foreach($permissions as $key => $permission)
                    <option value="{{$permission['id']}}" {{(isset($data['group']) && $data['group']==$permission['id']) || (!isset($data['group']) && $key == 0) ? 'selected' : ''}}>{{$permission['title']}}</option>
                @endforeach
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="box">
        <div class="row inline-row">
            <div class="col-sm-3 inline-col">
                <label for="send_email">@lang('admin.admins.form.send_email')</label><br>
                <label class="switch">
                    <input type="checkbox" name="send_email" id="send_email">
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="col-sm-3 inline-col">
                @if(!isset($edit))
                    <label for="tutorial">@lang('admin.admins.form.tutorial')</label><br>
                    <label class="switch">
                        <input type="checkbox" name="tutorial" id="tutorial" checked>
                        <span class="slider round"></span>
                    </label>
                @endif
            </div>
            <div class="col-sm-4 inline-col">
                @if(!isset($edit))
                    <label for="tutorial">@lang('admin.admins.form.first_login')</label><br>
                    <label class="switch">
                        <input type="checkbox" name="first_login" id="first_login" checked>
                        <span class="slider round"></span>
                    </label>
                @endif
            </div>
        </div>
    </div>

    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
        'saveNew' => true,
        'cancel' => route('throne.admins'),
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
            charset = "abcdefghijklmnopqrs%tuvwxyzABC%DEFGHIJKLMNOPQRSTUVWX%YZ0123456789",
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