<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransmissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transmissions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('message_id');
			$table->integer('receiver_id');
			$table->integer('sender_id');
			$table->boolean('received');
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
		Schema::drop('transmissions');
	}

}
