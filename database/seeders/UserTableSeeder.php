<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Entities\User\User;

class UserTableSeeder extends Seeder
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
                'name'=>'Super Admin', 
                'email'=>'admin@cityfreshfarms.ng', 
                'email_verified_at'=>\Carbon\Carbon::now(), 
                'password'=>'cityfreshfarms123', 
                'phone'=>'07000000000', 
                'is_admin'=>true, 
            ],
        ];

        foreach ($data as $dat) {
            $user = User::create($dat);
            $user->assignRole('root');
        }
    }
}
