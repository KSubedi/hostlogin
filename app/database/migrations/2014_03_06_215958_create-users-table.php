<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table)
		{
			$table->increments('id');
			$table->string('remember_token', 100);			
			$table->string('firstname', 20);
    		$table->string('lastname', 20);
			$table->boolean('confirmed');
			$table->string('token')->unique();
			$table->string('email', 100)->unique();
			$table->string('password', 64);
			$table->string('encryptiontoken');
			$table->timestamps();
			$table->softDeletes();
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
