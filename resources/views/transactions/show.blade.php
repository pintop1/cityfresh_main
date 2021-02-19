@extends('layouts.admin')

@section('title', __('View Transaction Details'))

@section('bread')
<div class="page-title-box">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h4 class="page-title">Viewing transactions</h4>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
				<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
				<li class="breadcrumb-item"><a href="/transactions">Transactions</a></li>
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
				<h4 class="mt-0 header-title">Transaction Details</h4>
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
                                    <td><strong>User</strong></td>
                                    <td><a href="/users/{{ $entity->user->id }}" target="_blank">{{ $entity->user->name() }} <i class="ml-2 mdi mdi-link"></i></a></td>
                                </tr>
                                <tr>
                                    <td><strong>Amount</strong></td>
                                    <td>₦{{ number_format($entity->data()->amount,2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Type</strong></td>
                                    <td>{!! $entity->type() !!}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>{!! $entity->status() !!}</td>
                                </tr>
                                <tr>
                                    <td><strong>Reference</strong></td>
                                    <td>
                                    	{{ $entity->data()->reference }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Description</strong></td>
                                    <td>
                                    	{{ $entity->data()->description }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Payment Gateway</strong></td>
                                    <td>{{ $entity->data()->payment_option }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date</strong></td>
                                    <td>{{ date('d M, Y h:i A', strtotime($entity->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Validation date</strong></td>
                                    <td>{{ date('d M, Y h:i A', strtotime($entity->updated_ats)) }}</td>
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