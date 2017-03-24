<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUnitOfficeTertiariesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('unit_office_tertiaries', function(Blueprint $table) {
			$table->increments('id');
			$table->string('UnitOfficeTertiaryName');
			$table->string('UnitOfficeHasQuaternary');
			$table->integer('UnitOfficeSecondaryID');
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
		Schema::drop('unit_office_tertiaries');
	}

}
