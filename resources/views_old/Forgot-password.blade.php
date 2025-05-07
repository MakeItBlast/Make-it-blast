@include('header')
<link rel="stylesheet" href="{{ asset('styles/forgot-pass.css') }}">
</head>
<body>
    <div class="main">
        <div class="slider-container">
        <div class="slider">
            <div class="slide"><img src="/media/33964222_03nov8.jpg?text=Slide+1" alt="Slide 1"></div>
            <div class="slide"><img src="/media/8_april_4.jpg?text=Slide+2" alt="Slide 2"></div>
            <div class="slide"><img src="/media/9425946_412.jpg?text=Slide+3" alt="Slide 3"></div>
        </div>
        <button class="prev">&#10094;</button>
        <button class="next">&#10095;</button>
    </div>
        <div class="log-in">
        <form class="log">
            <h2>Forgot Password ?</h2>
            <p>Please enter the emial used to register</p>
            <div class="input-group">
                <label>
                    <span>Enter Email</span>
                    <input type="email" placeholder="Enter your email" required>
                </label>
                
            </div>
            <button class="btn">Request Password Reset Link</button>
        </form>

        <a class="back-log" href="/"> <i class="fa-solid fa-left-long"></i> Back to Log In</a>

        
        </div> 
    </div>


</body>
</html>
