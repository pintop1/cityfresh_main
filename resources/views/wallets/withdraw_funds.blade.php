@extends('layouts.user')

@section('title', __('Withdraw funds from wallet'))

@section('bread')
<div class="page-title-box">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h4 class="page-title">Withdraw funds</h4>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
				<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
				<li class="breadcrumb-item"><a href="javascript:void(0)">Wallet</a></li>
				<li class="breadcrumb-item active">Withdraw Funds</li>
			</ol>
		</div>
	</div>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-6">
		<div class="card card-bordered m-b-30">
			<div class="card-body">
				<h4 class="mt-0 header-title">Withdraw funds</h4>
				<p class="sub-title">
				</p>
				<p>
					<strong>Wallet Balance: </strong> ₦{{ number_format($user->wallet->amount,2) }}<br>
					<strong>Withdrawable Funds: </strong> ₦{{ number_format($user->wallet->amount - $user->mandates()->sum('amount'),2) }}<br>
					<strong>Non-withdrawable Funds (<small>Funds for Rollover investment</small>): </strong> ₦{{ number_format($user->mandates()->sum('amount'),2) }}
				</p>
				<form action="{{ route('wallet.withdrawFunds') }}" class="dform" class="gy-3" method="post">
					@csrf
					<div class="row g-3 align-center">
						<div class="col-lg-5">
							<div class="form-group">
								<label class="form-label">Amount</label>
							</div>
						</div>
						<div class="col-lg-7">
							<div class="form-group">
								<div class="form-control-wrap">
									<input type="number" step="any" class="form-control" required="" name="amount">
								</div>
							</div>
						</div>
					</div>
					<div class="row g-3 align-center">
						<div class="col-lg-5">
							<div class="form-group">
								<label class="form-label">Destination Bank</label>
							</div>
						</div>
						<div class="col-lg-7">
							<div class="form-group">
								<div class="form-control-wrap">
									<select name="to" class="form-control">
		                                @foreach($user->banks as $bank)
		                                <option value="{{$bank->id}}">{{ strtoupper($bank->data()->bank->name) }} - {{ $bank->data()->account_name }} ({{ $bank->data()->account_number }})</option>
		                                @endforeach
		                            </select>
								</div>
							</div>
						</div>
					</div>
					<div class="row g-3">
						<div class="col-lg-7 offset-lg-5">
							<div class="form-group mt-2">
								<button type="submit" class="btn btn-lg btn-primary dfsub">Withdraw</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection