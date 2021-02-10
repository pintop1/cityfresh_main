@extends('layouts.admin')

@section('title', __('Edit role'))

@section('bread')
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h4 class="page-title">Edit Role</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/roles">Roles</a></li>
                <li class="breadcrumb-item active">Edit Role</li>
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
                <h4 class="mt-0 header-title">Edit role</h4>
                <p class="sub-title">
                </p>
                <form action="{{ route('roles.update', $entity->id) }}" class="gy-3" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label">Role Name</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" required="" name="name" required value="{{ $entity->name }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label">Permissions</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            @foreach($permissions as $perm)
                            <div class="form-group">
                                <div class="checkbox checkbox-primary">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck{{ $perm->id }}" name="permissions[]" value="{{ $perm->id }}" {{ $perm->roles()->where('id', $entity->id)->first() ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customCheck{{ $perm->id }}">Can {{ ucwords($perm->name) }}</label>
                                      </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-lg-7 offset-lg-5">
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection