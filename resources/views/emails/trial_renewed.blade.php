<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trial Renewed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #4CAF50;
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            margin-bottom: 15px;
        }

        .highlight {
            font-weight: bold;
            color: #4CAF50;
        }

        .footer {
            font-size: 14px;
            text-align: center;
            color: #888;
            margin-top: 30px;
        }

        .button {
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Your Account Access Period Has Been Renewed</h1>
        <p>Hello <span class="highlight">{{ $user->admin_name }}</span>,</p>
        <p>Good news! Your Acess has been renewed successfully. Your new trial end date is <strong>{{ $newTrialEndDate->format('F j, Y') }}</strong>.</p>
        <p>Enjoy your extended trial period! We're excited to have you continue with us.</p>
        <a href="https://financehubtracker.custospark.com" class="button">Explore Your Dashboard</a>
        <p class="footer">Best regards,<br>FinanceHubTracker Team</p>
    </div>
</body>

</html>
