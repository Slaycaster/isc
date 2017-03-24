<?php

class Unit_office_quaternary extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'UnitOfficeQuaternaryName' => 'required',
		'UnitOfficeTertiaryID' => 'required'
	);
}
