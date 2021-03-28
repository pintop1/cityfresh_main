@extends('layouts.admin')

@section('title', __('Edit farm'))

@section('bread')
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h4 class="page-title">Editing farm</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/farmlists">Farm List</a></li>
                <li class="breadcrumb-item"><a href="/farmlists/{{ $entity->slug }}">{{ $entity->name }}</a></li>
                <li class="breadcrumb-item active">Edit Farm</li>
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
                <h4 class="mt-0 header-title">Edit farm</h4>
                <p class="sub-title">Please fill in the farm details below carefully.</p>
                <form action="{{ route('farmlists.update', $entity->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-4">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $entity->name }}" readonly>
                        </div>
                        <div class="form-group col-4">
                            <label>Cover Image</label>
                            <input type="file" name="cover_image" class="form-control">
                            @error('cover_image')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        @if($entity->status != 'opened')
                        <div class="form-group col-4">
                            <label>Start Date</label>
                            <input class="form-control" type="datetime-local" value="{{ date('Y-m-d', strtotime($entity->start_date)) }}T{{ date('H:i:s', strtotime($entity->start_date)) }}" name="start_date">
                            @error('start_date')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label>Close Date</label>
                            <input class="form-control" type="datetime-local" value="{{ date('Y-m-d', strtotime($entity->close_date)) }}T{{ date('H:i:s', strtotime($entity->close_date)) }}" name="close_date">
                            @error('close_date')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label>Duration</label>
                            <input class="form-control" type="number" name="duration" value="{{ $entity->duration }}">
                            @error('duration')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label>Duration Type</label>
                            <select class="form-control" name="duration_type">
                                <option {{ $entity->duration_type == 'Day' ? 'checked':'' }}>Day</option>
                                <option {{ $entity->duration_type == 'Week' ? 'checked':'' }}>Week</option>
                                <option {{ $entity->duration_type == 'Month' ? 'checked':'' }}>Month</option>
                                <option {{ $entity->duration_type == 'Year' ? 'checked':'' }}>Year</option>
                            </select>
                        </div>
                        <div class="form-group col-4">
                            <label>Price Per Unit</label>
                            <input class="form-control" type="number" name="price_per_unit" step="any" value="{{ $entity->price_per_unit }}">
                            @error('price_per_unit')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label>ROI</label>
                            <input class="form-control" type="number" name="roi" step="any" value="{{ $entity->roi }}">
                            @error('roi')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        @endif
                        <div class="form-group col-4">
                            <label>Total Units</label>
                            <input class="form-control" type="number" name="total_units" value="{{ $entity->total_units }}">
                            @error('total_units')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label>Available Units</label>
                            <input class="form-control" type="number" name="available_units" value="{{ $entity->available_units }}" required="">
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