<?php

class Perspective extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'PerspectiveName' => 'required'
	);
}
