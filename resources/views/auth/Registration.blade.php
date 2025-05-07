@if ($errors->any())
    <div class="error-messages">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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

        body, html {
            height: 100%;
            background: #f4f4f4;
        }

        .container-wrapper {
            display: flex;
            height: 100vh;
        }

        /* Left Section */
        .left-section {
            width:40%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fff;
            padding: 40px;
            animation: fadeInLeft 1s ease-in-out;
        }

        /* Right Section */
        .right-section {
            width:60%;
            background: url("{{ asset('/media/2150208257.jpg') }}") no-repeat center center/cover;
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
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
            animation: fadeIn 1.4s ease-in-out;
        }

        /* Form Styling */
        form.log {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .input-group {
            position: relative;
        }

        .input-group label {
            display: flex;
            width:100%;
            flex-direction: column;
            gap: 5px;
        }

        .input-group span {
            font-size: 14px;
            color: #666;
        }

        .input-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            transition: 0.3s;
        }

        .input-group input:focus {
            border-color: #3b82f6;
            outline: none;
        }

        .input-group i {
            position: absolute;
            right: 15px;
            top: 65%;
            transform: translateY(-50%);
            color: #666;
            cursor: pointer;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: #3b82f6;
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 16px;
            transition: 0.3s;
            cursor: pointer;
        }

        .btn:hover {
            background: #2563eb;
        }

        .form-container p {
            font-size: 13px;
            color: #555;
        }

        .form-container a {
            color: #3b82f6;
            text-decoration: none;
        }

        .form-container a:hover {
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

        /* Responsive Design */
        @media (max-width: 992px) {
            .container-wrapper {
                flex-direction: column;
            }
            .right-section {
                height: 300px;
            }
        }
    </style>
</head>
<body>

<div class="container-wrapper">
    <!-- Left Section -->
    <div class="left-section">
        <div class="form-container">
            <h1>Sign Up to Make It Blast</h1>
            <p>Start your journey</p>

            <!-- Updated Form -->
            <form class="log" method="POST" action="{{ url('register') }}">
            @csrf

                <div class="input-group">
                    <label>
                        <span>Email Address</span>
                        <input type="email" name="email" placeholder="Enter your Email" required>
                        <i class="fa-regular fa-envelope"></i>
                    </label>
                </div>

                <div class="input-group">
                    <label>
                        <span>Password</span>
                        <input type="password" name="password" id="password" placeholder="Enter your Password" required>
                        <span class="toggle-password" onclick="togglePassword('password', 'eyeIcon')">
                            <i id="eyeIcon" class="fa fa-eye"></i>
                        </span>
                    </label>
                </div>

                <div class="input-group">
                    <label>
                        <span>Confirm Password</span>
                        <input type="password" name="password_confirmation" id="confirmPassword" placeholder="Re-enter your Password" required>
                        <span class="toggle-password" onclick="togglePassword('confirmPassword', 'confirmEyeIcon')">
                            <i id="confirmEyeIcon" class="fa fa-eye"></i>
                        </span>
                    </label>
                </div>

                <div class="input-group">
                    <label>
                        <span>First Name</span>
                        <input type="text" name="name" placeholder="Enter your name" required>
                        <i class="fa-regular fa-envelope"></i>
                    </label>
                </div>

                <div class="input-group">
                    <label>
                        <span>Phone Number</span>
                        <input type="number" name="mobile_number" placeholder="Enter your phone number" required>
                        <i class="fa-regular fa-envelope"></i>
                    </label>
                </div>
                <input type="submit" class="btn" value="Get Started">
            </form>
        </div>
    </div>

    <!-- Right Section -->
    <div class="right-section"></div>
</div>

<script>
    // Toggle password visibility
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(iconId);

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>

</body>
</html>
