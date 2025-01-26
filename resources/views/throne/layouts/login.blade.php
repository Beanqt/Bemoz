<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Bejelentkezés</title>

    <meta name="description" content="">
    <link rel="shortcut icon" type="image/x-icon" href="/images/throne/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="NOINDEX, NOFOLLOW">

    <style>
        @font-face {
            font-family: 'Open Sans';
            src: url('/assets/fonts/OpenSans/OpenSans-Regular.eot');
            src: url('/assets/fonts/OpenSans/OpenSans-Regular.woff2') format('woff2'),
            url('/assets/fonts/OpenSans/OpenSans-Regular.woff') format('woff'),
            url('/assets/fonts/OpenSans/OpenSans-Regular.ttf') format('truetype'),
            url('/assets/fonts/OpenSans/OpenSans-Regular.svg#OpenSans-Regular') format('svg'),
            url('/assets/fonts/OpenSans/OpenSans-Regular.eot?#iefix') format('embedded-opentype');
            font-weight: normal;
            font-style: normal;
        }
        * {
            margin: 0;
            padding: 0;
            border: 0;
            vertical-align: baseline;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {
            background: #2a3b4c;
            font-size: 14px;
            font-family: 'Open Sans', sans-serif;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .text-center {
            text-align: center;
        }
        button, input, select, textarea {
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            transition: background-color 5000s ease-in-out 0s;
            -webkit-text-fill-color: #8290a3 !important;
        }
        .form-control {
            padding: 6px 12px;
            border-radius: 3px;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            background-color: #dde3ec;
            height: 43px;
            color: #8290a3;
            border: 1px solid #dde3ec;
            width: 100%;
            outline: 0;
        }
        .loginPage {
            background: #2a3b4c;
            opacity: 0;
            transition: all 1.0s ease-in-out;
            -webkit-transition: all 1.0s ease-in-out;
            -moz-transition: all 1.0s ease-in-out;
        }
        .load.loginPage {
            opacity: 1;
        }
        .login {
            width: 100%;
            max-width: 360px;
            margin: 100px auto;
        }
        .loginPage h1 {
            text-transform: uppercase;
            text-align: center;
            color: #fff;
            line-height: 30px;
            margin-bottom: 30px;
            font-size: 34px;
        }
        .loginPage h1 small {
            display: block;
            color: rgba(72, 207, 173, 0.7);
            font-size: 18px;
        }
        .loginPage .panel {
            background: #fff;
            padding: 25px;
            -moz-box-shadow: 0 1px 1px rgba(0,0,0,0.2);
            -webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.2);
            box-shadow: 0 1px 1px rgba(0,0,0,0.2);
            border: 0;
            margin: auto;
        }
        .btn-primary {
            color: #fff;
            padding: 10px 20px;
            border-radius: 3px;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            outline: none;
            cursor: pointer;
            background-color: #48cfad;
            text-transform: uppercase;
        }
        .btn-primary:hover {
            background-color: #3cc1a0;
        }
        label {
            color: #000;
            margin-bottom: 4px;
            display: inline-block;
        }
        .footer {
            text-align: center;
            color: #7a8ca5;
            font-size: 13px;
            padding: 15px 0;
            background-color: rgba(108, 122, 141, 0.57);
            border-radius: 0 0 3px 3px;
            -moz-border-radius: 0 0 3px 3px;
            -webkit-border-radius: 0 0 3px 3px;
            box-shadow: inset 0 6px 2px -4px rgba(0, 0, 0, 0.06);
            -moz-box-shadow: inset 0 6px 2px -4px rgba(0, 0, 0, 0.06);
            -webkit-box-shadow: inset 0 6px 2px -4px rgba(0, 0, 0, 0.06);
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
            -moz-border-radius: 4px;
            -webkit-border-radius: 4px;
        }
        .alert-info {
            color: #31708f;
            background-color: #d9edf7;
            border-color: #bce8f1;
        }
        .alert-danger {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }
    </style>
    <script>
        function onload(){
            document.body.className += ' ' + 'load';
        }
    </script>
</head>
<body onload="onload()" class="loginPage">
<div class="login">
    <h1>{{env('ADMIN_NAME')}} <small>Admin</small></h1>
    <div class="panel panel-default">
        @if(session('change_password'))
            <div class="panel-body">
                <form role="form" method="post" action="{{route('throne.login.new_password')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @if($errors->has('password'))
                        <div class="alert alert-danger">{{$errors->first('password')}}</div>
                    @endif
                    @if(session('change_password'))
                        <div class="alert alert-info">@lang('admin.alert.password_regex')</div>
                    @endif
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="@lang('admin.admins.form.password')" name="password" id="password" pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).[A-Za-z0-9%_]{5,}$" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="@lang('admin.admins.form.password2')" name="password_confirmation" id="password2" data-match="#password" data-match-error="@lang('admin.alert.password_confirmed')" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                            @lang('admin.change_password.btn')
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="panel-body">
                @if(session('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                @endif

                <form role="form" method="post" action="{{route('throne.login.check')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <input class="form-control" placeholder="E-mail" name="email" type="email" required autofocus="">
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="@lang('admin.password')" name="password" type="password" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                            @lang('admin.login')
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
    <div class="footer">&copy; 2019 POSITIVE</div>
</div>
</body>
</html>