<?php

namespace Database\Seeders;

use App\Constants\RoleConstants as RoleCostant;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultRoles = ["admin"];
        foreach ($defaultRoles as $defaultRole){
            Role::findOrCreate($defaultRole, 'sanctum');
        }

    }
}
