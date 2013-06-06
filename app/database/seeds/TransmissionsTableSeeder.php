<?php

use Morsel\Transmission;

class TransmissionsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('transmissions')->delete();

		Transmission::create(array(
			'message_id'	=> 1,
			'sender_id'		=> 1,
			'receiver_id'	=> 2
		));

		Transmission::create(array(
			'message_id'	=> 2,
			'sender_id'		=> 2,
			'receiver_id'	=> 1
		));

	}

}