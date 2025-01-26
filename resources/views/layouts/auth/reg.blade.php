@extends('layouts.master')

@section('content')
    <section class="big-padding">
        <div class="container">
            <div class="row form-box">
                <div class="col-md-10 col-md-offset-1">
                    @include('partials.alerts')
                    @if(Session::get('reg_error_message'))
                        <div class="alert alert-danger">{{Session::get('reg_error_message')}}</div>
                    @endif
                    <h2>@lang('public.reg.user_data')</h2>
                    <form method="post" data-loader="true" action="{{route('reg')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" id="submit" name="submit" value="1">
                        <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
                            <label for="name">@lang('public.reg.form.name')<span class="required">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" data-required-error="@lang('public.alerts.required')" required>
                            <div class="help-block with-errors">
                                {!! $errors->first('name', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group {{$errors->has('password') ? 'has-error' : ''}}">
                                    <label for="password">@lang('public.reg.form.password') <small>@lang('public.reg.form.password_info')</small><span class="required">*</span></label>
                                    <input type="password" class="form-control" name="password" id="password" pattern="^[a-zA-Z0-9]{5,25}$" data-required-error="@lang('public.alerts.required')" data-pattern-error="@lang('public.alerts.regex')" required>
                                    <div class="help-block with-errors">
                                        {!! $errors->first('password', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group {{$errors->has('password_confirmation') ? 'has-error' : ''}}">
                                    <label for="password2">@lang('public.reg.form.password_confirmation')<span class="required">*</span></label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password2" data-match="#password" data-match-error="@lang('public.alerts.match')" data-required-error="@lang('public.alerts.required')" required>
                                    <div class="help-block with-errors">
                                        {!! $errors->first('password_confirmation', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group {{$errors->has('email') ? 'has-error' : ''}}">
                                    <label for="email">@lang('public.reg.form.email')<span class="required">*</span></label>
                                    <input type="email" class="form-control" name="email" id="email" value="{{old('email')}}" data-required-error="@lang('public.alerts.required')" required>
                                    <div class="help-block with-errors">
                                        {!! $errors->first('email', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group {{$errors->has('phone') ? 'has-error' : ''}}">
                                    <label for="phone">@lang('public.reg.form.phone') <small>(06xxxxxxxxx)</small></label>
                                    <input type="text" class="form-control" name="phone" id="phone" pattern="^06+[0-9]{9}$" data-pattern-error="@lang('public.alerts.regex')" value="{{old('phone')}}">
                                    <div class="help-block with-errors">
                                        {!! $errors->first('phone', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{$errors->first('aszf') ? 'has-error' : ''}}">
                            <label class="checkBoxInput">
                                <input type="checkbox" name="aszf" data-error="@lang('public.alerts.aszf')" required>
                                <span></span> @lang('public.reg.form.aszf')
                            </label>
                            <div class="help-block with-errors">{!! $errors->first('aszf', '<ul class="list-unstyled"><li>:message</li></ul>') !!}</div>
                        </div>
                        <div class="form-group {{$errors->first('newsletter') ? 'has-error' : ''}}">
                            <label class="checkBoxInput">
                                <input type="checkbox" name="newsletter">
                                <span></span> @lang('public.reg.form.newsletter')
                            </label>
                            <div class="help-block with-errors">{!! $errors->first('newsletter', '<ul class="list-unstyled"><li>:message</li></ul>') !!}</div>
                        </div>
                        <br>
                        <button type="submit" name="submit" class="btn btn-submit">@lang('public.reg.form.submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop
