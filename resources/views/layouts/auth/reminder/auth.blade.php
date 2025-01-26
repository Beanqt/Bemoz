<h2>@lang('public.login.reminder.title')</h2>
@if(session('reminder_success'))
    <div class="alert alert-success">{{session('reminder_success')}}</div>
@endif
@if(session('reminder_error'))
    <div class="alert alert-danger">{{session('reminder_error')}}</div>
@endif
<form action="{{route('reminder')}}" method="post" data-loader="true">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="form-group {{$errors->has('reminder_email') ? 'has-error' : ''}}">
        <label for="reminder_email">@lang('public.reg.form.email')</label>
        <input type="email" class="form-control" name="reminder_email" id="reminder_email" data-error="@lang('public.alerts.email')" required>
        <div class="help-block with-errors">
            {!! $errors->first('reminder_email', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
        </div>
    </div>
    <button type="submit" name="submit" class="btn btn-submit">@lang('public.login.reminder.form.submit')</button>&nbsp;
    <a href="#reg" data-toggle="tab">@lang('public.reg.title')</a>
</form>