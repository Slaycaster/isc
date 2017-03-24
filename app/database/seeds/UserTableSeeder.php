<?php

	class UserTableSeeder extends Seeder
	{
		public function run()
		{
			DB::table('users')->delete();
			User::create(array(

				'name'     => 'Denimar Fernandez',
				'username' => 'admin',
				'password' => Hash::make('admin'),
				));
		}

	}