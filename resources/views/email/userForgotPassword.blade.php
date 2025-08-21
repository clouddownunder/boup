<?php //dd($post->url);die; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='robots' content='noindex, nofollow' />
    <title>Forgot Password Email</title>
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
                                                                                                            <img src="{{asset('images/login.png')}}" >
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
                                                    </td>     --}}
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
                                                                                    <td align="left" style="font-family: 'Roboto', sans-serif; font-size:22px; font-weight: bold;
                                                                                    color:#000;line-height: 18px;"><br> Hello {{$name}}, </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td height="20"></td>
                                                                                </tr>
                                                                
                                                                                

                                                                                <tr>
                                                                                    <td class="esd-block-text  " align="left">
                                                                                        <p style="font-size: 16px; color: #6e7378; font-weight: 300; line-height: 24px;">It seems like you forgot your password. If this is correct, please click the link button below to reset your password.</p>
                                                                                    </td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td class="esd-block-button" align="center">
                                                                                        <span class="es-button-border" style="display: inline-block; padding: 20px 0px 30px;">
                                                                                            <a href="{{ Route('userShowResetPasswordForm',[$token])}}" style="color: #fff;text-decoration: none;background: #FF5221;width: 150px;height: 30px;display: inline-block;font-size: 15px;text-align: center;line-height: 30px;font-family: 'Roboto', sans-serif; display: table-cell;    vertical-align: middle;  ">
                                                                                                Change Password<span style="padding-left: 4px;"><img src="{{asset('images/right_icon.png')}}" style="height: 10px; width: 10px;"  alt=""></span></a>
                                                                                        </span>
                                                                                    </td> 
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="esd-block-text " align="left">
                                                                                        <p style="font-size: 16px;color: #6e7378; font-weight: 300; line-height: 24px;">If you did not request to change your password, then simply ignore this email.</p>
                                                                                    </td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td class="esd-block-text " align="left">
                                                                                        <p style="font-size: 16px;color: #6e7378; font-weight: 300; line-height: 24px;">Regards, <br/>Boup Team </p>
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