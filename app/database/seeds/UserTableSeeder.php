<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
            'email'         => 'kevin@develpr.com',
            'username'      => 'kevin',
            'group'         => 'admin',
            'password'      => Hash::make('password'),
            'first_name'     => 'Kevin',
            'last_name'      => 'Mitchell',
            'secret_key'     => 'sf9k03asgasfk02!@39fk9fsDF002FAsd995%#3d'
        ));
    }

}