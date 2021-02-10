<?php

namespace App\Console\Commands\Investment;

use Illuminate\Console\Command;
use App\Entities\Transaction\Investment;
use App\Entities\Transaction\Transaction;
use App\Entities\Transaction\Mandate;
use App\Traits\GlobalMethods;
use Carbon\Carbon;

class Maturity extends Command
{
    use GlobalMethods;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investment:maturity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mature and pay out investment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $investments = Investment::where('status', 'active')->latest()->get();
        foreach($investments as $inv){
            $date1 = Carbon::parse($inv->maturity_date)->subHour();
            $date2 = Carbon::now();
            if($date2->gt($date1)){
                $rollover = 0;
                $user = $inv->user;
                $farm = $inv->farm()->first();
                $amount = $inv->amount;
                $interest = $inv->amount * ($farm->roi/100);
                if($inv->data()->rollover){
                    if($inv->data()->type == 'roi'){
                        $rollover += $interest;
                    }else if($inv->data()->type == 'capital'){
                        $rollover += $amount;
                    }else if($inv->data()->type == 'roi + capital'){
                        $rollover += $amount+$interest;
                    }
                } 
                $inv->status = 'matured';
                $inv->maturity_date = null;
                $inv->save();
                //
                if($rollover > 0){
                    $mandate = Mandate::create(['amount'=>$rollover]);
                    $mandate->investments()->attach($inv->id);
                    $user->mandates()->save($mandate);
                }
                $newB = $user->wallet->amount + $amount + $interest;
                $dataa = [
                    'amount'=>$amount+$interest,
                    'type'=>'credit',
                    'description'=>'Investment payments',
                    'payment_option'=>'Investment',
                    'reference'=>$this->randomId('transactions', 'details->reference'),
                    'status'=>'success',
                ];
                $transaction = Transaction::create(['details'=>$dataa]);
                $transaction->investments()->attach($inv->id);
                $user->transactions()->save($transaction);
                $user->wallet->amount = $newB;
                $user->wallet->save();
                //
                $inv->status = 'paid';
                $inv->save();
            }
        }
    }
}
