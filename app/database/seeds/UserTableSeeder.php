<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
            'email'         => 'kevin@develpr.com',
            'username'      => 'kev',
            'group'         => 'admin',
            'password'      => Hash::make('password'),
            'first_name'     => 'Kevin',
            'last_name'      => 'Mitchell',
            'secret_key'     => Crypt::encrypt('5623-1325-3124-5341')
        ));

		User::create(array(
			'email'         => 'family@develpr.com',
			'username'      => 'mitchells',
			'group'         => 'admin',
			'password'      => Hash::make('password'),
			'first_name'     => 'Mitchell',
			'last_name'      => 'Morsel',
			'secret_key'     => Crypt::encrypt('5623-1325-3124-5341')
		));

		User::create(array(
			'email'         => 'antheamm@umich.edu',
			'username'      => 'anthea',
			'group'         => 'admin',
			'password'      => Hash::make('password'),
			'first_name'     => 'Anthea',
			'last_name'      => 'Mitchell',
			'secret_key'     => Crypt::encrypt('5623-1325-3124-5341')
		));

		User::create(array(
			'email'         => 'brittamm@uci.edu',
			'username'      => 'brittany',
			'group'         => 'admin',
			'password'      => Hash::make('password'),
			'first_name'     => 'Brittany',
			'last_name'      => 'Mitchell',
			'secret_key'     => Crypt::encrypt('5623-1325-3124-5341')
		));

		User::create(array(
			'email'         => 'kevwamitch@gmail.com',
			'username'      => 'kevin',
			'group'         => 'admin',
			'password'      => Hash::make('password'),
			'first_name'     => 'Kevin',
			'last_name'      => 'Mitchell',
			'secret_key'     => Crypt::encrypt('5623-1325-3124-5341')
		));

		User::create(array(
			'email'         => 'marmitchell@gmail.com',
			'username'      => 'mar',
			'group'         => 'admin',
			'password'      => Hash::make('password'),
			'first_name'     => 'Mar',
			'last_name'      => 'Mitchell',
			'secret_key'     => Crypt::encrypt('5623-1325-3124-5341')
		));


		User::create(array(
			'email'         => 'izzybeem@gmail.com',
			'username'      => 'izzy',
			'group'         => 'admin',
			'password'      => Hash::make('password'),
			'first_name'     => 'Izzy',
			'last_name'      => 'Mitchell',
			'secret_key'     => Crypt::encrypt('5623-1325-3124-5341')
		));


		User::create(array(
			'email'         => 'tristan@develpr.com',
			'username'      => 'tristan',
			'group'         => 'admin',
			'password'      => Hash::make('password'),
			'first_name'     => 'Tristan',
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