<?php

namespace App\Console\Commands\Farm;

use Illuminate\Console\Command;
use App\Entities\Farm\Farm;
use Carbon\Carbon;

class Openings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'farms:openings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if the date is due for farm to open.';

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
        $farms = Farm::where('status', 'pending')->latest()->get();
        foreach($farms as $farm){
            $date1 = Carbon::parse($farm->start_date)->subHour();
            $date2 = Carbon::now();
            if($date2->gt($date1)){
                $farm->status = 'opened';
                $farm->save();
            }
        }
    }
}
