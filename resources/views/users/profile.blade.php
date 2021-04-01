@extends('layouts.user')

@section('title', __('My Profile'))

@section('bread')
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h4 class="page-title">Profile</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Profile</li>
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
<script>
    $(function(){
        $('.deleteAction').click(function(e){
            e.preventDefault();
            var form = $(this).attr('data-target');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this card from your profile!",
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
        $('.deleteActionBank').click(function(e){
            e.preventDefault();
            var form = $(this).attr('data-target');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this bank from your profile!",
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
        $('.updateActionBank').click(function(e){
            e.preventDefault();
            var form = $(this).attr('data-target');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to make this bank your default bank account!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, make it!',
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
        $('.addCard').click(function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "A 100 NGN charge will be taken from the card for confirmation.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, i accept!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger ml-2',
                buttonsStyling: false
            }).then((result) => {
                if(result.isConfirmed){
                    var url = $(this).attr('href');
                    window.location.href = url;
                }
            });
        });
    });
</script>
@endpush

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">My Profile</h4>
                <p class="sub-title">You have full control to change your primary details. <span class="text-primary"><em class="fas fa-info" data-toggle="tooltip" data-placement="right" title="You can always edit your primary info"></em></span></p>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#profile" role="tab">
                        <span class="d-none d-md-block">Profile</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span> 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#cards" role="tab">
                        <span class="d-none d-md-block">Cards</span><span class="d-block d-md-none"><i class="mdi mdi-credit-card-multiple h5"></i></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#banks" role="tab">
                        <span class="d-none d-md-block">Banks</span><span class="d-block d-md-none"><i class="mdi mdi-bank h5"></i></span>
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active p-3" id="profile" role="tabpanel">
                        <p class="mb-0">
                            <form action="{{ route('profile.update', $user->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group col-lg-4">
                                        <label>Passport</label>
                                        <input type="file" name="passport" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Phone</label>
                                        <input type="number" name="phone" class="form-control" value="{{ $user->phone }}" readonly>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Date of birth</label>
                                        <input type="date" name="dob" class="form-control" value="{{ $user->dob }}">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Address</label>
                                        <input type="text" name="address" class="form-control" value="{{ $user->address }}">
                                    </div>
                                    <div class="form-group col-12">
                                        <button class="btn btn-primary btn-block btn-lg" type="submit">Update profile</button>
                                    </div>
                                </div>
                            </form>
                        </p>
                    </div>
                    <div class="tab-pane p-3" id="cards" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <a href="/card/add?from=-profile" class="btn btn-primary btn-lg mb-5 addCard">Add new card</a>
                                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Bank</th>
                                            <th>Account Name</th>
                                            <th>Card Type</th>
                                            <th>Last 4</th>
                                            <th>Date Added</th>
                                            <th><a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">Action </a></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->cards as $card)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $card->data()->bank }}</td>
                                            <td>{{ $card->data()->account_name }}</td>
                                            <td>{{ $card->data()->card_type }}</td>
                                            <td>{{ $card->data()->last4 }}</td>
                                            <td>{{ date('d M, Y h:i A', strtotime($card->created_at)) }}</td>
                                            <td>
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><i class="text-primary ti-more-alt"></i></a>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        <li class="dropdown-item"><a href="" class="deleteAction" data-target="#delete-card{{$card->id}}"><span>Remove Card</span></a></li>
                                                        <form id="delete-card{{$card->id}}" action="{{ route('cards.destroy', $card->id) }}" method="POST" class="d-none">
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
                    <div class="tab-pane p-3" id="banks" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-success waves-effect waves-light mb-3" data-toggle="modal" data-target="#myModal">Add Bank</button>
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Bank</th>
                                            <th>Account Name</th>
                                            <th>Account Number</th>
                                            <th>Default Bank</th>
                                            <th>Date Added</th>
                                            <th><a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">Action </a></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->banks as $bank)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $bank->data()->bank->name }}</td>
                                            <td>{{ $bank->data()->account_name }}</td>
                                            <td>{{ $bank->data()->account_number }}</td>
                                            <td>
                                                @if($bank->data()->default_card != null && $bank->data()->default_card)
                                                <i class="fas fa-check-double text-success"></i>
                                                @else
                                                <i class="mdi mdi-close text-danger"></i>
                                                @endif
                                            </td>
                                            <td>{{ date('d M, Y h:i A', strtotime($bank->created_at)) }}</td>
                                            <td>
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><i class="text-primary ti-more-alt"></i></a>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        <li class="dropdown-item"><a href="" class="deleteActionBank" data-target="#delete-bank{{$bank->id}}"><span>Remove Bank</span></a></li>
                                                        <form id="delete-bank{{$bank->id}}" action="{{ route('banks.destroy', $bank->id) }}" method="POST" class="d-none">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        @if(!$bank->data()->default_card)
                                                        <li class="dropdown-item"><a href="" class="updateActionBank" data-target="#update-bank{{$bank->id}}"><span>Make default</span></a></li>
                                                        <form id="update-bank{{$bank->id}}" action="{{ route('banks.update', $bank->id) }}" method="POST" class="d-none">
                                                            @csrf
                                                            @method('PUT')
                                                        </form>
                                                        @endif
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
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('banks.store') }}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Add New Bank Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>Banks</label>
                        <select class="form-control" name="bank">
                            @foreach($banks as $bank)
                            <option value="{{ $bank->code }}">{{ $bank->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Account Number</label>
                        <input type="number" name="account_number" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1" name="default_card">
                            <label class="custom-control-label font-weight-normal" for="customCheck1">Use this as default bank account.</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection