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
                                style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px;">
                                        <h1
                                            style="color:#242A37; font-weight:700; margin:0;font-size:25px;font-family:'Helvetica',sans-serif;">
                                            Quên mật khẩu?</h1>
                                        <span
                                            style="display:inline-block; vertical-align:middle; margin:20px 0 0px;"></span>
                                        <p style="color:#333333; font-size:15px;line-height:24px; margin:0;">
                                            Chào bạn, có vẻ bạn đã yêu cầu đặt lại mật khẩu cho tài khoản của mình. Nếu
                                            bạn đã làm điều đó vui lòng nhấp vào liên kết dưới đây và làm theo hướng dẫn
                                            để đặt lại
                                            mật khẩu của bạn. </p>
                                        <a href="{{ url('/reset-password/'. $token) }}"
                                            style="background:#0066FF;text-decoration:none !important; font-weight:500; margin-top:30px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:25px;">Đặt
                                            lại mật khẩu</a>
                                        <p style="color:#333333; font-size:15px;line-height:24px; margin-top: 20px;">
                                            Nếu bạn không làm điều đó, vui lòng <a href="#"
                                                style="text-decoration: none !important;color: #0066FF"> Liên hệ với bộ
                                                phận hỗ
                                                trợ</a>
                                            ngay lập tức.
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
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