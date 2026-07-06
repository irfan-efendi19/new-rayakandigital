<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reset Kata Sandi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style type="text/css">
        body, table, td, p, a, li, blockquote {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }
        body {
            margin: 0;
            padding: 0;
            width: 100% !important;
            height: 100% !important;
        }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #F8F5F2;
        }
        @media only screen and (max-width: 600px) {
            .responsive-table {
                width: 100% !important;
            }
            .responsive-padding {
                padding: 20px 16px !important;
            }
            .responsive-button {
                padding: 14px 24px !important;
                font-size: 15px !important;
            }
            .responsive-logo {
                font-size: 22px !important;
            }
            .responsive-body {
                padding: 30px 24px !important;
            }
            .responsive-footer {
                padding: 16px 16px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #F8F5F2; font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #F8F5F2;">
        <tr>
            <td align="center" style="padding: 40px 16px 20px 16px;">

                <table role="presentation" class="responsive-table" width="560" cellpadding="0" cellspacing="0" style="max-width: 560px; width: 100%;">

                    <!-- Logo -->
                    <tr>
                        <td align="center" style="padding-bottom: 32px;">
                            <img src="{{ asset('themes/garden/assets/images/logonew.png') }}" alt="{{ $appName }}" width="160" style="display: block; border: 0; max-width: 160px; height: auto;">
                        </td>
                    </tr>

                    <!-- Main Card -->
                    <tr>
                        <td align="center" style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">

                            <!-- Orange Accent Bar -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td height="6" style="height: 6px; background: linear-gradient(90deg, #FF7A00, #D96500); border-radius: 16px 16px 0 0; font-size: 0; line-height: 0;">&nbsp;</td>
                                </tr>
                            </table>

                            <!-- Body Content -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="responsive-body" style="padding: 40px 40px 0 40px;">

                                        <!-- Icon -->
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center" style="padding-bottom: 24px;">
                                                    <table role="presentation" cellpadding="0" cellspacing="0" style="width: 64px; height: 64px; background-color: #FFF4EB; border-radius: 16px;">
                                                        <tr>
                                                            <td align="center" valign="middle" style="font-size: 28px; line-height: 64px; color: #FF7A00;">
                                                                <i class="fas fa-lock"></i>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Title -->
                                        <h1 style="margin: 0; font-family: 'Playfair Display', Georgia, serif; font-size: 24px; font-weight: 700; color: #1A1A1A; text-align: center; line-height: 1.3;">
                                            Reset Kata Sandi
                                        </h1>

                                        <!-- Description -->
                                        <p style="margin: 12px 0 0 0; font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.6; color: #52525B; text-align: center;">
                                            Halo <strong style="color: #1A1A1A;">{{ $user->name }}</strong>,
                                        </p>
                                        <p style="margin: 8px 0 0 0; font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.6; color: #52525B; text-align: center;">
                                            Kami menerima permintaan reset kata sandi untuk akun <strong style="color: #FF7A00;">{{ $appName }}</strong> Anda. Klik tombol di bawah ini untuk mengatur ulang kata sandi Anda.
                                        </p>
                                    </td>
                                </tr>

                                <!-- Button -->
                                <tr>
                                    <td align="center" style="padding: 28px 40px 0 40px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center" style="background: linear-gradient(135deg, #FF7A00, #D96500); border-radius: 12px; box-shadow: 0 4px 14px rgba(255, 122, 0, 0.35);">
                                                    <a href="{{ $resetUrl }}"
                                                       class="responsive-button"
                                                       style="display: inline-block; padding: 14px 36px; font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 15px; font-weight: 700; color: #ffffff; text-decoration: none; border-radius: 12px; letter-spacing: 0.3px;">
                                                        Reset Kata Sandi
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- Expiry Info -->
                                <tr>
                                    <td style="padding: 20px 40px 0 40px;">
                                        <p style="margin: 0; font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 13px; line-height: 1.5; color: #A1A1AA; text-align: center;">
                                            Tautan ini akan kedaluwarsa dalam waktu {{ $expire }} menit.
                                        </p>
                                    </td>
                                </tr>

                                <!-- Divider -->
                                <tr>
                                    <td style="padding: 24px 40px 0 40px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="border-bottom: 1px solid #E4E4E7; line-height: 0; font-size: 0;">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- Footer Note -->
                                <tr>
                                    <td style="padding: 20px 40px 40px 40px;">
                                        <p style="margin: 0; font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 13px; line-height: 1.5; color: #A1A1AA; text-align: center;">
                                            Jika Anda tidak merasa meminta reset kata sandi, abaikan email ini. Akun Anda tetap aman.
                                        </p>
                                        <p style="margin: 8px 0 0 0; font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 13px; line-height: 1.5; color: #A1A1AA; text-align: center;">
                                            Jika tombol di atas tidak berfungsi, salin dan tempel URL berikut ke browser Anda:
                                        </p>
                                        <p style="margin: 8px 0 0 0; font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 12px; line-height: 1.5; color: #71717A; text-align: center; word-break: break-all;">
                                            <a href="{{ $resetUrl }}" style="color: #FF7A00; text-decoration: underline;">{{ $resetUrl }}</a>
                                        </p>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="responsive-footer" align="center" style="padding: 24px 16px 40px 16px;">
                            <p style="margin: 0; font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 12px; line-height: 1.5; color: #A1A1AA;">
                                &copy; {{ date('Y') }} {{ $appName }}. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
