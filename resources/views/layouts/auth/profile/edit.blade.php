@extends('layouts.master')

@section('content')
    <section>
        <div class="container">
            @include('partials.breadcrumb')
            @include('partials.headline', ['title' => trans('public.profile.main.title')])
            @include('partials.alerts')
            <div class="row">
                @include('layouts.auth._menu', ['active' => 1])
                <div class="col-sm-9">
                    <form method="post" data-loader="true">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="box">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
                                        <label for="name">@lang('public.reg.form.name')</label>
                                        <input type="text" class="form-control" name="name" id="name" data-error="@lang('public.alerts.required')" value="{{$data['name'] ?? ''}}" required>
                                        <div class="help-block with-errors">
                                            {!! $errors->first('name', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group {{$errors->has('email') ? 'has-error' : ''}}">
                                        <label for="email">@lang('public.reg.form.email')</label>
                                        <input type="email" class="form-control" name="email" id="email" data-error="@lang('public.alerts.required')" value="{{$data['email'] ?? ''}}" readonly required>
                                        <div class="help-block with-errors">
                                            {!! $errors->first('email', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group {{$errors->has('phone') ? 'has-error' : ''}}">
                                <label for="phone">@lang('public.reg.form.phone') <small>(06xxxxxxxxx)</small></label>
                                <input type="text" class="form-control" name="phone" id="phone"  pattern="^06+[0-9]{9}$" value="{{$data['phone'] ?? ''}}">
                                <div class="help-block with-errors">
                                    {!! $errors->first('phone', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn btn-submit">@lang('public.btn.save')</button>
                        </div>
                    </form>
                    <form method="post" data-loader="true">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="pw" value="1">
                        <div class="box">
                            <div class="form-group {{$errors->has('old_password') ? 'has-error' : ''}}">
                                <label for="old_password">@lang('public.reg.form.old_password')</label>
                                <input type="password" class="form-control" name="old_password" id="old_password" data-minlength="5" data-required-error="@lang('public.alerts.required')" data-minlength-error="@lang('public.alerts.pass_min')" required>
                                <div class="help-block with-errors">
                                    {!! $errors->first('old_password', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                                </div>
                            </div>
                            <div class="form-group {{$errors->has('password') ? 'has-error' : ''}}">
                                <label for="password">@lang('public.reg.form.password')</label>
                                <input type="password" class="form-control" name="password" id="password" data-minlength="5" data-required-error="@lang('public.alerts.required')" data-minlength-error="@lang('public.alerts.pass_min')" required>
                                <div class="help-block with-errors">
                                    {!! $errors->first('password', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                                </div>
                            </div>
                            <div class="form-group {{$errors->has('password_confirmed') ? 'has-error' : ''}}">
                                <label for="password_confirmation">@lang('public.reg.form.password_confirmation')</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" data-match="#password" data-error="@lang('public.alerts.match')" required>
                                <div class="help-block with-errors">
                                    {!! $errors->first('password', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn btn-submit">@lang('public.btn.password')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        @if(session('reg'))
            ga('send', 'event', 'form', 'registration');
        @endif
    </script>
@stop