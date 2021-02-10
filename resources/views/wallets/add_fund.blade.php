@extends('layouts.user')

@section('title', __('Add money to my wallet'))

@section('bread')
<div class="page-title-box">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h4 class="page-title">Add Funds</h4>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
				<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
				<li class="breadcrumb-item"><a href="javascript:void(0)">Wallet</a></li>
				<li class="breadcrumb-item active">Add Funds</li>
			</ol>
		</div>
	</div>
</div>
@endsection

@push('more-scripts')
<script type="text/javascript">
    $(function(){
        $(".dfsub").click(function(e){
            e.preventDefault();
            var selected = $('select.from').children("option:selected").val();
            if(selected == 'bank|bank'){
                $('.myModal').modal('show');
            }else {
                $('.dform').submit();
            }
        });
        $('.submitf').click(function(){
            $('.dform').submit();
        });
    });
</script>
@endpush

@section('content')
<div class="row">
	<div class="col-xl-6">
		<div class="card card-bordered m-b-30">
			<div class="card-body">
				<h4 class="mt-0 header-title">Deposit into your wallet</h4>
				<p class="sub-title">
				</p>
				<form action="{{ route('wallet.addFunds') }}" class="dform" class="gy-3" method="post">
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
								<label class="form-label">Source</label>
							</div>
						</div>
						<div class="col-lg-7">
							<div class="form-group">
								<div class="form-control-wrap">
									<select name="from" class="form-control from">
		                                @foreach($user->cards as $card)
		                                <option value="card|{{$card->id}}">{{ strtoupper($card->data()->card_type) }} - {{ $card->data()->bank }} ({{ $card->data()->last4 }})</option>
		                                @endforeach
		                                <option value="bank|bank">Bank Transfer</option>
		                            </select>
								</div>
							</div>
						</div>
					</div>
					<div class="row g-3">
						<div class="col-lg-7 offset-lg-5">
							<div class="form-group mt-2">
								<button type="submit" class="btn btn-lg btn-primary dfsub">Deposit</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">BANK TRANSFER</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @php
                $bank = explode('|', $setting->value);
                @endphp
                <h4>ACCOUNT NUMBER: <small>{{ $bank[1] }}</small></h4>
                <h4>ACCOUNT NAME: <small>{{ $bank[2] }}</small></h4>
                <h4>BANK: <small>{{ $bank[0] }}</small></h4>
                <p>Please make transfer to the above bank above!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect waves-light submitf">Already Transfered</button>
            </div>
        </div>
    </div>
</div>
@endsection