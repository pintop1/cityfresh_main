<?php

namespace App\Console\Commands\User;

use Illuminate\Console\Command;
use App\Entities\User\User;
use Carbon\Carbon;

class Delete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete unverified users after 3 days';

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
        $users = User::where('email_verified_at', null)->get();
        foreach($users as $user){
            $date1 = Carbon::parse($user->created_at)->addDays(3);
            $date2 = Carbon::now();
            if($date2->gt($date1)){
                $user->my_referral_code->delete();
                $user->wallet->delete();
                $user->banks()->delete();
                $user->cards()->delete();
                $user->transactions()->delete();
                $ref = $user->referral;
                if($ref){
                    $ref->referree()->detach();
                    $ref->delete();
                }
                $user->delete();
            }
        }
    }
}
