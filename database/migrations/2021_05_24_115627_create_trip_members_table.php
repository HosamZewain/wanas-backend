<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('trip_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('status');
           // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
           // $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_members');
    }
}
