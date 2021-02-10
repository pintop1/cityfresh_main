<?php

namespace App\Observers\Farm;

use App\Entities\Farm\Farm;
use Illuminate\Support\Facades\Auth;
use \Carbon\Carbon;

class FarmObserver
{
    public function created(Farm $farm)
    {
    	$user = Auth::user();
    	$user->farms()->save($farm);
    	$date1 = Carbon::parse($farm->start_date)->subHour();
        $date2 = Carbon::now();
        if($date2->gt($date1)){
        	$farm->status = 'opened';
        	$farm->save();
        }
    }

}
