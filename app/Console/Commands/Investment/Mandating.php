<?php

namespace App\Console\Commands\Investment;

use Illuminate\Console\Command;
use App\Entities\Transaction\Investment;
use App\Entities\Transaction\Transaction;
use App\Entities\Transaction\Mandate;
use App\Traits\GlobalMethods;
use Carbon\Carbon;

class Mandating extends Command
{
    use GlobalMethods;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investment:mandating';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reinvest mandates';

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
        $ret = false;
        $mandates = Mandate::where('amount', '>', 0)->latest()->get();
        foreach ($mandates as $key => $mandate) {
            $investment = $mandate->investments()->first();
            $dfarm = $investment->farm()->first();
            $package = $dfarm->package;
            $farms = $package->farms()->where('status', 'opened')->latest()->get();
            foreach ($farms as $farm) {
                if($mandate->amount > 0){
                    $this->investNow($farm, $mandate, $investment->data());
                }
            }
        }
    }

    private function investNow($farm, $mandate, $setting){
        $user = $mandate->user;
        $per_unit = $farm->price_per_unit;
        $remainder = $mandate->amount%$per_unit;
        $buying = (int) ($mandate->amount / $per_unit);
        if($buying > 0){
            // check if units is enough
            // end check
            $totalBuying = $per_unit * $buying;
            $investment = $this->saveInvestment($farm, $totalBuying, $buying, 'wallet', $user, 'success', 'pending', $setting);
            if($remainder > 0){
                $mandate->amount = $remainder;
                $mandate->save();
            }else {
                $investment = $mandate->investments()->first();
                $mandate->investments()->detach($investment->id);
                $mandate->delete();
            }
        }
    }

    private function saveInvestment($farm, $amount, $units, $from, $user, $status, $status2, $setting){
        $newU = $farm->available_units - $units;
        $rollover['rollover'] = false;
        if($setting->rollover){
            $rollover['rollover'] = true;
            $rollover['type'] = $setting->type;
        }
        $invData = [
            'units'=>$units,
            'amount'=>$amount,
            'settings' => $rollover,
            'status' => $status2,
        ];
        $dataa = [
            'amount'=>$amount,
            'type'=>'debit',
            'description'=>'Payment for investment',
            'payment_option'=>$from,
            'reference'=>$this->randomId('transactions', 'details->reference'),
            'status'=>$status,
        ];
        $investment = Investment::create($invData);
        $transaction = Transaction::create(['details'=>$dataa]);
        $farm->investments()->attach($investment->id);
        $user->transactions()->save($transaction);
        $user->investments()->save($investment);
        $investment->transactions()->attach($transaction->id);
        $farm->available_units = $newU;
        $farm->save();
        return $investment;
    }
}
