<?php

class EmployeeRegistrationController extends BaseController {

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

	public function forgot_password()
	{	$name = null;
		return View::make('forgot_password')
		->with('name', $name);

	}

	public function postforgot_password()
	{	$name = null;
		$email = Input::get('email');
		$badge = Input::get('BadgeNo');
		$employees = DB::table('employs')->where('email', '=', $email)->where('BadgeNo', '=', $badge)->get();

		if($email != null and $employees != null and $badge != null)
		{	
			
			foreach($employees as $employee)
			{	
				Mail::send('employs.mails.forgot', array('firstname'=> $employee->EmpFirstName, 'username'=> $employee->EmpID, 'password'=> $employee->EmpPassword), function($message){
				        $message->to(Input::get('email'))->subject('PNP Individual Scorecard!');
				    });
					Session::flash('forgot_success', 'Password has been successfully sent to your email');
					return Redirect::to('forgot_password')
					->with('name', $name);
			}
		}
		else
		{	
			Session::flash('forgot_error', 'Password not sent. Check your email address');		
			return Redirect::to('forgot_password')
					->with('name', $name);
		}

	}


	public function index()
	{	$name = null;
		$employees = DB::table('employs')->get();
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
		return View::make('employee_registration')
		->with('emp_id', $emp_id)
		->with('name', $name)
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




	public function postindex()
	{	$name = null;
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
		
		$supervisors = Employ::select(DB::raw('concat(RankCode," ",EmpLastName, ", ", EmpFirstName) as full_name'), 'employs.id' )
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
	

		return View::make('employee_registration')
		->with('emp_id', $emp_id)
		->with('employees',$employees)
		->with('name', $name)
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
	{	$name = null;
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
		$unit_offices_tertiaries_id= ['Select Tertiary...'] + DB::table('unit_office_tertiaries')
		->where('UnitOfficeSecondaryID', '=', $id_dropdown2)
		->orderBy('UnitOfficeTertiaryName','asc')
		->lists('UnitOfficeTertiaryName','id');
		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= ['none...'];
		
		return View::make('employee_registration')
		->with('emp_id', $emp_id)
		->with('employees',$employees)
		->with('ranks',$ranks)
		->with('name', $name)
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
	{	$name = null;
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
		$unit_offices_quaternaries_id= ['Select Quaternary...'] + DB::table('unit_office_quaternaries')->where('UnitOfficeTertiaryID', '=', $id_dropdown3)
		->orderBy('UnitOfficeQuaternaryName','asc')
		->lists('UnitOfficeQuaternaryName','id');
	
		return View::make('employee_registration')
		->with('emp_id', $emp_id)
		->with('employees',$employees)
		->with('ranks',$ranks)
		->with('name', $name)
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
	{	$name = null;
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
		return View::make('employee_registration')
		->with('emp_id', $emp_id)
		->with('employees',$employees)
		->with('ranks',$ranks)
		->with('name', $name)
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
			$pos = Input::get('PositionID');
			$ran = Input::get('RankID');
			$bad = Input::get('BadgeNo');
			$badge = DB::table('employs')->where('BadgeNo', '=', $bad)->first();
			$las = Input::get('EmpLastName');
			$fir = Input::get('EmpFirstName');
			$use = Input::get('EmpID');
			$usename = DB::table('employs')->where('EmpId', '=', $use)->first();
			$em = Input::get('email');
			
			$own = Input::get('OwnSupervisorID');

			$visor = Input::get('SupervisorID');
			
			if($visor == null && $own == null)
			{
				Session::flash('email-error', 'Please select a supervisor');

					return Redirect::to('registration/index')
						->withInput();
			}

			if($own == 'true')
			{
				$sup = Input::get('OwnSupervisorID');
			}
			else{
				$sup = Input::get('SupervisorID');
			}



			
if($usename == null)
{			
if($badge == null)
{
if($ran != 0 and $pos != 0 and $sup != null and $bad != '' and $las != '' and $fir != '' and $use != '' and $em != '' and $id_dropdown != 0)
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

				

				Session::flash('employ-create', 'Successfully created! You will be given a temporary password: '.$for_message->EmpPassword.' The PERSONNEL can change it when he/she log-in in the employee account.');

				return Redirect::to('login/employee');
			}

			return Redirect::to('registration/index')
				->withInput()
				->withErrors($validation)
				->with('message', 'There were validation errors.');
	   
			}
		else
			{
					Session::flash('email-error', 'Please check all inputs if valid and not empty. Add your profile picture again.');

					return Redirect::to('registration/index')
					->withInput();
			}


	}

	else
	{
		Session::flash('email-error', 'Badge Number Already Exist or is empty');

					return Redirect::to('registration/index')
					->withInput();
	}

}

	else
	{
		Session::flash('email-error', 'Username Already Exist or is empty');

					return Redirect::to('registration/index')
					->withInput();
	}

}

}