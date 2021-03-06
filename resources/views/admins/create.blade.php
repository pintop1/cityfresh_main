@extends('layouts.admin')

@section('title', __('Add a new administrator'))

@section('bread')
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h4 class="page-title">Administrators</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/administrators">Administrators</a></li>
                <li class="breadcrumb-item active">Add new user</li>
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
                <h4 class="mt-0 header-title">Add new user</h4>
                <p class="sub-title"></p>
                <form action="{{ route('administrators.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>E-mail</label>
                            <input type="email" name="email" class="form-control" required>
                            @error('email')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Phone</label>
                            <input class="form-control" type="number" name="phone" required>
                            @error('phone')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Roles</label>
                            <select class="form-control" name="roles[]" multiple>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <button class="btn btn-primary btn-lg" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection