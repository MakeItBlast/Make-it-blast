<!doctype html>
<html>
<head> 
	<meta charset="UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'Make It Blast')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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

   
    @yield('style')

</head>
<body>

	@include('admin.partials.header')

	@yield('content')
	
	@include('admin.partials.scripts')
	@yield('script')
</body>
</html>