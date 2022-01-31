<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">
        a:hover {
            text-decoration: underline !important;
        }
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
    <!--100% body table-->
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
        style="@import url(https://fonts.googleapis.com/css?family=Helvetica:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;">
        <tr>
            <td>
                <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0"
                    align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06); text-align: left;">
                                <tr>
                                    <td style="height:20px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px; text-align: left;">
                                        <h1
                                            style="color:#0066FF; font-weight:700; margin:0;font-size:25px;font-family:'Helvetica',sans-serif;">
                                            Strawhat
                                        </h1>
                                        <span
                                            style="display:inline-block; vertical-align:middle; margin:20px 0 0px;"></span>
                                        <p style="color:#333333; font-size:15px;line-height:24px; margin:0;">
                                            Xin chào <strong>{{ $user->hoTen }}</strong>,<br>
                                            Có vẻ bạn đã yêu cầu đặt lại mật khẩu cho tài khoản của bạn. Dưới đây là mã
                                            xác minh để đặt lại mật khẩu.</p>
                                        <strong style="font-size: 30px; color:#242A37">{{ $token
                                            }}</strong>
                                        <p style="color:#333333; font-size:15px;line-height:24px;margin-top: 5px;">
                                            Không để lộ mã này cho bất kì ai.<br>
                                            Nếu bạn không làm điều đó, vui lòng <a href="#"
                                                style="text-decoration: none !important;color: #0066FF"> Liên hệ với bộ
                                                phận hỗ
                                                trợ</a>
                                            ngay lập tức.
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:20px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>