<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomunsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('mobile', 255)->unique()->nullable();
            $table->string('activation_code', 255)->nullable();
            $table->string('civil_image', 255)->nullable();
            $table->string('profile_image', 255)->nullable();
            $table->tinyInteger('gender')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->date('birth_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
