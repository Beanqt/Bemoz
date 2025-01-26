<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{env('ADMIN_NAME')}}</title>

    <meta name="description" content="{{env('ADMIN_NAME')}}">
    <meta name="keywords" content="{{env('ADMIN_NAME')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <style>
        body {
            background: url(/images/start.jpg) no-repeat center center fixed;
            background-size: cover;
            -moz-background-size: cover;
            -webkit-background-size: cover;
            -ms-background-size: cover;
            -o-background-size: cover;
            font-family: 'Lato', sans-serif;
        }
        .container {
            position: absolute;
            text-align: center;
            top: 50%;
            left: 0;
            right: 0;
            margin-top: -97px;
        }
        .content {
            padding: 30px 20px;
            font-size: 18px;
            background: #fff;
            max-width: 380px;
            display: inline-block;
        }
        h1 {
            margin: 0 0 30px;
        }
        h2 {
            margin: 0;
            line-height: 30px;
            font-weight: 400;
        }
        @font-face {
            font-family: 'Lato';
            src: url('/assets/fonts/Lato/Lato-Regular.eot');
            src: url('/assets/fonts/Lato/Lato-Regular.woff2') format('woff2'),
            url('/assets/fonts/Lato/Lato-Regular.woff') format('woff'),
            url('/assets/fonts/Lato/Lato-Regular.ttf') format('truetype'),
            url('/assets/fonts/Lato/Lato-Regular.svg#Lato-Regular') format('svg'),
            url('/assets/fonts/Lato/Lato-Regular.eot?#iefix') format('embedded-opentype');
            font-weight: normal;
            font-style: normal;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <h2>{{setting('service')}}</h2>
        </div>
    </div>
</body>
</html>