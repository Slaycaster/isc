<?php

class Unit_office_secondary extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'UnitOfficeSecondaryName' => 'required',
		'UnitOfficeHasTertiary' => 'required',
		'UnitOfficeID' => 'required'
	);
}
