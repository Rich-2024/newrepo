<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Loan Repayment Notification</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

    <table width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f4f5;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table width="600" cellspacing="0" cellpadding="0" style="background: #ffffff; border-radius: 12px; padding: 40px; box-shadow: 0 4px 16px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding-bottom: 30px;">
                            <h1 style="font-size: 28px; color: #2e7d32; margin: 0;">✅ Repayment Received</h1>
                            <p style="font-size: 16px; color: #777777; margin: 10px 0 0;">
                                Hello {{ $admin_name }},
                            </p>
                            <p style="font-size: 15px; color: #555555; margin: 5px 0 20px;">
                               Overdue repayment has been made by one of your clients.
                            </p>
                        </td>
                    </tr>

                    <!-- Repayment Details -->
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0" style="font-size: 15px; color: #444;">
                                <tr>
                                    <td style="padding: 12px; background-color: #f9f9f9; font-weight: bold; width: 40%;">Client Name:</td>
                                    <td style="padding: 12px; background-color: #f9f9f9;">{{ $name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px; font-weight: bold;">Amount Paid:</td>
                                    <td style="padding: 12px;">UGX {{ number_format($amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px; background-color: #f9f9f9; font-weight: bold;">Payment Date:</td>
                                    <td style="padding: 12px; background-color: #f9f9f9;">{{ \Carbon\Carbon::parse($paymentDate)->format('F j, Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px; font-weight: bold;">Contact:</td>
                                    <td style="padding: 12px;">{{ $contact }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer Message -->
                    <tr>
                        <td style="padding-top: 30px; text-align: center;">
                            <p style="font-size: 15px; color: #555555;">
                                If you have any questions or need further assistance,<br>
                                feel free to contact our support team.
                            </p>
                            <p style="font-size: 15px; color: #555555; margin-top: 30px;">
                                Best regards,<br>
                                <strong style="color: #2e7d32;">FinanceHubLoanTracking System</strong>
                            </p>
                        </td>
                    </tr>

                </table>

                <!-- Footer Note -->
                <p style="font-size: 12px; color: #999999; margin-top: 20px; text-align: center;">
                    This is an automated message. Please do not reply to this email.
                </p>
            </td>
        </tr>
    </table>

</body>
</html>
