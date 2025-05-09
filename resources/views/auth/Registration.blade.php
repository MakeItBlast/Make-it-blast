@if ($errors->any())
<div id="errorOverlay" data-close="true">
    <div class="error-container">
        <div class="error-box" id="error-box" data-close="false">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        .input-field {
            position: relative;
            margin-bottom: 20px;
        }

        .input-field input {
            width: 100%;
            height: 60px;
            border-radius: 6px;
            font-size: 16px;
            padding: 0 45px 0 15px;
            border: 1px solid #ccc;
            background: transparent;
            color: #555;
            outline: none;
            transition: border 0.3s ease;
        }

        .input-field label {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #555;
            font-size: 16px;
            pointer-events: none;
            transition: 0.3s;
            background: #fff;
            padding: 0 5px;
        }

        .input-field input:focus {
            border: 2px solid #555;
        }

        .input-field input:focus~label,
        .input-field input.has-value~label {
            top: 0;
            left: 15px;
            font-size: 15px;
            color: #555;
            background: #fff;
            padding: 0 5px;
        }

        .input-field i.fa-regular,
        .input-field i.fa-solid {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #555;
            pointer-events: none;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
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
            color: #fff;
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

        /* Password Requirements Styling - Initially Hidden */
        .password-requirements {
            margin-top: -15px;
            margin-bottom: 15px;
            font-size: 12px;
            color: #666;
            display: none;
            /* Initially hidden */
            background: #fff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border: 1px solid #eee;
        }

        .requirement {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .requirement i {
            margin-right: 5px;
            font-size: 10px;
        }

        .requirement.valid {
            color: #4CAF50;
        }

        .requirement.invalid {
            color: #F44336;
        }

        /* Password Error Message */
        .password-error {
            font-size: 12px;
            color: #F44336;
            margin-top: 5px;
            display: none;
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

        /* Error container */
        #errorOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.6);
            z-index: 9998;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #errorBox {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            max-width: 500px;
        }

        /* Error box styling */
        .error-box {
            background: #ffebee;
            color: #d32f2f;
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

        /* Animation for smooth appearance */
        @keyframes jumpIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .one-time {
            display: none;
        }

        /* Phone number with country code */
        .phone-input-container {
            display: flex;
            width: 100%;
        }

        .country-code-selector {
            width: 120px;
            margin-right: 10px;
            position: relative;
        }

        .country-code-selector select {
            width: 100%;
            height: 60px;
            border-radius: 6px;
            font-size: 16px;
            padding: 0 15px;
            border: 1px solid #ccc;
            background: transparent;
            color: #555;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .country-code-selector::after {
            content: "▼";
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #555;
            pointer-events: none;
        }

        .phone-number-input {
            flex: 1;
            position: relative;
        }

        /* Flag styling */
        .flag-icon {
            width: 20px;
            height: 15px;
            margin-right: 8px;
            display: inline-block;
            vertical-align: middle;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .container-wrapper {
                flex-direction: column;
            }

            .right-section {
                height: 300px;
            }

            .country-code-selector {
                width: 100px;
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
                <form class="log" method="POST" action="{{ url('register') }}" id="registerForm">
                    @csrf

                    <div class="input-field">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                        <label for="email">Email Address</label>
                        <i class="fa-regular fa-envelope"></i>
                    </div>

                    <div class="input-field">
                        <input type="password" name="password" id="password" value="{{ old('password') }}" required
                            onkeyup="checkPasswordStrength()"
                            onblur="validatePasswordOnBlur()">
                        <label for="password">Password</label>
                        <span class="toggle-password" onclick="togglePassword('password', 'eyeIcon')">
                            <i id="eyeIcon" class="fa fa-eye"></i>
                        </span>
                        <div class="password-error" id="passwordError">
                            Password must contain at least 8 characters, including uppercase, lowercase, number and special character.
                        </div>
                        <div class="password-requirements" id="passwordRequirements">
                            <div class="requirement" id="lengthReq">
                                <i class="fas fa-circle"></i> At least 8 characters
                            </div>
                            <div class="requirement" id="upperReq">
                                <i class="fas fa-circle"></i> At least 1 uppercase letter
                            </div>
                            <div class="requirement" id="lowerReq">
                                <i class="fas fa-circle"></i> At least 1 lowercase letter
                            </div>
                            <div class="requirement" id="numberReq">
                                <i class="fas fa-circle"></i> At least 1 number
                            </div>
                            <div class="requirement" id="specialReq">
                                <i class="fas fa-circle"></i> At least 1 special character
                            </div>
                        </div>
                    </div>

                    <div class="input-field">
                        <input type="password" name="password_confirmation" id="confirmPassword"
                            value="{{ old('password_confirmation') }}" required
                            onkeyup="checkPasswordMatch()">
                        <label for="confirmPassword">Confirm Password</label>
                        <span class="toggle-password" onclick="togglePassword('confirmPassword', 'confirmEyeIcon')">
                            <i id="confirmEyeIcon" class="fa fa-eye"></i>
                        </span>
                        <div id="passwordMatch" class="password-error"></div>
                    </div>

                    <div class="input-group d-flex" style="gap: 10px;">
                        <div class="input-field" style="flex:1;">
                            <input type="text" name="name" id="first_name" value="{{ old('name') }}" required>
                            <label for="first_name">First Name</label>
                            <i class="fa-regular fa-user"></i>
                        </div>

                        <div class="input-field" style="flex:1;">
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required>
                            <label for="last_name">Last Name</label>
                            <i class="fa-regular fa-user"></i>
                        </div>
                    </div>

                    <div class="input-field">
                        <div class="phone-input-container">
                            <div class="country-code-selector">
                                <select name="country_code" id="country_code" required>
                                    <option value="" data-code="" data-flag="">Select Country</option>
                                    <option value="+1" data-code="US" data-flag="🇺🇸" selected>🇺🇸 +1 (US)</option>
                                    <option value="+44" data-code="GB" data-flag="🇬🇧">🇬🇧 +44 (UK)</option>
                                    <option value="+91" data-code="IN" data-flag="🇮🇳">🇮🇳 +91 (IN)</option>
                                    <option value="+61" data-code="AU" data-flag="🇦🇺">🇦🇺 +61 (AU)</option>
                                    <option value="+971" data-code="AE" data-flag="🇦🇪">🇦🇪 +971 (AE)</option>
                                    <option value="+966" data-code="SA" data-flag="🇸🇦">🇸🇦 +966 (SA)</option>
                                    <option value="+92" data-code="PK" data-flag="🇵🇰">🇵🇰 +92 (PK)</option>
                                    <option value="+65" data-code="SG" data-flag="🇸🇬">🇸🇬 +65 (SG)</option>
                                    <option value="+60" data-code="MY" data-flag="🇲🇾">🇲🇾 +60 (MY)</option>
                                    <option value="+86" data-code="CN" data-flag="🇨🇳">🇨🇳 +86 (CN)</option>
                                    <option value="+81" data-code="JP" data-flag="🇯🇵">🇯🇵 +81 (JP)</option>
                                    <option value="+82" data-code="KR" data-flag="🇰🇷">🇰🇷 +82 (KR)</option>
                                    <option value="+33" data-code="FR" data-flag="🇫🇷">🇫🇷 +33 (FR)</option>
                                    <option value="+49" data-code="DE" data-flag="🇩🇪">🇩🇪 +49 (DE)</option>
                                    <option value="+7" data-code="RU" data-flag="🇷🇺">🇷🇺 +7 (RU)</option>
                                    <option value="+55" data-code="BR" data-flag="🇧🇷">🇧🇷 +55 (BR)</option>
                                    <option value="+52" data-code="MX" data-flag="🇲🇽">🇲🇽 +52 (MX)</option>
                                    <option value="+234" data-code="NG" data-flag="🇳🇬">🇳🇬 +234 (NG)</option>
                                    <option value="+20" data-code="EG" data-flag="🇪🇬">🇪🇬 +20 (EG)</option>
                                    <option value="+27" data-code="ZA" data-flag="🇿🇦">🇿🇦 +27 (ZA)</option>
                                </select>
                            </div>
                            <div class="phone-number-input">
                                <input type="text" name="mobile_number" id="mobile_number" required placeholder="(123) 456-7890">
                                <label for="mobile_number">Phone Number</label>
                                <i class="fa-solid fa-phone"></i>
                                <div id="mobileError" class="text-danger mt-1" style="font-size: 0.875rem;"></div>
                            </div>
                        </div>
                    </div>

                    <input type="submit" class="btn" value="Get Started">
                </form>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section"></div>
    </div>

    <script>
        // Close error box
        function closeErrorBox() {
            const errorOverlay = document.getElementById('errorOverlay');
            if (errorOverlay) {
                errorOverlay.style.display = 'none';
            }
        }

        // for error and success message 
        document.addEventListener('DOMContentLoaded', () => {
            // Close the popups when clicking outside the box
            document.addEventListener('click', (event) => {
                // Error box logic
                const errorOverlay = document.getElementById('errorOverlay');
                if (errorOverlay && event.target.dataset.close === "true") {
                    closeErrorBox();
                }
            });
        });

        function togglePassword(fieldId, iconId) {
            const input = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }


        // Password strength checker
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;

            // Check requirements
            const hasMinLength = password.length >= 8;
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecialChar = /[#?!@$%^&*-]/.test(password);

            // Update requirement indicators
            updateRequirement('lengthReq', hasMinLength);
            updateRequirement('upperReq', hasUpperCase);
            updateRequirement('lowerReq', hasLowerCase);
            updateRequirement('numberReq', hasNumber);
            updateRequirement('specialReq', hasSpecialChar);

            // Also check password match if confirm password has value
            if (document.getElementById('confirmPassword').value) {
                checkPasswordMatch();
            }
        }

        // for mobile number field 
        const phoneInput = document.getElementById('mobile_number');
        const errorDiv = document.getElementById('mobileError');
        const form = document.getElementById('myForm');

        // Format input as (123) 456-7890
        phoneInput.addEventListener('input', function(e) {
            let input = e.target.value.replace(/\D/g, '').substring(0, 10); // Only digits, max 10
            const areaCode = input.substring(0, 3);
            const middle = input.substring(3, 6);
            const last = input.substring(6, 10);

            if (input.length > 6) {
                e.target.value = `(${areaCode}) ${middle}-${last}`;
            } else if (input.length > 3) {
                e.target.value = `(${areaCode}) ${middle}`;
            } else if (input.length > 0) {
                e.target.value = `(${areaCode}`;
            }
        });

        // Validation on submit
        form.addEventListener('submit', function(e) {
            const rawDigits = phoneInput.value.replace(/\D/g, '');

            if (rawDigits.length !== 10) {
                e.preventDefault();
                errorDiv.innerText = 'Phone number must be exactly 10 digits.';
            } else {
                errorDiv.innerText = '';
            }
        });

        function updateRequirement(elementId, isValid) {
            const element = document.getElementById(elementId);
            if (isValid) {
                element.classList.add('valid');
                element.classList.remove('invalid');
                element.innerHTML = '<i class="fas fa-check-circle"></i> ' + element.textContent.replace(/^.*?\)/, '').trim();
            } else {
                element.classList.add('invalid');
                element.classList.remove('valid');
                element.innerHTML = '<i class="fas fa-times-circle"></i> ' + element.textContent.replace(/^.*?\)/, '').trim();
            }
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const matchElement = document.getElementById('passwordMatch');

            if (confirmPassword === '') {
                matchElement.textContent = '';
                matchElement.style.display = 'none';
                return;
            }

            if (password === confirmPassword) {
                matchElement.textContent = 'Passwords match!';
                matchElement.style.color = '#4CAF50';
                matchElement.style.display = 'block';
            } else {
                matchElement.textContent = 'Passwords do not match!';
                matchElement.style.color = '#F44336';
                matchElement.style.display = 'block';
            }
        }

        // Validate password when leaving the field
        function validatePasswordOnBlur() {
            const password = document.getElementById('password').value;
            const passwordError = document.getElementById('passwordError');
            const requirements = document.getElementById('passwordRequirements');

            if (password === '') {
                passwordError.style.display = 'none';
                requirements.style.display = 'none';
                return;
            }

            // Check requirements
            const hasMinLength = password.length >= 8;
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecialChar = /[#?!@$%^&*-]/.test(password);

            const isValid = hasMinLength && hasUpperCase && hasLowerCase && hasNumber && hasSpecialChar;

            if (!isValid) {
                passwordError.style.display = 'block';
                requirements.style.display = 'block';
            } else {
                passwordError.style.display = 'none';
                requirements.style.display = 'none';
            }
        }

        // 👇 Auto-float labels if input already has value (on load)
        window.addEventListener('load', () => {
            document.querySelectorAll('.input-field input').forEach(input => {
                if (input.value.trim() !== "") {
                    input.classList.add('has-value');
                }

                // Live update as user types
                input.addEventListener('input', () => {
                    if (input.value.trim() !== "") {
                        input.classList.add('has-value');
                    } else {
                        input.classList.remove('has-value');
                    }
                });
            });

            // Check password strength on load if there's a value
            if (document.getElementById('password').value) {
                checkPasswordStrength();
                validatePasswordOnBlur();
            }
        });

        // Phone number validation
        document.getElementById("mobile_number").addEventListener("input", function(e) {
            let value = e.target.value.replace(/\D/g, ""); // Remove non-numeric characters
            if (value.length == 10) {
                value = value.slice(0, 10); // Restrict input to max 11 digits
            }
            e.target.value = value;
        });


        // Initialize country code selector
        document.addEventListener('DOMContentLoaded', function() {
            const countryCodeSelect = document.getElementById('country_code');

            // Set default country code based on user's location if needed
            if (!countryCodeSelect.value) {
                countryCodeSelect.value = '+1';
            }
        });

        // Form validation before submission
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;

            // Check password requirements
            const hasMinLength = password.length >= 8;
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecialChar = /[#?!@$%^&*-]/.test(password);

            if (!hasMinLength || !hasUpperCase || !hasLowerCase || !hasNumber || !hasSpecialChar) {
                e.preventDefault();
                document.getElementById('passwordError').style.display = 'block';
                document.getElementById('passwordRequirements').style.display = 'block';
                document.getElementById('password').focus();
                return false;
            }

            // Check password match
            const confirmPassword = document.getElementById('confirmPassword').value;
            if (password !== confirmPassword) {
                e.preventDefault();
                document.getElementById('passwordMatch').textContent = 'Passwords do not match!';
                document.getElementById('passwordMatch').style.color = '#F44336';
                document.getElementById('passwordMatch').style.display = 'block';
                document.getElementById('confirmPassword').focus();
                return false;
            }

            return true;
        });

        function dddr() {
            const x = document.getElementById('email').value;
            console.log(x);

            if (!x) {
                alert('Please enter your email.');
                return;
            }

            $.ajax({
                url: '{{ url("send-opt-to-verify-email") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    verify_email: x
                },
                success: function(response) {
                    alert('OTP sent to your email!');
                    console.log(response);
                },
                error: function(xhr) {
                    alert('Something went wrong!');
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
</body>

</html>