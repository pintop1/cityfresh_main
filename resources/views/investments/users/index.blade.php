@extends('layouts.user')

@section('title', __('My investments'))

@section('bread')
<div class="page-title-box">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h4 class="page-title">Investments</h4>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
				<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
				<li class="breadcrumb-item active">Investments</li>
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
				<h4 class="mt-0 header-title">Date</h4>
				<p class="sub-title">
				</p>
				<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
					<thead>
						<tr>
							<th>#</th>
							<th>Farms</th>
							<th>Days remaining</th>
							<th>Maturity Date</th>
							<th>Status</th>
							<th>Units</th>
							<th>Date</th>
							<th>Rollover</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($entities as $entity)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td><a href="/farms/{{ $entity->farm()->first()->slug }}" target="_blank">{{ $entity->farm()->first()->name }} <i class="ml-2 mdi mdi-link"></i></a></td>
							<td>
								@php
								if($entity->status == 'active'){
									$date1 = \Carbon\Carbon::parse($entity->maturity_date);
									$date2 = \Carbon\Carbon::now();
									echo $date2->diffInDays($date1).' days';
								}else {
									echo 'Pending';
								}
								@endphp
							</td>
							<td>{{ $entity->maturity_date ? date('d M, Y h:i A', strtotime($entity->maturity_date)) : '-' }}</td>
							<td>{!! $entity->status() !!}</td>
							<td>{{ $entity->units }}</td>
							<td>{{ date('d M, Y h:i A', strtotime($entity->created_at)) }}</td>
							<td>
								@if($entity->data()->rollover)
                                <i class="mdi mdi-check text-success"></i> Enabled for {{ strtoupper($entity->data()->type) }}
                                @else
                                <i class="mdi mdi-close text-danger"></i> Disabled
                                @endif
							</td>
							<td>
								<div class="drodown">
									<a href="#" class="dropdown-toggle btn btn-primary btn-trigger" data-toggle="dropdown">Action</a>
									<div class="dropdown-menu">
										<a class="dropdown-item d-block" href="/investments/{{ $entity->id }}"><span>View investment</span></a>
									</div>
								</div>
							</td>
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