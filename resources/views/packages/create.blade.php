@extends('layouts.admin')

@section('title', __('Add a new package'))

@section('bread')
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h4 class="page-title">Create Package</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/packages">Packages</a></li>
                <li class="breadcrumb-item active">Create Package</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@push('more-styles')
@endpush

@push('more-scripts')
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">Add new package</h4>
                <p class="sub-title">Please fill in the package details below carefully.</p>
                <form action="{{ route('packages.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-4">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                            @error('name')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label>Description</label>
                            <textarea class="form-control" name="description"></textarea>
                        </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary btn-lg" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection