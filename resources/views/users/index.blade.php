@extends('layouts.admin')

@section('title', __('Users'))

@section('bread')
<div class="page-title-box">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h4 class="page-title">Users</h4>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
				<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
				<li class="breadcrumb-item active">Users</li>
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
        $('.permAction').click(function(e){
            e.preventDefault();
            var link = $(this).attr('href');
            Swal.fire({
                title: 'Are you sure?',
                text: "This might affect how the user accesses the platform!",
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
				<h4 class="mt-0 header-title">All Users</h4>
				<p class="sub-title">
				</p>
				<table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Passport</th>
							<th>E-mail</th>
							<th>Phone</th>
							<th>Wallet</th>
							<th>Status</th>
							<th>Date Created</th>
							<th><a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">Action </a></th>
						</tr>
					</thead>
					<tbody>
						@foreach($entities as $entity)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $entity->name() }}</td>
							<td>
								@if($entity->profile_photo_path)
								<img src="{{ asset($entity->profile_photo_path) }}" width="30px" class="rounded rounded-circle">
								@else
								<img src="{{ Gravatar::get($entity->email) }}" width="30px" class="rounded rounded-circle">
								@endif
							</td>
							<td>{{ $entity->email }}</td>
							<td>{{ $entity->phone }}</td>
							<td>₦{{ number_format($entity->wallet->amount,2) }}</td>
							<td>{!! $entity->status() !!}</td>
							<td>{{ date('d M, Y h:i A', strtotime($entity->created_at)) }}</td>
							<td>
								<div class="drodown">
									<a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><i class="text-primary ti-more-alt"></i></a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li class="dropdown-item"><a href="/users/{{ $entity->id }}"><span>View User</span></a></li>
										<li class="dropdown-item"><a href="/users/{{ $entity->id }}/perm" class="permAction"><span>{{ $entity->is_active ? 'Restrict User' : 'Unrestrict User' }}</span></a></li>
									</ul>
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