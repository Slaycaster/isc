<?php



class Employ extends Eloquent {

	protected $guarded = array();



	public static $rules = array(

		'EmpID' => 'required',

		'EmpFirstName' => 'required',

		'EmpLastName' => 'required',

		'RankID' => 'required',

		'BadgeNo' => 'required',

		'PositionID' => 'required', 

		'email' => 'required'

	);

}

