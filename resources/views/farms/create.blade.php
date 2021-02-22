@extends('layouts.admin')

@section('title', __('Add a new Farm'))

@section('bread')
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h4 class="page-title">Farm Lists</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/farmlists">Farm List</a></li>
                <li class="breadcrumb-item active">Create Farm</li>
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
                <h4 class="mt-0 header-title">Add new farm</h4>
                <p class="sub-title">Please fill in the farm details below carefully.</p>
                <form action="{{ route('farmlists.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @isset($package)
                    <input type="hidden" name="package" class="form-control" value="{{ $package->id }}">
                    @else
                    <div class="row">
                        <div class="form-group col-4">
                            <label>Package</label>
                            <select class="form-control" name="package">
                                @foreach($packages as $package)
                                <option value="{{ $package->id }}" {{ old('package') == $package ? 'selected':'' }}>{{ $package->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endisset
                    <div class="row">
                        <div class="form-group col-4">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
                        <div class="form-group col-4">
                            <label>Start Date</label>
                            <input class="form-control" type="datetime-local" value="{{ date('Y-m-d') }}T{{ date('H')+1 }}:{{ date('i:s') }}" name="start_date">
                            @error('start_date')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label>Close Date</label>
                            <input class="form-control" type="datetime-local" value="{{ date('Y-m-d') }}T{{ date('H')+1 }}:{{ date('i:s') }}" name="close_date">
                            @error('close_date')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label>Duration</label>
                            <input class="form-control" type="number" name="duration" value="{{ old('duration') }}">
                            @error('duration')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label>Duration Type</label>
                            <select class="form-control" name="duration_type">
                                <option {{ old('duration_type') == 'Day' ? 'selected':'' }}>Day</option>
                                <option {{ old('duration_type') == 'Week' ? 'selected':'' }}>Week</option>
                                <option {{ old('duration_type') == 'Month' ? 'selected':'' }}>Month</option>
                                <option {{ old('duration_type') == 'Year' ? 'selected':'' }}>Year</option>
                            </select>
                        </div>
                        <div class="form-group col-4">
                            <label>Price Per Unit</label>
                            <input class="form-control" type="number" name="price_per_unit" step="any" value="{{ old('price_per_unit') }}">
                            @error('price_per_unit')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label>ROI</label>
                            <input class="form-control" type="number" name="roi" step="any" {{ old('roi') }}>
                            @error('roi')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label>Total Units</label>
                            <input class="form-control" type="number" name="total_units" {{ old('total_units') }}>
                            @error('total_units')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck2" name="allow_rollover" {{ old('allow_rollover') ? 'checked':'' }}>
                                <label class="custom-control-label font-weight-normal" for="customCheck2">Enable Roll Over</label>
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