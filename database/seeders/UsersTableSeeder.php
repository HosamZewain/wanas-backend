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
        $user = User::where('email' , 'admin@admin.com')->first();
        if (!$user){
            try {
                DB::transaction(static function() use ($role){
                    $user = User::firstOrCreate([ 'email' => 'admin@admin.com'],[
                        'name' => 'admin',
                        'email' => 'admin@admin.com',
                        'phone' => 12345678910,
                        'password' => 123456
                    ]);
                    $employee = [
                        "user_id" => $user->id,
                        "gender" => 1,
                        "is_active" => true,
                        "personal_email" => 'admin@admin.com',
                        "department_id" => 1,
                        "date_of_birth" => "2023-05-28",
                    ];
                    Employee::create($employee);
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
