@php
App\Http\Controllers\Invokable\Invoke::init();
@endphp
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
		<title>@yield('title') | City Fresh Farms</title>
		<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
		<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
		<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
		<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
		<link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">
		<link rel="mask-icon" href="{{ asset('favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
		<meta name="msapplication-TileColor" content="#da532c">
		<meta name="theme-color" content="#ffffff">
	</head>
	<body>
		<div class="error-bg"></div>
		<div class="home-btn d-none d-sm-block">
			<a href="/" class="text-white"><i class="fas fa-home h2"></i></a>
		</div>
		<div class="account-pages">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-5 col-md-8">
						<div class="card shadow-lg">
							<div class="card-block">
								<div class="text-center p-3">
									<h1 class="error-page mt-4"><span>@yield('code')</span></h1>
									<h4 class="mb-4 mt-5">@yield('message')</h4>
									<p class="mb-4">@yield('sub-message')</p>
									<a class="btn btn-primary mb-4 waves-effect waves-light" href="{{ url()->previous() }}"><i class="mdi mdi-home"></i> Back to Dashboard</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('assets/js/metismenu.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
		<script src="{{ asset('assets/js/waves.min.js') }}"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
		<script src="{{ asset('assets/js/app.js') }}"></script>
	</body>
</html>