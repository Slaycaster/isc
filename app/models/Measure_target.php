<?php

class Measure_target extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'MeasureTargetValue' => 'required',
	);
}
