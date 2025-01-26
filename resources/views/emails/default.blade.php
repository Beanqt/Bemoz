<html>
<head>
    <title>{{env('ADMIN_NAME')}}</title>
</head>
<body style="background: #e8e8e8;">
<table cellspacing="0" cellpadding="0" align="center" border="0" width="600">
    <tr>
        <td style="color: #777;padding: 15px;text-align: center;font-size:18px;font-weight:bold">
            <img src="{{asset('images/logo.png')}}"><br><br>
        </td>
    </tr>
    <tr>
        <td style="font-family: Arial, Helvetica, sans-serif;font-size: 14px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background: #fff;">
                <tbody>
                <tr>
                    <td style="font-family: Arial, Helvetica, sans-serif;font-size: 14px;vertical-align: top;padding: 30px;">
                        {!! $content !!}
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>
</body>
</html>