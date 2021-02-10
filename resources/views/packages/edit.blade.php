@extends('layouts.admin')

@section('title', __('Edit Package'))

@section('bread')
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h4 class="page-title">Edit Package</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/packages">Packages</a></li>
                <li class="breadcrumb-item"><a href="/packages/{{ $entity->slug }}">{{ $entity->name }}</a></li>
                <li class="breadcrumb-item active">Edit</li>
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
                <form action="{{ route('packages.update', $entity->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-4">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $entity->name }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label>Description</label>
                            <textarea class="form-control" name="description">{{ $entity->description }}</textarea>
                        </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary btn-lg" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection