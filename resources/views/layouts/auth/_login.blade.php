<div class="col-sm-6 padding-right border">
    <h2>@lang('public.login.title')</h2>
    @if(session('login_error'))
        <div class="alert alert-danger">{{session('login_error')}}</div>
    @endif
    <form method="post" action="{{route('login')}}" data-loader="true">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="form-group">
            <label for="email">@lang('public.login.form.email')</label>
            <input autocomplete="off" type="email" class="form-control" name="email" id="email" data-error="@lang('public.alerts.required')" required>
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="login_password">@lang('public.login.form.password')</label>
            <input autocomplete="off"  type="password" class="form-control" name="password" id="login_password" data-error="@lang('public.alerts.required')" required>
            <div class="help-block with-errors"></div>
        </div>
        <button type="submit" name="submit" class="btn btn-submit">@lang('public.login.btn')</button>
        <br><br>
        <b>@lang('public.login.reminder.question')</b><br>
        <a href="#reminder" data-toggle="tab" class="btn btn-reminder">@lang('public.login.reminder.title')</a>
    </form>
</div>
<div class="col-sm-6 padding-left">
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade{{old('reminder_email') ? '' : ' active in'}}" id="reg">
            <h2>@lang('public.reg.title')</h2>
            <div class="message-box login-reg">
                <div class="title"><b>@lang('public.reg.desc.title')</b></div>
                <div class="desc">@lang('public.reg.desc.create')</div><br>
                <a class="btn btn-default" href="{{route('reg')}}">@lang('public.reg.desc.button')</a>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade{{old('reminder_email') ? ' active in' : ''}}" id="reminder">
            @include('layouts.auth.reminder.auth')
        </div>
    </div>
</div>
