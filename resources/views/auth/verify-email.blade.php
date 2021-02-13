@extends('layouts.auth')

@section('title', __('Account verification'))

@section('content')
<h5 class="font-18 text-center">Verify your account.</h5>
<div class="mb-4 text-sm text-gray-600">
    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
</div>
<!--if (session('status') == 'verification-link-sent')-->
@if (session('message'))
    <div class="mb-4 font-medium text-sm text-success">
        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
    </div>
@endif
<div class="mt-4 flex items-center justify-between">
    <div class="row">
        <div class="col-8">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <div>
                    <button type="submit" class="btn btn-primary text-sm">
                        {{ __('Resend Verification Email') }}
                    </button>
                </div>
            </form>
        </div>
        <div class="col-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="btn btn-link underline text-sm text-gray-600">
                    {{ __('Logout') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection