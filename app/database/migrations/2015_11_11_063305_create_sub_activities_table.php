<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sub_activities', function(Blueprint $table) {
			$table->increments('id');
			$table->string('SubActivityName');
			$table->date('TerminationDate');
			$table->integer('MainActivityID');
			$table->integer('PerspectiveID');
			$table->integer('ObjectiveID');
			$table->integer('EmpID');
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
		Schema::drop('sub_activities');
	}

}
