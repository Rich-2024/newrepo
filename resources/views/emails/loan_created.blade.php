<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>New Loan Issued</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f5; font-family: Arial, sans-serif;">
    <table role="presentation" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table role="presentation" cellspacing="0" cellpadding="0" width="600" style="background: #ffffff; border-radius: 10px; padding: 40px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                    <tr>
                        <td style="text-align: center;">
                            <h2 style="color: #1a1a1a; font-size: 24px; margin-bottom: 12px;">📄 New Loan Issued</h2>
                            <p style="color: #555; font-size: 16px; margin: 0 0 30px;">
                                Hello {{ $admin_name }},
                            </p>
                            <p style="color: #555; font-size: 16px; margin: 0 0 30px;">
                                A new loan has been issued to one of your cliens today ,view its detail below:
                            </p>

                            <table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="margin: 20px 0;">
                                <tr>
                                    <td style="padding: 8px 0; font-weight: bold; color: #333;">Client Name:</td>
                                    <td style="padding: 8px 0; color: #555;">{{ $client_name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-weight: bold; color: #333;">Contact:</td>
                                    <td style="padding: 8px 0; color: #555;">{{ $contact }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-weight: bold; color: #333;">Loan Amount:</td>
                                    <td style="padding: 8px 0; color: #555;">Ugx{{ number_format($amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-weight: bold; color: #333;">Interest Rate:</td>
                                    <td style="padding: 8px 0; color: #555;">{{ $interest_rate }}%</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-weight: bold; color: #333;">Total Repayable:</td>
                                    <td style="padding: 8px 0; color: #555;">Ugx{{ number_format($total_repayable, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-weight: bold; color: #333;">Issued Date:</td>
                                    <td style="padding: 8px 0; color: #555;">{{ \Carbon\Carbon::parse($loan_date)->format('F j, Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-weight: bold; color: #333;">Due Date:</td>
                                    <td style="padding: 8px 0; color: #555;">{{ \Carbon\Carbon::parse($end_date)->format('F j, Y') }}</td>
                                </tr>
                            </table>

                            <p style="color: #555; font-size: 16px; margin: 0 0 30px;">
                                Please keep track of this loan in your system. Should you need to know any further details,login your account at LoanHubTracker,ypor daily  Loan management System
                            </p>

                            <p style="color: #555; font-size: 16px;">
                                Regards,<br />
                                FinanceHubLoanTracking System
                            </p>
                        </td>
                    </tr>
                </table>

                <p style="font-size: 12px; color: #999; margin-top: 20px; text-align: center;">
                    This is an automated notification. Please do not reply to this email.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
