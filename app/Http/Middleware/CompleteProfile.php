<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompleteProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(Auth::user()->profile_photo_path == null || Auth::user()->dob == null || Auth::user()->address == null){
            return redirect('/profile')->with('error_bottom', "<script>$(function(){Swal.fire({title: 'You are almost there!',text: 'Please fill your date of birth, passport photograph and address!',icon: 'error'})});</script>");
        }else if(Auth::user()->banks()->count() < 1){
            return redirect('/profile')->with('error_bottom', "<script>$(function(){Swal.fire({title: 'You are almost there!',text: 'Please add at lease one bank account to your profile!',icon: 'error'})});</script>");
        }
        return $next($request);
    }
}
