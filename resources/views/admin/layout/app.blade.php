<!doctype html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>@yield('title', 'Make It Blast')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Font Family -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=poppins">
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

	@include('admin.partials.styles')
	@yield('styles')

</head>

<body>

	<!-- Global Loader -->
	<div id="global-loader" style="display: none;">
		<div class="loader">
			<div class="justify-content-center jimu-primary-loading"></div>
		</div>
	</div>

	<div class="wrapper">
		@include('admin.partials.sidebar')

		<div class="content" id="content">
			@include('admin.partials.header')
			@yield('content')
		</div>

	</div>

	<!-- global toast -->
	<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
		<div id="ajaxToast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="d-flex">
				<div class="toast-body">
					This is a toast message.
				</div>
				<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
		</div>
	</div>






	@include('admin.partials.scripts')
	@yield('scripts')
</body>

</html>