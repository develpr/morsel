<?php

class RecipientSenderTableSeeder extends Seeder {

    public function run()
    {
        DB::table('recipient_sender')->delete();

		DB::table('recipient_sender')->insert(
			array('recipient_id' => 1, 'sender_id' => 2)
		);

		DB::table('recipient_sender')->insert(
			array('recipient_id' => 3, 'sender_id' => 2)
		);

		DB::table('recipient_sender')->insert(
			array('recipient_id' => 4, 'sender_id' => 2)
		);

		DB::table('recipient_sender')->insert(
			array('recipient_id' => 5, 'sender_id' => 2)
		);

		DB::table('recipient_sender')->insert(
			array('recipient_id' => 6, 'sender_id' => 2)
		);

		DB::table('recipient_sender')->insert(
			array('recipient_id' => 7, 'sender_id' => 2)
		);

		DB::table('recipient_sender')->insert(
			array('recipient_id' => 8, 'sender_id' => 2)
		);

		DB::table('recipient_sender')->insert(
			array('recipient_id' => 2, 'sender_id' => 1)
		);

		DB::table('recipient_sender')->insert(
			array('recipient_id' => 2, 'sender_id' => 3)
		);

		DB::table('recipient_sender')->insert(
			array('recipient_id' => 2, 'sender_id' => 4)
		);

		DB::table('recipient_sender')->insert(
			array('recipient_id' => 2, 'sender_id' => 5)
		);

		DB::table('recipient_sender')->insert(
			array('recipient_id' => 2, 'sender_id' => 6)
		);

		DB::table('recipient_sender')->insert(
			array('recipient_id' => 2, 'sender_id' => 7)
		);

		DB::table('recipient_sender')->insert(
			array('recipient_id' => 2, 'sender_id' => 8)
		);

    }

}