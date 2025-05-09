<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
    <style>
        body {
            background-color: #f8f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 420px;
            text-align: center;
        }

        .icon {
            width: 80px;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 26px;
            color: #2c2c2c;
            margin-bottom: 10px;
        }

        p {
            font-size: 14px;
            color: #5f5f5f;
            margin-bottom: 20px;
        }

        .success-msg {
            color: #28a745;
            margin-bottom: 15px;
        }

        .btn {
            background-color: #3b82f6;
            color: #fff;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
            margin: 10px 0;
            width: 100%;
        }

        .btn:hover {
            background-color: #2563eb;
        }

        .btn-outline {
            background-color: #fff;
            color: #3b82f6;
            border: 2px solid #3b82f6;
        }

        .btn-outline:hover {
            background-color: #f0f8ff;
        }

        .footer-msg {
            font-size: 13px;
            color: #888;
            margin-top: 25px;
        }

        a {
            color: #3b82f6;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <img src="https://img.icons8.com/fluency/96/secured-letter.png" alt="Mail Icon" class="icon">
        
        <h2>Verify Your Email</h2>
        <p>Please check your inbox for a verification link to continue using your account.</p>

        @if (session('message'))
            <p class="success-msg">{{ session('message') }}</p>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn">Resend Verification Email</button>
        </form>

        <a href="/make-it-blast">
            <button type="button" class="btn btn-outline">Back to Login</button>
        </a>

        <div class="footer-msg">
            Didn’t get the email? Be sure to check your spam folder.
        </div>
    </div>

</body>
</html>
