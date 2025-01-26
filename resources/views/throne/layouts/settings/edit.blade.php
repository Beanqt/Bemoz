@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1>@lang('admin.settings.edit')</h1>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <ul class="panelMenu subMenu">
                    <li class="active" data-id="seo"><i class="fas fa-search fa-fw"></i> @lang('admin.settings.menu.seo')</li>
                    <li data-id="cookie"><i class="fas fa-exclamation fa-fw"></i> @lang('admin.settings.menu.cookie')</li>
                    <li data-id="social"><i class="fas fa-share-alt fa-fw"></i>@lang('admin.settings.menu.social')</li>
                    <li data-id="tracking"><i class="fas fa-eye fa-fw"></i> @lang('admin.settings.menu.tracking')</li>
                    <li data-id="service"><i class="fas fa-cogs fa-fw"></i> @lang('admin.settings.menu.service')</li>
                    <li data-id="upload"><i class="fas fa-cloud-upload-alt fa-fw"></i> @lang('admin.settings.menu.upload')</li>
                    <li data-id="javascript"><i class="fas fa-code fa-fw"></i> @lang('admin.settings.menu.javascript')</li>
                    <li data-id="other"><i class="fas fa-bars fa-fw"></i> @lang('admin.settings.menu.other')</li>
                </ul>
            </div>
            <div class="col-sm-9">
                <form method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="panels">
                        <div class="panel panel-seo active">
                            @include('throne.layouts.settings.forms.seo')
                        </div>
                        <div class="panel panel-cookie">
                            @include('throne.layouts.settings.forms.cookie')
                        </div>
                        <div class="panel panel-social">
                            @include('throne.layouts.settings.forms.social')
                        </div>
                        <div class="panel panel-tracking box">
                            @include('throne.layouts.settings.forms.tracking')
                        </div>
                        <div class="panel panel-service box">
                            @include('throne.layouts.settings.forms.service')
                        </div>
                        <div class="panel panel-upload box">
                            @include('throne.layouts.settings.forms.upload')
                        </div>
                        <div class="panel panel-javascript box">
                            @include('throne.layouts.settings.forms.javascript')
                        </div>
                        <div class="panel panel-other box">
                            @include('throne.layouts.settings.forms.other')
                        </div>
                    </div>
                    @include('throne.widgets.actions', [
                        'save' => true,
                    ])
                </form>
            </div>
        </div>
    </div>
@stop