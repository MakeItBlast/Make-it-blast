<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body,
        html {
            height: 100%;
            background: #f4f4f4;
        }

        .container-wrapper {
            display: flex;
            height: 100vh;
        }

        .back-log{
        text-decoration: none;
        background: #007bff;
        border-radius: 25px;
        color:#fff;
        padding:5px 20px;
    }

    .back-log:hover{
        background: #0056b3;
    }

        /* Left Section */
        .left-section {
            width: 40%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fff;
            padding: 40px;
            animation: fadeInLeft 1s ease-in-out;
        }

        /* Right Section */
        .right-section {
            width: 60%;
            background: url("{{ asset('/media/2150208257.jpg')}}") no-repeat center center/cover;
            animation: fadeInRight 1s ease-in-out;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            animation: moveUp 0.8s ease-in-out;
        }

        .form-container h1 {
            font-size: 28px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            animation: fadeIn 1.2s ease-in-out;
        }

        .form-container p {
            font-size: 16px;
            color: #000;
            margin-bottom: 30px;
            animation: fadeIn 1.4s ease-in-out;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
            animation: slideIn 0.8s ease-in-out;
        }

        .form-group input {
            width: 100%;
            padding: 12px 45px 12px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            transition: 0.3s;
        }

        .form-group input:focus {
            border-color: #3b82f6;
            outline: none;
        }

        .form-group i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .form-group label{
            text-align:left;
        }

        .toggle-password i {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background: #3b82f6;
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 16px;
            transition: 0.3s;
            animation: moveUp 0.9s ease-in-out;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .for-pass {
            text-decoration: none;
            animation: moveUp 0.9s ease-in-out;
        }

        .rem-user {
            justify-content: center;
            display: flex;
            gap: 15px;
            animation: moveUp 0.9s ease-in-out;
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
            animation: fadeIn 1s ease-in-out;
        }

        .social-login a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border: 1px solid #ccc;
            border-radius: 50%;
            color: #333;
            font-size: 20px;
            transition: 0.3s;
            text-decoration: none;
        }


        .social-login a:hover {
            background: #f0f0f0;
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
            animation: fadeIn 1.2s ease-in-out;
        }

        .footer-text a {
            color: #3b82f6;
            text-decoration: none;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        /* Animations */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes fadeInLeft {
            0% {
                opacity: 0;
                transform: translateX(-50px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            0% {
                opacity: 0;
                transform: translateX(50px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes moveUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateX(-30px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .container-wrapper {
                flex-direction: column;
            }

            .right-section {
                height: 300px;
            }
        }


        /* Full-page overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.6);
            /* Semi-transparent black */
            z-index: 9998;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Center the error message */
        .error-container {
            position: relative;
            z-index: 9999;
            width: 450px;
            max-width: 90%;
            background: linear-gradient(to bottom, #fff5f5, #fce4e4);
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            padding: 20px;
            font-family: 'Poppins', sans-serif;
            animation: jumpin 0.5s ease-in-out;
        }

        /* Close button styling */
        .close-btn {
            font-size: 20px;
            color: #888;
            cursor: pointer;
            float: right;
            transition: color 0.3s;
        }

        .close-btn:hover {
            color: #555;
        }

        /* Error message list styling */
        .error-box ul {
            list-style: none;
            padding: 0;
            margin: 0;
            color: #444;
            line-height: 1.6;
        }

        /* Animation for smooth appearance */
        @keyframes jumpin {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    @if ($errors->any())
    <div class="overlay" id="errorOverlay">
        <div class="error-container">
            <div class="error-box">
                <span class="close-btn" onclick="closeErrorBox()">&times;</span>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif


    <div class="container-wrapper">
        <!-- Left Section -->
        <div class="left-section text-center">
            <div class="form-container my-4">
                <h1>Forgot your password?</h1>
                <p>Reset it with one simple click</p>
                <form class="log">
                    <div class="form-group">
                        <label>
                            <span>Enter Email</span>
                            <input type="email" placeholder="Enter your email" required>
                        </label>

                    </div>
                    <button class="btn mb-4 back-log">Request Password Reset Link</button>
                </form>

                <a class="back-log my-4" href="{{ url('/') }}"> <i class="fa-solid fa-left-long"></i> Back to Log In</a>
            </div>

        </div>

        <!-- Right Section -->
        <div class="right-section"></div>
    </div>

    <script>
        // Close the error box and remove the overlay
        function closeErrorBox() {
            const overlay = document.getElementById('errorOverlay');
            if (overlay) {
                overlay.style.display = 'none';
            }
        }
    </script>

</body>

</html>