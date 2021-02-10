<?php

namespace App\Observers\Transaction;

use App\Entities\Transaction\Mandate;
use App\Entities\User\User;
use App\Notifications\Transaction\MandateNotification;

class MandateObserver
{
    /**
     * Handle the Mandate "created" event.
     *
     * @param  \App\Models\Transaction\Mandate  $mandate
     * @return void
     */
    public function created(Mandate $mandate)
    {
        //
    }

    /**
     * Handle the Mandate "updated" event.
     *
     * @param  \App\Models\Transaction\Mandate  $mandate
     * @return void
     */
    public function updated(Mandate $mandate)
    {
        if($mandate->isDirty('user_id')){
            $user = User::find($mandate->user_id);
            $user->notify(new MandateNotification(explode(' ', $user->name)[0], false, $mandate));
        }
    }

    /**
     * Handle the Mandate "deleted" event.
     *
     * @param  \App\Models\Transaction\Mandate  $mandate
     * @return void
     */
    public function deleted(Mandate $mandate)
    {
        $user = User::find($mandate->user_id);
        $user->notify(new MandateNotification(explode(' ', $user->name)[0], true, $mandate));
    }

    /**
     * Handle the Mandate "restored" event.
     *
     * @param  \App\Models\Transaction\Mandate  $mandate
     * @return void
     */
    public function restored(Mandate $mandate)
    {
        //
    }

    /**
     * Handle the Mandate "force deleted" event.
     *
     * @param  \App\Models\Transaction\Mandate  $mandate
     * @return void
     */
    public function forceDeleted(Mandate $mandate)
    {
        //
    }
}
