<?php

class Unit_office extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'UnitOfficeName' => 'required',
		'UnitOfficeHasField' => 'required'
	);
}
