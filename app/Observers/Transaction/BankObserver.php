<?php

namespace App\Observers\Transaction;

use App\Entities\Transaction\Bank;
use App\Notifications\Transaction\BankNotification;

class BankObserver
{
    /**
     * Handle the Bank "created" event.
     *
     * @param  \App\Models\Transaction\Bank  $bank
     * @return void
     */
    public function created(Bank $bank)
    {
        $user = $bank->user;
        $user->notify(new BankNotification(explode(' ', $user->name)[0], false));
    }

    /**
     * Handle the Bank "updated" event.
     *
     * @param  \App\Models\Transaction\Bank  $bank
     * @return void
     */
    public function updated(Bank $bank)
    {
        //
    }

    /**
     * Handle the Bank "deleted" event.
     *
     * @param  \App\Models\Transaction\Bank  $bank
     * @return void
     */
    public function deleted(Bank $bank)
    {
        $user = $bank->user;
        $user->notify(new BankNotification(explode(' ', $user->name)[0], true));
    }

    /**
     * Handle the Bank "restored" event.
     *
     * @param  \App\Models\Transaction\Bank  $bank
     * @return void
     */
    public function restored(Bank $bank)
    {
        //
    }

    /**
     * Handle the Bank "force deleted" event.
     *
     * @param  \App\Models\Transaction\Bank  $bank
     * @return void
     */
    public function forceDeleted(Bank $bank)
    {
        //
    }
}
