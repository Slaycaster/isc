<?php

class Unit_office_tertiary extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'UnitOfficeTertiaryName' => 'required',
		'UnitOfficeHasQuaternary' => 'required',
		'UnitOfficeSecondaryID' => 'required'
	);
}
