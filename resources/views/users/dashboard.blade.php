@extends('layouts.user')

@section('title', __('Dashboard'))

@section('bread')
<div class="page-title-box">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h4 class="page-title">Dashboard</h4>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
				<li class="breadcrumb-item active">Dashboard</li>
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
<script src="{{ asset('plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('assets/pages/dashboard.init.js') }}"></script>
@endpush

@section('content')
<div class="row">
	<div class="col-sm-6 col-xl-3">
		<div class="card">
			<div class="card-heading p-4">
				<div class="mini-stat-icon float-right">
					<i class="icon-graph-descending bg-primary text-white"></i>
				</div>
				<div>
					<h5 class="font-16">Transactions</h5>
				</div>
				<h3 class="mt-4">₦{{ number_format($transactions,2) }}</h3>
				<div class="progress mt-4" style="height: 4px;">
					<div class="progress-bar bg-primary" role="progressbar" style="width: {{$transaction_percent}}%" aria-valuenow="{{$transaction_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<p class="text-muted mt-2 mb-0">Successful transaction<span class="float-right">{{round($transaction_percent)}}%</span></p>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-xl-3">
		<div class="card">
			<div class="card-heading p-4">
				<div class="mini-stat-icon float-right">
					<i class="icon-diamond bg-success text-white"></i>
				</div>
				<div>
					<h5 class="font-16">Total Investments</h5>
				</div>
				<h3 class="mt-4">₦{{ number_format($investments,2) }}</h3>
				<div class="progress mt-4" style="height: 4px;">
					<div class="progress-bar bg-success" role="progressbar" style="width: {{$active_investment}}%" aria-valuenow="{{$active_investment}}" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<p class="text-muted mt-2 mb-0">Active investments<span class="float-right">{{round($active_investment)}}%</span></p>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-xl-3">
		<div class="card">
			<div class="card-heading p-4">
				<div class="mini-stat-icon float-right">
					<i class="mdi mdi-buffer bg-danger text-white"></i>
				</div>
				<div>
					<h5 class="font-16">Referrals</h5>
				</div>
				<h3 class="mt-4">{{ $user->referrals()->count() }}</h3>
				<div class="progress mt-4" style="height: 4px;">
					<div class="progress-bar bg-danger" role="progressbar" style="width: {{$ref_percent}}%" aria-valuenow="{{$ref_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<p class="text-muted mt-2 mb-0">Commission paid<span class="float-right">{{round($ref_percent)}}%</span></p>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-xl-3">
		<div class="card">
			<div class="card-heading p-4">
				<div class="mini-stat-icon float-right">
					<i class="icon-graph-descending bg-warning text-white"></i>
				</div>
				<div>
					<h5 class="font-16">Pending Transactions</h5>
				</div>
				<h3 class="mt-4">₦{{ number_format($ptransactions,2) }}</h3>
				<p class="text-muted mt-2 mb-0"></p>
				<br><br>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xl-6">
		<div class="card overflow-hidden m-b-30">
			<div class="bg-soft-primary">
				<div class="row">
					<div class="col-7">
						<div class="text-primary p-3">
							<h5 class="text-primary">Welcome Back !</h5>
							<p>Have a lovely time exploring.</p>
						</div>
					</div>
					<div class="col-5 align-self-end">
						<img src="{{ asset('assets/images/profile-img.png') }}" alt="" class="img-fluid">
					</div>
				</div>
			</div>
			<div class="card-body pt-0">
				<div class="row">
					<div class="col-sm-4">
						<div class="avatar-md profile-user-wid mb-4">
							@if($user->profile_photo_path == null)
							<img src="{{ Gravatar::get($user->email) }}" alt="" style="width: 120px;height:120px;object-fit: cover;" class="img-thumbnail rounded-circle">
							@else
							<img src="{{ asset($user->profile_photo_path) }}" style="width: 120px;height:120px;object-fit: cover;" alt="" class="img-thumbnail rounded-circle">
							@endif
						</div>
						<h5 class="font-size-15 text-truncate">{{ $user->name() }}</h5>
						<p class="text-muted mb-0 text-truncate">{{ $user->id() }}</p>
					</div>
					<div class="col-sm-8">
						<div class="pt-4">
							<div class="row">
								<div class="col-6">
									<h5 class="font-size-15">{{ $user->referrals()->count() }}</h5>
									<p class="text-muted mb-0">Referred</p>
								</div>
								<div class="col-6">
									<h5 class="font-size-15">₦{{ number_format($user->paid_commission()->sum('amount')) }}</h5>
									<p class="text-muted mb-0">Referral Earnings</p>
								</div>
							</div>
						</div>
					</div>
					<p class="text mb-0"><b>Referral Code: </b><span class="text-primary">{{ $user->my_referral_code->code }}</span></p>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-6">
		<div class="card">
			<div class="card-heading p-4">
				<div class="mini-stat-icon float-right">
					<i class="fas fa-wallet bg-warning text-white"></i>
				</div>
				<div>
					<h5 class="font-16">Wallet Balance</h5>
				</div>
				<h3 class="mt-4">₦{{ number_format($user->wallet->amount,2) }}</h3>
				<p class="text-muted mt-2 mb-0"></p>
				<br><br>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xl-12">
		<div class="card m-b-30">
			<div class="card-body">
				<h4 class="mt-0 header-title mb-4">Recent Transactions</h4>
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Amount</th>
								<th scope="col">Type</th>
								<th scope="col">Status</th>
								<th scope="col">Description</th>
								<th scope="col">Paid from</th>
								<th scope="col">Date Performed</th>
								<th scope="col">Date Approved/Declined</th>
							</tr>
						</thead>
						<tbody>
							@foreach($trans as $entity)
							<tr>
								<td>{{ $entity->data()->reference }}</td>
								<td>₦{{ number_format($entity->data()->amount,2) }}</td>
								<td>{!! $entity->type() !!}</td>
								<td>{!! $entity->status() !!}</td>
								<td>{{ $entity->data()->description }}</td>
								<td>{{ $entity->data()->payment_option }}</td>
								<td>{{ \Carbon\Carbon::parse($entity->created_at)->addHour()->format('d M, Y h:i A') }}</td>
								<td>{{ \Carbon\Carbon::parse($entity->updated_at)->addHour()->format('d M, Y h:i A') }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END ROW -->
@endsection