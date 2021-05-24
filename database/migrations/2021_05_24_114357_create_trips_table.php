<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('pickup_address', 255)->nullable();
            $table->string('drop_off_address', 255)->nullable();
            $table->date('trip_date')->nullable();
            $table->time('trip_time')->nullable();
            $table->integer('status')->nullable();
            $table->integer('members_count')->nullable();
            $table->double('trip_cost_per_person')->nullable();
            $table->double('total_trip_cost')->nullable();
            $table->double('rate')->nullable();


           // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('trips');
    }
}
