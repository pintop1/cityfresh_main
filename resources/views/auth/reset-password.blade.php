@extends('layouts.auth')

@section('content')
<h5 class="font-18 text-center">Reset your password.</h5>
<form class="form-horizontal m-t-30" method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <div class="form-group">
        <div class="col-12">
            <label>Email</label>
            <input class="form-control" type="text" required="" name="email" placeholder="Your E-mail address">
            @error('email')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <div class="col-12">
            <label>Password</label>
            <input class="form-control" type="password" name="password" required="" placeholder="Password">
            @error('password')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <div class="col-12">
            <label>Confirm Password</label>
            <input class="form-control" type="password" name="password_confirmation" required="" placeholder="Confirm Password">
        </div>
    </div>
    <div class="form-group text-center m-t-20">
        <div class="col-12">
            <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Reset Password</button>
        </div>
    </div>
</form>
@endsection