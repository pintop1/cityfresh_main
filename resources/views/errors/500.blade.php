@extends('layouts.error')

@section('title', __('Server Error'))
@section('code', '500!')
@section('message', __('Server Error'))
@section('sub-message')
Please contact system administrators for quick fix
@endsection
