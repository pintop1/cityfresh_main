@extends('layouts.admin')

@section('title', __('Edit Mandate'))

@section('bread')
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h4 class="page-title">Edit Mandate</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="/">City Fresh Farms</a></li>
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/mandates">Mandates</a></li>
                <li class="breadcrumb-item active">Edit Mandate</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-6">
        <div class="card card-bordered m-b-30">
            <div class="card-body">
                <h4 class="mt-0 header-title">Edit</h4>
                <p class="sub-title">
                </p>
                <form action="{{ route('mandates.update', $entity->id) }}" class="dform" class="gy-3" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label">Amount</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="number" step="any" class="form-control" required="" name="amount" value="{{ $entity->amount }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-lg-7 offset-lg-5">
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-lg btn-primary dfsub">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection