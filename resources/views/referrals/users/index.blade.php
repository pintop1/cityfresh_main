@extends('layouts.user')

@section('title', __('My referrals & earnings'))

@section('bread')
<div class="page-title-box">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h4 class="page-title">Referrals</h4>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
				<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
				<li class="breadcrumb-item active">Referrals</li>
			</ol>
		</div>
	</div>
</div>
@endsection

@push('more-styles')
<link href="{{ asset('plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('more-scripts')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/pages/datatables.init.js') }}"></script>
@endpush

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card m-b-30">
			<div class="card-body">
				<h4 class="mt-0 header-title">All Referrals</h4>
				<p class="sub-title">
					List of all your referrals
				</p>
				<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
					<thead>
						<tr>
							<th>#</th>
							<th>Referral Name</th>
							<th>Amount Earned</th>
							<th>Referral Phone</th>
							<th>Registration Date</th>
							<th>Date Paid</th>
						</tr>
					</thead>
					<tbody>
						@foreach($entities as $entity)
							@php
							$user = \App\Entities\User\User::find($entity->user_id);
							@endphp
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $user->name }}</td>
							<td>₦{{ $entity->paid_commission()->count() > 0 ? number_format($entity->paid_commission()->first()->pivot->amount,2) : 0.00 }}</td>
							<td>{{ $user->phone }}</td>
							<td>{{ \Carbon\Carbon::parse($entity->created_at)->addHour()->format('d M, Y h:i A') }}</td>
							<td>{{ $entity->paid_commission()->count() > 0 ? date('d M, Y h:i A', strtotime($entity->paid_commission()->first()->pivot->created_at)) : '-' }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection