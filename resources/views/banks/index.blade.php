@extends('layouts.user')

@section('title', __('Invest now'))

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
@endpush

@push('more-scripts')
@endpush

@section('content')

@endsection