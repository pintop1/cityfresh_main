<?php

namespace App\Observers\Transaction;

use App\Entities\Transaction\Transaction;
use App\Entities\User\User;
use App\Notifications\Transaction\TransactionNotification;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     *
     * @param  \App\Models\Transaction\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        $user = $transaction->user;
        $status = $transaction->data()->status;
        if($user){
            if($status == 'success'){
                $user->notify(new TransactionNotification(explode(' ', $user->name)[0], false, false, true, $transaction));
            }else {
                $user->notify(new TransactionNotification(explode(' ', $user->name)[0], true, false, false, $transaction));
            }
        }
        
    }

    /**
     * Handle the Transaction "updated" event.
     *
     * @param  \App\Models\Transaction\Transaction  $transaction
     * @return void
     */
    public function updated(Transaction $transaction)
    {
        if($transaction->isDirty('details')){
            $user = User::findOrFail($transaction->user_id);
            $status = $transaction->data()->status;
            if($status == 'success'){
                $user->notify(new TransactionNotification(explode(' ', $user->name)[0], false, false, true, $transaction));
            }elseif($status == 'failed'){
                $user->notify(new TransactionNotification(explode(' ', $user->name)[0], false, true, false, $transaction));
            }
        }elseif($transaction->isDirty('user_id')){
            $user = User::findOrFail($transaction->user_id);
            $status = $transaction->data()->status;
            if($status == 'success'){
                $user->notify(new TransactionNotification(explode(' ', $user->name)[0], false, false, true, $transaction));
            }else {
                $user->notify(new TransactionNotification(explode(' ', $user->name)[0], true, false, false, $transaction));
            }
        }
    }

    /**
     * Handle the Transaction "deleted" event.
     *
     * @param  \App\Models\Transaction\Transaction  $transaction
     * @return void
     */
    public function deleted(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     *
     * @param  \App\Models\Transaction\Transaction  $transaction
     * @return void
     */
    public function restored(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     *
     * @param  \App\Models\Transaction\Transaction  $transaction
     * @return void
     */
    public function forceDeleted(Transaction $transaction)
    {
        //
    }
}
