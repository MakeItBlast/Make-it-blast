<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
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


        /* Form container styling */
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

        .form-control {
            width: 100%;
            height: 60px;
            border-radius: 6px;
            font-size: 18px;
            padding: 0 15px;
            border: 2px solid #fff;
            background: transparent;
            outline: none;
        }

        .floating-label {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #000;
            font-size: 16px;
            pointer-events: none;
            transition: 0.3s ease;
            background: #fff;
            padding: 0 4px;
        }

        .form-group.focused .floating-label {
            top: 0;
            font-size: 15px;
            color: #000;
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



        /* Overlay styling */
        #errorOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Semi-transparent black */
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Error container */
        .error-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        /* Error box styling */
        .error-box {
            background: #ffebee;
            /* Light red background */
            color: #d32f2f;
            /* Dark red text */
            padding: 25px;
            border: 1px solid #f44336;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 500px;
            max-width: 90%;
            position: relative;
            animation: jumpIn 0.5s;
        }

        /* Close button */
        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 22px;
            color: #555;
            cursor: pointer;
            background: none;
            border: none;
        }

        .close-btn:hover {
            color: #f44336;
        }

        /* Error list styling */
        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            margin: 5px 0;
            font-size: 16px;
        }

        /* Fade-in animation */
        @keyframes jumpIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>

<body>

    @if ($errors->any())
    <div id="errorOverlay">
        <div class="error-container">
            <div class="error-box" id="error-box">
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
        <div class="left-section">
            <div class="form-container">
                <h1>Welcome back</h1>
                <p>Power Up Your Campaigns – One Login Away!</p>

                <form class="sign" method="POST" action="{{  url('/login/') }}">
                    @csrf
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" required>
                        <label class="floating-label">Enter your e-mail</label>
                        <i class="fa-regular fa-envelope"></i>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" id="passwordInput" name="password" required>
                        <label class="floating-label">Enter your password</label>
                        <span class="toggle-password" onclick="togglePassword()" style="position: absolute; top: 50%; right: 10px; cursor: pointer;">
                            <i id="eyeIcon" class="fa fa-eye"></i>
                        </span>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-2">Login</button>
                    <a href="{{ url('forgot-password')}}" class="d-block text-center mt-4 mb-4 for-pass">Forgot Password?</a>
                    <div class="form-check">
                        <div class="rem-user">
                            <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">
                                Remember my username
                            </label>
                        </div>

                    </div>
                    <div class="text-center mt-3 text-uppercase">or sign up with</div>

                    <div class="social-login">
                        <a href="{{ url('/auth/facebook') }}" class="fb"><i class="fa-brands fa-facebook" style="color: #4372e6; font-size:30px;"></i></a>
                        <a href="{{ url('/auth/google') }}" class="google"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 48 48">
                                <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
                                <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
                                <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
                                <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                            </svg></a>
                        <a href="#" class="apple"><i class="fa-brands fa-apple" style="color: #000000; font-size:30px;"></i></a>
                    </div>

                    <div class="footer-text">
                        Don't have an account? <a href="{{ url('sign-up') }}">Sign Up</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section"></div>
    </div>

    <script>
        // for popup overlay
        // Function to close the error popup
        function closeErrorBox() {
            const overlay = document.getElementById('errorOverlay');
            if (overlay) {
                overlay.style.display = 'none';
            }
        }

        window.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('.form-group .form-control');

            const updateInputState = (input) => {
                const parent = input.closest('.form-group');
                if (input.value.trim() !== "") {
                    parent.classList.add('focused');
                } else {
                    parent.classList.remove('focused');
                }
            };

            inputs.forEach(input => {
                const parent = input.closest('.form-group');

                // Run after all rendering + value population
                setTimeout(() => {
                    updateInputState(input);
                }, 0);

                input.addEventListener('input', () => updateInputState(input));
                input.addEventListener('focus', () => parent.classList.add('focused'));
                input.addEventListener('blur', () => updateInputState(input));
            });
        });

        // Password toggle 
        function togglePassword() {
            const passwordInput = document.getElementById("passwordInput");
            const eyeIcon = document.getElementById("eyeIcon");

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

        // Close the error box and remove the overlay
        function closeErrorBox() {
            const overlay = document.getElementById('errorOverlay');
            if (overlay) {
                overlay.style.display = 'none';
            }
        }

        // Close the popup when clicking outside the error box
        document.addEventListener('click', function(event) {
            const overlay = document.getElementById('errorOverlay');
            const errorBox = document.getElementById('error-box');

            if (event.target === overlay) {
                closeErrorBox();
            }
        });
    </script>

</body>

</html>