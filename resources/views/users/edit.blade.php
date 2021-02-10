@extends('layouts.app')

@section('content')

<form method="post" action="#">
           <input type="hidden" name="__method" value="put">
<div class="form-group">
    <label for="id">Id</label>
    <input type="text" class="form-control" id="id" name="id" value="{{old('id',$entity ? $entity->id : "")}}" required >
</div>
<div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{old('name',$entity ? $entity->name : "")}}" required >
</div>
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" value="{{old('email',$entity ? $entity->email : "")}}" required >
</div>
<div class="form-group">
    <label for="email_verified_at">Email verified at</label>
    <input type="text" class="form-control" id="email_verified_at" name="email_verified_at" value="{{old('email_verified_at',$entity ? $entity->email_verified_at : "")}}"  >
</div>
<div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" value="{{old('password',$entity ? $entity->password : "")}}" required >
</div>
<div class="form-group">
    <label for="two_factor_secret">Two factor secret</label>
    <textarea  class="form-control" id="exampleFormControlTextarea1" id="two_factor_secret" name="two_factor_secret">{{old('two_factor_secret',$entity ? $entity->two_factor_secret : "")}}</textarea>
</div>
<div class="form-group">
    <label for="two_factor_recovery_codes">Two factor recovery codes</label>
    <textarea  class="form-control" id="exampleFormControlTextarea1" id="two_factor_recovery_codes" name="two_factor_recovery_codes">{{old('two_factor_recovery_codes',$entity ? $entity->two_factor_recovery_codes : "")}}</textarea>
</div>
<div class="form-group">
    <label for="phone">Phone</label>
    <input type="text" class="form-control" id="phone" name="phone" value="{{old('phone',$entity ? $entity->phone : "")}}"  >
</div>
<div class="form-group">
    <label for="remember_token">Remember token</label>
    <input type="text" class="form-control" id="remember_token" name="remember_token" value="{{old('remember_token',$entity ? $entity->remember_token : "")}}"  >
</div>
<div class="form-group">
    <label for="current_team_id">Current team id</label>
    <input type="text" class="form-control" id="current_team_id" name="current_team_id" value="{{old('current_team_id',$entity ? $entity->current_team_id : "")}}"  >
</div>
<div class="form-group">
    <label for="profile_photo_path">Profile photo path</label>
    <textarea  class="form-control" id="exampleFormControlTextarea1" id="profile_photo_path" name="profile_photo_path">{{old('profile_photo_path',$entity ? $entity->profile_photo_path : "")}}</textarea>
</div>
<div class="form-group">
    <label for="dob">Dob</label>
    <input type="text" class="form-control" id="dob" name="dob" value="{{old('dob',$entity ? $entity->dob : "")}}"  >
</div>
<div class="form-group">
    <label for="address">Address</label>
    <input type="text" class="form-control" id="address" name="address" value="{{old('address',$entity ? $entity->address : "")}}"  >
</div>
<div class="form-group">
    <label for="is_admin">Is admin</label>
    <input type="text" class="form-control" id="is_admin" name="is_admin" value="{{old('is_admin',$entity ? $entity->is_admin : "")}}" required >
</div>
<div class="form-group">
    <label for="is_active">Is active</label>
    <input type="text" class="form-control" id="is_active" name="is_active" value="{{old('is_active',$entity ? $entity->is_active : "")}}" required >
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