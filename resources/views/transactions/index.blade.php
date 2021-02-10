@extends('layouts.admin')

@section('title', __('All Transactions'))

@section('bread')
<div class="page-title-box">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h4 class="page-title">Transactions</h4>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
				<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
				<li class="breadcrumb-item active">All Transactions</li>
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
        $('.changeStatus').click(function(e){
            e.preventDefault();
            var link = $(this).attr('href');
            var extra = $(this).attr('data-target');
            Swal.fire({
                title: 'Are you sure?',
                html: "Please note that this action cannot be reverted!<br>"+extra,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Proceed!',
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
				<h4 class="mt-0 header-title">All Transactions</h4>
				<p class="sub-title">
				</p>
				<table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
					<thead>
						<tr>
							<th>#</th>
							<th>Reference</th>
							<th>User</th>
							<th>Amount</th>
							<th>Type</th>
							<th>Status</th>
							<th>Description</th>
							<th>Paid from</th>
							<th>Date Performed</th>
							<th>Date Approved/Declined</th>
							<th><a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">Action </a></th>
						</tr>
					</thead>
					<tbody>
						@foreach($entities as $entity)
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
							<td>
								@if($entity->data()->status == 'pending' && $entity->investments()->count() < 1)
								<div class="drodown">
									<a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><i class="text-primary ti-more-alt"></i></a>
									<ul class="dropdown-menu dropdown-menu-right">
										@if($entity->data()->type == "withdrawal")
										<li class="dropdown-item"><a data-target='<h6>ACCOUNT NUMBER: <small>{{ $entity->banks()->first()->data()->account_number }}</small></h6><h6>ACCOUNT NAME: <small>{{ $entity->banks()->first()->data()->account_name }}</small></h6><h6>BANK: <small>{{ $entity->banks()->first()->data()->bank->name }}</small></h6><p>Please make transfer to the above bank above!' class="changeStatus" href="/transactions/{{ $entity->id }}/approve"><span>Approve Transaction</span></a></li>
											@else
										<li class="dropdown-item"><a class="changeStatus" href="/transactions/{{ $entity->id }}/approve"><span>Approve Transaction</span></a></li>
											@endif
										<li class="dropdown-item"><a data-target='' class="changeStatus" href="/transactions/{{ $entity->id }}/decline"><span>Decline Transaction</span></a></li>
									</ul>
								</div>
								@else
								<div class="text-muted">No action required</div>
								@endif
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection