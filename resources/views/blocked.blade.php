<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Access Denied - Firewall</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 600px;
            text-align: center;
            padding: 45px 35px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .emoji {
            font-size: 72px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
            opacity: 0.9;
            margin-bottom: 10px;
        }

        .attempt-box {
            margin-top: 25px;
            padding: 15px;
            background: rgba(0, 0, 0, 0.15);
            border-radius: 10px;
        }

        .attempt-box strong {
            font-size: 24px;
        }

        .warning {
            margin-top: 20px;
            font-size: 14px;
            opacity: 0.8;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="emoji">🚫</div>

    <h1>Access Denied</h1>

    <p>
        Your IP address has been blocked by the firewall.
    </p>

    <p>
        If you believe this is an error, please contact the administrator.
    </p>

    @isset($attemptCount)
        <div class="attempt-box">
            <p>Blocked attempts from your IP</p>
            <strong>{{ $attemptCount }}</strong>
        </div>
    @endisset

    <p class="warning">
        Repeated unauthorized attempts may trigger automatic security actions.
    </p>

</div>

</body>
</html>