<?php

namespace App\Console\Commands\Farm;

use Illuminate\Console\Command;
use App\Entities\Farm\Farm;
use Carbon\Carbon;

class Closing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'farms:closing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if the date is due for farm to close.';

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
        $farms = Farm::where('status', 'opened')->latest()->get();
        foreach($farms as $farm){
            $date1 = Carbon::parse($farm->close_date)->subHour();
            $date2 = Carbon::now();
            if($date1->gt($date2)){
                $investments = $farm->investments()->where('status', 'pending')->orWhere('status', 'queued')->latest()->get();
                foreach($investments as $inv){
                    if($inv->status == 'queued'){
                        $transaction = $inv->transactions()->first();
                        $transaction->update(['details->status'=>'failed']);
                        $inv->status = 'declined';
                        $inv->save();
                    }else {
                        $inv->maturity_date = $this->addTo($farm->duration, $farm->duration_type);
                        $inv->status = 'active';
                        $inv->save();
                    }
                }
                $farm->status = 'closed';
                $farm->save();
            }
        }
    }

    private function addTo($add, $addType)
    {
        $date1 = Carbon::now();
        if($addType == 'Day'){
            $date1->addDays($add);
        }elseif($addType == 'Week'){
            $date1->addWeeks($add);
        }elseif($addType == 'Month'){
            $date1->addMonths($add);
        }elseif($addType == 'Year'){
            $date1->addYears($add);
        }
        return $date1;
    }
}
