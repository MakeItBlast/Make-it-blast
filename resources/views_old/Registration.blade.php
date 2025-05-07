@include('header')
<link rel="stylesheet" href="{{ asset('/public/styles/registration.css') }}">

</head>
<body>
    <!-- Display any errors if present -->
    @if ($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif
    <div class="top">
        <div class="slider-container">
            <div class="slider">
                <div class="slide"><img src="{{ asset('/public/media/33964222_03nov8.jpg?text=Slide+1')}}" alt="Slide 1"></div>
                <div class="slide"><img src="{{ asset('/public/media/8_april_4.jpg?text=Slide+2')}}" alt="Slide 2"></div>
                <div class="slide"><img src="{{ asset('/public/media/9425946_412.jpg?text=Slide+3')}}" alt="Slide 3"></div>
            </div>
            <button class="prev">&#10094;</button>
            <button class="next">&#10095;</button>
        </div>

        <div class="log-in">
            <h2>Start today for <span class="free">Free!</span></h2>

            <form class="log" method="POST" action="{{ url('register') }}">
                @csrf

                <div class="input-group">
                    <label>
                        <span>Email Address</span>
                        <input type="email" placeholder="Enter your Email" name="email" value="{{ old('email') }}" required>
                    </label>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <label>
                        <span>Password</span>
                        <input type="password" placeholder="Enter your Password" name="password" required>
                        <span class="toggle-password" onclick="togglePassword()">
                            <i id="eyeIcon" class="fa fa-eye"></i>
                        </span>
                    </label>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <label>
                        <span>Confirm Password</span>
                        <input type="password" placeholder="Re-enter your Password" name="password_confirmation" required>
                        <span class="toggle-password" onclick="togglePassword()">
                            <i id="eyeIcon" class="fa fa-eye"></i>
                        </span>
                    </label>
                    @error('password_confirmation')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <label>
                        <span>First Name</span>
                        <input type="text" placeholder="Enter your name" name="name" value="{{ old('name') }}" required>
                    </label>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <label>
                        <span>Mobile Number</span>
                        <input type="number" placeholder="Enter your mobile number" name="mobile_number" value="{{ old('mobile_number') }}" required>
                    </label>
                    @error('mobile_number')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <p>By clicking “Get Started”, you agree to the <a class="tos" href="#">Terms of Service</a> and acknowledge receipt of our <a class="policy" href="#">Privacy Notice</a></p>

                <button class="btn">Get Started</button>
            </form>
        </div>
    </div>

    <script>
        const slider = document.querySelector('.slider');
        const slides = document.querySelectorAll('.slide');
        const prevBtn = document.querySelector('.prev');
        const nextBtn = document.querySelector('.next');
        let index = 0;

        function updateSlide() {
            slider.style.transform = `translateX(${-index * 100}%)`;
        }

        function nextSlide() {
            index = (index + 1) % slides.length;
            updateSlide();
        }

        function prevSlide() {
            index = (index - 1 + slides.length) % slides.length;
            updateSlide();
        }

        nextBtn.addEventListener('click', nextSlide);
        prevBtn.addEventListener('click', prevSlide);

        setInterval(nextSlide, 3000); // Auto slide every 3 seconds

        document.addEventListener("DOMContentLoaded", function () {
            const passwordField = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");
            const togglePassword = document.querySelector(".toggle-password");

            if (passwordField && eyeIcon && togglePassword) {
                togglePassword.addEventListener("click", function () {
                    if (passwordField.type === "password") {
                        passwordField.type = "text";
                        eyeIcon.classList.remove("fa-eye");
                        eyeIcon.classList.add("fa-eye-slash");
                    } else {
                        passwordField.type = "password";
                        eyeIcon.classList.remove("fa-eye-slash");
                        eyeIcon.classList.add("fa-eye");
                    }
                });
            }
        });
    </script>
</body>
</html>
