<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleTableSeeder;
use Database\Seeders\UserTableSeeder;
use Database\Seeders\SettingSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
        	RoleTableSeeder::class,
            UserTableSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
