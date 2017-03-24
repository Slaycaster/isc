<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMeasureTargetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('measure_targets', function(Blueprint $table) {
			$table->increments('id');
			$table->string('MeasureTargetValue');
			$table->integer('MeasureTargetUnitID');
			$table->integer('MeasureID');
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
		Schema::drop('measure_targets');
	}

}
