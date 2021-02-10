<?php

namespace App\Observers\User;

use App\Entities\User\Wallet;
use App\Notifications\User\Wallet as WalletNotification;

class WalletObserver
{
    /**
     * Handle the Wallet "created" event.
     *
     * @param  \App\Models\User\Wallet  $wallet
     * @return void
     */
    public function created(Wallet $wallet)
    {
        //
    }

    /**
     * Handle the Wallet "updated" event.
     *
     * @param  \App\Models\User\Wallet  $wallet
     * @return void
     */
    public function updated(Wallet $wallet)
    {
        $user = $wallet->user;
        if($wallet->isDirty('amount')){
            $old_amount = $wallet->getOriginal('amount'); 
            $amount = $wallet->amount; 
            $wallet->user->notify(new WalletNotification(explode(' ', $user->name)[0], $old_amount, $amount));
        }
    }

    /**
     * Handle the Wallet "deleted" event.
     *
     * @param  \App\Models\User\Wallet  $wallet
     * @return void
     */
    public function deleted(Wallet $wallet)
    {
        //
    }

    /**
     * Handle the Wallet "restored" event.
     *
     * @param  \App\Models\User\Wallet  $wallet
     * @return void
     */
    public function restored(Wallet $wallet)
    {
        //
    }

    /**
     * Handle the Wallet "force deleted" event.
     *
     * @param  \App\Models\User\Wallet  $wallet
     * @return void
     */
    public function forceDeleted(Wallet $wallet)
    {
        //
    }
}
