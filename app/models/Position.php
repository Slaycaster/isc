<?php

class Position extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
	
		'PositionName' => 'required',
	);
}
