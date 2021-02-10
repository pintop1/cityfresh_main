<?php

namespace App\Observers\User\Referral;

use App\Entities\User\Referral\Referral;
use App\Notifications\User\Referral\ReferralNotification;

class ReferralObserver
{
    /**
     * Handle the Referral "created" event.
     *
     * @param  \App\Models\User\Referral\Referral  $referral
     * @return void
     */
    public function created(Referral $referral)
    {
        //$user = $referral->referree()->first();
        //$user->notify(new ReferralNotification(explode(' ', $user->name)[0]));
    }

    /**
     * Handle the Referral "updated" event.
     *
     * @param  \App\Models\User\Referral\Referral  $referral
     * @return void
     */
    public function updated(Referral $referral)
    {
        //
    }

    /**
     * Handle the Referral "deleted" event.
     *
     * @param  \App\Models\User\Referral\Referral  $referral
     * @return void
     */
    public function deleted(Referral $referral)
    {
        //
    }

    /**
     * Handle the Referral "restored" event.
     *
     * @param  \App\Models\User\Referral\Referral  $referral
     * @return void
     */
    public function restored(Referral $referral)
    {
        //
    }

    /**
     * Handle the Referral "force deleted" event.
     *
     * @param  \App\Models\User\Referral\Referral  $referral
     * @return void
     */
    public function forceDeleted(Referral $referral)
    {
        //
    }
}
