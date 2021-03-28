@extends('layouts.admin')

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
            </div>
        </div>
    </div>
</div>
@endsection