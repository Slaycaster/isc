<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint 
class CreateUnitOfficeQuaternariesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('unit_office_quaternaries', function(Blueprint $table) {
			$table->increments('id');
			$table->string('UnitOfficeQuaternaryName');
			$table->integer('UnitOfficeTertiaryID');
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
		Schema::drop('unit_office_quaternaries');
	}

}
