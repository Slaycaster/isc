<?php

class UnitAdmin extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'LastName' => 'required',
		'FirstName' => 'required',
		'UserName' => 'required',
		'Password' => 'required',
		'AdminEmail' => 'required',
	);
}
