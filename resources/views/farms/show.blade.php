@extends('layouts.admin')

@section('title', __('View Farm Details'))

@section('bread')
<div class="page-title-box">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h4 class="page-title">Viewing farmlist</h4>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
				<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
				<li class="breadcrumb-item"><a href="/farmlists">Farm List</a></li>
				<li class="breadcrumb-item active">{{ $entity->name }}</li>
			</ol>
		</div>
	</div>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-lg-6">
		<div class="card m-b-30">
			<div class="card-body">
				<h4 class="mt-0 header-title">{{ $entity->name }} - {{ $entity->id() }}</h4>
				<div class="">
					<img class="img-thumbnail mb-4" alt="200x200" style="width: 200px; height: 200px;" src="{{ asset($entity->cover_image) }}" data-holder-rendered="true">
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
                                    <td><strong>Start Date</strong></td>
                                    <td>{{ date('d M, Y h:iA', strtotime($entity->start_date)) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Close Date</strong></td>
                                    <td>{{ date('d M, Y h:iA', strtotime($entity->close_date)) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Duration</strong></td>
                                    <td>{{ $entity->duration }} {{ $entity->duration_type }}s</td>
                                </tr>
                                <tr>
                                    <td><strong>Price Per Unit</strong></td>
                                    <td>{{ number_format($entity->price_per_unit,2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>ROI</strong></td>
                                    <td>{{ $entity->roi }}%</td>
                                </tr>
                                <tr>
                                    <td><strong>Available Units</strong></td>
                                    <td>{{ $entity->available_units }} units</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Units</strong></td>
                                    <td>{{ $entity->total_units }} units</td>
                                </tr>
                                <tr>
                                    <td><strong>Created At</strong></td>
                                    <td>{{ date('d M, Y h:i A',strtotime($entity->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Created By</strong></td>
                                    <td>{{ $entity->user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Investments</strong></td>
                                    <td><a href="" class="text text-primary" target="_blank">{{ $entity->investments()->count() }} <i class="mdi mdi-link"></i></a></td>
                                </tr>
                                <tr>
                                    <td><strong>Active Investments</strong></td>
                                    <td><a href="" class="text text-primary" target="_blank">{{ $entity->investments()->where('status', 'active')->count() }} <i class="mdi mdi-link"></i></a></td>
                                </tr>
                                <tr>
                                    <td><strong>Pending Investment</strong></td>
                                    <td><a href="" class="text text-primary" target="_blank">{{ $entity->investments()->where('status', 'pending')->count() }} <i class="mdi mdi-link"></i></a></td>
                                </tr>
                                <tr>
                                    <td><strong>Matured Investment</td>
                                    <td><a href="" class="text text-primary" target="_blank">{{ $entity->investments()->where('status', 'matured')->count() }} <i class="mdi mdi-link"></i></a></td>
                                </tr>
                                <tr>
                                    <td><strong>Declined Investment</strong></td>
                                    <td><a href="" class="text text-primary" target="_blank">{{ $entity->investments()->where('status', 'declined')->count() }} <i class="mdi mdi-link"></i></a></td>
                                </tr>
                                <tr>
                                    <td><strong>Paid Investment</strong></td>
                                    <td><a href="" class="text text-primary" target="_blank">{{ $entity->investments()->where('status', 'paid')->count() }} <i class="mdi mdi-link"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection