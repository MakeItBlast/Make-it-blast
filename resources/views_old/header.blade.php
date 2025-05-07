<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #90caf9;
            padding: 15px 20px;
            color: white;
        }

        .main {
            width: 100%;
            max-width: 1300px;
            margin: 0 auto;
            padding-top: 40px;
        }

        .header h2 {
            font-size: 30px;
            color: #000;
        }

        .menu-icon,
        .profile-icon {
            font-size: 24px;
            cursor: pointer;
            color: #000;
        }

        .profile {
            color: #000 !important;
        }

        /* Off-Canvas Menu */
        .off-canvas {
            position: fixed;
            top: 0;
            left: -250px;
            /* Initially hidden */
            width: 250px;
            height: 100%;
            background: #222;
            color: white;
            padding-top: 20px;
            transition: 0.3s;
            box-shadow: 2px 0px 10px rgba(0, 0, 0, 0.3);
            z-index: 99;
        }

        .off-canvas a {
            display: block;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            border-bottom: 1px solid #444;
        }

        .off-canvas a:hover {
            background: #444;
        }

        .close-btn {
            font-size: 24px;
            padding: 10px;
            cursor: pointer;
            display: block;
            text-align: right;
            color: white;
        }

        /* Overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 90;
        }

        input::-webkit-inner-spin-button {
            display: none;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="header">
        <i class="fas fa-bars menu-icon" onclick="openMenu()"></i>
        <h2>Blast It Now</h2>
        <a class="profile" href="{{ url('profile')}}"><i class="fas fa-user-circle profile-icon"></i></a>

    </div>

    <!-- Off-Canvas Menu -->
    <div class="off-canvas" id="sideMenu">
        <span class="close-btn" onclick="closeMenu()"><i class="fa-solid fa-xmark"></i></span>
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="{{ url('profile')}}">My Profile</a>
        <a href="{{ url('blast-dashboard') }}">Create Blast</a>
        <a href="#">Services</a>
        <a href="/">Login</a>
        <a href="{{ url('sign-up') }}">Register</a>
        <a href="#">Contact</a>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay" onclick="closeMenu()"></div>

    <script>
        function openMenu() {
            document.getElementById("sideMenu").style.left = "0";
            document.getElementById("overlay").style.display = "block";
        }

        function closeMenu() {
            document.getElementById("sideMenu").style.left = "-250px";
            document.getElementById("overlay").style.display = "none";
        }
    </script>

</body>

</html>