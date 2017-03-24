<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMeasureTargetUnitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('measure_target_units', function(Blueprint $table) {
			$table->increments('id');
			$table->string('MeasureTargetUnitName');
			$table->string('MeasureTargetUnitSymbol');
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
		Schema::drop('measure_target_units');
	}

}
