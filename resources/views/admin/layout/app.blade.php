<!doctype html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>@yield('title', 'Make It Blast')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Add in <head> section -->
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

	@include('admin.partials.styles')
	@yield('styles')

</head>

<body>

	<div class="wrapper">
		@include('admin.partials.sidebar') 

		<div class="content" id="content">
			@include('admin.partials.header')
			@yield('content')
		</div>

	</div>






	@include('admin.partials.scripts')
	@yield('scripts')
</body>

</html>