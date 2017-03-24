<?php

class UnitAdminObjectiveController extends BaseController 

{
	public function __construct(Objective $objective)
	{
		$this->objective = $objective;
	}

	public function showindex()
	{

	if (Session::has('unitadminid') && Session::has('unitadminname')) {

		$id = Session::get('unitadminid', 'default');

		$name = Session::get('unitadminname', 'default');

		$obj_primaryunitoffice_id = Session::get('primaryunit','default');

		$obj_secondaryoffice_id = Session::get('secondaryunit','default');

		$unitoffice = DB::table('unit_admins')

			->where('id','=',$id)
			->get();
	
		$perspectives=DB::table('perspectives')->get();
	
		
			
		foreach($unitoffice as $unitadmin)
			{
				if($unitadmin->UnitOfficeSecondaryID != '0')
				{
					$objectives = DB::table('objectives')		
					->join('obj_secondaryunitoffice', 'objectives.id', '=', 'obj_secondaryunitoffice.ObjectiveID')
					->where('obj_secondaryunitoffice.SecondaryUnitOfficeID', '=', $obj_secondaryoffice_id)
					->select('objectives.id as id', 'objectives.PerspectiveID as PerspectiveID', 'objectives.ObjectiveName')
					->get();

					$perspectives_id=DB::table('perspectives')
						
						->lists('PerspectiveName','id');

				}

				if($unitadmin->UnitOfficeSecondaryID == '0')
				{
					$objectives = DB::table('objectives')
					->join('obj_primaryunitoffice', 'obj_primaryunitoffice.ObjectiveID', '=', 'objectives.id')
					->where('obj_primaryunitoffice.PrimaryUnitOfficeID', '=', $obj_primaryunitoffice_id)
					->select('objectives.id as id', 'objectives.PerspectiveID as PerspectiveID', 'objectives.ObjectiveName')
					->get();

					$perspectives_id=DB::table('perspectives')
						->lists('PerspectiveName','id');
				}

						

			}

		$OfficeName = '';
					$unit_offices = DB::table('unit_offices')->where('id', '=', $obj_primaryunitoffice_id)->first();
					$unit_office_secondaries = DB::table('unit_office_secondaries')->where('id', '=', $obj_secondaryoffice_id)->first();
				
						if($unit_office_secondaries != null)
						{
							$OfficeName = $unit_offices->UnitOfficeName.', '.$unit_office_secondaries->UnitOfficeSecondaryName;
						}
						elseif($unit_office_secondaries == null)
						{
							$OfficeName = $unit_offices->UnitOfficeName;
						}
						else
						{
							$OfficeName = "No Unit Office Assign";
						}

		return View::make('UnitAdminObjective')
		->with('OfficeName', $OfficeName)
		->with('objectives', $objectives)
		->with('perspectives', $perspectives)
		->with('perspectives_id',$perspectives_id)
		->with('id', $id)
		->with('name', $name)
		->with('obj_secondaryoffice_id', $obj_secondaryoffice_id)
		->with('obj_primaryoffice_id', $obj_primaryunitoffice_id)
		->with('unitoffice',$unitoffice);

			}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');

		}
		
	}

	public function showindexdatatable()
	{

		if (Session::has('unitadminid') && Session::has('unitadminname')) 
		{
			$id = Session::get('unitadminid', 'default');

			$obj_primaryunitoffice_id = Session::get('primaryunit','default');
			$obj_secondaryoffice_id = Session::get('secondaryunit','default');

			$unitoffice = DB::table('unit_admins')
							->where('id','=',$id)
							->get();
	
			$perspectives=DB::table('perspectives')->get();
				
			foreach($unitoffice as $unitadmin)
				{
					if($unitadmin->UnitOfficeSecondaryID != '0')
					{
						$objectives = DB::table('objectives')		
										->join('obj_secondaryunitoffice', 'objectives.id', '=', 'obj_secondaryunitoffice.ObjectiveID')
										->join('perspectives', 'objectives.PerspectiveID', '=', 'perspectives.id')
										->where('obj_secondaryunitoffice.SecondaryUnitOfficeID', '=', $obj_secondaryoffice_id)
										->select('objectives.id as id', 'objectives.ObjectiveName', 'perspectives.PerspectiveName as PerspectiveName')
										->orderBy('perspectives.id');
					}

					if($unitadmin->UnitOfficeSecondaryID == '0')
					{
						$objectives = DB::table('objectives')
						->join('obj_primaryunitoffice', 'obj_primaryunitoffice.ObjectiveID', '=', 'objectives.id')
						->join('perspectives', 'objectives.PerspectiveID', '=', 'perspectives.id')
						->where('obj_primaryunitoffice.PrimaryUnitOfficeID', '=', $obj_primaryunitoffice_id)
						->select('objectives.id as id', 'objectives.ObjectiveName', 'perspectives.PerspectiveName as PerspectiveName')
						->orderBy('perspectives.id');
					}	
				}

			return Datatables::of($objectives)
			->add_column('Actions', '
	        				<a class = \'btn btn-warning\' href="{{ URL::to(\'admins/show/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'admins/show/\' . $id) }}\', \'newwindow\', \'width=450, height=500\'); return false;">View</a>
                        	<a class = \'btn btn-info\'  href="{{ URL::to(\'admins/edit/\' . $id . \'/edit\') }}" onclick="window.open(\'{{ URL::to(\'admins/edit/\' . $id . \'/edit\') }}\', \'newwindow\', \'width=450, height=450\'); return false;">Edit</a>
                        ')
	        ->remove_column('id')
	        ->make(true);
		}

		else
		{
			Session::flash('message', 'Please login first!');
			return Redirect::to('login/unitadmin');
		}
		
	}

	public function showstore()
	{
		$input = Input::all();
		$validation = Validator::make($input, Objective::$rules);
		$id = Session::get('unitadminid', 'default');

		$name = Session::get('unitadminname', 'default');

		$obj_primaryunitoffice_id = Session::get('primaryunit','default');

		$obj_secondaryoffice_id = Session::get('secondaryunit','default');

		$unitadmin = DB::table('unit_admins')
			->where('id','=',$id)
			->get();
		if ($validation->passes())
		{
			$this->objective->create($input);
			foreach ($unitadmin as $unit) 
			{
				if($unit->UnitOfficeSecondaryID != 0)
				{
					$obj_id = DB::table('objectives')->max('id');
					DB::insert('insert into obj_secondaryunitoffice (SecondaryUnitOfficeID, ObjectiveID) values (?,?)', array($obj_secondaryoffice_id, $obj_id));
				}
				else
				{
					$obj_id = DB::table('objectives')->max('id');
					DB::insert('insert into obj_primaryunitoffice (PrimaryUnitOfficeID, ObjectiveID) values (?,?)', array($obj_primaryunitoffice_id, $obj_id));
				}
			}
			
		
			return Redirect::to('admins/objectives');
		}

		return Redirect::to('admins/objectives')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	public function show($id)
	{
		//$id = Session::get('unitadminid', 'default');
		$name = Session::get('unitadminname', 'default');
		$perspectives=DB::table('perspectives')->get();

		$objective = $this->objective->findOrFail($id);

		return View::make('UnitAdminShowObjective')
		->with('objective',$objective)
		->with('perspectives',$perspectives);
	}

	public function edit($id)
	{
		
		$name = Session::get('unitadminname', 'default'); 
		$objective = $this->objective->find($id);
		$perspectives_id=DB::table('perspectives')
		->lists('PerspectiveName','id');

		if (is_null($objective))
		{
			return Redirect::route('UnitAdminEditObjective');
		}

		return View::make('UnitAdminEditObjective')
		->with('perspectives_id',$perspectives_id)
		->with('objective',$objective);
		
	}

	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Objective::$rules);

		
			$objective = $this->objective->find($id);
			$objective->update($input);


		$name = Session::get('unitadminname', 'default');
		$perspectives=DB::table('perspectives')->get();

		$objective = $this->objective->findOrFail($id);

		return View::make('UnitAdminShowObjective')
		->with('objective',$objective)
		->with('perspectives',$perspectives);
	}

	}

?>