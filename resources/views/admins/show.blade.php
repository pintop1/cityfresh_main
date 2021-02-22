@extends('layouts.admin')

@section('title', __('View Admin Details'))

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
                text: "This action cannot be reverted!",
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
        $('.datatable').dataTable();
    });
</script>
@endpush

@section('bread')
<div class="page-title-box">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h4 class="page-title">Viewing Administrators</h4>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
				<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
				<li class="breadcrumb-item"><a href="/administrators">Administrators</a></li>
				<li class="breadcrumb-item active">View</li>
			</ol>
		</div>
	</div>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-lg-4">
		<div class="card m-b-30">
			<div class="card-body">
				<h4 class="mt-0 header-title">{{ $entity->id() }}</h4>
				<div class="">
					<div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Entry</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Name</strong></td>
                                    <td>{{ $entity->name() }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>{!! $entity->status() !!}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td>{{ $entity->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone</strong></td>
                                    <td>{{ $entity->phone }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date Added</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($entity->created_at)->addHour()->format('d M, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date Last Updated</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($entity->updated_at)->addHour()->format('d M, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Roles</strong></td>
                                    <td>
                                    	@foreach($entity->roles as $role)
                                    	<a href="/roles/{{ $role->id }}" target="_blank"> {{ $role->name }} <i class="mdi mdi-link"></i></a><br>
                                    	@endforeach
                                    </td>
                                </tr>
                                <tr>
                                	<td></td>
                                	<td></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Packages Created</strong></td>
                                    <td>
                                    	{{ $entity->packages()->count() }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Total Farms Created</strong></td>
                                    <td>
                                    	{{ $entity->farms()->count() }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Pending Farms Created</strong></td>
                                    <td>
                                    	{{ $entity->farms()->where('status', 'pending')->count() }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Closed Farms Created</strong></td>
                                    <td>
                                    	{{ $entity->farms()->where('status', 'closed')->count() }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Pending Farms Created</strong></td>
                                    <td>
                                    	{{ $entity->farms()->where('status', 'pending')->count() }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-12"><a href="/users/{{ $entity->id }}/perm" class="permAction btn btn-danger btn-lg">{{ $entity->is_active ? 'Restrict User' : 'Unrestrict User' }}</a> <a href="/users/{{ $entity->id }}/edit" class="btn btn-warning btn-lg ml-2">Edit Account</a></div>
                    </div>
				</div>
			</div>
		</div>
	</div>
    <div class="col-xl-8">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">All Packages</h4>
                <p class="sub-title">
                </p>
                <table class="datatable table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Farms</th>
							<th>Created by</th>
							<th>Created at</th>
							<th><a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">Action </a></th>
						</tr>
					</thead>
					<tbody>
						@foreach($entity->packages as $package)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $package->name }}</td>
							<td>{{ $package->farms()->count() }}</td>
							<td>{{ $package->user->name }}</td>
							<td>{{ \Carbon\Carbon::parse($package->created_at)->addHour()->format('d M, Y h:i A') }}</td>
							<td>
								<div class="drodown">
									<a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><i class="text-primary ti-more-alt"></i></a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li class="dropdown-item"><a href="/packages/{{ $package->slug }}"><span>View Package</span></a></li>
										<li class="dropdown-item"><a href="/packages/{{ $package->slug }}/edit"><span>Edit Package</span></a></li>
										<li class="dropdown-item"><a href="/farmlists/{{ $package->slug }}/create"><span>Add Farm</span></a></li>
										<li class="dropdown-item"><a href="" class="deleteAction" data-target="#delete-package{{$package->id}}"><span>Remove Package</span></a></li>
                                        <form id="delete-package{{$package->id}}" action="{{ route('packages.destroy', $package->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
									</ul>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
            </div>
        </div>
        <div class="card m-b-30 mt-3">
            <div class="card-body">
                <h4 class="mt-0 header-title">All Farms</h4>
                <p class="sub-title">
                </p>
                <table class="datatable table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Cover Image</th>
							<th>Start date</th>
							<th>Close date</th>
							<th>Duration</th>
							<th>Package</th>
							<th>Status</th>
							<th><a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">Action </a></th>
						</tr>
					</thead>
					<tbody>
						@foreach($entity->farms as $farm)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $farm->name }}</td>
							<td><img src="{{ $farm->cover_image }}" width="120px"></td>
							<td>{{ date('d M, Y h:i A', strtotime($farm->start_date)) }}</td>
							<td>{{ date('d M, Y h:i A', strtotime($farm->close_date)) }}</td>
							<td>{{ $farm->duration }} {{ $farm->duration_type }}</td>
							<td><a href="/packages/{{ $farm->package->slug }}" class="text text-primary" target="_blank">{{ $farm->package->name }} <i class="mdi mdi-link"></i></a></td>
							<td>{!! $farm->status() !!}</td>
							<td>
								<div class="drodown">
									<a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><i class="text-primary ti-more-alt"></i></a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li class="dropdown-item"><a href="/farmlists/{{ $farm->slug }}"><span>View Farm</span></a></li>
										@if($farm->status == 'pending')
										<li class="dropdown-item"><a href="/farmlists/{{ $farm->slug }}/edit"><span>Edit Farm</span></a></li>
										@endif
										<li class="dropdown-item"><a href="" class="deleteAction" data-target="#delete-farm{{$farm->id}}"><span>Remove Farm</span></a></li>
                                        <form id="delete-farm{{$farm->id}}" action="{{ route('farmlists.destroy', $farm->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
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
</div>
@endsection