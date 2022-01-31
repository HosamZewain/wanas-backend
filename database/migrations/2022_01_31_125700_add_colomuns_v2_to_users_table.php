<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomunsV2ToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_fcm_tokens', function (Blueprint $table) {
            //
            $table->string('brand', 255)->nullable();
            $table->string('osName', 255)->nullable();
            $table->string('osVersion', 255)->nullable();
            $table->string('deviceName', 255)->nullable();
            $table->string('DeviceType', 255)->nullable();
            $table->string('DeviceId', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_fcm_tokens', function (Blueprint $table) {

            $table->dropColumn('brand');
            $table->dropColumn('osName');
            $table->dropColumn('osVersion');
            $table->dropColumn('deviceName');
            $table->dropColumn('DeviceType');
            $table->dropColumn('DeviceId');
        });
    }
}
