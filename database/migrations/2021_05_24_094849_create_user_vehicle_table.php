<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_vehicle', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('color', 255)->nullable();
            $table->string('number', 255)->nullable();
            $table->string('model', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->integer('type');


            /*indexes*/
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //$table->foreign('type')->references('id')->on('vehicle_types')->onDelete('cascade');
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
        Schema::dropIfExists('user_vehicle');
    }
}
