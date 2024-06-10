<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- CSS -->
	<link rel="stylesheet" href="{{ asset('css/bootstrap-reboot.min.css') }} ">
	<link rel="stylesheet" href="{{ asset('css/bootstrap-grid.min.css') }} ">
	<link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }} ">
	<link rel="stylesheet" href="{{ asset('css/select2.min.css') }} ">
	<link rel="stylesheet" href="{{ asset('css/admin.css') }} ">

	<!-- Favicons -->

	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="Dmitry Volkov">
	<title>FlixTV – Movies & TV Shows, Online cinema HTML Template</title>

</head>
<body>
	<!-- sign in -->
	<div class="sign section--bg" data-bg="img/bg.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="sign__content">
						@yield('main')
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end sign in -->

	<!-- JS -->
	<script src="{{ asset('js/jquery-3.5.1.min.js') }} "></script>
	<script src="{{ asset('js/bootstrap.bundle.min.js') }} "></script>
	<script src="{{ asset('js/jquery.magnific-popup.min.js') }} "></script>
	<script src="{{ asset('js/smooth-scrollbar.js') }} "></script>
	<script src="{{ asset('js/select2.min.js') }} "></script>
	<script src="{{ asset('js/admin.js') }} "></script>
</body>
</html>