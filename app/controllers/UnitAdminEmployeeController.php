<?php

class UnitAdminEmployeeController extends BaseController 

{
	public function __construct(Employ $employee)
	{
		$this->employee = $employee;
	}

public function showindex()
	{

	if (Session::has('unitadminid') && Session::has('unitadminname')) {

		$id = Session::get('unitadminid', 'default');

		$name = Session::get('unitadminname', 'default');

		$unitoffice_id = Session::get('primaryunit','default');

		$secondaryoffice_id = Session::get('secondaryunit','default');

		$unitoffice = DB::table('unit_admins')
			->where('id','=',$id)
			->get();

		$employs = DB::table('employs')
		->where('employs.isActive', '!=', '0')
		->get();
			
		foreach($unitoffice as $unitadmin)
			{
				if($unitadmin->UnitOfficeSecondaryID != '0')
				{
					$employees = DB::table('employs')
					->where('UnitOfficeID','=',$unitoffice_id)
					->where('UnitOfficeSecondaryID','=',$secondaryoffice_id)
					->where('employs.isActive', '!=', '0')
					->get();
				}

				if($unitadmin->UnitOfficeSecondaryID == '0')
				{
					$employees = DB::table('employs')
					->where('UnitOfficeID','=',$unitoffice_id)
					->where('employs.isActive', '!=', '0')
					->get();
				}
				


			}
		$employee_max = DB::table('employs')->max('id');
		$employee_max = $employee_max + 1;
		$emp_id = 'EMP'.str_pad($employee_max, 5, '0', STR_PAD_LEFT); 
		$ranks = DB::table('ranks')->get();
		$ranks_id= DB::table('ranks')->orderBy('Hierarchy','desc')
		->lists('RankCode','id');

		$positions= DB::table('positions')->get();
		$positions_id= DB::table('positions')->orderBy('PositionName','asc')
		->lists('PositionName','id');

		$id_dropdown2='0';
		$id_dropdown3='0';
		$id_dropdown4='0';
		
		$supervisors = Employ::select(DB::raw('concat(RankCode," ",EmpLastName, ", ", EmpFirstName) as full_name'), 'employs.id' )
		->join('ranks', 'ranks.id', '=', 'employs.RankID')
		->where('UnitOfficeID', '=', $unitoffice_id)->where('UnitOfficeSecondaryID', '=', $id_dropdown2)->where('UnitOfficeTertiaryID', '=', $id_dropdown3)
		->where('UnitOfficeQuaternaryID', '=', $id_dropdown4)
		->orderBy('EmpLastName', 'asc')->lists('full_name', 'id');
		
		
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		foreach($unitoffice as $unitadmin)
			{
				if($unitadmin->UnitOfficeSecondaryID != '0')
				{
					$unit_offices_secondaries_id = 	$secondaryoffice_id;
				}

				if($unitadmin->UnitOfficeSecondaryID == '0')
				{
							$unit_offices_secondaries_id= ['Select Secondary...'] + DB::table('unit_office_secondaries')
							->where('UnitOfficeID', '=', $unitoffice_id)
							->orderBy('UnitOfficeSecondaryName','asc')
							->lists('UnitOfficeSecondaryName','id');
				}
				


			}

		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')->get();
			foreach($unitoffice as $unitadmin)
			{
				if($unitadmin->UnitOfficeSecondaryID != '0')
				{
					$unit_offices_tertiaries_id= ['Select Tertiary...'] + DB::table('unit_office_tertiaries')
					->where('UnitOfficeSecondaryID', '=', $secondaryoffice_id)
					->orderBy('UnitOfficeTertiaryName','asc')
					->lists('UnitOfficeTertiaryName','id');
				}

				if($unitadmin->UnitOfficeSecondaryID == '0')
				{
							$unit_offices_tertiaries_id= ['none...'];
				}
				


			}
		
		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= ['none...'];

		$OfficeName = '';
					$unit_offices = DB::table('unit_offices')->where('id', '=', $unitoffice_id)->first();
					$unit_office_secondaries = DB::table('unit_office_secondaries')->where('id', '=', $secondaryoffice_id)->first();
				
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
		return View::make('admin_index')
		->with('OfficeName', $OfficeName)
		->with('id', $id)
		->with('name', $name)
		->with('unitoffice',$unitoffice)
		->with('emp_id', $emp_id)
		->with('employees',$employees)
		->with('employs',$employs)
		->with('id_dropdown2',$id_dropdown2)
		->with('id_dropdown3',$id_dropdown3)
		->with('id_dropdown4',$id_dropdown4)
		->with('ranks',$ranks)
		->with('ranks_id',$ranks_id)
		->with('positions',$positions)
		->with('positions_id',$positions_id)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id)
		->with('unit_offices_tertiaries',$unit_offices_tertiaries)
		->with('unit_offices_tertiaries_id',$unit_offices_tertiaries_id)
		->with('unit_offices_quaternaries',$unit_offices_quaternaries)
		->with('unit_offices_quaternaries_id',$unit_offices_quaternaries_id)
		->with('supervisors',$supervisors);

			}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');

		}
		



		}

		public function UAEsetEmployeeMainActivity($id)
		{

			if (Session::has('unitadminid') && Session::has('unitadminname')) {

				$name = Session::get('unitadminname', 'default');
				$main_activities = DB::table('employs')
				->join('main_activities','employs.id','=','main_activities.EmpID')
				->where('employs.id','=',$id)
				->where('main_activities.EmpID','=',$id)
				->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
			    			AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID")
				->get();
				$Employees = DB::table('employs')
				        ->join('positions', 'positions.id', '=', 'employs.PositionID')
				        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
				        ->where('employs.id', '=', $id)
				        ->first();

				$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;
				return View::make('UAEsetmainactivities')
				    ->with('PersonnelName', $PersonnelName)
					->with('main_activities',$main_activities)
					->with('id',$id)
					->with('name',$name);

			}

			else

			{

				Session::flash('message', 'Please login first!');

					return Redirect::to('login/unitadmin');

			}

		}

		public function postUAEeditMain()
		{
			$id = Input::get('empid');
			$main = Input::get('main_activity');
            $main_id = Input::get('mainactivity');
            $state_ids = Input::get('state_id');
            $state = Input::get('state');
            date_default_timezone_set('Asia/Singapore');
            $datenow = date('Y-m-d 00:00:00.000000');
            $today = new DateTime("now");
            $dt_min = new DateTime("monday");
           
          
            if ($dt_min > $today)
            {
                $dt_min = new DateTime("last monday");
            }
           
            
            $dt_max = clone($dt_min);

            $dt_max->modify('-6 days');
             $i = 0;   
            if ($main != null)
            {
                foreach($main as $mains)
                {

                        DB::statement('UPDATE main_activities SET MainActivityName=:sur WHERE EmpID=:res AND id=:res2' ,
                             array('sur' => $mains, 'res' => $id, 'res2' =>$main_id[$i]) );
                        $i++;
                }
            }
             if ($state_ids != null)
            {
            $x = 0;
            foreach($state_ids as $state_id)
            {
                if ($state[$x] == 'Disable'){
                DB::statement('UPDATE main_activities SET TDate=:sur WHERE EmpID=:res AND id=:res2' ,
                         array('sur' => $dt_max, 'res' => $id, 'res2' =>$state_id) );
                }
               if ($state[$x] == 'Enable'){
                      DB::statement('UPDATE main_activities SET TDate=:sur WHERE EmpID=:res AND id=:res2' ,
                         array('sur' => NULL, 'res' => $id, 'res2' =>$state_id) );
                }    
                 $x++;
                }

            }



           
           Session::flash('message', 'Changes Saved!');
            return Redirect::to('UAEactivities');
		}

		public function unit($id)
	{

	if (Session::has('unitadminid') && Session::has('unitadminname')) {

		$emp_id = $id;

		$id = Session::get('unitadminid', 'default');

		$name = Session::get('unitadminname', 'default');

		$unitoffice_id = Session::get('primaryunit','default');

		$secondaryoffice_id = Session::get('secondaryunit','default');

		$unitoffice = DB::table('unit_admins')
			->where('id','=',$id)
			->get();

		
			
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		foreach($unitoffice as $unitadmin)
			{
				if($unitadmin->UnitOfficeSecondaryID != '0')
				{
					$unit_offices_secondaries_id = 	$secondaryoffice_id;
				}

				if($unitadmin->UnitOfficeSecondaryID == '0')
				{
							$unit_offices_secondaries_id= ['Select Secondary...'] + DB::table('unit_office_secondaries')
							->where('UnitOfficeID', '=', $unitoffice_id)
							->orderBy('UnitOfficeSecondaryName','asc')
							->lists('UnitOfficeSecondaryName','id');
				}
				


			}

		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')->get();
			foreach($unitoffice as $unitadmin)
			{
				if($unitadmin->UnitOfficeSecondaryID != '0')
				{
					$unit_offices_tertiaries_id= ['Select Tertiary...'] + DB::table('unit_office_tertiaries')
					->where('UnitOfficeSecondaryID', '=', $secondaryoffice_id)
					->orderBy('UnitOfficeTertiaryName','asc')
					->lists('UnitOfficeTertiaryName','id');
				}

				if($unitadmin->UnitOfficeSecondaryID == '0')
				{
							$unit_offices_tertiaries_id= ['none...'];
				}
				


			}
		
		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= ['none...'];
		$id_dropdown2='0';
		$id_dropdown3='0';
		$id_dropdown4='0';

		return View::make('admin_unit')
		->with('id', $id)
		->with('name', $name)
		->with('unitoffice',$unitoffice)
		->with('emp_id', $emp_id)
		->with('id_dropdown2',$id_dropdown2)
		->with('id_dropdown3',$id_dropdown3)
		->with('id_dropdown4',$id_dropdown4)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id)
		->with('unit_offices_tertiaries',$unit_offices_tertiaries)
		->with('unit_offices_tertiaries_id',$unit_offices_tertiaries_id)
		->with('unit_offices_quaternaries',$unit_offices_quaternaries)
		->with('unit_offices_quaternaries_id',$unit_offices_quaternaries_id);

			}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');

		}
		



		}


		public function postindex()
	{

	if (Session::has('unitadminid') && Session::has('unitadminname')) {

		$id = Session::get('unitadminid', 'default');

		$name = Session::get('unitadminname', 'default');

		$unitoffice_id = Session::get('primaryunit','default');

		$secondaryoffice_id = Session::get('secondaryunit','default');

		$unitoffice = DB::table('unit_admins')
			->where('id','=',$id)
			->get();
		$id_dropdown2 = Input::get('UnitOfficeSecondaryID');	

		$employs = DB::table('employs')->get();

		foreach($unitoffice as $unitadmin)
			{
				if($unitadmin->UnitOfficeSecondaryID != '0')
				{
					$employees = DB::table('employs')
					->where('UnitOfficeID','=',$unitoffice_id)
					->where('UnitOfficeSecondaryID','=',$secondaryoffice_id)
					->where('employs.isActive', '!=', '0')
					->get();
				}

				if($unitadmin->UnitOfficeSecondaryID == '0')
				{
					$employees = DB::table('employs')
					->where('UnitOfficeID','=',$unitoffice_id)
					->where('employs.isActive', '!=', '0')
					->get();
				}
				


			}
		$employee_max = DB::table('employs')->max('id');
		$employee_max = $employee_max + 1;
		$emp_id = 'EMP'.str_pad($employee_max, 5, '0', STR_PAD_LEFT); 
		$ranks = DB::table('ranks')->get();
		$ranks_id= ['Select Rank...'] + DB::table('ranks')->orderBy('RankCode','asc')
		->lists('RankCode','id');

		$positions= DB::table('positions')->get();
		$positions_id= ['Select Position...'] + DB::table('positions')->orderBy('PositionName','asc')
		->lists('PositionName','id');

		$id_dropdown3='0';
		$id_dropdown4='0';
		
		$supervisors =  Employ::select(DB::raw('concat(RankCode," ",EmpLastName, ", ", EmpFirstName) as full_name'), 'employs.id' )
		->join('ranks', 'ranks.id', '=', 'employs.RankID')
		->where('UnitOfficeID', '=', $unitoffice_id)
		->orderBy('EmpLastName', 'asc')->lists('full_name', 'id');
		
		
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id = DB::table('unit_office_secondaries')->where('id', '=', $id_dropdown2)->orderBy('UnitOfficeSecondaryName','asc')
			->lists('UnitOfficeSecondaryName','id');
		
		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')->get();
		
		$unit_offices_tertiaries_id= ['Select Tertiary...'] + DB::table('unit_office_tertiaries')
					->where('UnitOfficeSecondaryID', '=', $id_dropdown2)
					->orderBy('UnitOfficeTertiaryName','asc')
					->lists('UnitOfficeTertiaryName','id');
			
		
		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= ['none...'];

		$OfficeName = '';
					$unit_offices = DB::table('unit_offices')->where('id', '=', $unitoffice_id)->first();
					$unit_office_secondaries = DB::table('unit_office_secondaries')->where('id', '=', $secondaryoffice_id)->first();
				
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
	
	

		return View::make('admin_index')
		->with('id', $id)
		->with('name', $name)
		->with('unitoffice',$unitoffice)
		->with('emp_id', $emp_id)
		->with('employees',$employees)
		->with('employs',$employs)
		->with('id_dropdown2',$id_dropdown2)
		->with('id_dropdown3',$id_dropdown3)
		->with('id_dropdown4',$id_dropdown4)
		->with('OfficeName',$OfficeName)
		->with('ranks',$ranks)
		->with('ranks_id',$ranks_id)
		->with('positions',$positions)
		->with('positions_id',$positions_id)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id)
		->with('unit_offices_tertiaries',$unit_offices_tertiaries)
		->with('unit_offices_tertiaries_id',$unit_offices_tertiaries_id)
		->with('unit_offices_quaternaries',$unit_offices_quaternaries)
		->with('unit_offices_quaternaries_id',$unit_offices_quaternaries_id)
		->with('supervisors',$supervisors);

			}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');

		}
		


	}

			public function postunit()
	{

	if (Session::has('unitadminid') && Session::has('unitadminname')) {


		$id = Session::get('unitadminid', 'default');

		$name = Session::get('unitadminname', 'default');

		$unitoffice_id = Session::get('primaryunit','default');

		$secondaryoffice_id = Session::get('secondaryunit','default');

		$unitoffice = DB::table('unit_admins')
			->where('id','=',$id)
			->get();

		
		$id_dropdown2 = Input::get('UnitOfficeSecondaryID');	
		$emp_id = Input::get('emp_id'); 
				
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id = DB::table('unit_office_secondaries')->where('id', '=', $id_dropdown2)->orderBy('UnitOfficeSecondaryName','asc')
			->lists('UnitOfficeSecondaryName','id');
		
		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')->get();
		
		$unit_offices_tertiaries_id= ['Select Tertiary...'] + DB::table('unit_office_tertiaries')
					->where('UnitOfficeSecondaryID', '=', $id_dropdown2)
					->orderBy('UnitOfficeTertiaryName','asc')
					->lists('UnitOfficeTertiaryName','id');
			
		
		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= ['none...'];
	
		$id_dropdown3='0';
		$id_dropdown4='0';

		return View::make('admin_unit')
		->with('id', $id)
		->with('name', $name)
		->with('unitoffice',$unitoffice)
		->with('emp_id', $emp_id)
		->with('id_dropdown2',$id_dropdown2)
		->with('id_dropdown3',$id_dropdown3)
		->with('id_dropdown4',$id_dropdown4)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id)
		->with('unit_offices_tertiaries',$unit_offices_tertiaries)
		->with('unit_offices_tertiaries_id',$unit_offices_tertiaries_id)
		->with('unit_offices_quaternaries',$unit_offices_quaternaries)
		->with('unit_offices_quaternaries_id',$unit_offices_quaternaries_id);

			}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');

		}
		



		}


		public function postindex2()
	{

	if (Session::has('unitadminid') && Session::has('unitadminname')) {

		$id = Session::get('unitadminid', 'default');

		$name = Session::get('unitadminname', 'default');

		$unitoffice_id = Session::get('primaryunit','default');

		$secondaryoffice_id = Session::get('secondaryunit','default');

		$employs = DB::table('employs')->get();
		$unitoffice = DB::table('unit_admins')
			->where('id','=',$id)
			->get();
		$id_dropdown2 = Input::get('UnitOfficeSecondaryID');	
		$id_dropdown3 = Input::get('UnitOfficeTertiaryID');	

		foreach($unitoffice as $unitadmin)
			{
				if($unitadmin->UnitOfficeSecondaryID != '0')
				{
					$employees = DB::table('employs')
					->where('UnitOfficeID','=',$unitoffice_id)
					->where('UnitOfficeSecondaryID','=',$secondaryoffice_id)
					->get();
				}

				if($unitadmin->UnitOfficeSecondaryID == '0')
				{
					$employees = DB::table('employs')
					->where('UnitOfficeID','=',$unitoffice_id)
					->get();
				}
				


			}
		$employee_max = DB::table('employs')->max('id');
		$employee_max = $employee_max + 1;
		$emp_id = 'EMP'.str_pad($employee_max, 5, '0', STR_PAD_LEFT); 
		$ranks = DB::table('ranks')->get();
		$ranks_id= ['Select Rank...'] + DB::table('ranks')->orderBy('RankCode','asc')
		->lists('RankCode','id');

		$positions= DB::table('positions')->get();
		$positions_id= ['Select Position...'] + DB::table('positions')->orderBy('PositionName','asc')
		->lists('PositionName','id');

		$id_dropdown4 = '0'; 
		
		$supervisors = Employ::select(DB::raw('concat(RankCode," ",EmpLastName, ", ", EmpFirstName) as full_name'), 'employs.id' )
		->join('ranks', 'ranks.id', '=', 'employs.RankID')
		->where('UnitOfficeID', '=', $unitoffice_id)
		->orderBy('EmpLastName', 'asc')->lists('full_name', 'id');
		
		
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id = DB::table('unit_office_secondaries')->where('id', '=', $id_dropdown2)->orderBy('UnitOfficeSecondaryName','asc')
			->lists('UnitOfficeSecondaryName','id');
		
		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')->get();
			$unit_offices_tertiaries_id= DB::table('unit_office_tertiaries')->where('id', '=', $id_dropdown3)->orderBy('UnitOfficeTertiaryName','asc')
		->lists('UnitOfficeTertiaryName','id');

		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= ['Select Quaternary...'] + DB::table('unit_office_quaternaries')->where('UnitOfficeTertiaryID', '=', $id_dropdown3)
		->orderBy('UnitOfficeQuaternaryName','asc')
		->lists('UnitOfficeQuaternaryName','id');

		$OfficeName = '';
					$unit_offices = DB::table('unit_offices')->where('id', '=', $unitoffice_id)->first();
					$unit_office_secondaries = DB::table('unit_office_secondaries')->where('id', '=', $secondaryoffice_id)->first();
				
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
		

		return View::make('admin_index')
		->with('id', $id)
		->with('name', $name)
		->with('unitoffice',$unitoffice)
		->with('emp_id', $emp_id)
		->with('employees',$employees)
		->with('employs',$employs)
		->with('id_dropdown2',$id_dropdown2)
		->with('id_dropdown3',$id_dropdown3)
		->with('id_dropdown4',$id_dropdown4)
		->with('ranks',$ranks)
		->with('ranks_id',$ranks_id)
		->with('OfficeName',$OfficeName)
		->with('positions',$positions)
		->with('positions_id',$positions_id)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id)
		->with('unit_offices_tertiaries',$unit_offices_tertiaries)
		->with('unit_offices_tertiaries_id',$unit_offices_tertiaries_id)
		->with('unit_offices_quaternaries',$unit_offices_quaternaries)
		->with('unit_offices_quaternaries_id',$unit_offices_quaternaries_id)
		->with('supervisors',$supervisors);

			}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');

		}
		


	}

		public function postunit2()
	{

	if (Session::has('unitadminid') && Session::has('unitadminname')) {


		$id = Session::get('unitadminid', 'default');

		$name = Session::get('unitadminname', 'default');

		$unitoffice_id = Session::get('primaryunit','default');

		$secondaryoffice_id = Session::get('secondaryunit','default');

		$unitoffice = DB::table('unit_admins')
			->where('id','=',$id)
			->get();

		
		$id_dropdown2 = Input::get('UnitOfficeSecondaryID');	
		$id_dropdown3 = Input::get('UnitOfficeTertiaryID');	

	
		$emp_id = Input::get('emp_id');
		
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id = DB::table('unit_office_secondaries')->where('id', '=', $id_dropdown2)->orderBy('UnitOfficeSecondaryName','asc')
			->lists('UnitOfficeSecondaryName','id');
		
		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')->get();
			$unit_offices_tertiaries_id= DB::table('unit_office_tertiaries')->where('id', '=', $id_dropdown3)->orderBy('UnitOfficeTertiaryName','asc')
		->lists('UnitOfficeTertiaryName','id');

		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= ['Select Quaternary...'] + DB::table('unit_office_quaternaries')->where('UnitOfficeTertiaryID', '=', $id_dropdown3)
		->orderBy('UnitOfficeQuaternaryName','asc')
		->lists('UnitOfficeQuaternaryName','id');
		$id_dropdown4 = '0'; 

		return View::make('admin_unit')
		->with('id', $id)
		->with('name', $name)
		->with('unitoffice',$unitoffice)
		->with('emp_id', $emp_id)
		->with('id_dropdown2',$id_dropdown2)
		->with('id_dropdown3',$id_dropdown3)
		->with('id_dropdown4',$id_dropdown4)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id)
		->with('unit_offices_tertiaries',$unit_offices_tertiaries)
		->with('unit_offices_tertiaries_id',$unit_offices_tertiaries_id)
		->with('unit_offices_quaternaries',$unit_offices_quaternaries)
		->with('unit_offices_quaternaries_id',$unit_offices_quaternaries_id);

			}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');

		}
		



		}


		public function postindex3()
	{

	if (Session::has('unitadminid') && Session::has('unitadminname')) {

		$id = Session::get('unitadminid', 'default');

		$name = Session::get('unitadminname', 'default');

		$unitoffice_id = Session::get('primaryunit','default');

		$secondaryoffice_id = Session::get('secondaryunit','default');
		$employs =  DB::table('employs')->get();
		$unitoffice = DB::table('unit_admins')
			->where('id','=',$id)
			->get();
		$id_dropdown2 = Input::get('UnitOfficeSecondaryID');	
		$id_dropdown3 = Input::get('UnitOfficeTertiaryID');	
		$id_dropdown4 = Input::get('UnitOfficeQuaternaryID');	

		foreach($unitoffice as $unitadmin)
			{
				if($unitadmin->UnitOfficeSecondaryID != '0')
				{
					$employees = DB::table('employs')
					->where('UnitOfficeID','=',$unitoffice_id)
					->where('UnitOfficeSecondaryID','=',$secondaryoffice_id)
					->get();
				}

				if($unitadmin->UnitOfficeSecondaryID == '0')
				{
					$employees = DB::table('employs')
					->where('UnitOfficeID','=',$unitoffice_id)
					->get();
				}
				


			}
		$employee_max = DB::table('employs')->max('id');
		$employee_max = $employee_max + 1;
		$emp_id = 'EMP'.str_pad($employee_max, 5, '0', STR_PAD_LEFT); 
		$ranks = DB::table('ranks')->get();
		$ranks_id= ['Select Rank...'] + DB::table('ranks')->orderBy('RankCode','asc')
		->lists('RankCode','id');

		$positions= DB::table('positions')->get();
		$positions_id= ['Select Position...'] + DB::table('positions')->orderBy('PositionName','asc')
		->lists('PositionName','id');
		
		$supervisors =Employ::select(DB::raw('concat(RankCode," ",EmpLastName, ", ", EmpFirstName) as full_name'), 'employs.id' )
		->join('ranks', 'ranks.id', '=', 'employs.RankID')
		->where('UnitOfficeID', '=', $unitoffice_id)
		->orderBy('EmpLastName', 'asc')->lists('full_name', 'id');
		
		
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id = DB::table('unit_office_secondaries')->where('id', '=', $id_dropdown2)->orderBy('UnitOfficeSecondaryName','asc')
			->lists('UnitOfficeSecondaryName','id');
		
		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')->get();
			$unit_offices_tertiaries_id= DB::table('unit_office_tertiaries')->where('id', '=', $id_dropdown3)->orderBy('UnitOfficeTertiaryName','asc')
		->lists('UnitOfficeTertiaryName','id');

		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= DB::table('unit_office_quaternaries')->where('id', '=', $id_dropdown4)->orderBy('UnitOfficeQuaternaryName','asc')
		->lists('UnitOfficeQuaternaryName','id');

		$OfficeName = '';
					$unit_offices = DB::table('unit_offices')->where('id', '=', $unitoffice_id)->first();
					$unit_office_secondaries = DB::table('unit_office_secondaries')->where('id', '=', $secondaryoffice_id)->first();
				
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
		
		return View::make('admin_index')
		->with('id', $id)
		->with('name', $name)
		->with('unitoffice',$unitoffice)
		->with('emp_id', $emp_id)
		->with('employees',$employees)
		->with('employs',$employs)
		->with('id_dropdown2',$id_dropdown2)
		->with('id_dropdown3',$id_dropdown3)
		->with('id_dropdown4',$id_dropdown4)
		->with('ranks',$ranks)
		->with('ranks_id',$ranks_id)
		->with('positions',$positions)
		->with('positions_id',$positions_id)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id)
		->with('unit_offices_tertiaries',$unit_offices_tertiaries)
		->with('unit_offices_tertiaries_id',$unit_offices_tertiaries_id)
		->with('unit_offices_quaternaries',$unit_offices_quaternaries)
		->with('unit_offices_quaternaries_id',$unit_offices_quaternaries_id)
		->with('supervisors',$supervisors)
		->with('OfficeName',$OfficeName);

			}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');

		}
		


	}

	public function postunit3()
	{

	if (Session::has('unitadminid') && Session::has('unitadminname')) {


		$id = Session::get('unitadminid', 'default');

		$name = Session::get('unitadminname', 'default');

		$unitoffice_id = Session::get('primaryunit','default');

		$secondaryoffice_id = Session::get('secondaryunit','default');

		$unitoffice = DB::table('unit_admins')
			->where('id','=',$id)
			->get();

		
		$id_dropdown2 = Input::get('UnitOfficeSecondaryID');	
		$id_dropdown3 = Input::get('UnitOfficeTertiaryID');	
		$id_dropdown4 = Input::get('UnitOfficeQuaternaryID');	

		$emp_id = Input::get('emp_id');
		
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id = DB::table('unit_office_secondaries')->where('id', '=', $id_dropdown2)->orderBy('UnitOfficeSecondaryName','asc')
			->lists('UnitOfficeSecondaryName','id');
		
		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')->get();
			$unit_offices_tertiaries_id= DB::table('unit_office_tertiaries')->where('id', '=', $id_dropdown3)->orderBy('UnitOfficeTertiaryName','asc')
		->lists('UnitOfficeTertiaryName','id');

		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= DB::table('unit_office_quaternaries')->where('id', '=', $id_dropdown4)->orderBy('UnitOfficeQuaternaryName','asc')
		->lists('UnitOfficeQuaternaryName','id');

		return View::make('admin_unit')
		->with('id', $id)
		->with('name', $name)
		->with('unitoffice',$unitoffice)
		->with('emp_id', $emp_id)
		->with('id_dropdown2',$id_dropdown2)
		->with('id_dropdown3',$id_dropdown3)
		->with('id_dropdown4',$id_dropdown4)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id)
		->with('unit_offices_tertiaries',$unit_offices_tertiaries)
		->with('unit_offices_tertiaries_id',$unit_offices_tertiaries_id)
		->with('unit_offices_quaternaries',$unit_offices_quaternaries)
		->with('unit_offices_quaternaries_id',$unit_offices_quaternaries_id);

			}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');

		}
		



		}


	public function saveunit()
	{
		$id = Session::get('unitadminid', 'default');

		$name = Session::get('unitadminname', 'default');

		$unitoffice_id = Session::get('primaryunit','default');

		$secondaryoffice_id = Session::get('secondaryunit','default');

		$unitoffice = DB::table('unit_admins')
			->where('id','=',$id)
			->get();

		$emp_id = Input::get('emp_id');
		$id_dropdown = $unitoffice_id;	

		foreach($unitoffice as $unitadmin)
					{
						if($unitadmin->UnitOfficeSecondaryID != '0')
						{	
							$id_dropdown2 = $secondaryoffice_id;
						}
						
						if($unitadmin->UnitOfficeSecondaryID == '0')
						{
							$id_dropdown2 = Input::get('UnitOfficeSecondaryID');
						}
					}

		
		$id_dropdown3 = Input::get('UnitOfficeTertiaryID');	
		$id_dropdown4 = Input::get('UnitOfficeQuaternaryID');	

        DB::statement('UPDATE employs SET UnitOfficeID=:a, UnitOfficeSecondaryID=:b, UnitOfficeTertiaryID=:c, UnitOfficeQuaternaryID=:d
        		WHERE id=:res' ,
               array('res' => $emp_id, 'a' => $id_dropdown, 'b' =>$id_dropdown2, 'c' =>$id_dropdown3, 'd' =>$id_dropdown4) );
		
		$employee = $this->employee->findOrFail($emp_id);
		$ranks = DB::table('ranks')->get();
		$positions= DB::table('positions')->get();
		$supervisors=DB::table('employs')->get();
		$unit_offices = DB::table('unit_offices')->get();
		$unit_office_secondaries = DB::table('unit_office_secondaries')->get();
		$unit_office_tertiaries = DB::table('unit_office_tertiaries')->get();
		$unit_office_quaternaries = DB::table('unit_office_quaternaries')->get();
		return View::make('admin_view')
			->with('employee', $employee)
			->with('ranks',$ranks)
			->with('positions',$positions)
			->with('supervisors',$supervisors)
			->with('unit_offices',$unit_offices)
			->with('unit_office_secondaries',$unit_office_secondaries)
			->with('unit_office_tertiaries',$unit_office_tertiaries)
			->with('unit_office_quaternaries',$unit_office_quaternaries);
	}

	public function store()
	{
			

			$id = Session::get('unitadminid', 'default');

			$name = Session::get('unitadminname', 'default');

			$unitoffice_id = Session::get('primaryunit','default');

			$secondaryoffice_id = Session::get('secondaryunit','default');

			$unitoffice = DB::table('unit_admins')
			->where('id','=',$id)
			->get();

			$id_dropdown2 = Input::get('UnitOfficeSecondaryID');
			
			$id_dropdown3 = Input::get('UnitOfficeTertiaryID');
			if($id_dropdown3 == null)
			{
				$id_dropdown3 = 0;
				$id_dropdown4 = 0;
			}
			$id_dropdown4 = Input::get('UnitOfficeQuaternaryID');
			if($id_dropdown4 == null)
			{
				$id_dropdown4 = 0;
			}
		
			$employee_max = DB::table('employs')->max('id');
			$id= $employee_max + 1;
			$input = Input::all();
			$validation = Validator::make($input, Employ::$rules);
			$file = array('image' => Input::file('EmpPicturePath'));
			$emp_fname = preg_replace('/\s+/', '', Input::get('EmpFirstName'));
			$mail = Input::get('email');
			$emp = DB::table('employs')->where('email', '=', $mail)->get();
			$pos = Input::get('PositionID');
			$ran = Input::get('RankID');
			$bad = Input::get('BadgeNo');
			$badge = DB::table('employs')->where('BadgeNo', '=', $bad)->first();
			$las = Input::get('EmpLastName');
			$fir = Input::get('EmpFirstName');
			$use = Input::get('EmpID');
			$em = Input::get('email');
			
			$own = Input::get('OwnSupervisorID');

			$visor = Input::get('SupervisorID');
			
			if($visor == null && $own == null)
			{
				Session::flash('email-error', 'Please select a supervisor');

					return Redirect::to('admin/index');
			}

			if($own == 'true')
			{
				$sup = Input::get('OwnSupervisorID');
			}
			else{
				$sup = Input::get('SupervisorID');
			}
if($badge == null)
{
if($ran != 0 and $pos != 0 and $sup != null and $bad != '' and $las != '' and $fir != '' and $use != '' and $em != '')
	{
			
		

			if ($validation->passes())
			{
				$picture_path = Input::file('EmpPicturePath');
				if ($picture_path != null)
				{
				$destinationPath = 'employees'; //upload path
				$extension = Input::file('EmpPicturePath')->getClientOriginalExtension(); //getting image extension
				$fileName = $id.''.Input::get('EmpLastName').''.$emp_fname.'.'.$extension; //renaming image to -> 1FernandezDenimar.jpg
				Input::file('EmpPicturePath')->move($destinationPath, $fileName);
				}
				$employee = new Employ;
				$employee->EmpID = Input::get('EmpID');
				$employee->email = Input::get('email');
				$employee->BadgeNo = Input::get('BadgeNo');
				$employee->EmpLastName = Input::get('EmpLastName');
				$employee->EmpFirstName = Input::get('EmpFirstName');
				$employee->EmpMidInit = Input::get('EmpMidInit');
				$employee->EmpQualifier = Input::get('EmpQualifier');
				if ($picture_path == null)
				{
				$employee->EmpPicturePath = '../img/silhoutte.jpg';
				}
				else {
				$employee->EmpPicturePath = 'employees/'.$id.''.Input::get('EmpLastName').''.$emp_fname.'.'.$extension;
				}
				$employee->RankID = Input::get('RankID');
				$employee->PositionID = Input::get('PositionID');
				$employee->UnitOfficeID = $unitoffice_id;

				foreach($unitoffice as $unitadmin)
					{
						if($unitadmin->UnitOfficeSecondaryID != '0')
						{	
							$employee->UnitOfficeSecondaryID = $secondaryoffice_id;
						}
						
						if($unitadmin->UnitOfficeSecondaryID == '0')
						{
							$employee->UnitOfficeSecondaryID = $id_dropdown2;
						}
					}
				$employee->UnitOfficeTertiaryID =	$id_dropdown3;
				$employee->UnitOfficeQuaternaryID =	$id_dropdown4;
				
				$employee->save();

				

				$str_random = Str::random($length = 8);

    			$id = DB::table('employs')->max('id');
    			$supervisor_id = Input::get('OwnSupervisorID');
    			$super = Input::get('SupervisorID');
    			if($supervisor_id == 'true')
    			{
	    			DB::statement('UPDATE employs SET SupervisorID=:sur WHERE id=:res2',
					 array('sur' => $id, 'res2' => $id) );
    			}
    			else{
    				DB::statement('UPDATE employs SET SupervisorID=:sur WHERE id=:res2',
					 array('sur' => $super, 'res2' => $id) );
    			}	
										//placeholder values for variable
				DB::statement('UPDATE employs SET EmpPassword=:sur WHERE id=:res2',
				 array('sur' => $str_random, 'res2' => $id) );

				$for_message = DB::table('employs')->where('id', '=', $id)->first();

				

				Session::flash('employ-create', 'Successfully created! You will be given a temporary password: '.$for_message->EmpPassword.' The PERSONNEL can change it when he/she log-in in the employee account.');

				return Redirect::to('admin/index');
			}

			return Redirect::to('admin/index')
				->withInput()
				->withErrors($validation)
				->with('message', 'There were validation errors.');
	   
			}
		else
			{
					Session::flash('email-error', 'Please check all inputs if valid and not empty. Add your profile picture again.');

					return Redirect::to('admin/index')
					->withInput();
			}


	}

	else
	{
		Session::flash('email-error', 'Badge Number Already Exist or is empty');

					return Redirect::to('admin/index')
					->withInput();
	}
}

	    public function processCroppedPhoto()
	 {
	 	$img = $_REQUEST['imgBase64'];
	 	
	 	
		$img = str_replace('data:image/png;base64,', '', $img);
		
		$img = str_replace(' ', '+', $img);	
	 	$fileData = base64_decode($img);

	 

	 	$max = DB::table('employs')
		->max('id');
		$maxemployee = DB::table('employs')
		->where('id','=',$max)
		->first();
	 	$destinationPath = 'employees'; //upload path
	 	
	 	$fileName = $maxemployee->EmpPicturePath; //renaming image to -> 1FernandezDenimar.jpg
	 

	 	file_put_contents($fileName, $fileData);

	 


	 }

	 public function processCroppedPhotoEdit()
	 {
	 	$emp_id = $_REQUEST['empID'];
	 	$img = $_REQUEST['imgBase64'];
	 
		$img = str_replace('data:image/png;base64,', '', $img);
	
		$img = str_replace(' ', '+', $img);	
	 	$fileData = base64_decode($img);



		$maxemployee = DB::table('employs')
		->where('id','=',$emp_id)
		->first();
	 
	 	
	 	$fileName = $maxemployee->EmpPicturePath;
	 	
	 	file_put_contents($fileName, $fileData);

	 }

	 public function finishedCroppedPhoto()
	 {
	 		$max = DB::table('employs')
		->max('id');
		$maxemployee = DB::table('employs')
		->where('id','=',$max)
		->first();
		
	 	 	
				Session::flash('employ-create', 'Successfully created! You will be given a temporary password: '.$maxemployee->EmpPassword.' The PERSONNEL can change it when he/she log-in in the employee account. Email is sent to your account');
				return Redirect::to('admin/index');
	 }

	  public function finishedCroppedPhotoEdit()
	 {
	 			
				
				return Redirect::to('admin/index');
	 }
		
	    	public function view($id)
	{
		$employee = $this->employee->findOrFail($id);
		$ranks = DB::table('ranks')->get();
		$positions= DB::table('positions')->get();
		$supervisors=DB::table('employs')->get();
		$unit_offices = DB::table('unit_offices')->get();
		$unit_office_secondaries = DB::table('unit_office_secondaries')->get();
		$unit_office_tertiaries = DB::table('unit_office_tertiaries')->get();
		$unit_office_quaternaries = DB::table('unit_office_quaternaries')->get();
		return View::make('admin_view')
			->with('employee', $employee)
			->with('ranks',$ranks)
			->with('positions',$positions)
			->with('supervisors',$supervisors)
			->with('unit_offices',$unit_offices)
			->with('unit_office_secondaries',$unit_office_secondaries)
			->with('unit_office_tertiaries',$unit_office_tertiaries)
			->with('unit_office_quaternaries',$unit_office_quaternaries);
	}



	public function edit($id)
	{
		 
		$employee = $this->employee->find($id);
		$emp_id	= $employee->EmpID;

		$unitoffice_id = Session::get('primaryunit','default');

		$secondaryoffice_id = Session::get('secondaryunit','default');


		
		$ranks = DB::table('ranks')->get();
		$ranks_id= DB::table('ranks')->orderBy('Hierarchy','asc')
		->lists('RankCode','id');
		$positions= DB::table('positions')->get();
		$positions_id = DB::table('positions')->orderBy('PositionName','asc')
		->lists('PositionName','id');
		
		$supervisors = ['Select your Supervisor...'] + Employ::select(DB::raw('concat(EmpLastName, ", ", EmpFirstName) as full_name'), 'id' )
		->where('UnitOfficeID', '=', $unitoffice_id)->orderBy('EmpLastName', 'asc')->lists('full_name', 'id');
	
		return View::make('admin_edit')
		->with('emp_id', $emp_id)
		->with('employee',$employee)
		->with('ranks',$ranks)
		->with('ranks_id',$ranks_id)
		->with('positions',$positions)
		->with('positions_id',$positions_id)
		->with('supervisors',$supervisors);
		
	}

	public function update($id)
	{		
			
			$unitoffice_id = Session::get('primaryunit','default');

			$secondaryoffice_id = Session::get('secondaryunit','default');

			$name = Session::get('unitadminname', 'default');

			

			$unitoffice = DB::table('unit_admins')
			->where('id','=',$id)
			->get();
		
			$input = array_except(Input::all(), '_method');
			$file = array('image' => Input::file('EmpPicturePath'));
			$emp_fname = preg_replace('/\s+/', '', Input::get('EmpFirstName'));
			$picture_path = Input::file('EmpPicturePath');
			if ($picture_path != null)
			{
			$destinationPath = 'employees'; //upload path
			$extension = Input::file('EmpPicturePath')->getClientOriginalExtension(); //getting image extension
			if($extension == "jpg" || $extension == "png")
			{
				$fileName = $id.''.Input::get('EmpLastName').''.$emp_fname.'.'.$extension; //renaming image to -> 1FernandezDenimar.jpg
			}
			else{
				return Redirect::route('unit_admins.edit', $id);
			}
			Input::file('EmpPicturePath')->move($destinationPath, $fileName);
			}

			$mail = Input::get('email');
			$emp = DB::table('employs')->where('email', '=', $mail)->where('id','!=', $id)->get();
			$pos = Input::get('PositionID');
			$ran = Input::get('RankID');
			$bad = Input::get('BadgeNo');
			$badge = DB::table('employs')->where('BadgeNo', '=', $bad)->where('id','!=', $id)->first();
			$las = Input::get('EmpLastName');
			$fir = Input::get('EmpFirstName');
			$use = Input::get('EmpID');
			$user = DB::table('employs')->where('EmpID', '=', $use)->where('id','!=', $id)->get();
			$em = Input::get('email');
		
			$own = Input::get('OwnSupervisorID');

			$visor = Input::get('SupervisorID');
			
			if($visor == null && $own == null)
			{
				Session::flash('email-error', 'Please select a supervisor');

					return Redirect::to('admin/edit/'.$id);
			}

			if($own == 'true')
			{
				$sup = Input::get('OwnSupervisorID');
			}
			else{
				$sup = Input::get('SupervisorID');
			}

if($badge == null)
{

		
			if($user == null)
			{
				if($ran != 0 and $pos != 0 and $sup != null and $bad != '' and $las != '' and $fir != '' and $use != '' and $em != '')
				{
			
					$employee = $this->employee->find($id);
					$employee->EmpID = Input::get('EmpID');
					$employee->email = Input::get('email');
					$employee->EmpPassword = Input::get('EmpPassword');
					$employee->BadgeNo = Input::get('BadgeNo');
					$employee->EmpLastName = Input::get('EmpLastName');
					$employee->EmpFirstName = Input::get('EmpFirstName');
					$employee->EmpMidInit = Input::get('EmpMidInit');
					$employee->EmpQualifier = Input::get('EmpQualifier');
					if ($picture_path != null)
					{
						$employee->EmpPicturePath = 'employees/'.$id.''.Input::get('EmpLastName').''.$emp_fname.'.'.$extension;
					}
					else {
						$employee->EmpPicturePath = Input::get('picture_path');
					}
					$employee->RankID = Input::get('RankID');
					$employee->PositionID = Input::get('PositionID');
					$employee->SupervisorID = Input::get('SupervisorID');

					$employee->update();


				$employee = $this->employee->findOrFail($id);
				$ranks = DB::table('ranks')->get();
				$positions= DB::table('positions')->get();
				$supervisors=DB::table('employs')->get();
				$unit_offices = DB::table('unit_offices')->get();
				$unit_office_secondaries = DB::table('unit_office_secondaries')->get();
				$unit_office_tertiaries = DB::table('unit_office_tertiaries')->get();
				$unit_office_quaternaries = DB::table('unit_office_quaternaries')->get();


				//$fn = DB::table('employs')
				//	->where('id','=',$id)
				//	->first();

				//	return View::make('unitadminemployeecropphoto')
				//		->with('fn',$fn)
				//		->with('id',$id)
				//		->with('employee', $employee)
				//	->with('ranks',$ranks)
				//	->with('positions',$positions)
				//	->with('supervisors',$supervisors)
				//	->with('unit_offices',$unit_offices)
				//	->with('unit_office_secondaries',$unit_office_secondaries)
				//	->with('unit_office_tertiaries',$unit_office_tertiaries)
				//	->with('unit_office_quaternaries',$unit_office_quaternaries)
				//	->with('name',$name);
				return View::make('admin_view')
					->with('employee', $employee)
					->with('ranks',$ranks)
					->with('positions',$positions)
					->with('supervisors',$supervisors)
					->with('unit_offices',$unit_offices)
					->with('unit_office_secondaries',$unit_office_secondaries)
					->with('unit_office_tertiaries',$unit_office_tertiaries)
					->with('unit_office_quaternaries',$unit_office_quaternaries);
			}
			else
			{
				Session::flash('email-error', 'Please check all inputs if valid and not empty. Add your profile picture again.');

				return Redirect::to('admin/edit/'.$id)
				->withInput();
			}


		}
		else
		{
			Session::flash('email-error', 'UserName Already Exist or is empty');
			return Redirect::to('admin/edit/'.$id)
			->withInput();
		}

	
}
else
	{
		Session::flash('email-error', 'Badge Number Already Exist or is empty');

					return Redirect::to('admin/edit/'.$id)
					->withInput();
	}

}
		public function ajaxsecondary()
	{
		if(Request::ajax())
		{
			$officeID2 = $_POST['officeID2'];
			$queries = DB::table('unit_office_tertiaries')
			->where('UnitOfficeSecondaryID', '=', $officeID2)
			->get();

			return Response::json($queries);
		}
	}


	public function showEmployeeDatatable()
	{

		$id = Session::get('unitadminid', 'default');

		$name = Session::get('unitadminname', 'default');

		$unitoffice_id = Session::get('primaryunit','default');

		$secondaryoffice_id = Session::get('secondaryunit','default');

		$unitoffice = DB::table('unit_admins')
			->where('id','=',$id)
			->get();
			
		foreach($unitoffice as $unitadmin)
			{
				if($unitadmin->UnitOfficeSecondaryID != '0')
				{
					//$employees = DB::table('employs')
					//->where('UnitOfficeID','=',$unitoffice_id)
					//->where('UnitOfficeSecondaryID','=',$secondaryoffice_id)
					//->where('employs.isActive', '!=', '0')
					//->get();

					 $employs = DB::table('employs')
					->join('ranks', 'employs.RankID', '=', 'ranks.id')
					->join('positions', 'employs.PositionID', '=', 'positions.id')
					->join('unit_offices', 'employs.UnitOfficeID', '=', 'unit_offices.id')
					->join('employs AS employ_supervisor', 'employs.SupervisorID', '=', 'employ_supervisor.id')
					->select('employs.id as id', 'employs.EmpLastName as EmpLastName', 'employs.EmpFirstName as EmpFirstName', 'ranks.RankCode as rank', 'positions.PositionName as position', 'unit_offices.UnitOfficeName as UnitOfficeName', 'employs.EmpPicturePath as picpath')
					->where('employs.UnitOfficeID','=',$unitoffice_id)
					->where('employs.UnitOfficeSecondaryID','=',$secondaryoffice_id)
					->orderBy('ranks.Hierarchy');

				}

				if($unitadmin->UnitOfficeSecondaryID == '0')
				{
					//$employees = DB::table('employs')
					//->where('UnitOfficeID','=',$unitoffice_id)
					//->where('employs.isActive', '!=', '0')
					//->get();
					$employs = DB::table('employs')
					->join('ranks', 'employs.RankID', '=', 'ranks.id')
					->join('positions', 'employs.PositionID', '=', 'positions.id')
					->join('unit_offices', 'employs.UnitOfficeID', '=', 'unit_offices.id')
					->join('employs AS employ_supervisor', 'employs.SupervisorID', '=', 'employ_supervisor.id')
					->select('employs.id as id', 'employs.EmpLastName as EmpLastName', 'employs.EmpFirstName as EmpFirstName', 'ranks.RankCode as rank', 'positions.PositionName as position', 'unit_offices.UnitOfficeName as UnitOfficeName', 'employs.EmpPicturePath as picpath')
					->where('employs.UnitOfficeID','=',$unitoffice_id)
					->orderBy('ranks.Hierarchy');
				}
				


			}


		  //$employs = DB::table('employs')
			//->join('ranks', 'employs.RankID', '=', 'ranks.id')
			//->join('positions', 'employs.PositionID', '=', 'positions.id')
			//->join('unit_offices', 'employs.UnitOfficeID', '=', 'unit_offices.id')
			//->join('employs AS employ_supervisor', 'employs.SupervisorID', '=', 'employ_supervisor.id')
			//->select('employs.id as id', 'employs.EmpLastName as EmpLastName', 'employs.EmpFirstName as EmpFirstName', 'ranks.RankCode as rank', 'positions.PositionName as position', 'unit_offices.UnitOfficeName as UnitOfficeName', 'employs.EmpPicturePath as picpath')
			//->orderBy('ranks.Hierarchy');


			

        return Datatables::of($employs)
        ->add_column('Pictures', '<img style = "height:60px; width:60px;" src="{{URL::asset($picpath)}}">')
        ->add_column('Actions', ' <a class = \'btn btn-warning\' style = "margin-bottom:5px" href="{{ URL::to(\'admin/view/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'admin/view/\' . $id) }}\', \'newwindow\', \'width=380, height=620\'); return false;">View</a>

        	 <br>
  
              
                    <a class = \'btn btn-info\' style = "margin-bottom:5px" href="{{ URL::to(\'admin/edit/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'admin/edit/\' . $id) }}\', \'newwindow\', \'width=450, height=450\'); return false;">Edit</a><br>

              <a class = \'btn btn-success\'  href="{{ URL::to(\'admin/units/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'admin/units/\' . $id) }}\', \'newwindow\', \'width=500, height=500\'); return false; ">Unit</a>
                    
                ')
   
        ->make(true);
	}

	public function secondaryunit()
	{
		$officeID = $_REQUEST['officeID2'];

		$queries= DB::table('unit_office_tertiaries')
					->where('UnitOfficeSecondaryID', '=', $officeID)
					->select('UnitOfficeTertiaryName','id')
					->orderBy('UnitOfficeTertiaryName','asc')
					->get();

		return Response::json($queries);



	}

	public function tertiaryunit()
	{
		$officeID = $_REQUEST['officeID3'];

		

		$queries= DB::table('unit_office_quaternaries')
		->where('UnitOfficeTertiaryID', '=', $officeID)
		->select('UnitOfficeQuaternaryName','id')
		->orderBy('UnitOfficeQuaternaryName','asc')
		->get();

		return Response::json($queries);

	}


	}




?>