@extends('layouts.user')

@section('title', __('Wallet Overview'))

@section('bread')
<div class="page-title-box">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h4 class="page-title">Dashboard</h4>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
				<li class="breadcrumb-item active">Wallet</li>
			</ol>
		</div>
	</div>
</div>
@endsection

@push('more-styles')
<link rel="stylesheet" href="{{ asset('plugins/morris/morris.css') }}">
<style type="text/css">
	.profile-user-wid{margin-top:-36px}
	.bg-soft-primary{background-color:rgba(85,110,230,.25)!important}
</style>
@endpush

@push('more-scripts')
@endpush

@section('content')
<div class="row">
	<div class="col-xl-6">
		<div class="row">
			<div class="col-xl-12">
				<div class="card">
					<div class="card-heading p-4">
						<div class="mini-stat-icon float-right">
							<i class="fas fa-wallet bg-success text-white"></i>
						</div>
						<div>
							<h5 class="font-16">Total Balance</h5>
						</div>
						<h3 class="mt-4">₦{{ number_format($user->wallet->amount,2) }}</h3>
						<p class="text-muted mt-2 mb-0"></p>
						<br><br>
						<ul>
							<li>Total Investment Payout: <b>₦{{ number_format($paid_investment,2) }}</b></li>
							<li>Total ROI Received: <b>₦{{ number_format($paid_roi,2) }}</b></li>
							<li>Total Bank Deposit: <b>₦{{ number_format($bank_deposit,2) }}</b></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-3">
		<div class="row">
			<div class="col-xl-12">
				<div class="card">
					<div class="card-heading p-4">
						<div class="mini-stat-icon float-right">
							<i class="fas fa-wallet bg-warning text-white"></i>
						</div>
						<div>
							<h5 class="font-16">Available Funds</h5>
						</div>
						<h3 class="mt-4">₦{{ number_format($user->wallet->amount-$user->mandates()->sum('amount'),2) }}</h3>
						<p class="text-muted mt-2 mb-0"></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-3">
		<div class="row">
			<div class="col-xl-12">
				<div class="card">
					<div class="card-heading p-4">
						<div class="mini-stat-icon float-right">
							<i class="fas fa-wallet bg-danger text-white"></i>
						</div>
						<div>
							<h5 class="font-16">Non-withdrawable Funds</h5>
						</div>
						<h3 class="mt-4">₦{{ number_format($user->mandates()->sum('amount'),2) }}</h3>
						<p class="text-muted mt-2 mb-0"></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END ROW -->
@endsection