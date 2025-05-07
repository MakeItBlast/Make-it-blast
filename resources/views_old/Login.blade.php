@include('header')
<link rel="stylesheet" href="{{ asset('styles/login.css') }}">

<body>

    <div class="container my-4">
        <div class="row justify-content-center">
            <!-- Slider Section -->
            <!-- Bootstrap Carousel -->
            <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <!-- Indicators -->
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>

                    <!-- Slides -->
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{asset('/public/media/33964222_03nov8.jpg')}}" class="d-block w-100" alt="Slide 1">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('/public/media/8_april_4.jpg')}}" class="d-block w-100" alt="Slide 2">
                        </div>
                        <div class="carousel-item">
                            <img src="{{asset('/public/media/9425946_412.jpg')}}" class="d-block w-100" alt="Slide 3">
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>


            <!-- Login Section -->
            <div class="col-lg-6 col-md-6 col-sm-12 frm">
                <div class="log-frm">
                    <div class="card p-4 shadow-sm">
                        <h2 class="text-center">Blast It Now</h2>
                        <h3 class="text-center">Login</h3>
                        <p class="text-center">Don't have an account? <a href="{{ url('sign-up') }}" class="text-decoration-none">Sign up free</a></p>

                        <form class="sign" method="POST" action="{{url('profile')}}">
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="mb-3 position-relative">
                                <input type="password" class="form-control" placeholder="Password" required id="passwordInput">
                                <span class="toggle-password" onclick="togglePassword()" style="position: absolute; top: 50%; right: 10px; cursor: pointer;">
                                    <i id="eyeIcon" class="fa fa-eye"></i>
                                </span>
                            </div>
                            <button class="btn btn-primary w-100 mb-2">Login</button>
                            <a href="{{ url('forgot-password')}}" class="d-block text-center mb-2">Forgot Password?</a>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">
                                    Remember my username
                                </label>
                            </div>

                            <div class="social-login text-center mt-4">
                                <a class="btn btn-outline-danger w-100 mb-2" href="#"><i class="fa-brands fa-google me-2"></i>Login with Google</a>
                                <a class="btn btn-outline-dark w-100 mb-2" href="#"><i class="fa-brands fa-apple me-2"></i>Login with Apple</a>
                                <a class="btn btn-outline-primary w-100" href="#"><i class="fa-brands fa-facebook-f me-2"></i>Login with Facebook</a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
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
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var myCarousel = new bootstrap.Carousel(document.querySelector('#carouselExampleIndicators'), {
                interval: 3000, // Change slide every 3 seconds
                wrap: true, // Allows infinite looping
                pause: 'hover' // Pause on mouse hover
            });

            // Optional: Event listener for debugging
            document.querySelector('#carouselExampleIndicators').addEventListener('slid.bs.carousel', function(event) {
                console.log('Slide changed to index:', event.to);
            });
        });
    </script>
</body>