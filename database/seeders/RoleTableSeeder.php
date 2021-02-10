<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
    	$data = [
    		['name' => 'view farms'],
    		['name' => 'create farms'],
    		['name' => 'edit farms'],
    		['name' => 'delete farms'],
    		['name' => 'view packages'],
    		['name' => 'create packages'],
    		['name' => 'edit packages'],
    		['name' => 'delete packages'],
    		['name' => 'view banks'],
    		['name' => 'view cards'],
    		['name' => 'view investments'],
    		['name' => 'edit investments'],
    		['name' => 'view mandates'],
    		['name' => 'delete mandates'],
    		['name' => 'view transactions'],
    		['name' => 'edit transactions'],
    		['name' => 'view referrals'],
    		['name' => 'view users'],
    		['name' => 'edit users'],
    		['name' => 'view wallets'],
            ['name' => 'view settings'],
    		['name' => 'edit settings'],
    		['name' => 'view admins'],
    		['name' => 'create admins'],
    		['name' => 'edit admins'],
    		['name' => 'delete admins'],
    		['name' => 'view roles'],
    		['name' => 'edit roles'],
    		['name' => 'create roles'],
    		['name' => 'delete roles'],
    	];
        $role = Role::create(['name'=>'root']);
        foreach ($data as $dat) {
        	$perm = Permission::create($dat);
        	$role->givePermissionTo($perm);
        }
    }
}
