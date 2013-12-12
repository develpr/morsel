<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipientSenderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recipient_sender', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('recipient_id');
			$table->integer('sender_id');
			$table->timestamps();
			$table->unique(array('recipient_id', 'sender_id'));

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('recipient_sender');
	}

}