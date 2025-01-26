@extends('layouts.master')

@section('content')
    <section class="default simple-page">
        <div class="container">
            @include('partials.breadcrumb')
            <div class="headline text-center">
                <h1><span>@lang('public.profile.title')</span></h1>
                <h3 class="italic">@lang('public.profile.menu.newsletter.title')</h3>
            </div>
            @if(session('profile_success'))
                <div class="alert alert-success">{{session('profile_success')}}</div>
            @endif
            <div class="row">
                <div class="col-sm-9 col-sm-offset-3">
                    <h2 class="user-name">{{auth()->guard('public')->user()->fullName}}</h2>
                </div>
            </div>
            <div class="row">
                @include('layouts.auth.menu.profile', ['active' => 8])
                <div class="col-sm-9 newsletter">
                    <form method="post" data-loader="true">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="white-box box-padding box-group">
                            <div class="form-group">
                                <label for="newsletter">@lang('public.profile.form.newsletter')</label><br>
                                <label class="switch">
                                    <input type="checkbox" name="newsletter" id="newsletter" {{auth()->guard('public')->user()->newsletter ? 'checked' : ''}}>
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <button type="submit" name="submit" class="btn btn-more btn-green">@lang('public.profile.btn.save2')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop