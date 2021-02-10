@extends('layouts.user')

@section('title', __('View Investment Details'))

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
				<li class="breadcrumb-item"><a href="/investments">Investments</a></li>
				<li class="breadcrumb-item active">View</li>
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
                                    <td><strong>Farm</strong></td>
                                    <td><a href="/farms/{{ $entity->farm()->first()->slug }}" target="_blank">{!! $entity->farm()->first()->name !!} <i class="ml-2 mdi mdi-link"></i></a></td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>{!! $entity->status() !!}</td>
                                </tr>
                                <tr>
                                    <td><strong>Units</strong></td>
                                    <td>{!! $entity->units !!} units</td>
                                </tr>
                                <tr>
                                    <td><strong>Maturity date</strong></td>
                                    <td>{{ $entity->maturity_date ? date('d M, Y h:i A', strtotime($entity->maturity_date)) : '' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Invested (<small class="text-danger">rated at ₦{{ number_format($entity->farm()->first()->price_per_unit,2) }} per unit</small>)</strong></td>
                                    <td>
                                    	₦{{ number_format($entity->amount,2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Expected Returns ({{$entity->farm()->first()->roi}}%)</strong></td>
                                    <td>
                                    	₦{{ number_format($entity->amount + (($entity->amount*$entity->farm()->first()->roi)/100),2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Days Remaining</strong></td>
                                    <td>
                                        @php
                                        if($entity->status == 'active'){
                                            $date1 = \Carbon\Carbon::parse($entity->maturity_date);
                                            $date2 = \Carbon\Carbon::now();
                                            echo $date2->diffInDays($date1).' days';
                                        }else {
                                            echo '0 day';
                                        }
                                        @endphp
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Created at</strong></td>
                                    <td>{{ date('d M, Y h:i A', strtotime($entity->created_at)) }}</td>
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
</div>
@endsection