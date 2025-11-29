<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', config('app.name'))</title>
    <style>
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
            }
            .logo img {
                width: 80px !important;
                height: 80px !important;
            }
            .content {
                padding: 10px !important;
            }
            .footer p {
                text-align: center;
            }
            .social-media p {
                text-align: center;
            }
        }
    </style>
</head>

<body style="margin: 0; padding: 0; background-color: #f4f7fc">
    <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="margin: 20px 0">
        <tr>
            <td align="center">
                <table class="email-container" cellpadding="0" cellspacing="0" border="0" width="100%"
                    style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 10px; overflow: hidden;">
                    
                    <!-- Logo Section -->
                    <tr>
                        <td class="logo" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); text-align: center; padding: 30px 0; height: 103px;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 32px; font-weight: 700;">{{ config('app.name') }}</h1>
                        </td>
                    </tr>

                    <!-- Content Section -->
                    <tr>
                        <td class="content" style="padding: 20px; font-size: 14px; line-height: 1.5; color: #333;">
                            @yield('content')
                        </td>
                    </tr>

                    <!-- Social Media Section -->
                    <tr>
                        <td class="social-media" style="text-align: center; padding: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; font-size: 14px;">
                           
                            <table align="center" border="0" cellpadding="0" cellspacing="0" style="max-width: 100%; min-width: 100%" width="100%">
                                <tbody>
                                    <tr>
                                        <td valign="top" class="mcnTextContent" style="color: #ffffff; font-size: 14px; line-height: 150%; text-align: center; padding-bottom: 10px;">
                                            <p style="margin: 0;">
                                                &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('message.all_rights_reserved') }}
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
