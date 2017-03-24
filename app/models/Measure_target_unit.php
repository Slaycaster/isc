<?php

class Measure_target_unit extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'MeasureTargetUnitName' => 'required',
		'MeasureTargetUnitSymbol' => 'required'
	);
}
