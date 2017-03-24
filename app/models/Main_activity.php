<?php

class Main_activity extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'MainActivityName' => 'required'
	);
}
