<!doctype html>
<html lang="{{App::getLocale()}}">
<head itemscope itemtype="http://schema.org/WebSite">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{$meta['title'] ?? setting('seo.title', true) }}</title>

    <meta name="description" content="{{$meta['description'] ?? setting('seo.desc', true) }}">
    <meta name="keywords" content="{{$meta['keywords'] ?? setting('seo.keywords', true) }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(isset($meta['nofollow']) && $meta['nofollow'])
        <meta name="robots" content="NOINDEX, NOFOLLOW">
    @endif

    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" type="image/png" href="/images/apple/logo-57.png">
    <link rel="apple-touch-icon" type="image/png" sizes="72x72" href="/images/apple/logo-72.png">
    <link rel="apple-touch-icon" type="image/png" sizes="114x114" href="/images/apple/logo-114.png">

    <meta property="og:type" content="{{$meta['type'] ?? 'website' }}">
    <meta property="og:description" content="{{$meta['description'] ?? setting('seo.desc', true) }}">
    <meta property="og:locale" content="hu">
    <meta property="og:site_name" content="{{$meta['title'] ?? setting('seo.title', true) }}">
    <meta property="og:title" content="{{$meta['title'] ?? setting('seo.title', true) }}">
    <meta property="og:image" content="{{$meta['image'] ?? asset('images/apple/logo.114.jpg') }}">

    <meta name="msapplication-square70x70logo" content="/images/tiles/icon-70.png" />
    <meta name="msapplication-square150x150logo" content="/images/tiles/icon-150.png" />
    <meta name="msapplication-wide310x150logo" content="/images/tiles/icon-310.png" />
    <meta name="msapplication-square310x310logo" content="/images/tiles/icon-310x.png" />

    <meta name="DC.language" content="{{App::getLocale()}}">
    <meta name="DC.source" content="{{Request::root()}}">
    <meta name="DC.title" content="{{$meta['title'] ?? setting('seo.title', true) }}">
    <meta name="DC.keywords" content="{{$meta['keywords'] ?? setting('seo.keywords', true) }}">
    <meta name="DC.subject" content="{{$meta['title'] ?? setting('seo.title', true) }}">
    <meta name="DC.description" content="{{$meta['desc'] ?? setting('seo.desc', true) }}">
    <meta name="DC.format" content="text/html">
    <meta name="DC.type" content="Text">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ assetVersion('assets/stylesheets/app.css') }}">
    @if(isset($styles))
        <style>{!! str_replace(["\r", "\n", "\t", "  "], '', $styles) !!}</style>
    @endif
    <script>
        var lang = '{{app()->getLocale()}}';
        var default_lang = '{{env('DEFAULT_LANG')}}';

        var settings = {
            map: '{{setting('map')}}',
            ga: '{{setting('ga')}}',
            ga4: '{{setting('ga4')}}',
            gtm: '{{setting('gtm')}}',
            fb: '{{setting('pixel')}}',
        };
        var messages = {
            ajax: {
                error: "@lang('public.ajax.error')"
            },
            filebox: {
                title: "@lang('public.embed.filebox.title')",
                selected: "@lang('public.embed.filebox.selected')",
            },
            btn: {
                more: "@lang('public.btn.more')"
            },
            calendar: {
                week: "@lang('public.calendar.week')",
                month: {
                    '01': "@lang('public.month.jan')",
                    '02': "@lang('public.month.feb')",
                    '03': "@lang('public.month.mar')",
                    '04': "@lang('public.month.apr')",
                    '05': "@lang('public.month.may')",
                    '06': "@lang('public.month.jun')",
                    '07': "@lang('public.month.jul')",
                    '08': "@lang('public.month.aug')",
                    '09': "@lang('public.month.sep')",
                    '10': "@lang('public.month.oct')",
                    '11': "@lang('public.month.nov')",
                    '12': "@lang('public.month.dec')",
                }
            },
            feeds: {
                slug: "@lang('public.feeds.slug')"
            }
        };
        function addGPDR() {
            {!! htmlspecialchars_decode(setting('javascript')) !!}
        }
    </script>
    <script src="{{ assetVersion('assets/scripts/app.js') }}"></script>

    <script type="application/ld+json">
        {
          "@context": "http://schema.org",
          "@type": "Organization",
          "url": "{{Request::root()}}",
          "logo": "{{Request::root()}}/images/logo.png"
        }
    </script>
</head>
<body class="loading">
    <div class="loader active"></div>
    @if(setting('cookie.desc', true) && (!isset($_COOKIE['cookieBox']) || (isset($_COOKIE['cookieBox']) && $_COOKIE['cookieBox'] == 'false')))
        <div class="cookieBox">
            <div class="container">
                <div class="row inline-row text-center">
                    <div class="inline-col col-sm-10 text-left desc">
                        <div class="title">{{setting('cookie.title', true)}}</div>
                        {!! setting('cookie.desc', true) !!}<br>
                        @if(setting('cookie.link', true))
                            <a href="{{setting('cookie.link', true)}}">{{setting('cookie.btn', true)}}</a>
                        @endif
                    </div>
                    <div class="inline-col col-sm-2">
                        @if(setting('cookie.ok', true))
                            <span class="btn btn-more cookieBtn">{{setting('cookie.ok', true)}}</span>
                        @endif
                        <div class="cancelCookie">
                            @if(setting('cookie.cancel', true))
                                <span class="cookieBtnCancel">{{setting('cookie.cancel', true)}}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @include('partials.header')

    @section('content')
    @show

    @include('partials.footer')
</body>
</html>