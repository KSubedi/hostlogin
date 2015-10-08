<?php

use Illuminate\Database\Migrations\Migration;

class ServerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('servers', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('type');
    		$table->string('provider');
			$table->string('url');
			$table->string('panel');
			$table->string('panelurl');			
			$table->boolean('iswhmcs');
			$table->string('panellogin');
			$table->string('panelpassword');
			$table->string('billingurl');
			$table->string('billinglogin');
			$table->string('billingpassword');
			$table->string('location');
			$table->longText('ip');			
			$table->string('color');
			$table->string('options');
			$table->longText('notes');
			$table->longText('extras');
			$table->string('storage');
			$table->string('ram');
			$table->string('cost');
			$table->string('bandwidth');
			$table->integer('user_id');
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
		Schema::drop('servers');
	}

}