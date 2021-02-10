<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
	            'name'=>'referral-commission', 
	            'value'=>'1', 
	            'model'=>'App\\Http\\Entities\\User\\Referral\\Referrals', 
	            'description'=>'This is the commission for the referrals on first investment.', 
            ],
            [
                'name'=>'payment-bank', 
                'value'=>'Zenith Bank|2261526461|JOHN JOE', 
                'model'=>'', 
                'description'=>'This is the bank all bank transfer transactions will occur in.', 
            ],
        ];

        foreach ($data as $dat) {
            \App\Entities\Setting::create($dat);
        }
    }
}
