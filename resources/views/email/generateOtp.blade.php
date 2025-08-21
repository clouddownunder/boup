{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Otp</title>
</head>
<body>
    <p>Hi!</p>
    <p>Your verification OTP is :</p>
    <h2>{{$otpdata}}</h2>
</body>
</html> --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='robots' content='noindex, nofollow' />
    <title>OTP Verification</title>

    <style type="text/css">

        html,body{width:100%;font-family:helvetica,'helvetica neue',arial,verdana,sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%; margin: 0px; padding: 0px;}


    </style>


</head>

<body style="background-color: #FAFBFB;">
    <div class="es-wrapper-color">
        <table class="es-wrapper" style="background-position: center top;" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td class="esd-email-paddings" valign="top">
                        <table cellpadding="0" cellspacing="0" class="es-content esd-header-popover" align="center" style="padding: 30px 0px;">
                            <tbody>
                                <tr>
                                    <td class="es-adaptive esd-stripe" align="center">
                                        <table class="es-content-body" style="background-color: transparent;" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-structure es-p10" align="left" valign="center">
                                                        <table class="es-left" cellspacing="0" cellpadding="0" align="center">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-structure" align="left">
                                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-container-frame" width="280" valign="top" align="center">
                                                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td class="esd-block-image es-p20b" align="center" style="font-size:0">
                                                                                                        <a href="#" target="_blank">
                                                                                                            <img src="{{url('images/login.png')}}" >
                                                                                                        </a>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                    </td>
                                                    {{-- <td class="esd-structure es-p10" align="right" valign="center">
                                                        <table class="es-right" cellspacing="0" cellpadding="0" align="right">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame" width="280" align="left">
                                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="es-infoblock esd-block-text es-m-txt-c" align="right">

                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td> --}}
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="es-content" cellspacing="0" cellpadding="0" align="center">
                            <tbody>
                                <tr>
                                    <td class="esd-stripe" align="center">
                                        <table class="es-content-body" style="background-color: #fff; padding: 15px; border: 1px solid #707070;" width="600" cellspacing="0" cellpadding="0" align="center">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-structure" align="left">
                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame" width="600" valign="top" align="center">
                                                                        <table style="padding: 20px 0px;" width="100%" cellspacing="0" cellpadding="0" >
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="esd-block-text  " align="center">
                                                                                        <h2 style="color: #030303; font-size: 24px; margin: 15px 0px 20px; font-weight: 500;">Verify your Account</h2>
                                                                                    </td>
                                                                                </tr>

                                                                                {{-- <tr>
                                                                                    <td class="esd-block-text  " align="left">
                                                                                        <p style="font-size: 16px; color: #6e7378; font-weight: 300; line-height: 24px;">It seems like you changed your Email. If this is correct, enter the below OTP to update your Email.</p>
                                                                                    </td>
                                                                                </tr> --}}
                                                                                <tr>
                                                                                    <td class="esd-block-text  " align="center">
                                                                                        <h2 style="color: #030303; font-size: 90px; margin: 25px 0px; line-height: normal; font-weight: normal;">{{ $otpdata->otp }}</h2>
                                                                                    </td>
                                                                                </tr>

                                                                                {{-- <tr>
                                                                                    <td class="esd-block-text " align="left">
                                                                                        <p style="font-size: 16px;color: #6e7378; font-weight: 300; line-height: 24px;">If you did not interest verification otp , then simply ignore this email.</p>
                                                                                    </td>
                                                                                </tr> --}}

                                                                                {{-- <tr>
                                                                                    <td class="esd-block-text " align="left">
                                                                                        <p style="font-size: 16px;color: #6e7378; font-weight: 300; line-height: 24px;">Regards, <br/>Boup Team </p>
                                                                                    </td>
                                                                                </tr> --}}
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="es-content" cellspacing="0" cellpadding="0" align="center">
                            <tbody>
                                <tr>
                                    <td class="esd-stripe" align="center">
                                        <table class="es-content-body" style="background-color: #fcfcfc;" width="600" cellspacing="0" cellpadding="0"  align="center">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-structure es-p40t  " esd-custom-block-id="15790" align="left">

                                                        <table class="es-left" width="100%" cellspacing="0" cellpadding="0" align="center" style="padding: 30px 0px;">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="100%" align="center">
                                                                        <table width="100%" cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <p style="color: #A0A0A0; font-size: 14px; margin:0px; font-weight: normal;text-align: center;">© <?php echo date('Y'); ?> Boup | Australia</p>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>

