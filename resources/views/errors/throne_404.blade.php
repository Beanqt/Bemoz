<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{env('ADMIN_NAME')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

    <style>
        body {
            font-family: 'Lato', sans-serif;
            background: #364150;
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
            max-width: 380px;
            color: #fff;
            display: inline-block;
        }
        h1 {
            margin: 0;
        }
        h2 {
            margin: 0 0 20px 0;
            line-height: 30px;
            font-weight: 400;
            font-size: 22px;
        }
        a {
            color: #fff;
            text-decoration: none;
            display: inline-block;
            padding: 8px;
            background-color: #337ab7;
            border-color: #2e6da4;
            font-size: 14px;
        }
        a:hover {
            background-color: #286090;
            border-color: #204d74;
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
            <h1>404</h1>
            <h2>a kért oldal nem található</h2>
            <a href="/throne">Vissza az adminhoz</a>
        </div>
    </div>
</body>
</html>