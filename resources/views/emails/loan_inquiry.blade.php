<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Loan Inquiry</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">

    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.08);">
                    <tr>
                        <td style="background-color: #28a745; padding: 20px; color: white; text-align: center;">
                            <h1 style="margin: 0; font-size: 22px;">💼 New Loan Inquiry</h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 30px;">
                            <p style="font-size: 16px; color: #333;">A new loan inquiry has been submitted. Here are the details:</p>

                            <table width="100%" cellpadding="10" cellspacing="0" style="margin-top: 15px;">
                                <tr>
                                    <td width="30%" style="font-weight: bold; color: #555;">🙍‍♂️ Name:</td>
                                    <td style="color: #222;">{{ $details['name'] }}</td>
                                </tr>
                                <tr>
                                    <td width="30%" style="font-weight: bold; color: #555;">📧 Email:</td>
                                    <td style="color: #222;">{{ $details['email'] }}</td>
                                </tr>
                                <tr>
                                    <td width="30%" style="font-weight: bold; color: #555;">🏷️ Loan Type:</td>
                                    <td style="color: #222;">{{ $details['loan_type'] }}</td>
                                </tr>
                                <tr>
                                    <td width="30%" style="font-weight: bold; color: #555; vertical-align: top;">📝 Message:</td>
                                    <td style="color: #222;">{{ $details['message'] }}</td>
                                </tr>
                            </table>

                            <p style="margin-top: 30px; font-size: 14px; color: #999;">This is an automated notification from your Loan Inquiry form.</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="background-color: #f0f0f0; text-align: center; padding: 15px; font-size: 12px; color: #888;">
                            &copy; {{ date('Y') }} Loan Management System. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>
