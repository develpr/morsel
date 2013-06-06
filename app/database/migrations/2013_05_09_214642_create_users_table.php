<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
            $table->increments('id');
			$table->integer('user_id');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('group', 20);
            $table->string('password', 60);
            $table->string('first_name', 30);
            $table->string('last_name', 30);
            $table->string('secret_key', 100); //For API authentication
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
		Schema::drop('users');
	}

}
