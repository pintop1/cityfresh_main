@extends('layouts.auth')

@section('title', __('Login'))

@section('content')
<h5 class="font-18 text-center">Sign in to continue to CityFresh Farms.</h5>
<form class="form-horizontal m-t-30" method="POST" action="{{ route('login') }}">
    @csrf
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {!! session('status') !!}
        </div>
    @endif
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
            <div class="checkbox checkbox-primary">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="remember">
                    <label class="custom-control-label" for="customCheck1"> Remember me</label>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group text-center m-t-20">
        <div class="col-12">
            <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Log In</button>
        </div>
    </div>
    <div class="form-group row m-t-30 m-b-0">
        <div class="col-sm-7">
            <a href="{{ route('password.request') }}" class="text-muted"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
        </div>
        <div class="col-sm-5 text-right">
            <a href="{{ route('register') }}" class="text-muted">Create an account</a>
        </div>
    </div>
</form>
@endsection