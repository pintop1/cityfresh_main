<?php

namespace App\Observers\Farm;

use App\Entities\Farm\Farm;
use Illuminate\Support\Facades\Auth;
use \Carbon\Carbon;

class FarmObserver
{
    /**
     * Handle the Farm "created" event.
     *
     * @param  \App\Models\Farm  $farm
     * @return void
     */
    public function created(Farm $farm)
    {
        /*$date1 = Carbon::parse($farm->start_date)->subHour();
        $date2 = Carbon::now();
        if($date2->gt($date1)){
            $farm->status = 'opened';
            $farm->save();
        }*/
    }

    /**
     * Handle the Farm "updated" event.
     *
     * @param  \App\Models\Farm  $farm
     * @return void
     */
    public function updated(Farm $farm)
    {
        if($farm->isDirty('start_date')){
            $date1 = Carbon::parse($farm->start_date)->subHour();
            $date2 = Carbon::now();
            if($date2->gt($date1)){
                $farm->status = 'opened';
                $farm->save();
            }
        }
    }

    /**
     * Handle the Farm "deleted" event.
     *
     * @param  \App\Models\Farm  $farm
     * @return void
     */
    public function deleted(Farm $farm)
    {
        //
    }

    /**
     * Handle the Farm "restored" event.
     *
     * @param  \App\Models\Farm  $farm
     * @return void
     */
    public function restored(Farm $farm)
    {
        //
    }

    /**
     * Handle the Farm "force deleted" event.
     *
     * @param  \App\Models\Farm  $farm
     * @return void
     */
    public function forceDeleted(Farm $farm)
    {
        //
    }
}
