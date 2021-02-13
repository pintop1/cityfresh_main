@extends('layouts.auth')

@section('title', __('Sign up now'))

@section('content')
<h5 class="font-18 text-center">Register</h5>
<form class="dform form-horizontal m-t-30" method="POST" action="{{ route('register') }}">
    @csrf
    <div class="form-group">
        <div class="col-12">
            <label>Name</label>
            <input class="form-control" type="text" required="" name="name" placeholder="Your full name">
            @error('name')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <div class="col-12">
            <label>Email</label>
            <input class="form-control" type="email" required="" name="email" placeholder="Your E-mail address">
            @error('email')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <div class="col-12">
            <label>Phone Number</label>
            <input class="form-control" type="number" required="" name="phone" placeholder="Your phone number">
            @error('phone')
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
    <div class="form-group">
        <div class="col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="customCheck1" name="terms">
                <label class="custom-control-label font-weight-normal" for="customCheck1">I accept <a href="#" class="text-primary">Terms and Conditions</a></label>
            </div>
            @error('terms')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group text-center m-t-20">
        <div class="col-12">
            <button class="onAct btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Register</button>
        </div>
    </div>
    <div class="form-group mb-0 row">
        <div class="col-12 m-t-10 text-center">
            <a href="{{ route('login') }}" class="text-muted">Already have account?</a>
        </div>
    </div>
</form>
@endsection

@push('more-scripts')
<script>
    $(function(){
        $('.onAct').on("click", function (e) {
            Swal.fire({
              html: 'Were you referred to us by an active user?<br> Please enter the user\'s referral code below.',
              input: 'text',
              inputAttributes: {
                autocapitalize: 'off'
              },
              showCancelButton: true,
              cancelButtonText: 'No referral link',
              confirmButtonText: 'Look up',
              showLoaderOnConfirm: true,
              inputValue: (value) => {
                alert(value);
              },
              inputValidator: (value) => {
                if (!value) {
                  return 'You need to write the referral code!'
                }
              },
              preConfirm: function preConfirm(login) {
                return fetch("{{ url('verify_referee') }}/".concat(login)).then(function (response) {
                  if (!response.ok) {
                    throw new Error(response.statusText);
                  }

                  return response.text();
                  
                })["catch"](function (error) {
                  Swal.showValidationMessage("Request failed: ".concat(error));
                });
              },
              allowOutsideClick: function allowOutsideClick() {
                return !Swal.isLoading();
              }
            }).then(function (result) {
                if(result.isConfirmed){
                    if (result.value != 'error') {
                        Swal.fire({
                          title: 'Are you sure?',
                          text: 'Your referee\'s name is '.concat(result.value),
                          icon: 'warning',
                          showCancelButton: true,
                          confirmButtonText: 'Correct'
                        }).then(function (result) {
                          //isConfirmed // isDenied
                          if(result.isConfirmed){
                            $('.dform').submit();
                          }
                        });
                      }else {
                        Swal.fire("Oops!", "Invalid Referral code supplied", "error");
                      }
                }else {
                    $('.dform').submit();
                }
              
            });
            e.preventDefault();
        });
    });
</script>
@endpush