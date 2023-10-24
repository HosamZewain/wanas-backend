<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Throwable;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $permissions = Permission::where('guard_name', 'sanctum')->get();
        $role = Role::findOrCreate('admin', 'sanctum');
        $role->givePermissionTo($permissions);
        $user = User::where('email' , 'admin@wanas.com')->first();
        if (!$user){
            try {
                DB::transaction(static function() use ($role){
                    $user = User::firstOrCreate(['email' => 'admin@wanas.com'],[
                        'name' => 'admin',
                        'email' => 'admin@wanas.com',
                        'phone' => 12345678910,
                        'password' => 'WanasP@ssw0rd'
                    ]);
                    $user->assignRole($role);
                });
            }catch (Exception $e) {
                echo $e->getMessage();
            } catch (Throwable $e) {
                echo $e->getMessage();
            }
        } else {
            $user->assignRole($role);
        }
    }
}
