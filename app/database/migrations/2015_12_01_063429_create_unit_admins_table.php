<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUnitAdminsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('unit_admins', function(Blueprint $table) {
			$table->increments('id');
			$table->string('LastName');
			$table->string('FirstName');
			$table->string('UserName');
			$table->string('Password');
			$table->string('AdminEmail');
			$table->integer('UnitOfficeID');
			$table->integer('UnitOfficeSecondaryID');
			$table->string('state');
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
		Schema::drop('unit_admins');
	}

}
