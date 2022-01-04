<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomunsToTripV3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trips', function (Blueprint $table) {
            //
            $table->integer('from_city_id')->nullable();
            $table->integer('from_governorates_id')->nullable();
            $table->integer('to_city_id')->nullable();
            $table->integer('to_governorates_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trips', function (Blueprint $table) {
            //
            $table->dropColumn('from_city_id');
            $table->dropColumn('from_governorates_id');
            $table->dropColumn('to_city_id');
            $table->dropColumn('to_governorates_id');
        });
    }
}
