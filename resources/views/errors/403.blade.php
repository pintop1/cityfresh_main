@extends('layouts.error')

@section('title', __('Forbidden'))
@section('code', '403!')
@section('message', __('Sorry, you are not authorized to perform this action'))
@section('sub-message')
We are sorry for any inconvenience caused!
@endsection
