<?php

namespace App\Observers\Transaction;

use App\Entities\Transaction\Card;
use App\Notifications\Transaction\CardNotification;

class CardObserver
{
    /**
     * Handle the Card "created" event.
     *
     * @param  \App\Models\Transaction\Card  $card
     * @return void
     */
    public function created(Card $card)
    {
        //
    }

    /**
     * Handle the Card "updated" event.
     *
     * @param  \App\Models\Transaction\Card  $card
     * @return void
     */
    public function updated(Card $card)
    {
        if($card->isDirty('user_id')){
            $user = $card->user;
            $user->notify(new CardNotification(explode(' ', $user->name)[0], false));
        }
    }

    /**
     * Handle the Card "deleted" event.
     *
     * @param  \App\Models\Transaction\Card  $card
     * @return void
     */
    public function deleted(Card $card)
    {
        $user = $card->user;
        $user->notify(new CardNotification(explode(' ', $user->name)[0], false));
    }

    /**
     * Handle the Card "restored" event.
     *
     * @param  \App\Models\Transaction\Card  $card
     * @return void
     */
    public function restored(Card $card)
    {
        //
    }

    /**
     * Handle the Card "force deleted" event.
     *
     * @param  \App\Models\Transaction\Card  $card
     * @return void
     */
    public function forceDeleted(Card $card)
    {
        //
    }
}
