<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{ env('APP_NAME') }}</title>
    <meta name="viewport" content="width=device-width" />
    <style type="text/css">
        @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
            body[yahoo] .buttonwrapper { background-color: transparent !important; }
            body[yahoo] .button { padding: 0 !important; }
            body[yahoo] .button a { background-color: #9b59b6; padding: 15px 25px !important; }
        }

        @media only screen and (min-device-width: 601px) {
            .content { width: 600px !important; }
            .col387 { width: 387px !important; }
        }
    </style>
</head>
<body bgcolor="#f1f1f1" style="margin: 0; padding: 0;" yahoo="fix">
<!--[if (gte mso 9)|(IE)]>
<table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td>
<![endif]-->
<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 700px;" class="content">

    @hasSection('mail-header')
        <tr>
            <td align="left" bgcolor="#ffffff" style=" border-bottom: 1px">
                @yield('mail-header')
            </td>
        </tr>
    @endif

    <tr>
        <td align="left" bgcolor="#ffffff" style=" border-bottom: 1px solid #f6f6f6;">
            @yield('mail-content')
        </td>
    </tr>
    <tr>
        <td align="center" bgcolor="#0960a5" style="padding: 5px 5px 5px 5px; color: #ffffff; font-family: Arial, sans-serif; font-size: 36px; font-weight: bold;">
            <img src="{{ asset('images/logo-white-ct.PNG') }}" alt="" width="30%"  style="margin-top: 7px;">
        </td>
    </tr>

    <tr>
        <td style="padding: 15px 10px 15px 10px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td align="center" width="100%" style="color: #414141; font-family: Arial, sans-serif; font-size: 12px;">
                        ERM© {{ \Carbon\Carbon::today()->year }} CMATIK
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!--[if (gte mso 9)|(IE)]>
</td>
</tr>
</table>
<![endif]-->
</body>
</html>
