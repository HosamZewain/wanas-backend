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
        $defaultRoles = ["admin", "top management", "employee", "human resource", "customer"];
        foreach ($defaultRoles as $defaultRole){
            $role = Role::findOrCreate($defaultRole, 'sanctum');
            $permissions = Permission::whereIn('name', ['read-ticket', 'update-ticket'])->pluck('name')->toArray();
            if ($role->name === 'customer') {
                $role->syncPermissions(['read-project', 'read-sla', 'read-sla-log-hours', 'read-notification',
                    'delete-notification', 'create-notification', 'read-note', 'update-note', 'create-note',
                    'delete-note', 'create-ticket', 'read-ticket', 'update-ticket']);
            } else {
                $role->syncPermissions($permissions);
            }
        }

    }
}
