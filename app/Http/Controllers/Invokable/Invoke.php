<?php

namespace App\Http\Controllers\Invokable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class Invoke extends Controller
{
    public static function init(){
    	Artisan::call('farms:closing');
    	Artisan::call('farms:openings');
    	Artisan::call('investment:mandating');
    	Artisan::call('investment:maturity');
    	Artisan::call('users:delete');
    }
}
