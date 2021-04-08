@extends('layouts.user')

@section('title', __('View Farm Details'))

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

@section('bread')
<div class="page-title-box">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h4 class="page-title">Viewing farm</h4>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
				<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
				<li class="breadcrumb-item"><a href="/farms">Farms</a></li>
				<li class="breadcrumb-item active">{{ $entity->name }}</li>
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
                                    <td><strong>DESCRIPTION</strong></td>
                                    <td>{!! $entity->package->description !!}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>{!! $entity->status() !!}</td>
                                </tr>
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
                            </tbody>
                        </table>
                    </div>
                    @if($entity->status == 'opened')
                    <div class="row">
                        <div class="col-6"><a href="/farms/{{ $entity->slug }}/invest" class="btn btn-primary btn-lg">Invest</a></div>
                    </div>
                    @endif
				</div>
			</div>
		</div>
	</div>

    <div class="col-lg-8">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">Other farms in package</h4>
                <p class="sub-title">
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
                        @foreach($entity->package->farms()->where('id', '!=', $entity->id)->latest()->get() as $farm)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $farm->name }}</td>
                            <td><img src="{{ asset($farm->cover_image) }}" width="90px" class="rounded"></td>
                            <td>{{ date('d M, Y h:i A', strtotime($farm->start_date)) }}</td>
                            <td>{{ date('d M, Y h:i A', strtotime($farm->close_date)) }}</td>
                            <td>{{ $farm->duration }} {{ $farm->duration_type }}</td>
                            <td>
                                {!! $farm->status() !!}
                            </td>
                            <td>
                                <div class="drodown">
                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><i class="text-primary ti-more-alt"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li class="dropdown-item"><a href="/farms/{{ $farm->slug }}"><span>View Farm</span></a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">Investments</h4>
                <p class="sub-title">
                </p>
                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Farms</th>
                            <th>Invested Amount</th>
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
                        @foreach($entity->investments as $entity)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="/farms/{{ $entity->farm()->first()->slug }}" target="_blank">{{ $entity->farm()->first()->name }} <i class="ml-2 mdi mdi-link"></i></a></td>
                            <td>₦{{ number_format($entity->amount,2) }}</td>
                            <td>
                                @php
                                if($entity->status == 'active'){
                                    $date1 = \Carbon\Carbon::parse($entity->maturity_date);
                                    $date2 = \Carbon\Carbon::now();
                                    echo $date2->diffInDays($date1).' days';
                                }else if($entity->status == 'pending'){
                                    echo 'Pending';
                                }else{
                                    echo '0 day';
                                }
                                @endphp
                            </td>
                            <td>{{ $entity->maturity_date ? date('d M, Y h:i A', strtotime($entity->maturity_date)) : '-' }}</td>
                            <td>{!! $entity->status() !!}</td>
                            <td>{{ $entity->units }}</td>
                            <td>{{ \Carbon\Carbon::parse($entity->created_at)->addHour()->format('d M, Y h:i A') }}</td>
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
</div>
@endsection