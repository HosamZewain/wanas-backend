<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        if (Schema::hasTable('users')) {
            User::firstOrCreate([
                'name' => 'Wanes Admin',
                'email' => 'admin@wanas.com',
                'password' => Hash::make('WanasP@ssw0rd'),
                'type' => User::TYPE_ADMIN
            ]);
        }
    }
}
