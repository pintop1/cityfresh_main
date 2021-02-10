@extends('layouts.admin')

@section('title', __('Administration Dashboard'))

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
					<i class="mdi mdi-table-tennis bg-warning text-white"></i>
				</div>
				<div>
					<h5 class="font-16">Total Mandates</h5>
				</div>
				<h3 class="mt-4 mb-5 pb-2">₦{{ number_format($mandates,2) }}</h3>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-xl-3">
		<div class="card">
			<div class="card-heading p-4">
				<div class="mini-stat-icon float-right">
					<i class="fas fa-wallet bg-danger text-white"></i>
				</div>
				<div>
					<h5 class="font-16">Wallets</h5>
				</div>
				<h3 class="mt-4">₦{{ number_format($wallets,2) }}</h3>
				<div class="progress mt-4" style="height: 4px;">
					<div class="progress-bar bg-danger" role="progressbar" style="width: {{$withdrawable}}%" aria-valuenow="{{$withdrawable}}" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<p class="text-muted mt-2 mb-0">Withdrawable<span class="float-right">{{round($withdrawable)}}%</span></p>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6 col-xl-3">
		<div class="card">
			<div class="card-heading p-4">
				<div class="mini-stat-icon float-right">
					<i class="ti-user bg-warning text-white"></i>
				</div>
				<div>
					<h5 class="font-16">Users</h5>
				</div>
				<h3 class="mt-4">{{$users}}</h3>
				<div class="progress mt-4" style="height: 4px;">
					<div class="progress-bar bg-warning" role="progressbar" style="width: {{$active_user}}%" aria-valuenow="{{$active_user}}" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<p class="text-muted mt-2 mb-0">Active Users<span class="float-right">{{round($active_user)}}%</span></p>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-xl-3">
		<div class="card">
			<div class="card-heading p-4">
				<div class="mini-stat-icon float-right">
					<i class="ti-direction-alt bg-danger text-white"></i>
				</div>
				<div>
					<h5 class="font-16">Farms</h5>
				</div>
				<h3 class="mt-4">{{ $farms }}</h3>
				<div class="progress mt-4" style="height: 4px;">
					<div class="progress-bar bg-danger" role="progressbar" style="width: {{$open_farm}}%" aria-valuenow="{{$open_farm}}" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<p class="text-muted mt-2 mb-0">Opened farms<span class="float-right">{{round($open_farm)}}%</span></p>
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
					<h5 class="font-16">Active Investments</h5>
				</div>
				<h3 class="mt-4 mb-5 pb-2">{{ $active_investments }}</h3>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-xl-3">
		<div class="card">
			<div class="card-heading p-4">
				<div class="mini-stat-icon float-right">
					<i class="fas fa-money-bill bg-primary text-white"></i>
				</div>
				<div>
					<h5 class="font-16">Pending Payouts</h5>
				</div>
				<h3 class="mt-4">₦{{ number_format($payouts,2) }}</h3>
				<div class="progress mt-4" style="height: 4px;">
					<div class="progress-bar bg-primary" role="progressbar" style="width: {{$payouts_percent}}%" aria-valuenow="{{$open_farm}}" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<p class="text-muted mt-2 mb-0">Pending Payouts<span class="float-right">{{round($payouts_percent)}}%</span></p>
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
								<th scope="col">Reference</th>
								<th scope="col">User</th>
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
								<td>{{ $loop->iteration }}</td>
								<td>{{ $entity->data()->reference }}</td>
								<td><a href="/users/{{ $entity->user->id }}" target="_blank">{{ $entity->user->name() }}</a></td>
								<td>₦{{ number_format($entity->data()->amount,2) }}</td>
								<td>{!! $entity->type() !!}</td>
								<td>{!! $entity->status() !!}</td>
								<td>{{ $entity->data()->description }}</td>
								<td>{{ $entity->data()->payment_option }}</td>
								<td>{{ date('d M, Y h:i A', strtotime($entity->created_at)) }}</td>
								<td>{{ date('d M, Y h:i A', strtotime($entity->updated_at)) }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection