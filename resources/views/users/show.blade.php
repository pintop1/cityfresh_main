@extends('layouts.admin')

@section('title', __('View User Details'))

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
        $('.daction').click(function(e){
            e.preventDefault();
            var link = $(this).attr('href');
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be reverted!",
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
        $('.changeStatus').click(function(e){
            e.preventDefault();
            var link = $(this).attr('href');
            var extra = $(this).attr('data-target');
            Swal.fire({
                title: 'Are you sure?',
                html: "Please note that this action cannot be reverted!<br>"+extra,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Proceed!',
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
			<h4 class="page-title">Viewing User</h4>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
				<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
				<li class="breadcrumb-item"><a href="/users">Users</a></li>
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
					<img class="img-thumbnail mb-4" alt="200x200" style="width: 200px; height: 200px;" src="{{ asset($entity->profile_photo_path) }}" data-holder-rendered="true">
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
                                    <td><strong>DOB</strong></td>
                                    <td>{{ $entity->dob }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Address</strong></td>
                                    <td>{{ $entity->address }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date Joined</strong></td>
                                    <td>{{ date('d M, Y h:i A', strtotime($entity->created_at))}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date Last Updated</strong></td>
                                    <td>{{ date('d M, Y h:i A', strtotime($entity->created_at))}}</td>
                                </tr>
                                @can('view wallets')
                                <tr>
                                    <td><strong>Wallet Balance</strong></td>
                                    <td>
                                    	₦{{ number_format($entity->wallet->amount,2) }}
                                    </td>
                                </tr>
                                <tr>
                                	<td></td>
                                	<td></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Invested (<small class="text-danger">{{ $entity->investments()->count() }} Investments</small>)</strong></td>
                                    <td>
                                    	₦{{ number_format($entity->investments()->sum('amount'),2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Queued Investments (<small class="text-danger">{{ $entity->investments()->where('status', 'queued')->count() }} Investments</small>)</strong></td>
                                    <td>
                                    	₦{{ number_format($entity->investments()->where('status', 'queued')->sum('amount'),2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Pending Investments (<small class="text-danger">{{ $entity->investments()->where('status', 'pending')->count() }} Investments</small>)</strong></td>
                                    <td>
                                    	₦{{ number_format($entity->investments()->where('status', 'pending')->sum('amount'),2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Declined Investments (<small class="text-danger">{{ $entity->investments()->where('status', 'declined')->count() }} Investments</small>)</strong></td>
                                    <td>
                                    	₦{{ number_format($entity->investments()->where('status', 'declined')->sum('amount'),2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Matured Investments (<small class="text-danger">{{ $entity->investments()->where('status', 'matured')->count() }} Investments</small>)</strong></td>
                                    <td>
                                    	₦{{ number_format($entity->investments()->where('status', 'matured')->sum('amount'),2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Paid Investments (<small class="text-danger">{{ $entity->investments()->where('status', 'paid')->count() }} Investments</small>)</strong></td>
                                    <td>
                                    	₦{{ number_format($entity->investments()->where('status', 'paid')->sum('amount'),2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Active Investments (<small class="text-danger">{{ $entity->investments()->where('status', 'active')->count() }} Investments</small>)</strong></td>
                                    <td>
                                    	₦{{ number_format($entity->investments()->where('status', 'active')->sum('amount'),2) }}
                                    </td>
                                </tr>
                                <tr>
                                	<td></td>
                                	<td></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Transactions (<small class="text-danger">{{ $entity->transactions()->count() }} Transactions</small>)</strong></td>
                                    <td>
                                    	₦{{ number_format($entity->transactions()->sum('details->amount'),2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Pending Transactions (<small class="text-danger">{{ $entity->transactions()->where('details->status', 'pending')->count() }} Transactions</small>)</strong></td>
                                    <td>
                                    	₦{{ number_format($entity->transactions()->where('details->status', 'pending')->sum('details->amount'),2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Successful Transactions (<small class="text-danger">{{ $entity->transactions()->where('details->status', 'success')->count() }} Transactions</small>)</strong></td>
                                    <td>
                                    	₦{{ number_format($entity->transactions()->where('details->status', 'success')->sum('details->amount'),2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Failed Transactions (<small class="text-danger">{{ $entity->transactions()->where('details->status', 'failed')->count() }} Transactions</small>)</strong></td>
                                    <td>
                                    	₦{{ number_format($entity->transactions()->where('details->status', 'failed')->sum('details->amount'),2) }}
                                    </td>
                                </tr>
                                @endcan
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-6"><a href="/users/{{ $entity->id }}/perm" class="btn btn-primary btn-lg">{{ $entity->is_active ? 'Restrict User' : 'Unrestrict User' }}</a></div>
                    </div>
				</div>
			</div>
		</div>
	</div>
    <div class="col-xl-8">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">All Cards</h4>
                <p class="sub-title">
                </p>
                <table class="table table-striped table-bordered dt-responsive nowrap datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bank</th>
                            <th>Account Name</th>
                            <th>Card Type</th>
                            <th>Last 4</th>
                            <th>Date Added</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entity->cards as $card)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $card->data()->bank }}</td>
                            <td>{{ $card->data()->account_name }}</td>
                            <td>{{ $card->data()->card_type }}</td>
                            <td>{{ $card->data()->last4 }}</td>
                            <td>{{ date('d M, Y h:i A', strtotime($card->created_at)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card m-b-30 mt-3">
            <div class="card-body">
                <h4 class="mt-0 header-title">All Banks</h4>
                <p class="sub-title">
                </p>
                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bank</th>
                            <th>Account Name</th>
                            <th>Account Number</th>
                            <th>Default Bank</th>
                            <th>Date Added</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entity->banks as $bank)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $bank->data()->bank->name }}</td>
                            <td>{{ $bank->data()->account_name }}</td>
                            <td>{{ $bank->data()->account_number }}</td>
                            <td>
                                @if($bank->data()->default_card)
                                <i class="fas fa-check-double text-success"></i>
                                @else
                                <i class="mdi mdi-close text-danger"></i>
                                @endif
                            </td>
                            <td>{{ date('d M, Y h:i A', strtotime($bank->created_at)) }}</td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @can('view wallets')
        <div class="card m-b-30 mt-3">
            <div class="card-body">
                <h4 class="mt-0 header-title">All Investments</h4>
                <p class="sub-title">
                </p>
                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Farms</th>
                            <th>Units</th>
                            <th>Rollover</th>
                            <th>Maturity Date</th>
                            <th>Days remaining</th>
                            <th>Status</th>
                            <th>Date Created</th>
                            <th><a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">Action </a></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entity->investments()->latest()->get() as $inv)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="/farms/{{ $inv->farm()->first()->slug }}" target="_blank">{{ $inv->farm()->first()->name }} <i class="ml-2 mdi mdi-link"></i></a></td>
                            <td>{{ $inv->units }}</td>
                            <td>
                                @if($inv->data()->rollover)
                                <i class="mdi mdi-check text-success"></i> Enabled for {{ strtoupper($inv->data()->type) }}
                                @else
                                <i class="mdi mdi-close text-danger"></i> Disabled
                                @endif
                            </td>
                            <td>{{ $inv->maturity_date ? date('d M, Y h:i A', strtotime($inv->maturity_date)) : '-' }}</td>
                            <td>
                                @php
                                if($inv->status == 'active'){
                                    $date1 = \Carbon\Carbon::parse($inv->maturity_date);
                                    $date2 = \Carbon\Carbon::now();
                                    echo $date1->diffInDays($date2).' days';
                                }else {
                                    echo 'Not active';
                                }
                                @endphp
                            </td>
                            <td>{!! $inv->status() !!}</td>
                            <td>{{ date('d M, Y h:i A', strtotime($inv->created_at)) }}</td>
                            <td>
                                @if($inv->status == 'queued')
                                <a class="btn btn-primary daction" href="/investments/{{ $inv->id }}/approve"><span> Approve investment</span></a><a class="ml-2 btn btn-danger daction" href="/investments/{{ $inv->id }}/decline"><span> Decline investment</span></a>
                                @else
                                <span class="text-muted">No action required</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card m-b-30 mt-3">
            <div class="card-body">
                <h4 class="mt-0 header-title">All Transactions</h4>
                <p class="sub-title">
                </p>
                <table class="table table-striped table-bordered dt-responsive nowrap datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Reference</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>Paid from</th>
                            <th>Date Performed</th>
                            <th>Date Approved/Declined</th>
                            <th><a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">Action </a></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entity->transactions()->latest()->get() as $trans)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $trans->data()->reference }}</td>
                            <td>₦{{ number_format($trans->data()->amount,2) }}</td>
                            <td>{!! $trans->type() !!}</td>
                            <td>{!! $trans->status() !!}</td>
                            <td>{{ $trans->data()->description }}</td>
                            <td>{{ $trans->data()->payment_option }}</td>
                            <td>{{ date('d M, Y h:i A', strtotime($trans->created_at)) }}</td>
                            <td>{{ date('d M, Y h:i A', strtotime($trans->updated_at)) }}</td>
                            <td>
                                @if($trans->data()->status == 'pending' && $trans->investments()->count() < 1)
                                <div class="drodown">
                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><i class="text-primary ti-more-alt"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        @if($trans->data()->type == "withdrawal")
                                        <li class="dropdown-item"><a data-target='<h6>ACCOUNT NUMBER: <small>{{ $trans->banks()->first()->data()->account_number }}</small></h6><h6>ACCOUNT NAME: <small>{{ $trans->banks()->first()->data()->account_name }}</small></h6><h6>BANK: <small>{{ $trans->banks()->first()->data()->bank->name }}</small></h6><p>Please make transfer to the above bank above!' class="changeStatus" href="/transactions/{{ $trans->id }}/approve"><span>Approve Transaction</span></a></li>
                                            @else
                                        <li class="dropdown-item"><a class="changeStatus" href="/transactions/{{ $trans->id }}/approve"><span>Approve Transaction</span></a></li>
                                            @endif
                                        <li class="dropdown-item"><a data-target='' class="changeStatus" href="/transactions/{{ $trans->id }}/decline"><span>Decline Transaction</span></a></li>
                                    </ul>
                                </div>
                                @else
                                <div class="text-muted">No action required</div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endcan
    </div>
</div>
@endsection