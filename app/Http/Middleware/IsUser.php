<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsUser
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

        if (Auth::check()) {
            if (!Auth::user()->is_admin) { 
                if(Auth::user()->is_active){
                    return $next($request);
                }
                $request->session()->invalidate();
                $request->session()->flush();
                $request->session()->regenerateToken();
                return redirect('login')->with('status', '<div class="alert alert-danger">You have been restricted from our platform.<br> Please contact our adminsitrators for support!</div>');
            }

            return redirect()->route('admin.dashboard')->with('error','<div class="alert alert-danger">You can\'t access user profile with admin account.</div>');
        }
        return redirect()->route('login');
    }
}