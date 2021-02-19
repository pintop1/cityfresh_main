@extends('layouts.auth')

@section('title', __('Forgot Password'))

@section('content')
<form class="form-horizontal m-t-30" method="POST" action="{{ route('password.email') }}">
    @csrf
    @if (session('status'))
        <div class="col-12">
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {!! session('status') !!}
            </div>
        </div>
    @endif
    <div class="col-12 mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>
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
    <div class="form-group text-center m-t-20">
        <div class="col-12">
            <button class="btn btn-success btn-block btn-lg waves-effect waves-light" type="submit">Email Password Reset Link</button>
        </div>
    </div>
</form>
@endsection