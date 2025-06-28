<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your OTP Code</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f5; font-family: Arial, sans-serif;">

    <table role="presentation" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table role="presentation" cellspacing="0" cellpadding="0" width="600" style="background: #ffffff; border-radius: 10px; padding: 40px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                    <tr>
                        <td style="text-align: center;">
                            <h2 style="color: #1a1a1a; font-size: 24px; margin-bottom: 12px;">🔐 Your OTP Code</h2>
                            <p style="color: #555; font-size: 16px; margin: 0 0 30px;">
                                Use the following One-Time Password (OTP) to complete your login or action:
                            </p>
                            <div style="display: inline-block; padding: 15px 30px; background-color: #1a73e8; color: #ffffff; font-size: 32px; font-weight: bold; border-radius: 8px; letter-spacing: 2px; margin: 20px 0;">
                                {{ $otp }}
                            </div>
                            <p style="color: #888; font-size: 14px; margin: 30px 0 0;">
                                ⚠️ This OTP is valid for a limited time and can only be used once.
                            </p>
                        </td>
                    </tr>
                </table>

                <p style="font-size: 12px; color: #999; margin-top: 20px; text-align: center;">
                    If you did not request this OTP, please ignore this email.
                </p>
            </td>
        </tr>
    </table>

</body>
</html>
