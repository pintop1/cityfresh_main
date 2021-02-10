<?php

namespace App\Observers\User\Referral;

use App\Entities\User\Referral\ReferreeDetail;
use App\Notifications\User\Referral\ReferralDetailNotification;

class ReferreeDetailObserver
{
    /**
     * Handle the ReferreeDetail "created" event.
     *
     * @param  \App\Models\User\Referral\ReferreeDetail  $referreeDetail
     * @return void
     */
    public function created(ReferreeDetail $referreeDetail)
    {
        //$user = $referreeDetail->user;
        //$user->notify(new ReferralDetailNotification(explode(' ', $user->name)[0], $referreeDetail->code));
    }

    /**
     * Handle the ReferreeDetail "updated" event.
     *
     * @param  \App\Models\User\Referral\ReferreeDetail  $referreeDetail
     * @return void
     */
    public function updated(ReferreeDetail $referreeDetail)
    {
        //
    }

    /**
     * Handle the ReferreeDetail "deleted" event.
     *
     * @param  \App\Models\User\Referral\ReferreeDetail  $referreeDetail
     * @return void
     */
    public function deleted(ReferreeDetail $referreeDetail)
    {
        //
    }

    /**
     * Handle the ReferreeDetail "restored" event.
     *
     * @param  \App\Models\User\Referral\ReferreeDetail  $referreeDetail
     * @return void
     */
    public function restored(ReferreeDetail $referreeDetail)
    {
        //
    }

    /**
     * Handle the ReferreeDetail "force deleted" event.
     *
     * @param  \App\Models\User\Referral\ReferreeDetail  $referreeDetail
     * @return void
     */
    public function forceDeleted(ReferreeDetail $referreeDetail)
    {
        //
    }
}
