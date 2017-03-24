<?php

class Sub_activity extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'SubActivityName' => 'required'
	);
}
