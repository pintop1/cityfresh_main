@extends('layouts.admin')

@section('title', __('Farm Lists'))

@section('bread')
<div class="page-title-box">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h4 class="page-title">Farm Lists</h4>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
				<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
				<li class="breadcrumb-item active">Farm List</li>
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
        $('.deleteAction').click(function(e){
            e.preventDefault();
            var form = $(this).attr('data-target');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this farm, every investments attached to this farm and every transaction history of these investments from the system!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger ml-2',
                buttonsStyling: false
            }).then((result) => {
                if(result.isConfirmed){
                    $(form).submit();
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
				<h4 class="mt-0 header-title">All Farms</h4>
				<p class="sub-title">
					The list of all site farm lists displays here!
					@can('create farms')
					<a href="/farmlists/create" class="btn btn-primary float-right">Create Farm</a>
					@endcan
				</p>
				<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Start date</th>
							<th>Close date</th>
							<th>Duration</th>
							<th>Package</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($entities as $entity)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $entity->name }}</td>
							<td>{{ date('d M, Y h:i A', strtotime($entity->start_date)) }}</td>
							<td>{{ date('d M, Y h:i A', strtotime($entity->close_date)) }}</td>
							<td>{{ $entity->duration }} {{ $entity->duration_type }}</td>
							<td><a href="/packages/{{ $entity->package->slug }}" class="text text-primary" target="_blank">{{ $entity->package->name }} <i class="mdi mdi-link"></i></a></td>
							<td>{!! $entity->status() !!}</td>
							<td>
								<div class="drodown">
									<a href="#" class="dropdown-toggle btn btn-primary btn-trigger" data-toggle="dropdown">Action</a>
									<div class="dropdown-menu">
										<a class="dropdown-item d-block" href="/farmlists/{{ $entity->slug }}"><span>View Farm</span></a>
										@if($entity->status == 'pending' || $entity->status == 'opened')
										<a class="dropdown-item d-block" href="/farmlists/{{ $entity->slug }}/edit"><span>Edit Farm</span></a>
										@endif
										<a class="dropdown-item d-block deleteAction" href="" data-target="#delete-farm{{$entity->id}}"><span>Remove Farm</span></a>
										<form id="delete-farm{{$entity->id}}" action="{{ route('farmlists.destroy', $entity->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
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