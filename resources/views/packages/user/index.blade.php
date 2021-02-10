@extends('layouts.user')

@section('title', __('Farms'))

@section('bread')
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h4 class="page-title">Farms</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Farms</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="text-center">
            <h5>Choose your Farm</h5>
            <p class="text-muted">Please choose your open farm of preference below!</p>
        </div>
    </div>
</div>
<div class="row m-t-30">
    @foreach($entities as $entity)
        @php
        $farm = $entity->farms()->latest()->first();
        @endphp
    <div class="col-xl-3 col-md-6">
        <div class="card pricing-box mt-4 p-0">
            <img class="card-img-top img-fluid" src="{{ asset($farm->cover_image) }}" style="height: 200px; object-fit: cover;" alt="Card image cap">
            <div class="pricing-icon">
                @if($farm->status == 'pending') 
                <i class="mdi mdi-block-helper bg-warning"></i>
                @elseif($farm->status == 'closed')
                <i class="mdi mdi-block-helper bg-danger"></i>
                @else
                <i class="ti-check bg-success"></i>
                @endif
            </div>
            <div class="pricing-content">
                <div class="pl-4">
                    <h5 class="text-uppercase mt-5">{!! $farm->status() !!}</h5>
                </div>
                <div class="pricing-features mt-4">
                    <p class="font-14 mb-2"> {{ ucwords($entity->name) }} </p>
                    <p class="font-14 mb-2"> {{ $farm->duration.' '.strtolower($farm->duration_type) }}s </p>
                    <p class="font-14 mb-2"> ₦{{ number_format($farm->price_per_unit,2) }} per unit </p>
                    <p class="font-14 mb-2"> {{ $farm->roi }}% ROI</p>
                </div>
                <div class="pricing-border mt-4 ml-4 mr-4"></div>
                <div class="mt-4 pt-3 p-3 text-center">
                    @if($farm->status == 'opened')
                    <a href="/farms/{{ $farm->slug }}" class="btn btn-success btn-lg w-100 btn-round">Invest Now</a>
                    @elseif($farm->status == 'pending')
                    <a href="/farms/{{ $farm->slug }}" class="btn btn-warning btn-lg w-100 btn-round">View Details</a>
                    @else
                    <a href="/farms/{{ $farm->slug }}" class="btn btn-danger btn-lg w-100 btn-round">View Details</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection