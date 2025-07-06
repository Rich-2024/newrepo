<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to LoanHubTracker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #4CAF50;
            font-size: 24px;
            margin-bottom: 10px;
        }
        p {
            line-height: 1.6;
        }
        .btn {
            background-color: #4CAF50;
            color: #fff;
            padding: 12px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            display: inline-block;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #45a049;
        }
        footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Welcome to LoanHubTracker!</h1>

        <p>Dear {{ $name }},</p>

        <p>Thank you for choosing <strong>LoanHubTracker</strong> as your loan management system. We’re excited to have you on board!</p>

        <p>Your trial duration is for <strong>2 months</strong>, starting from <strong>{{ $trialStartDate }}</strong> and will end on <strong>{{ $trialEndDate }}</strong>.</p>

        <p>Get started now and explore all the features of LoanHubTracker!</p>

        <a href="https://custohost.custospark.com/" class="btn">Start Now</a>

        <footer>
            <p>Best regards, <br> The LoanHubTracker Team</p>
        </footer>
    </div>

</body>
</html>
