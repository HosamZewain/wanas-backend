<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_rates', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('rate_user_id');
            $table->integer('rate');
            $table->text('comment');
            $table->timestamp('updated_at')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('user_rates');
    }
}
