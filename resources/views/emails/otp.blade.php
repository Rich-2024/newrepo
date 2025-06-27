<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your OTP Code</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f5; margin: 0; padding: 0;">
    <table role="presentation" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table role="presentation" cellspacing="0" cellpadding="0" width="600" style="background: #ffffff; border-radius: 8px; padding: 40px;">
                    <tr>
                        <td style="text-align: center;">
                            <h2 style="color: #333; font-size: 24px; margin-bottom: 10px;">🔐 Your OTP Code</h2>
                            <p style="color: #555; font-size: 16px; margin-bottom: 30px;">
                                Use the following OTP to complete your login:
                            </p>
                            <h1 style="font-size: 36px; color: #1a73e8; margin: 0 0 20px;">{{ $otp }}</h1>
                            <p style="color: #888; font-size: 14px; margin-bottom: 0;">
                                This OTP is valid for one-time use only and will expire shortly.
                            </p>
                        </td>
                    </tr>
                </table>

                <p style="font-size: 12px; color: #aaa; margin-top: 20px;">
                    If you did not request this OTP, you can ignore this email.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
