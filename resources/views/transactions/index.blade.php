@extends('layouts.admin')

@section('title', __($status.' Transactions'))

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
				<li class="breadcrumb-item active">{{$status}} Transactions</li>
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
				<h4 class="mt-0 header-title">{{$status}} Transactions</h4>
				<p class="sub-title">
				</p>
				<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
					<thead>
						<tr>
							<th>#</th>
							<th>User</th>
							<th>Amount</th>
							<th>Type</th>
							<th>Status</th>
							<th>Payment Gateway</th>
							<th>Reference</th>
							<th><a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">Action </a></th>
						</tr>
					</thead>
					<tbody>
						@foreach($entities as $entity)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td><a href="/users/{{ $entity->user->id }}" target="_blank">{{ $entity->user->name() }}</a></td>
							<td>₦{{ number_format($entity->data()->amount,2) }}</td>
							<td>{!! $entity->type() !!}</td>
							<td>{!! $entity->status() !!}</td>
							<td>{{ $entity->data()->payment_option }}</td>
							<td>{{ $entity->data()->reference }}</td>
							<td>
								@if($entity->data()->status == 'pending')
								<div class="drodown">
									<a href="#" class="dropdown-toggle btn btn-warning btn-trigger" data-toggle="dropdown">Action</a>
									<div class="dropdown-menu">
										@if($entity->investments()->count() < 1)
											@if($entity->data()->type == "withdrawal")
											<a class="dropdown-item d-block changeStatus" data-target='<h6>ACCOUNT NUMBER: <small>{{ $entity->banks()->first()->data()->account_number }}</small></h6><h6>ACCOUNT NAME: <small>{{ $entity->banks()->first()->data()->account_name }}</small></h6><h6>BANK: <small>{{ $entity->banks()->first()->data()->bank->name }}</small></h6><p>Please make transfer to the above bank above!' href="/transactions/{{ $entity->id }}/approve"><span>Approve Transaction</span></a>
											@else
											<a class="dropdown-item d-block changeStatus" href="/transactions/{{ $entity->id }}/approve"><span>Approve Transaction</span></a>
											@endif
											<a class="dropdown-item d-block changeStatus" href="/transactions/{{ $entity->id }}/decline"><span>Decline Transaction</span></a>
										@endif
										<a class="dropdown-item d-block" href="/transactions/{{ $entity->id }}"><span>View Transaction</span></a>
									</div>
								</div>
								@else
								<a class="btn btn-primary" href="/transactions/view/single/{{ $entity->id }}"><span>View</span></a>
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