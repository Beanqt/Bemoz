@extends('layouts.master')

@section('content')
    <section class="big-padding">
        <div class="container">
            <div class="row form-box">
                <div class="col-sm-6 col-sm-offset-3">
                    <h2>@lang('public.login.reminder.title')</h2>
                    @if(session('reminder_success'))
                        <div class="alert alert-success">{{session('reminder_success')}}</div>
                    @endif
                    @if(session('reminder_error'))
                        <div class="alert alert-danger">{{session('reminder_error')}}</div>
                    @endif
                    <form method="post" data-loader="true">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group {{$errors->has('reminder_password') ? 'has-error' : ''}}">
                            <label for="reminder_password">@lang('public.login.reminder.form.new_password') <small>@lang('public.reg.form.password_info')</small><span class="required">*</span></label>
                            <input type="password" class="form-control" name="reminder_password" id="reminder_password" pattern="^[a-zA-Z0-9]{5,16}$" data-required-error="@lang('public.alerts.required')" data-pattern-error="@lang('public.alerts.regex')" required>
                            <div class="help-block with-errors">
                                {!! $errors->first('reminder_password', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                            </div>
                        </div>
                        <div class="form-group {{$errors->has('reminder_password_confirmation') ? 'has-error' : ''}}">
                            <label for="reminder_password_confirmation">@lang('public.login.reminder.form.new_password_confirmed')<span class="required">*</span></label>
                            <input type="password" class="form-control" name="reminder_password_confirmation" id="reminder_password_confirmation" data-match="#reminder_password" data-match-error="@lang('public.alerts.match')" data-required-error="@lang('public.alerts.required')" required>
                            <div class="help-block with-errors">
                                {!! $errors->first('reminder_password_confirmation', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                            </div>
                        </div>
                        <br>
                        <button type="submit" name="submit" class="btn btn-submit">@lang('public.login.reminder.form.submit2')</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop