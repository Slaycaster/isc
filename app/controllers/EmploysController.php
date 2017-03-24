<?php

class EmploysController extends BaseController {

	/**
	 * Employee Repository
	 *
	 * @var Employee
	 */
	protected $employee;

	public function __construct(Employ $employee)
	{
		$this->employee = $employee;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$employees = DB::table('employs')
		->where('employs.isActive', '!=', '0')
		->paginate(10);
		$employee_max = DB::table('employs')->max('id');
		$employee_max = $employee_max + 1;
		$emp_id = 'EMP'.str_pad($employee_max, 5, '0', STR_PAD_LEFT); 
		$ranks = DB::table('ranks')->get();
		$ranks_id= DB::table('ranks')->orderBy('Hierarchy','desc')
		->lists('RankCode','id');
		$positions= DB::table('positions')->get();
		$positions_id= DB::table('positions')->orderBy('PositionName','asc')
		->lists('PositionName','id');
		
		$supervisors = Employ::select(DB::raw('concat(RankCode," ",EmpLastName, ", ", EmpFirstName) as full_name'), 'employs.id' )
		->join('ranks', 'ranks.id', '=', 'employs.RankID')
		->orderBy('EmpLastName', 'asc')->lists('full_name', 'id');
		$unit_offices = DB::table('unit_offices')->get();
		$unit_offices_id= ['Select Unit/Office...'] + DB::table('unit_offices')->orderBy('UnitOfficeName','asc')
		->lists('UnitOfficeName','id');
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();
		$unit_offices_secondaries_id= ['none...'];
		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')->get();
		$unit_offices_tertiaries_id= ['none...'];
		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= ['none...'];
		$id_dropdown = "0";
		$id_dropdown2 = "0";
		$id_dropdown3 = "0";
		$id_dropdown4 = "0";
		return View::make('employs.index', compact('employs'))
		->with('emp_id', $emp_id)
		->with('employees',$employees)
		->with('id_dropdown', $id_dropdown)
		->with('id_dropdown2', $id_dropdown2)
		->with('id_dropdown3', $id_dropdown3)
		->with('id_dropdown4', $id_dropdown4)
		->with('ranks',$ranks)
		->with('ranks_id',$ranks_id)
		->with('positions',$positions)
		->with('positions_id',$positions_id)
		->with('unit_offices',$unit_offices)
		->with('unit_offices_id',$unit_offices_id)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id)
		->with('unit_offices_tertiaries',$unit_offices_tertiaries)
		->with('unit_offices_tertiaries_id',$unit_offices_tertiaries_id)
		->with('unit_offices_quaternaries',$unit_offices_quaternaries)
		->with('unit_offices_quaternaries_id',$unit_offices_quaternaries_id)
		->with('supervisors',$supervisors);
	}


		public function unit($id)
	{
		
		$unit_offices = DB::table('unit_offices')->get();
		$unit_offices_id= ['Select Unit Office...'] + DB::table('unit_offices')->orderBy('UnitOfficeName','asc')
		->lists('UnitOfficeName','id');
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();
		$unit_offices_secondaries_id= ['none...'];
		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')->get();
		$unit_offices_tertiaries_id= ['none...'];
		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= ['none...'];
		$id_dropdown = "0";
		$id_dropdown2 = "0";
		$id_dropdown3 = "0";
		$id_dropdown4 = "0";
		$emp_id = $id;


		return View::make('employs.unit')
		->with('emp_id', $emp_id)
		->with('id_dropdown', $id_dropdown)
		->with('id_dropdown2', $id_dropdown2)
		->with('id_dropdown3', $id_dropdown3)
		->with('id_dropdown4', $id_dropdown4)
		->with('unit_offices',$unit_offices)
		->with('unit_offices_id',$unit_offices_id)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id)
		->with('unit_offices_tertiaries',$unit_offices_tertiaries)
		->with('unit_offices_tertiaries_id',$unit_offices_tertiaries_id)
		->with('unit_offices_quaternaries',$unit_offices_quaternaries)
		->with('unit_offices_quaternaries_id',$unit_offices_quaternaries_id);
	}

	public function postunit()
	{
		$emp_id = Input::get('EmpID');
		$id_dropdown = Input::get('UnitOfficeID');

		$unit_offices = DB::table('unit_offices')->get();
		$unit_offices_id= DB::table('unit_offices')->where('id', '=', $id_dropdown)->orderBy('UnitOfficeName','asc')
		->lists('UnitOfficeName','id');
		
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id= ['Select Secondary...'] + DB::table('unit_office_secondaries')
		->where('UnitOfficeID', '=', $id_dropdown)
		->orderBy('UnitOfficeSecondaryName','asc')
		->lists('UnitOfficeSecondaryName','id');
		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')->get();
		$unit_offices_tertiaries_id= ['none...'];
		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= ['none...'];
		$id_dropdown2='0';
		$id_dropdown3='0';
		$id_dropdown4='0';

		return View::make('employs.unit')
		->with('emp_id', $emp_id)
		->with('id_dropdown', $id_dropdown)
		->with('id_dropdown2', $id_dropdown2)
		->with('id_dropdown3', $id_dropdown3)
		->with('id_dropdown4', $id_dropdown4)
		->with('unit_offices',$unit_offices)
		->with('unit_offices_id',$unit_offices_id)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id)
		->with('unit_offices_tertiaries',$unit_offices_tertiaries)
		->with('unit_offices_tertiaries_id',$unit_offices_tertiaries_id)
		->with('unit_offices_quaternaries',$unit_offices_quaternaries)
		->with('unit_offices_quaternaries_id',$unit_offices_quaternaries_id);
	}

	public function postunit2()
	{
		$emp_id = Input::get('EmpID');
		$id_dropdown = Input::get('UnitOfficeID');	
		$id_dropdown2 = Input::get('UnitOfficeSecondaryID');	

		$unit_offices = DB::table('unit_offices')->get();
		$unit_offices_id= DB::table('unit_offices')->where('id', '=', $id_dropdown)->orderBy('UnitOfficeName','asc')
		->lists('UnitOfficeName','id');
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id= DB::table('unit_office_secondaries')->where('id', '=', $id_dropdown2)->orderBy('UnitOfficeSecondaryName','asc')
		->lists('UnitOfficeSecondaryName','id');

		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')->get();
		$unit_offices_tertiaries_id= ['Select Tertiary...'] + DB::table('unit_office_tertiaries')
		->where('UnitOfficeSecondaryID', '=', $id_dropdown2)
		->orderBy('UnitOfficeTertiaryName','asc')
		->lists('UnitOfficeTertiaryName','id');
		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= ['none...'];
		$id_dropdown3 = '0';
		$id_dropdown4 = '0';

		return View::make('employs.unit')
		->with('emp_id', $emp_id)
		->with('id_dropdown', $id_dropdown)
		->with('id_dropdown2', $id_dropdown2)
		->with('id_dropdown3', $id_dropdown3)
		->with('id_dropdown4', $id_dropdown4)
		->with('unit_offices',$unit_offices)
		->with('unit_offices_id',$unit_offices_id)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id)
		->with('unit_offices_tertiaries',$unit_offices_tertiaries)
		->with('unit_offices_tertiaries_id',$unit_offices_tertiaries_id)
		->with('unit_offices_quaternaries',$unit_offices_quaternaries)
		->with('unit_offices_quaternaries_id',$unit_offices_quaternaries_id);
	}

	public function postunit3()
	{
		$emp_id = Input::get('EmpID');
		$id_dropdown = Input::get('UnitOfficeID');	
		$id_dropdown2 = Input::get('UnitOfficeSecondaryID');
		$id_dropdown3 = Input::get('UnitOfficeTertiaryID');	

		$unit_offices = DB::table('unit_offices')->get();
		$unit_offices_id= DB::table('unit_offices')->where('id', '=', $id_dropdown)->orderBy('UnitOfficeName','asc')
		->lists('UnitOfficeName','id');
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id= DB::table('unit_office_secondaries')->where('id', '=', $id_dropdown2)->orderBy('UnitOfficeSecondaryName','asc')
		->lists('UnitOfficeSecondaryName','id');

		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')->get();
		$unit_offices_tertiaries_id= DB::table('unit_office_tertiaries')->where('id', '=', $id_dropdown3)->orderBy('UnitOfficeTertiaryName','asc')
		->lists('UnitOfficeTertiaryName','id');

		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= ['Select Quaternary...'] + DB::table('unit_office_quaternaries')->where('UnitOfficeTertiaryID', '=', $id_dropdown3)
		->orderBy('UnitOfficeQuaternaryName','asc')
		->lists('UnitOfficeQuaternaryName','id');
		$id_dropdown4 = '0'; 

		return View::make('employs.unit')
		->with('emp_id', $emp_id)
		->with('id_dropdown', $id_dropdown)
		->with('id_dropdown2', $id_dropdown2)
		->with('id_dropdown3', $id_dropdown3)
		->with('id_dropdown4', $id_dropdown4)
		->with('unit_offices',$unit_offices)
		->with('unit_offices_id',$unit_offices_id)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id)
		->with('unit_offices_tertiaries',$unit_offices_tertiaries)
		->with('unit_offices_tertiaries_id',$unit_offices_tertiaries_id)
		->with('unit_offices_quaternaries',$unit_offices_quaternaries)
		->with('unit_offices_quaternaries_id',$unit_offices_quaternaries_id);
	}

	public function postunit4()
	{
		$emp_id = Input::get('EmpID');
		$id_dropdown = Input::get('UnitOfficeID');	
		$id_dropdown2 = Input::get('UnitOfficeSecondaryID');
		$id_dropdown3 = Input::get('UnitOfficeTertiaryID');	
		$id_dropdown4 = Input::get('UnitOfficeQuaternaryID');	

		$unit_offices = DB::table('unit_offices')->get();
		$unit_offices_id= DB::table('unit_offices')->where('id', '=', $id_dropdown)->orderBy('UnitOfficeName','asc')
		->lists('UnitOfficeName','id');
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id= DB::table('unit_office_secondaries')->where('id', '=', $id_dropdown2)->orderBy('UnitOfficeSecondaryName','asc')
		->lists('UnitOfficeSecondaryName','id');

		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')->get();
		$unit_offices_tertiaries_id= DB::table('unit_office_tertiaries')->where('id', '=', $id_dropdown3)->orderBy('UnitOfficeTertiaryName','asc')
		->lists('UnitOfficeTertiaryName','id');

		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= DB::table('unit_office_quaternaries')->where('id', '=', $id_dropdown4)->orderBy('UnitOfficeQuaternaryName','asc')
		->lists('UnitOfficeQuaternaryName','id');
		return View::make('employs.unit')
		->with('emp_id', $emp_id)
		->with('id_dropdown', $id_dropdown)
		->with('id_dropdown2', $id_dropdown2)
		->with('id_dropdown3', $id_dropdown3)
		->with('id_dropdown4', $id_dropdown4)
		->with('unit_offices',$unit_offices)
		->with('unit_offices_id',$unit_offices_id)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id)
		->with('unit_offices_tertiaries',$unit_offices_tertiaries)
		->with('unit_offices_tertiaries_id',$unit_offices_tertiaries_id)
		->with('unit_offices_quaternaries',$unit_offices_quaternaries)
		->with('unit_offices_quaternaries_id',$unit_offices_quaternaries_id);
	}

	public function saveunit()
	{
		$emp_id = Input::get('EmpID');
		$id_dropdown = Input::get('UnitOfficeID');	
		$id_dropdown2 = Input::get('UnitOfficeSecondaryID');
		$id_dropdown3 = Input::get('UnitOfficeTertiaryID');	
		$id_dropdown4 = Input::get('UnitOfficeQuaternaryID');	

        DB::statement('UPDATE employs SET UnitOfficeID=:a, UnitOfficeSecondaryID=:b, UnitOfficeTertiaryID=:c, UnitOfficeQuaternaryID=:d
        		WHERE id=:res' ,
               array('res' => $emp_id, 'a' => $id_dropdown, 'b' =>$id_dropdown2, 'c' =>$id_dropdown3, 'd' =>$id_dropdown4) );
		$unit_offices = DB::table('unit_offices')->get();
		$unit_offices_id= DB::table('unit_offices')->where('id', '=', $id_dropdown)->orderBy('UnitOfficeName','asc')
		->lists('UnitOfficeName','id');
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id= DB::table('unit_office_secondaries')->where('id', '=', $id_dropdown2)->orderBy('UnitOfficeSecondaryName','asc')
		->lists('UnitOfficeSecondaryName','id');

		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')->get();
		$unit_offices_tertiaries_id= DB::table('unit_office_tertiaries')->where('id', '=', $id_dropdown3)->orderBy('UnitOfficeTertiaryName','asc')
		->lists('UnitOfficeTertiaryName','id');

		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= DB::table('unit_office_quaternaries')->where('id', '=', $id_dropdown4)->orderBy('UnitOfficeQuaternaryName','asc')
		->lists('UnitOfficeQuaternaryName','id');


		$employees = DB::table('employs')->get();
		$employee = $this->employee->findOrFail($emp_id);
		$ranks = DB::table('ranks')->get();
		$positions= DB::table('positions')->get();
		$supervisors=DB::table('employs')->get();
		$unit_offices = DB::table('unit_offices')->get();
		$unit_office_secondaries = DB::table('unit_office_secondaries')->get();
		$unit_office_tertiaries = DB::table('unit_office_tertiaries')->get();
		$unit_office_quaternaries = DB::table('unit_office_quaternaries')->get();


		Session::flush();
		return View::make('employs.show', compact('employ'))
			->with('employee', $employee)
			->with('employees', $employees)
			->with('ranks',$ranks)
			->with('positions',$positions)
			->with('supervisors',$supervisors)
			->with('unit_offices',$unit_offices)
			->with('unit_office_secondaries',$unit_office_secondaries)
			->with('unit_office_tertiaries',$unit_office_tertiaries)
			->with('unit_office_quaternaries',$unit_office_quaternaries);
	}

	public function postindex()
	{
		$employees = DB::table('employs')->get();
		$employee_max = DB::table('employs')->max('id');
		$employee_max = $employee_max + 1;
		$emp_id = 'EMP'.str_pad($employee_max, 5, '0', STR_PAD_LEFT); 
		$ranks = DB::table('ranks')->get();
		$ranks_id= ['Select Rank...'] + DB::table('ranks')->orderBy('RankCode','asc')
		->lists('RankCode','id');

		$positions= DB::table('positions')->get();
		$positions_id= ['Select Position...'] + DB::table('positions')->orderBy('PositionName','asc')
		->lists('PositionName','id');
		

		
		$id_dropdown = Input::get('UnitOfficeID');
		$id_dropdown2='0';
		$id_dropdown3='0';
		$id_dropdown4='0';


		$supervisors =  Employ::select(DB::raw('concat(RankCode," ",EmpLastName, ", ", EmpFirstName) as full_name'), 'employs.id' )
		->join('ranks', 'ranks.id', '=', 'employs.RankID')
		->where('UnitOfficeID', '=', $id_dropdown)
		->orderBy('EmpLastName', 'asc')->lists('full_name', 'id');
		
		$unit_offices = DB::table('unit_offices')->get();
		$unit_offices_id= DB::table('unit_offices')->where('id', '=', $id_dropdown)->orderBy('UnitOfficeName','asc')
		->lists('UnitOfficeName','id');
		
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id= ['Select Secondary...'] + DB::table('unit_office_secondaries')
		->where('UnitOfficeID', '=', $id_dropdown)
		->orderBy('UnitOfficeSecondaryName','asc')
		->lists('UnitOfficeSecondaryName','id');
		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')->get();
		$unit_offices_tertiaries_id= ['none...'];
		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= ['none...'];
	

		return View::make('employs.index', compact('employs'))
		->with('emp_id', $emp_id)
		->with('employees',$employees)
		->with('id_dropdown',$id_dropdown)
		->with('id_dropdown2',$id_dropdown2)
		->with('id_dropdown3',$id_dropdown3)
		->with('id_dropdown4',$id_dropdown4)
		->with('ranks',$ranks)
		->with('ranks_id',$ranks_id)
		->with('positions',$positions)
		->with('positions_id',$positions_id)
		->with('unit_offices',$unit_offices)
		->with('unit_offices_id',$unit_offices_id)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id)
		->with('unit_offices_tertiaries',$unit_offices_tertiaries)
		->with('unit_offices_tertiaries_id',$unit_offices_tertiaries_id)
		->with('unit_offices_quaternaries',$unit_offices_quaternaries)
		->with('unit_offices_quaternaries_id',$unit_offices_quaternaries_id)
		->with('supervisors',$supervisors);
	}

	public function postindex2()
	{
		$employees = DB::table('employs')->get();
		$employee_max = DB::table('employs')->max('id');
		$employee_max = $employee_max + 1;
		$emp_id = 'EMP'.str_pad($employee_max, 5, '0', STR_PAD_LEFT); 
		$ranks = DB::table('ranks')->get();
		$ranks_id= ['Select Rank...'] + DB::table('ranks')->orderBy('RankCode','asc')
		->lists('RankCode','id');

		$positions= DB::table('positions')->get();
		$positions_id= ['Select Position...'] + DB::table('positions')->orderBy('PositionName','asc')
		->lists('PositionName','id');
		
		$id_dropdown = Input::get('UnitOfficeID');	
		$id_dropdown2 = Input::get('UnitOfficeSecondaryID');
		$id_dropdown3 = '0';
		$id_dropdown4 = '0';	


		$supervisors =  Employ::select(DB::raw('concat(RankCode," ",EmpLastName, ", ", EmpFirstName) as full_name'), 'employs.id' )
		->join('ranks', 'ranks.id', '=', 'employs.RankID')
		->where('UnitOfficeID', '=', $id_dropdown)
		->orderBy('EmpLastName', 'asc')->lists('full_name', 'id');
	
		
		
	
		$unit_offices = DB::table('unit_offices')->get();
		$unit_offices_id= DB::table('unit_offices')->where('id', '=', $id_dropdown)->orderBy('UnitOfficeName','asc')
		->lists('UnitOfficeName','id');
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id= DB::table('unit_office_secondaries')->where('id', '=', $id_dropdown2)->orderBy('UnitOfficeSecondaryName','asc')
		->lists('UnitOfficeSecondaryName','id');

		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')->get();
		$unit_offices_tertiaries_id= ['Select Tertiary...'] + DB::table('unit_office_tertiaries')
		->where('UnitOfficeSecondaryID', '=', $id_dropdown2)
		->orderBy('UnitOfficeTertiaryName','asc')
		->lists('UnitOfficeTertiaryName','id');
		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= ['none...'];
		
		return View::make('employs.index', compact('employs'))
		->with('emp_id', $emp_id)
		->with('employees',$employees)
		->with('ranks',$ranks)
		->with('id_dropdown',$id_dropdown)
		->with('id_dropdown2',$id_dropdown2)
		->with('id_dropdown3',$id_dropdown3)
		->with('id_dropdown4',$id_dropdown4)
		->with('ranks_id',$ranks_id)
		->with('positions',$positions)
		->with('positions_id',$positions_id)
		->with('unit_offices',$unit_offices)
		->with('unit_offices_id',$unit_offices_id)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id)
		->with('unit_offices_tertiaries',$unit_offices_tertiaries)
		->with('unit_offices_tertiaries_id',$unit_offices_tertiaries_id)
		->with('unit_offices_quaternaries',$unit_offices_quaternaries)
		->with('unit_offices_quaternaries_id',$unit_offices_quaternaries_id)
		->with('supervisors',$supervisors);
	}

	public function postindex3()
	{
		$employees = DB::table('employs')->get();
		$employee_max = DB::table('employs')->max('id');
		$employee_max = $employee_max + 1;
		$emp_id = 'EMP'.str_pad($employee_max, 5, '0', STR_PAD_LEFT); 
		$ranks = DB::table('ranks')->get();
		$ranks_id= ['Select Rank...'] + DB::table('ranks')->orderBy('RankCode','asc')
		->lists('RankCode','id');

		$positions= DB::table('positions')->get();
		$positions_id= ['Select Position...'] + DB::table('positions')->orderBy('PositionName','asc')
		->lists('PositionName','id');
		
		$id_dropdown = Input::get('UnitOfficeID');	
		$id_dropdown2 = Input::get('UnitOfficeSecondaryID');
		$id_dropdown3 = Input::get('UnitOfficeTertiaryID');	
		$id_dropdown4 = '0';


		$supervisors =  Employ::select(DB::raw('concat(RankCode," ",EmpLastName, ", ", EmpFirstName) as full_name'), 'employs.id' )
		->join('ranks', 'ranks.id', '=', 'employs.RankID')
		->where('UnitOfficeID', '=', $id_dropdown)
		->orderBy('EmpLastName', 'asc')->lists('full_name', 'id');
		


		$unit_offices = DB::table('unit_offices')->get();
		$unit_offices_id= DB::table('unit_offices')->where('id', '=', $id_dropdown)->orderBy('UnitOfficeName','asc')
		->lists('UnitOfficeName','id');
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id= DB::table('unit_office_secondaries')->where('id', '=', $id_dropdown2)->orderBy('UnitOfficeSecondaryName','asc')
		->lists('UnitOfficeSecondaryName','id');

		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')->get();
		$unit_offices_tertiaries_id= DB::table('unit_office_tertiaries')->where('id', '=', $id_dropdown3)->orderBy('UnitOfficeTertiaryName','asc')
		->lists('UnitOfficeTertiaryName','id');

		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= ['Select Quaternary...'] + DB::table('unit_office_quaternaries')->where('UnitOfficeTertiaryID', '=', $id_dropdown3)
		->orderBy('UnitOfficeQuaternaryName','asc')
		->lists('UnitOfficeQuaternaryName','id');
	
		return View::make('employs.index', compact('employs'))
		->with('emp_id', $emp_id)
		->with('employees',$employees)
		->with('ranks',$ranks)
		->with('id_dropdown',$id_dropdown)
		->with('id_dropdown2',$id_dropdown2)
		->with('id_dropdown3',$id_dropdown3)
		->with('id_dropdown4',$id_dropdown4)
		->with('ranks_id',$ranks_id)
		->with('positions',$positions)
		->with('positions_id',$positions_id)
		->with('unit_offices',$unit_offices)
		->with('unit_offices_id',$unit_offices_id)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id)
		->with('unit_offices_tertiaries',$unit_offices_tertiaries)
		->with('unit_offices_tertiaries_id',$unit_offices_tertiaries_id)
		->with('unit_offices_quaternaries',$unit_offices_quaternaries)
		->with('unit_offices_quaternaries_id',$unit_offices_quaternaries_id)
		->with('supervisors',$supervisors);
	}

	public function postindex4()
	{
		$employees = DB::table('employs')->get();
		$employee_max = DB::table('employs')->max('id');
		$employee_max = $employee_max + 1;
		$emp_id = 'EMP'.str_pad($employee_max, 5, '0', STR_PAD_LEFT); 
		$ranks = DB::table('ranks')->get();
		$ranks_id= ['Select Rank...'] + DB::table('ranks')->orderBy('RankCode','asc')
		->lists('RankCode','id');

		$positions= DB::table('positions')->get();
		$positions_id= ['Select Position...'] + DB::table('positions')->orderBy('PositionName','asc')
		->lists('PositionName','id');
		$id_dropdown = Input::get('UnitOfficeID');	
		$id_dropdown2 = Input::get('UnitOfficeSecondaryID');
		$id_dropdown3 = Input::get('UnitOfficeTertiaryID');	
		$id_dropdown4 = Input::get('UnitOfficeQuaternaryID');
		
		
		$supervisors = Employ::select(DB::raw('concat(RankCode," ",EmpLastName, ", ", EmpFirstName) as full_name'), 'employs.id' )
		->join('ranks', 'ranks.id', '=', 'employs.RankID')
		->where('UnitOfficeID', '=', $id_dropdown)
		->orderBy('EmpLastName', 'asc')->lists('full_name', 'id');
	
		
		
			

		$unit_offices = DB::table('unit_offices')->get();
		$unit_offices_id= DB::table('unit_offices')->where('id', '=', $id_dropdown)->orderBy('UnitOfficeName','asc')
		->lists('UnitOfficeName','id');
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id= DB::table('unit_office_secondaries')->where('id', '=', $id_dropdown2)->orderBy('UnitOfficeSecondaryName','asc')
		->lists('UnitOfficeSecondaryName','id');

		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')->get();
		$unit_offices_tertiaries_id= DB::table('unit_office_tertiaries')->where('id', '=', $id_dropdown3)->orderBy('UnitOfficeTertiaryName','asc')
		->lists('UnitOfficeTertiaryName','id');

		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= DB::table('unit_office_quaternaries')->where('id', '=', $id_dropdown4)->orderBy('UnitOfficeQuaternaryName','asc')
		->lists('UnitOfficeQuaternaryName','id');
		return View::make('employs.index', compact('employs'))
		->with('emp_id', $emp_id)
		->with('employees',$employees)
		->with('ranks',$ranks)
		->with('id_dropdown',$id_dropdown)
		->with('id_dropdown2',$id_dropdown2)
		->with('id_dropdown3',$id_dropdown3)
		->with('id_dropdown4',$id_dropdown4)
		->with('ranks_id',$ranks_id)
		->with('positions',$positions)
		->with('positions_id',$positions_id)
		->with('unit_offices',$unit_offices)
		->with('unit_offices_id',$unit_offices_id)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id)
		->with('unit_offices_tertiaries',$unit_offices_tertiaries)
		->with('unit_offices_tertiaries_id',$unit_offices_tertiaries_id)
		->with('unit_offices_quaternaries',$unit_offices_quaternaries)
		->with('unit_offices_quaternaries_id',$unit_offices_quaternaries_id)
		->with('supervisors',$supervisors);
	}



	public function postSearch()
	{

		$q = Input::get('query');
		$employee_max = DB::table('employs')->max('id');
		$employee_max = $employee_max + 1;
		$emp_id = 'EMP'.str_pad($employee_max, 5, '0', STR_PAD_LEFT); 
		$employees = DB::table('employs')->whereRaw("MATCH(EmpID, EmpLastName, EmpFirstName) AGAINST(? IN BOOLEAN MODE)", array($q))->paginate(9);
		$ranks = DB::table('ranks')->get();
		$ranks_id=DB::table('ranks')
		->lists('RankCode','id');
		$unit_offices = DB::table('unit_offices')->get();
		$unit_offices_id=DB::table('unit_offices')
		->lists('UnitOfficeName','id');
		$positions = DB::table('positions')->get();
		$positions_id=DB::table('positions')
		->lists('PositionName','id');
		$supervisors = Employ::select(DB::raw('concat(EmpLastName, ", ", EmpFirstName) as full_name'), 'id' )
		->orderBy('EmpLastName', 'asc')->lists('full_name', 'id');

		return View::make('employs.index')
		->with('emp_id', $emp_id)
		->with('employees',$employees)
		->with('ranks',$ranks)
		->with('ranks_id',$ranks_id)
		->with('positions',$positions)
		->with('positions_id',$positions_id)
		->with('unit_offices',$unit_offices)
		->with('unit_offices_id',$unit_offices_id)
		->with('supervisors',$supervisors);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
		$employee_max = DB::table('employs')->max('id');
		$employee_max = $employee_max + 1;
		$emp_id = 'EMP-'.str_pad($employee_max, 5, '0', STR_PAD_LEFT); 
		$departments=DB::table('departments')
		->lists('name','id');
		$contracts=DB::table('contracts')
		->lists('contract_name','id');
		$jobtitles=DB::table('jobtitles')
		->lists('jobtitle_name','id');
		return View::make('employs.create')
		->with('emp_id', $emp_id)
		->with('departments',$departments)
		->with('jobtitles',$jobtitles)
		->with('contracts',$contracts);

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Rsesponse
	 */
	public function store()
	{
			$id_dropdown = Input::get('UnitOfficeID');			
			$id_dropdown2 = Input::get('UnitOfficeSecondaryID');
			if($id_dropdown2 == null)
			{
				$id_dropdown2 = 0;
				$id_dropdown3 = 0;
				$id_dropdown4 = 0;
			}
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

			
			if ($validation->passes())
			{
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
						Session::flash('email-error', 'The file format must be jpeg and png only');

							return Redirect::route('employs.index');
					}
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
				$employee->UnitOfficeID = $id_dropdown;
				$employee->UnitOfficeSecondaryID = $id_dropdown2;
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

				
				 Mail::send('employs.mails.welcome', array('firstname'=>Input::get('EmpFirstName'), 'username'=>Input::get('EmpID'), 'password'=> $str_random), function($message){
				        $message->to(Input::get('email'), Input::get('EmpFirstName').' '.Input::get('EmpLastName'))->subject('PNP Individual Scorecard!');
				    });
				Session::flash('employ-create', 'Successfully created! You will be given a temporary password: '.$for_message->EmpPassword.' The PERSONNEL can change it when he/she log-in in the employee account. Email is sent to your account');

				return Redirect::route('employs.index');
				//$max = DB::table('employs')
				//->max('id');
				//$fn = DB::table('employs')
				//->where('id','=',$max)
				//->first();
				//$id = 0;
				//return View::make('employeecropphoto')
				//->with('fn',$fn)
				//->with('id',$id);
			}

			return Redirect::route('employs.index')
				->withInput()
				->withErrors($validation)
				->with('message', 'There were validation errors.');

			
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

				return Redirect::route('employs.index');
	 }

	  public function finishedCroppedPhotoEdit()
	 {
	 			
				return Redirect::route('employs.index');
	 }
		
	

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$employee = $this->employee->findOrFail($id);
		$ranks = DB::table('ranks')->get();
		$employees = DB::table('employs')->get();
		$positions= DB::table('positions')->get();
		$supervisors=DB::table('employs')->get();
		$unit_offices = DB::table('unit_offices')->get();
		$unit_office_secondaries = DB::table('unit_office_secondaries')->get();
		$unit_office_tertiaries = DB::table('unit_office_tertiaries')->get();
		$unit_office_quaternaries = DB::table('unit_office_quaternaries')->get();
		return View::make('employs.show', compact('employ'))
			->with('employee', $employee)
		    ->with('employees', $employees)
			->with('ranks',$ranks)
			->with('positions',$positions)
			->with('supervisors',$supervisors)
			->with('unit_offices',$unit_offices)
			->with('unit_office_secondaries',$unit_office_secondaries)
			->with('unit_office_tertiaries',$unit_office_tertiaries)
			->with('unit_office_quaternaries',$unit_office_quaternaries);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		 
		$employee = $this->employee->find($id);
		$emp_id	= $employee->EmpID;
				$ranks = DB::table('ranks')->get();
		$ranks_id= ['Select Rank...'] + DB::table('ranks')->orderBy('RankCode','asc')
		->lists('RankCode','id');
		$positions= DB::table('positions')->get();
		$positions_id= ['Select Position...'] + DB::table('positions')->orderBy('PositionName','asc')
		->lists('PositionName','id');
		
		$supervisors = ['Select your Supervisor...'] + Employ::select(DB::raw('concat(EmpLastName, ", ", EmpFirstName) as full_name'), 'id' )
		->orderBy('EmpLastName', 'asc')->lists('full_name', 'id');
		$unit_offices = DB::table('unit_offices')->get();
		$unit_offices_id= ['Select Unit Office...'] + DB::table('unit_offices')->orderBy('UnitOfficeName','asc')
		->lists('UnitOfficeName','id');
		

		if (is_null($employee))
		{
			return Redirect::route('employs.index');
		}

		return View::make('employs.edit', compact('employ'))
		->with('emp_id', $emp_id)
		->with('employee',$employee)
		->with('ranks',$ranks)
		->with('ranks_id',$ranks_id)
		->with('positions',$positions)
		->with('positions_id',$positions_id)
		->with('unit_offices',$unit_offices)
		->with('unit_offices_id',$unit_offices_id)
		->with('supervisors',$supervisors);
		
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
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
			else
			{
				Session::flash('message', 'The file format must be jpeg and png only');

				//return Redirect::route('employs.index');
				return Redirect::route('employs.edit', $id);
			}
			Input::file('EmpPicturePath')->move($destinationPath, $fileName);
			}
			$employee = $this->employee->find($id);
			$employee->EmpID = Input::get('EmpID');
			$employee->EmpPassword = Input::get('EmpPassword');
			$employee->email = Input::get('email');
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

			//$fn = DB::table('employs')
			//->where('id','=',$id)
			//->first();

			//return View::make('employeecropphoto')
			//	->with('fn',$fn)
			//	->with('id',$id);

			return Redirect::route('employs.show', $id);
		}
	


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->employee->find($id)->delete();

		return Redirect::route('employs.index');
	}

}