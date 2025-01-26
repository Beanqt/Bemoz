@if(request()->ajax())
    @section('content')
    @show
@else
    <!doctype html>
    <html lang="{{App::getLocale()}}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>{{env('ADMIN_NAME')}} Admin</title>

        <meta name="description" content="">
        <link rel="shortcut icon" type="image/x-icon" href="/images/throne/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="stylesheet" href="{{ asset(assetVersion('/assets/stylesheets/throne/app.css')) }}">
        <meta name="robots" content="NOINDEX, NOFOLLOW">
        <?php
            $array = trans('help');
            //dd($array);
            //array_walk($array, function(&$a, $b) { dd($a);$a = "'$b':'$a'"; });
        ?>
        <script>
            var config = {
                ajax: true
            };
            var messages = {
                ajax: {
                    error: "@lang('admin.ajax.error')"
                },
            };
            var helps = { 'enabled': "{{auth()->guard('admin')->user()->tutorial ? 'on' : 'off'}}", 'exeption': {!! auth()->guard('admin')->user()->getTutorial && auth()->guard('admin')->user()->getTutorial->tutorial ? auth()->guard('admin')->user()->getTutorial->tutorial : '{}' !!}, 'elements': @json(trans('help')) };
        </script>
        <script src="{{ asset(assetVersion("/assets/scripts/throne/app.js")) }}" type="text/javascript"></script>
        <script src="{{ asset("assets/scripts/throne/ckeditor/ckeditor.js") }}" type="text/javascript"></script>
        <script src="{{ asset("assets/scripts/throne/ckfinder/ckfinder.js") }}" type="text/javascript"></script>
    </head>
    <body>
        @include('throne.partials.header')

        <div class="messages"><ul></ul></div>
        <script>
            $(document).ready(function(){
                @if(session('success'))
                    app.notify.add('success', '{{session('success')}}');
                @endif
                @if(session('info'))
                    app.notify.add('warning', '{{session('info')}}');
                @endif
                @if(session('error'))
                    app.notify.add('error', '{{session('error')}}');
                @endif
            });
        </script>

        <div class="content open">
            @section('content')
            @show
        </div>

        @include('throne.partials.footer')
    </body>
    </html>
@endif