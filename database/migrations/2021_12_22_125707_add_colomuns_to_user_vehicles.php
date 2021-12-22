<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomunsToUserVehicles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_vehicle', function (Blueprint $table) {
            //
            $table->integer('status');
            $table->text('car_license_front')->nullable();
            $table->text('car_license_back')->nullable();
            $table->text('driver_license_front')->nullable();
            $table->text('driver_license_back')->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_vehicle', function (Blueprint $table) {
            //
            $table->dropColumn('status');
            $table->dropColumn('car_license_front');
            $table->dropColumn('car_license_back');
            $table->dropColumn('driver_license_front');
            $table->dropColumn('driver_license_back');
            $table->dropColumn('notes');
        });
    }
}
