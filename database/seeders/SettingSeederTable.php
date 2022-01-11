<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SettingSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if (Schema::hasTable('settings')) {
            Setting::firstOrCreate([
                'app_name' => 'WANAS',
                'email' => 'admin@wanas.com',
            ]);
        }
    }
}
