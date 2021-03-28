@extends('layouts.user')

@section('title', __('Invest now'))

@section('bread')
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h4 class="page-title">Create investment</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/farm">Farms</a></li>
                <li class="breadcrumb-item active">Invest</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@push('more-styles')
@endpush

@push('more-scripts')
<script type="text/javascript">
    $(function(){
        var perUnit = {{ $entity->price_per_unit }};
        var entry = $("input[name='units']");
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
        $('input[type="checkbox"]').change(function(){
            if($('input[type="checkbox"]').is(":checked")){
                $('.selecter').html('<select class="form-control" name="rollover_type"><option value="roi">Rollover ROI</option><option value="capital">Rollover Capital</option><option value="roi + capital">Rollover Capital + ROI</option></select>');
            }else {
                $('.selecter').html('');
            }
        });
        entry.on('input', function(){
            var amount = $(this).val() * perUnit;
            var displ = 'Price for selected units => ₦'+processNumber(amount);
            $('.dataReport').html(displ);
        });

    });

    function processNumber(number){
        return new Intl.NumberFormat('ja-JP').format(number);
    }
</script>
@endpush

@section('content')
<div class="row">
    <div class="col-xl-6 col-md-6">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">{{ $entity->name }}</h4>
                <p class="sub-title">Please fill in the investment details below carefully.</p>
                <p>
                    <strong>Available Units:</strong> {{ $entity->available_units }}<br>
                    <strong>Price Units:</strong> {{ number_format($entity->price_per_unit,2) }} NGN<br>
                </p>
                <form action="{{ route('investments.store') }}" class="dform" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="farm" value="{{ $entity->id }}">
                    <div class="row">
                        <div class="form-group col-12">
                            <label>Units to purchase</label>
                            <input type="number" name="units" class="form-control units" required>
                            <div class="text-success dataReport"></div>
                        </div>
                        <div class="form-group col-12">
                            <label>Payment from</label>
                            <select name="from" class="form-control from">
                                @foreach($user->cards as $card)
                                <option value="card|{{$card->id}}">{{ strtoupper($card->data()->card_type) }} - {{ $card->data()->bank }} ({{ $card->data()->last4 }})</option>
                                @endforeach
                                <option value="wallet|wallet">Wallet (₦{{ number_format($user->wallet->amount,2) }})</option>
                                <option value="bank|bank">Bank Transfer</option>
                            </select>
                        </div>
                        @if($entity->rollover)
                        <div class="form-group col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1" name="rollover">
                                <label class="custom-control-label font-weight-normal" for="customCheck1">Roll Over</label>
                            </div>
                        </div>
                        <div class="form-group col-12 selecter">
                            
                        </div>
                        @endif
                        <div class="col-12">
                            <button class="btn btn-primary btn-lg dfsub" type="submit">Submit</button>
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