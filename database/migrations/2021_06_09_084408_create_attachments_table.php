<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsTable extends Migration {

	public function up()
	{
		Schema::create('attachments', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
            $table->integer('attachmentable_id');
			$table->string('attachment_url', 255)->nullable();
            $table->string('attachmentable_type', 255)->nullable();
            $table->string('original_name', 255)->nullable();
            $table->string('file_type', 255)->nullable();
            $table->string('key', 255)->nullable();
		});
	}

	public function down()
	{
        Schema::dropIfExists('attachments');
	}
}
