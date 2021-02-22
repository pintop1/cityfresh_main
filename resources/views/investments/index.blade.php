@extends('layouts.admin')

@section('title', __('All investments'))

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
<script>
    $(function(){
        $('.daction').click(function(e){
            e.preventDefault();
            var link = $(this).attr('href');
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be reverted!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, proceed!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger ml-2',
                buttonsStyling: false
            }).then((result) => {
                if(result.isConfirmed){
                    window.location.href = link;
                }
            });
        });
    });
</script>
@endpush

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card m-b-30">
			<div class="card-body">
				<h4 class="mt-0 header-title">All Investments</h4>
				<p class="sub-title">
				</p>
				<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
					<thead>
						<tr>
							<th>#</th>
							<th>User</th>
							<th>Farms</th>
							<th>Units</th>
							<th>Rollover</th>
							<th>Maturity Date</th>
							<th>Days remaining</th>
							<th>Status</th>
							<th>Date Created</th>
							<th><a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">Action </a></th>
						</tr>
					</thead>
					<tbody>
						@foreach($entities as $entity)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td><a href="/users/{{ $entity->user->id }}" target="_blank">{{ $entity->user->name() }} <i class="ml-2 mdi mdi-link"></i></a></td>
							<td><a href="/farms/{{ $entity->farm()->first()->slug }}" target="_blank">{{ $entity->farm()->first()->name }} <i class="ml-2 mdi mdi-link"></i></a></td>
							<td>{{ $entity->units }}</td>
							<td>
								@if($entity->data()->rollover)
                                <i class="mdi mdi-check text-success"></i> Enabled for {{ strtoupper($entity->data()->type) }}
                                @else
                                <i class="mdi mdi-close text-danger"></i> Disabled
                                @endif
							</td>
							<td>{{ $entity->maturity_date ? date('d M, Y h:i A', strtotime($entity->maturity_date)) : '-' }}</td>
							<td>
								@php
								if($entity->status == 'active'){
									$date1 = \Carbon\Carbon::parse($entity->maturity_date);
									$date2 = \Carbon\Carbon::now();
									if($date2->diffInDays($date1, false) > 1)
										echo $date2->diffInDays($date1, false).' days';
									else 
										echo '0 day';
								}else {
									echo 'Not active';
								}
								@endphp
							</td>
							<td>{!! $entity->status() !!}</td>
							<td>{{ \Carbon\Carbon::parse($entity->created_at)->addHour()->format('d M, Y h:i A') }}</td>
							<td>
								@if($entity->status == 'queued')
								<div class="drodown">
									<a href="#" class="dropdown-toggle btn btn-primary btn-trigger" data-toggle="dropdown">Action</a>
									<div class="dropdown-menu">
										<a class="dropdown-item d-block daction" href="/investments/{{ $entity->id }}/approve"><span> Approve investment</span></a>
										<a class="dropdown-item d-block daction" href="/investments/{{ $entity->id }}/decline"><span> Decline investment</span></a>
									</div>
								</div>
								@else
								<span class="text-muted">No action required</span>
								@endif
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