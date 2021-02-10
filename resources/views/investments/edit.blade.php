@extends('layouts.app')

@section('content')

<form method="post" action="#">
           <input type="hidden" name="__method" value="put">
<div class="form-group">
    <label for="id">Id</label>
    <input type="text" class="form-control" id="id" name="id" value="{{old('id',$entity ? $entity->id : "")}}" required >
</div>
<div class="form-group">
    <label for="user_id">User id</label>
    <input type="text" class="form-control" id="user_id" name="user_id" value="{{old('user_id',$entity ? $entity->user_id : "")}}"  >
</div>
<div class="form-group">
    <label for="status">Status</label>
    <input type="text" class="form-control" id="status" name="status" value="{{old('status',$entity ? $entity->status : "")}}" required >
</div>
<div class="form-group">
    <label for="settings">Settings</label>
    <input type="text" class="form-control" id="settings" name="settings" value="{{old('settings',$entity ? $entity->settings : "")}}" required >
</div>
<div class="form-group">
    <label for="units">Units</label>
    <input type="text" class="form-control" id="units" name="units" value="{{old('units',$entity ? $entity->units : "")}}" required >
</div>
<div class="form-group">
    <label for="amount">Amount</label>
    <input type="text" class="form-control" id="amount" name="amount" value="{{old('amount',$entity ? $entity->amount : "")}}" required >
</div>
<div class="form-group">
    <label for="maturity_date">Maturity date</label>
    <input type="text" class="form-control" id="maturity_date" name="maturity_date" value="{{old('maturity_date',$entity ? $entity->maturity_date : "")}}" required >
</div>
<div class="form-group">
    <label for="created_at">Created at</label>
    <input type="text" class="form-control" id="created_at" name="created_at" value="{{old('created_at',$entity ? $entity->created_at : "")}}"  >
</div>
<div class="form-group">
    <label for="updated_at">Updated at</label>
    <input type="text" class="form-control" id="updated_at" name="updated_at" value="{{old('updated_at',$entity ? $entity->updated_at : "")}}"  >
</div><button type='submit' class='btn btn-primary'>Submit</button></form>

@endsection