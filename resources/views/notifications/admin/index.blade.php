@extends('layouts.admin')

@section('title', __('My Notifications'))

@section('bread')
<div class="page-title-box">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h4 class="page-title">Notifications</h4>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
				<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
				<li class="breadcrumb-item active">Notifications</li>
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
				<h4 class="mt-0 header-title">All Notifications</h4>
				<p class="sub-title">
				</p>
				<table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
					<thead>
						<tr>
							<th>#</th>
							<th>Title</th>
							<th>Status</th>
							<th>Date</th>
							<th><a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">Action </a></th>
						</tr>
					</thead>
					<tbody>
						@foreach(auth()->user()->notifications as $entity)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{!! explode('</b>', $entity->data['body'])[0] !!}</td>
							<td>
								@if($entity->read_at)
								<span class="badge badge-success">Read</span>
								@else
								<span class="badge badge-warning">Unread</span>
								@endif
							</td>
							<td>{{ $entity->created_at ? date('d M, Y h:i A', strtotime($entity->maturity_date)) : '' }}</td>
							<td><a class="btn btn-primary" href="/notifications/{{ $entity->id }}"><span> View notification</span></a></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- end col -->
</div>
<!-- end row -->
@endsection