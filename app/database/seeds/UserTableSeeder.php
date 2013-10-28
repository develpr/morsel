<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
            'email'         => 'kevin@develpr.com',
			'user_id'		=> '2',
            'username'      => 'kevin',
            'group'         => 'admin',
            'password'      => Hash::make('password'),
            'first_name'     => 'Kevin',
            'last_name'      => 'Mitchell',
            'secret_key'     => Crypt::encrypt('5623-1325-3124-5341')
        ));

		User::create(array(
			'email'         => 'shoelessone@gmail.com',
			'user_id'		=> '1',
			'username'      => 'shoelessone',
			'group'         => 'admin',
			'password'      => Hash::make('password'),
			'first_name'     => 'Kevin',
			'last_name'      => 'Mitchell',
			'secret_key'     => Crypt::encrypt('5623-1325-3124-5341')
		));

		User::create(array(
			'email'         => 'nobody@gmail.com',
			'username'      => 'donttasemebro',
			'group'         => 'admin',
			'password'      => Hash::make('password'),
			'first_name'     => 'Kevin',
			'last_name'      => 'Mitchell',
			'secret_key'     => Crypt::encrypt('5623-1325-3124-5341')
		));

        User::create(array(
            'email'         => 'smithnick@gmail.com',
            'username'      => 'nick',
            'group'         => 'admin',
            'password'      => Hash::make('password'),
            'first_name'     => 'Nick',
            'last_name'      => 'Smith',
            'secret_key'     => Crypt::encrypt('5623-1325-3124-5341')
        ));
    }

}