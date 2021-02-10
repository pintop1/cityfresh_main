@extends('layouts.admin')

@section('title', __('View package'))

@section('bread')
<div class="page-title-box">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h4 class="page-title">Viewing package</h4>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
				<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
				<li class="breadcrumb-item"><a href="/packages">Packages</a></li>
				<li class="breadcrumb-item active">{{ $entity->name }}</li>
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
	<div class="col-lg-4">
		<div class="card m-b-30">
			<div class="card-body">
				<h4 class="mt-0 header-title">{{ $entity->name }}</h4>
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
                                    <td><strong>Description</strong></td>
                                    <td>{{ $entity->description }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Farms</strong></td>
                                    <td>{{ $entity->farms()->count() }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Created At</strong></td>
                                    <td>{{ date('d M, Y h:i A',strtotime($entity->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Created By</strong></td>
                                    <td>{{ $entity->user->name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-12"><a href="/farmlists/{{ $entity->slug }}/create" class="btn btn-primary btn-lg">Create Farm</a><a href="/packages/{{ $entity->slug }}/edit" class="btn btn-warning btn-lg ml-2">Edit Farm</a></div>
                    </div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-8">
		<div class="card m-b-30">
			<div class="card-body">
				<h4 class="mt-0 header-title">All Farms</h4>
				<p class="sub-title">
					The list of all farms in this package.
				</p>
				<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Cover Image</th>
							<th>Start date</th>
							<th>Close date</th>
							<th>Duration</th>
							<th>Status</th>
							<th><a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">Action </a></th>
						</tr>
					</thead>
					<tbody>
						@foreach($entity->farms as $farm)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $farm->name }}</td>
							<td><img src="{{ asset($farm->cover_image) }}" width="90px" class="rounded"></td>
							<td>{{ date('d M, Y h:i A', strtotime($farm->start_date)) }}</td>
							<td>{{ date('d M, Y h:i A', strtotime($farm->close_date)) }}</td>
							<td>{{ $farm->duration }} {{ $farm->duration_type }}</td>
							<td>
								{{ $farm->status }}
							</td>
							<td>
								<div class="drodown">
									<a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><i class="text-primary ti-more-alt"></i></a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li class="dropdown-item"><a href="/farmlists/{{ $farm->id }}"><span>View Farm</span></a></li>
										<li class="dropdown-item"><a href="/farmlists/{{ $farm->id }}/edit"><span>Edit Farm</span></a></li>
										<li class="dropdown-item"><a href="/farmlists/{{ $farm->id }}/delete"><span>Delete Farm</span></a></li>
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