<?php

namespace App\Observers\Transaction;

use App\Entities\Transaction\Investment;
use App\Notifications\Transaction\Investment as InvestmentNotification;
use App\Entities\User\User;
use App\Entities\Setting;
use App\Entities\Transaction\Transaction;
use App\Entities\User\Referral\Referral;
use DB;
use App\Traits\GlobalMethods;
use Carbon\Carbon;

class InvestmentObserver
{
    use GlobalMethods;
    /**
     * Handle the Investment "created" event.
     *
     * @param  \App\Models\Transaction\Investment  $investment
     * @return void
     */
    public function created(Investment $investment)
    {
        $user = User::find($investment->user_id);
        if($user){
            $status = $investment->status;
            if($status == 'pending'){
                $this->payRef($user, $investment);
                $user->notify(new InvestmentNotification(explode(' ', $user->name)[0], $investment, false, false, false, false, false, true));
            }else {
                $user->notify(new InvestmentNotification(explode(' ', $user->name)[0], $investment, false, false, false, false, true, false));
            }
        }
    }

    /**
     * Handle the Investment "updated" event.
     *
     * @param  \App\Models\Transaction\Investment  $investment
     * @return void
     */
    public function updated(Investment $investment)
    {
        if($investment->isDirty('status')){
            $user = User::find($investment->user_id);
            $status = $investment->status;
            if($status == 'declined'){
                $user->notify(new InvestmentNotification(explode(' ', $user->name)[0], $investment, true, false, false, false, false, false));
            }elseif($status == 'paid'){
                $user->notify(new InvestmentNotification(explode(' ', $user->name)[0], $investment, false, true, false, false, false, false));
            }elseif($status == 'matured'){
                $user->notify(new InvestmentNotification(explode(' ', $user->name)[0], $investment, false, false, true, false, false, false));
            }elseif($status == 'active'){
                $user->notify(new InvestmentNotification(explode(' ', $user->name)[0], $investment, false, false, false, true, false, false));
            }
        }elseif($investment->isDirty('user_id')){
            $user = User::find($investment->user_id);
            $status = $investment->status;
            if($status == 'pending'){
                $this->payRef($user, $investment);
                $user->notify(new InvestmentNotification(explode(' ', $user->name)[0], $investment, false, false, false, false, false, true));
            }else {
                $user->notify(new InvestmentNotification(explode(' ', $user->name)[0], $investment, false, false, false, false, true, false));
            }
        }
    }

    /**
     * Handle the Investment "deleted" event.
     *
     * @param  \App\Models\Transaction\Investment  $investment
     * @return void
     */
    public function deleted(Investment $investment)
    {
        //
    }

    /**
     * Handle the Investment "restored" event.
     *
     * @param  \App\Models\Transaction\Investment  $investment
     * @return void
     */
    public function restored(Investment $investment)
    {
        //
    }

    /**
     * Handle the Investment "force deleted" event.
     *
     * @param  \App\Models\Transaction\Investment  $investment
     * @return void
     */
    public function forceDeleted(Investment $investment)
    {
        //
    }

    private function payRef($user, $investment)
    {
        $setting = Setting::find(1);
        $referral = Referral::where('user_id', $user->id)->first();
        if($referral){
            $referree = $referree = $referral->referree()->first();
            if($referree)
            {
                $paid = DB::table('paid_referrals')->where(['referral_id'=>$referral->id, 'user_id'=>$referree->id])->count();
                if($paid < 1)
                {
                    $amount = $investment->amount * ($setting->value/100);
                    $newB = $referree->wallet->amount + $amount;
                    $referree->wallet->amount = $newB;
                    $referree->wallet->save();
                    $data = [
                        'amount'=>$amount,
                        'type'=>'credit',
                        'description'=>'Referral Commission payment',
                        'payment_option'=>'wallet',
                        'reference'=>$this->randomId('transactions', 'details->reference'),
                        'status'=>'success',
                    ];
                    $transaction = Transaction::create(['details'=>$data]);
                    $referral->paid_commission()->attach($referree->id, ['amount'=>$amount, 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now]);
                    $referral->referral_payments()->attach($transaction->id);
                    $referree->transactions()->save($transaction);
                }
            }
        }
    }
}
