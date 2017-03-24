<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmploysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employs', function(Blueprint $table) {
			$table->increments('id');
			$table->string('EmpID');
			$table->string('EmpFirstName');
			$table->string('EmpLastName');
			$table->string('EmpMidInit');
			$table->string('EmpQualifier');
			$table->string('EmpPicturePath');
			$table->integer('RankID');
			$table->integer('PositionID');
			$table->integer('SupervisorID');
			$table->integer('UnitOfficeID');
			$table->string('EmpPassword');
			$table->integer('UnitOfficeSecondaryID');
			$table->integer('UnitOfficeTertiaryID');
			$table->integer('UnitOfficeQuaternaryID');
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
		Schema::drop('employs');
	}

}
