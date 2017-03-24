<?php

class Rank extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'RankName' => 'required',
		'RankCode' => 'required'
	);
}
