<?php

class Employee extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'EmpID' => 'required',
		'EmpFirstName' => 'required',
		'EmpLastName' => 'required',
		'EmpMidInit' => 'required',
		'EmpPicturePath' => 'required',
		'EmpPassword' => 'required',
		'EmpCode' => 'required',
		'RankID' => 'required',
		'PositionID' => 'required',
		'SuperiorID' => 'required'
	);
}
