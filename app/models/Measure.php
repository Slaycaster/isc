<?php

class Measure extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'MeasureName' => 'required'
	);
}
