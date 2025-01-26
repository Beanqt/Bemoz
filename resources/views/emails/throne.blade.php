<html>
<head>
    <title>{{env('ADMIN_NAME')}} Admin</title>
</head>
<body style="background: #e8e8e8;">
<table cellspacing="0" cellpadding="0" align="center" border="0" width="600">
    <tr>
        <td style="color: #777;padding: 15px;text-align: center;font-size:18px;font-weight:bold; text-transform: uppercase">
            <span style="font-size: 25px;">{{env('ADMIN_NAME')}}</span><br>
            <span style="font-size: 20px;font-weight: normal">Admin</span>
            <br>
        </td>
    </tr>
    <tr>
        <td style="font-family: Arial, Helvetica, sans-serif;font-size: 14px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background: #fff;">
                <tbody>
                <tr>
                    <td style="font-family: Arial, Helvetica, sans-serif;font-size: 14px;vertical-align: top;padding: 30px;">
                        {!! $data !!}
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>
</body>
</html>