<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
		<title>@yield('title') | City Fresh Farms</title>
		<link href="{{ asset('plugins/sweet-alert2/sweetalert2.css') }}" rel="stylesheet" type="text/css">
		@stack('more-styles')
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
		<!-- Begin page -->
		<div id="wrapper">
			<!-- Top Bar Start -->
			<div class="topbar">
				<!-- LOGO -->
				<div class="topbar-left">
					<a href="/dashboard" class="logo">
					<span class="logo-light">
					<img src="{{ asset('cityfresh-farms-logo-small.png') }}" width="24px"> City Fresh Farms
					</span>
					<span class="logo-sm">
					<img src="{{ asset('cityfresh-farms-logo-small.png') }}" width="50px">
					</span>
					</a>
				</div>
				<nav class="navbar-custom">
					<ul class="navbar-right list-inline float-right mb-0">
						<!-- full screen -->
						<li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
							<a class="nav-link waves-effect" href="#" id="btn-fullscreen">
							<i class="mdi mdi-arrow-expand-all noti-icon"></i>
							</a>
						</li>
						<!-- notification -->
						<li class="dropdown notification-list list-inline-item">
							<a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
							<i class="mdi mdi-bell-outline noti-icon"></i>
							@if(auth()->user()->unreadNotifications()->count() > 0)
							<span class="badge badge-pill badge-danger noti-icon-badge">{{ auth()->user()->unreadNotifications()->count() }}</span>
							@endif
							</a>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-lg px-1">
								<!-- item-->
								<h6 class="dropdown-item-text">
									Notifications
									<a href="/notifications/myaction/viewall" class="float-right text-primary small">Mark all as read</a>
								</h6>
								<div class="slimscroll notification-item-list">
									<!-- item-->
									@forelse(auth()->user()->unreadNotifications as $notification)
									<a href="/notifications/{{ $notification->id }}" class="dropdown-item notify-item active">
										{!! $notification->data['icon'] !!}
										<p class="notify-details">{!! $notification->data['body'] !!}</p>
									</a>
									@endforeach
								</div>
								<!-- All-->
								<a href="/notifications" class="dropdown-item text-center notify-all text-primary">
								View all <i class="fi-arrow-right"></i>
								</a>
							</div>
						</li>
						<li class="dropdown notification-list list-inline-item">
							<div class="dropdown notification-list nav-pro-img">
								<a class="dropdown-toggle nav-link arrow-none nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
									@if(auth()->user()->profile_photo_path != 'storage/')
									<img src="{{ asset(auth()->user()->profile_photo_path) }}" alt="user" class="rounded-circle">
									@else
									<img src="{{ Gravatar::get(auth()->user()->email) }}" class="rounded-circle">
									@endif
								</a>
								<div class="dropdown-menu dropdown-menu-right profile-dropdown ">
									<!-- item-->
									<a class="dropdown-item" href="/profile"><i class="mdi mdi-account-circle"></i> Profile</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="mdi mdi-power text-danger"></i> Logout</a>
									<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
								</div>
							</div>
						</li>
					</ul>
					<ul class="list-inline menu-left mb-0">
						<li class="float-left">
							<button class="button-menu-mobile open-left waves-effect">
							<i class="mdi mdi-menu"></i>
							</button>
						</li>
					</ul>
				</nav>
			</div>
			<div class="left side-menu">
				<div class="slimscroll-menu" id="remove-scroll">
					<div id="sidebar-menu">
						<ul class="metismenu" id="side-menu">
							<li class="menu-title">Menu</li>
							<li>
								<a href="/dashboard" class="waves-effect">
								<i class="icon-accelerator"></i> <span> Dashboard </span>
								</a>
							</li>
							<li>
								<a href="/referrals" class="waves-effect">
								<i class="fas fa-users"></i> <span> Referrals </span>
								</a>
							</li>
							<li class="menu-title">Wallet</li>
							<li>
								<a href="/transactions" class="waves-effect">
								<i class="icon-graph-descending"></i> <span> Transactions </span>
								</a>
							</li>
							<li>
								<a href="javascript:void(0);" class="waves-effect"><i class="fas fa-wallet"></i><span> Wallet <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
								<ul class="submenu">
									<li><a href="/add-funds">Add Funds</a></li>
									<li><a href="/withdraw-fund">Withdraw Fund</a></li>
								</ul>
							</li>
							<li class="menu-title">Investments</li>
							<li>
								<a href="/packages" class="waves-effect">
								<i class="ti-direction-alt"></i> <span> Farms </span>
								</a>
							</li>
							<li>
								<a href="/investments" class="waves-effect">
								<i class="icon-diamond"></i> <span> Investments </span>
								</a>
							</li>
							<!--<li>
								<a href="/mandates" class="waves-effect">
								<i class="fab fa-uniregistry"></i> <span> Mandates </span>
								</a>
							</li>-->
						</ul>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="content-page">
				<div class="content">
					<div class="container-fluid">
						@yield('bread')
						@if(session('error'))
							{!! session('error') !!}
						@endif
						@yield('content')
					</div>
				</div>
				<footer class="footer">
					© 2021 City Fresh Farms LTD.
				</footer>
			</div>
		</div>
		<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('assets/js/metismenu.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
		<script src="{{ asset('assets/js/waves.min.js') }}"></script>
		@stack('more-scripts')
		<script src="{{ asset('plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
		<script src="{{ asset('assets/js/app.js') }}"></script>
		@if(session('error_bottom'))
			{!! session('error_bottom') !!}
		@endif
	</body>
</html>