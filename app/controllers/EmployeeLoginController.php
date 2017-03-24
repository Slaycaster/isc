<?php



class EmployeeLoginController extends BaseController
 {
 	public function showLogin()
 {
 	if(Session::has('empid'))
 	{
 		return Redirect::to('employee/dashboard');
 	}
 	else
 	{
		$name = null;
		$users=DB::table('users')
		->get();

		return View::make('employeelogin')
		->with('users',$users)
		->with('name',$name);
 		
 	}

	}

	public function doLogin()

	{

		$rules = array(

			'username'   => 'required', 

			'password'=> 'required|alphaNum|min:4'

			);

		$users=DB::table('users')

		->get();



		$validator = Validator::make(Input::all(), $rules);



		if($validator -> fails()){

			Session::flash('message', 'Username and password required.');

			return Redirect::to('login/employee')

			->withErrors($validator)

			->with('users',$users)

			->withInput(Input::except('password')); 

		}

		else

		{

			$user = Input::get('username');

			$pass = Input::get('password');

			$users=DB::table('users')

		->get();

			$credentials = DB::table('employs')->where('EmpID', '=', $user)->where('EmpPassword', '=', $pass)->get();

			

			if (count($credentials) > 0) {

				foreach ($credentials as $key => $value) {

					$employeename = $value->EmpFirstName. ' ' .$value->EmpLastName;

					$employeepic = $value->EmpPicturePath;

					$employeeid = $value->id;

					$unitoffice = $value->UnitOfficeID;

					$secondaryoffice = $value->UnitOfficeSecondaryID;

					$tertiaryoffice = $value->UnitOfficeTertiaryID;

					$quaternaryoffice = $value->UnitOfficeQuaternaryID;

					if ($value->isActive == 0) //Account currently suspended
					{
						Session::flash('message', 'Account currently suspended! Please contact your administrator for details.');
						return Redirect::to('login/employee');
					}

				}

				Session::put('empid', $employeeid);

				Session::put('empname', $employeename);

				Session::put('emppic', $employeepic);

				Session::put('unitoffice',$unitoffice);

				Session::put('secondaryoffice',$secondaryoffice);

				Session::put('tertiaryoffice',$tertiaryoffice);

				Session::put('quaternaryoffice',$quaternaryoffice);

				return Redirect::to('employee/dashboard')

				->with('users',$users);

			}

			else

			{

				Session::flash('message', 'Sorry! Incorrect username/password. Please try again.');

				return Redirect::to('login/employee');

			}

		}

	}//doLogin



	public function doLogout()

	{

		Session::flush();	

		Session::flash('message2', 'Successfully logged out. Have a good day!');

		return Redirect::to('login/employee');

	}




	public function __construct(Employ $employee)
	{
		$this->employee = $employee;
	}

	public function view()
	{	
		if (Session::has('empid') && Session::has('empname')) {

		$id = Session::get('empid', 'default');
		$employee = $this->employee->findOrFail($id);
		$ranks = DB::table('ranks')->get();
		$positions= DB::table('positions')->get();
		$supervisors=DB::table('employs')->get();
		$unit_offices = DB::table('unit_offices')->get();
		$unit_office_secondaries = DB::table('unit_office_secondaries')->get();
		$unit_office_tertiaries = DB::table('unit_office_tertiaries')->get();
		$unit_office_quaternaries = DB::table('unit_office_quaternaries')->get();
		return View::make('personnel_profile')
			->with('employee', $employee)
			->with('ranks',$ranks)
			->with('positions',$positions)
			->with('supervisors',$supervisors)
			->with('unit_offices',$unit_offices)
			->with('unit_office_secondaries',$unit_office_secondaries)
			->with('unit_office_tertiaries',$unit_office_tertiaries)
			->with('unit_office_quaternaries',$unit_office_quaternaries);
		}
		else{
				Session::flash('message', 'Please login first!');

				return Redirect::to('login/employee');
		}
	}


		public function postRemoveScorecard()
	{

	
		$empid = Session::get('empid', 'default');
		
	
		$today = new DateTime("now");

		$dt_min = new DateTime("monday");

        if ($dt_min > $today)
        {

            $dt_min = new DateTime("last monday");

        }
        $act = DB::table('activity_variants')->where('EmpID', '=', $empid)
        ->where('ActivityVariantDate', '=', $dt_min)
        ->get();

      
       if($act != null)
       {
       		DB::table('daily_accomplishments')
       		->join('measure_variants', 'daily_accomplishments.MeasureVariantID', '=', 'measure_variants.id')
       		->where('measure_variants.EmpID', '=', $empid)
       		->where('Date', '=', $dt_min)
       		->delete();


       		DB::table('measure_variants')
       		->where('EmpID', '=', $empid)
       		->where('MeasureVariantDate', '=', $dt_min)
       		->delete();

       		DB::table('activity_variants')
       		->where('EmpID', '=', $empid)
       		->where('ActivityVariantDate', '=', $dt_min)
       		->delete();


       		DB::table('otherdaily_accomplishment')
       		->join('othermeasure_variants', 'otherdaily_accomplishment.OtherMeasureVariantID', '=', 'othermeasure_variants.id')
       		->where('othermeasure_variants.EmpID', '=', $empid)
       		->where('Date', '=', $dt_min)
       		->delete();


       		DB::table('othermeasure_variants')
       		->where('EmpID', '=', $empid)
       		->where('OtherMeasureVariantDate', '=', $dt_min)
       		->delete();

       		DB::table('other_variants')
       		->where('EmpID', '=', $empid)
       		->where('OtherVariantDate', '=', $dt_min)
       		->delete();


       		DB::table('target_approval')
       		->where('empID', '=', $empid)
       		->where('date', '=', $dt_min)
       		->delete();

       		Session::flash('message_this', 'Submitted Scorecard successfully removed.');
			return Redirect::to('employee/accomplishment-final');

       } 
       else{
       		Session::flash('message_not', 'Scorecard not yet submitted.');
			return Redirect::to('employee/accomplishment-final');
       }
       


	}


	public function showChangePassword()

	{

		if (Session::has('empid') && Session::has('empname')) {

			$id = Session::get('empid', 'default');

			$name = Session::get('empname', 'default');

			$pic = Session::get('emppic', 'default');

			$users = DB::table('users')->get();

			$myrecord = DB::table('employs')
			->where('id','=',$id)
			->get();

			

			foreach($myrecord as $myrecords)
			{
					$unitoffice = DB::table('unit_admins')
					->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
					->get();
			}

			return View::make('change_password')

				->with('id', $id)

				->with('name', $name)

				->with('pic', $pic)

				->with('unitoffice',$unitoffice)

				->with('myrecord',$myrecord)

				->with('users',$users);
		}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/employee');

		}

	}


	public function showChangePhoto()

	{

		if (Session::has('empid') && Session::has('empname')) {

			$id = Session::get('empid', 'default');

			$name = Session::get('empname', 'default');

			$pic = Session::get('emppic', 'default');

			$users = DB::table('users')->get();

			$myrecord = DB::table('employs')
			->where('id','=',$id)
			->get();

			

			foreach($myrecord as $myrecords)
			{
					$unitoffice = DB::table('unit_admins')
					->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
					->get();
			}

			return View::make('edit_photo')

				->with('id', $id)

				->with('name', $name)

				->with('pic', $pic)

				->with('unitoffice',$unitoffice)

				->with('myrecord',$myrecord)

				->with('users',$users);
		}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/employee');

		}

	}


	public function changePhoto()
	{
		$id = Session::get('empid', 'default');
		$name = Session::get('empname', 'default');
		$pic = Session::get('emppic', 'default');
		$file = array('image' => Input::file('EmpPicturePath'));
		$emp_fname = preg_replace('/\s+/', '', $name);

		$users = DB::table('users')->get();

			$myrecord = DB::table('employs')
			->where('id','=',$id)
			->get();

			

			foreach($myrecord as $myrecords)
			{
					$unitoffice = DB::table('unit_admins')
					->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
					->get();
			}

		$picture_path = Input::file('EmpPicturePath');
		if ($picture_path != null)
		{
			$destinationPath = 'employees'; //upload path
			$extension = Input::file('EmpPicturePath')->getClientOriginalExtension(); //getting image extension
			$fileName = $id.''.$emp_fname.'.'.$extension; //renaming image to -> 1FernandezDenimar.jpg
			Input::file('EmpPicturePath')->move($destinationPath, $fileName);

			$empic = 'employees/'.$id.''.$emp_fname.'.'.$extension;

			DB::statement('UPDATE employs SET EmpPicturePath=:sur WHERE id=:res2',
					 array('sur' => $empic, 'res2' => $id) );
			Session::flash('changepw_success', 'Change Profile Picture successful!');


		}
			//$fn = DB::table('employs')
			//->where('id','=',$id)
			//->first();

			//return View::make('cropchangephoto')
			//	->with('fn',$fn)
			//	->with('id',$id)
			//	->with('name',$name)
			//	->with('pic',$pic)
			//	->with('myrecord',$myrecord)
			//	->with('users',$users)
			//	->with('unitoffice',$unitoffice);

		return Redirect::to('employee/change_photo');

	}

	public function processCroppedPhoto()
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
		Session::flash('changepw_success', 'Change Profile Picture successful!');
		return Redirect::to('employee/change_photo');
	}





	 public function changePassword() 

	{

	    $validator = Validator::make(Input::all(),

			array(

				'new_password' 		=> 'required',

				'old_password'	=> 'required',

				'password_again'=> 'required|same:new_password'

			)

		);



		if($validator->fails()) 

		{

			return Redirect::to('employee/change_password')

				->withErrors($validator);



		} else {

			

			$id = Session::get('empid', 'default');



			$old_password = DB::table('employs')->select('EmpPassword as old_password')->where('id', '=', $id)->get();		

			$employees = DB::table('employs')->where('id' ,'=', $id)->get();

			foreach ($old_password as $value) {

				if (Input::get('old_password') == $value->old_password) 

				{

					DB::table('employs')->where('id', '=', $id)->update(array('EmpPassword' => Input::get('new_password')));

					Session::flash('changepw_success', 'Change password success!');

					return Redirect::to('employee/change_password');	

				}

				else

				{

					Session::flash('changepw_error', 'Invalid old password!');

					return Redirect::to('employee/change_password');

				}



			}
 		}
	}


public function showGraphPersonnel()
	{
if (Session::has('empid') && Session::has('empname')) {

			$id = Session::get('empid', 'default');

			$name = Session::get('empname', 'default');

			$pic = Session::get('emppic', 'default');

			$employs = DB::table('ranks')
							->join('employs', 'ranks.id', '=', 'employs.RankID')

							->where('employs.SupervisorID', '=', $id)
							->where('isActive', '=', 1)

							->get();

			$myrecord = DB::table('employs')
			->where('id','=',$id)
			->get();

			

			foreach($myrecord as $myrecords)
			{
					$unitoffice = DB::table('unit_admins')
					->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
					->get();
			}
			$employ = DB::table('employs')
			->where('id', '=', $id)
			->first();

			$users = DB::table('users')->get();
			$CurrentDate = date('Y-m-d');
			$CurrentDateFormat = "";
			if(date("w",strtotime($CurrentDate)) == 0)
			{
				$CurrentDateFormat = 6;
			}
			else
			{
				$CurrentDateFormat = date("w",strtotime($CurrentDate.'-'. '1'.'days'));
			}
			$StartDate = date("Y/m/d", strtotime($CurrentDate.'-'. $CurrentDateFormat. 'days'));
			$EndDate = date("Y/m/d", strtotime($StartDate.'+'. '6' . 'days'));

			$StartDateCovered = "";
	        $EndDateCovered = "";			

			$StartDateFormatter = date("m", strtotime($StartDate));
		    $EndDateFormatter = date("m", strtotime($EndDate));
		    if($StartDateFormatter==$EndDateFormatter)
		    {
		    	$StartDateCovered = date("F d-", strtotime($StartDate));
	        	$EndDateCovered = date("d, Y", strtotime($EndDate));
		    }
		    else
		    {
		    	$StartDateCovered = date("M d, Y - ", strtotime($StartDate));
	        	$EndDateCovered = date("M d, Y", strtotime($EndDate));
		    }

		    $DateCovered = $StartDateCovered.$EndDateCovered;


		    $LastWeekStartDate = date("Y/m/d", strtotime($StartDate.'-'. '7' . 'days'));
			$LastWeekEndDate = date("Y/m/d", strtotime($StartDate.'-'. '1' . 'days'));

			$LastWeekStartDateCovered = "";
	        $LastWeekEndDateCovered = "";			

			$LastWeekStartDateFormatter = date("m", strtotime($LastWeekStartDate));
		    $LastWeekEndDateFormatter = date("m", strtotime($LastWeekEndDate));
		    if($LastWeekStartDateFormatter==$LastWeekEndDateFormatter)
		    {
		    	$LastWeekStartDateCovered = date("F d-", strtotime($LastWeekStartDate));
	        	$LastWeekEndDateCovered = date("d, Y", strtotime($LastWeekEndDate));
		    }
		    else
		    {
		    	$LastWeekStartDateCovered = date("M d, Y - ", strtotime($LastWeekStartDate));
	        	$LastWeekEndDateCovered = date("M d, Y", strtotime($LastWeekEndDate));
		    }

		    $LastWeekDateCovered = $LastWeekStartDateCovered.$LastWeekEndDateCovered;



		$today = new DateTime("now");

		$dt_min = new DateTime("monday");

        if ($dt_min > $today)
        {

            $dt_min = new DateTime("last monday");

        }
		
		return View::make('personnelselectemp')
			->with('employs', $employs)
			->with('users', $users)
			->with('DateCovered', $DateCovered)
			->with('myrecord', $myrecord)
			->with('pic', $pic)
			->with('name', $name)
			->with('unitoffice', $unitoffice)
			->with('LastWeekDateCovered', $LastWeekDateCovered);
		}
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/employee');
			}
	}
	public function postGraphPersonnel()
	{
		if (Session::has('empid') && Session::has('empname')) {

			$id = Session::get('empid', 'default');

			$name = Session::get('empname', 'default');

			$pic = Session::get('emppic', 'default');

			$myrecord = DB::table('employs')
			->where('id','=',$id)
			->get();

			

			foreach($myrecord as $myrecords)
			{
					$unitoffice = DB::table('unit_admins')
					->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
					->get();
			}
			$employs = DB::table('ranks')
							->join('employs', 'ranks.id', '=', 'employs.RankID')

							->where('employs.SupervisorID', '=', $id)
							->where('isActive', '=', 1)

							->get();

			$employ = DB::table('employs')
			->where('id', '=', $id)
			->first();

			$users = DB::table('users')->get();
				
				$StartDate = Input::get('StartDate');
				$StartDate = date("Y/m/d",strtotime($StartDate));
				$EndDate = date("Y/m/d", strtotime($StartDate.'+'. '6' . 'days'));


				$empid = Input::get('emp_id');
				$employsname = DB::table('ranks')	
							->join('employs', 'ranks.id', '=', 'employs.RankID')
							->where('employs.id', '=', $empid)
							->get();

				$summations = DB::table('measures')
							->join('measure_variants', 'measure_variants.MeasureID', '=', 'measures.id')
							->join('daily_accomplishments', 'daily_accomplishments.MeasureVariantID', '=', 'measure_variants.id')
							->where('measures.EmpID', '=', $empid)
							->whereBetween('daily_accomplishments.Date',array($StartDate, $EndDate))				
							->get();
			
						return View::make('personnelgraph')
							->with('summations', $summations)
							->with('employsname', $employsname)
							->with('myrecord', $myrecord)
							->with('pic', $pic)
							->with('users', $users)
							->with('unitoffice', $unitoffice)
							->with('name', $name)
							->with('StartDate', $StartDate)
							->with('empid', $empid);
			}
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/employee');
			}
	}


public function showGraph()
	{
		if (Session::has('empid') && Session::has('empname')) {

			$id = Session::get('empid', 'default');

			$name = Session::get('empname', 'default');

			$pic = Session::get('emppic', 'default');
			
			$myrecord = DB::table('employs')
			->where('id','=',$id)
			->get();

			

			foreach($myrecord as $myrecords)
			{
					$unitoffice = DB::table('unit_admins')
					->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
					->get();
			}
		$users = DB::table('users')->get();
		$employs = DB::table('employs')
		->where('employs.isActive', '!=', '0')
		->get();

		$CurrentDate = date('Y-m-d');
			$CurrentDateFormat = "";
			if(date("w",strtotime($CurrentDate)) == 0)
			{
				$CurrentDateFormat = 6;
			}
			else
			{
				$CurrentDateFormat = date("w",strtotime($CurrentDate.'-'. '1'.'days'));
			}
			$StartDate = date("Y/m/d", strtotime($CurrentDate.'-'. $CurrentDateFormat. 'days'));
			$EndDate = date("Y/m/d", strtotime($StartDate.'+'. '6' . 'days'));

			$StartDateCovered = "";
	        $EndDateCovered = "";			

			$StartDateFormatter = date("m", strtotime($StartDate));
		    $EndDateFormatter = date("m", strtotime($EndDate));
		    if($StartDateFormatter==$EndDateFormatter)
		    {
		    	$StartDateCovered = date("F d-", strtotime($StartDate));
	        	$EndDateCovered = date("d, Y", strtotime($EndDate));
		    }
		    else
		    {
		    	$StartDateCovered = date("M d, Y - ", strtotime($StartDate));
	        	$EndDateCovered = date("M d, Y", strtotime($EndDate));
		    }

		    $DateCovered = $StartDateCovered.$EndDateCovered;


		    $LastWeekStartDate = date("Y/m/d", strtotime($StartDate.'-'. '7' . 'days'));
			$LastWeekEndDate = date("Y/m/d", strtotime($StartDate.'-'. '1' . 'days'));

			$LastWeekStartDateCovered = "";
	        $LastWeekEndDateCovered = "";			

			$LastWeekStartDateFormatter = date("m", strtotime($LastWeekStartDate));
		    $LastWeekEndDateFormatter = date("m", strtotime($LastWeekEndDate));
		    if($LastWeekStartDateFormatter==$LastWeekEndDateFormatter)
		    {
		    	$LastWeekStartDateCovered = date("F d-", strtotime($LastWeekStartDate));
	        	$LastWeekEndDateCovered = date("d, Y", strtotime($LastWeekEndDate));
		    }
		    else
		    {
		    	$LastWeekStartDateCovered = date("M d, Y - ", strtotime($LastWeekStartDate));
	        	$LastWeekEndDateCovered = date("M d, Y", strtotime($LastWeekEndDate));
		    }

		    $LastWeekDateCovered = $LastWeekStartDateCovered.$LastWeekEndDateCovered;



		$today = new DateTime("now");

		$dt_min = new DateTime("monday");

        if ($dt_min > $today)
        {

            $dt_min = new DateTime("last monday");

        }
		
		
		return View::make('EMPselectdate')
			->with('employs', $employs)
			->with('users', $users)
			->with('DateCovered', $DateCovered)
			->with('id', $id)
			->with('name', $name)
			->with('pic', $pic)
			->with('myrecord',$myrecord)
			->with('unitoffice',$unitoffice)
			->with('LastWeekDateCovered', $LastWeekDateCovered);
		}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/employee');

		}
	}
	public function postGraph()
	{
		if (Session::has('empid') && Session::has('empname')) {

			$id = Session::get('empid', 'default');

			$name = Session::get('empname', 'default');

			$pic = Session::get('emppic', 'default');
			
			$myrecord = DB::table('employs')
			->where('id','=',$id)
			->get();

			

			foreach($myrecord as $myrecords)
			{
					$unitoffice = DB::table('unit_admins')
					->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
					->get();
			}
		$users = DB::table('users')->get();
	

		$StartDate = Input::get('StartDate');
		$StartDate = date("Y/m/d",strtotime($StartDate));
		$EndDate = date("Y/m/d", strtotime($StartDate.'+'. '6' . 'days'));

		$employsname = DB::table('ranks')	
					->join('employs', 'ranks.id', '=', 'employs.RankID')
					->where('employs.id', '=', $id)
					->get();

		$summations = DB::table('measures')
					->join('measure_variants', 'measure_variants.MeasureID', '=', 'measures.id')
					->join('daily_accomplishments', 'daily_accomplishments.MeasureVariantID', '=', 'measure_variants.id')
					->where('measures.EmpID', '=', $id)
					->whereBetween('daily_accomplishments.Date',array($StartDate, $EndDate))				
					->get();


		
		return View::make('empgraph')
			->with('summations', $summations)
			->with('employsname', $employsname)
			->with('StartDate', $StartDate)
			->with('id', $id)
			->with('name', $name)
			->with('pic', $pic)
			->with('myrecord',$myrecord)
			->with('users', $users)
			->with('unitoffice',$unitoffice)
			->with('empid', $id);

		}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/employee');

		}
	}

	public function showDashboard()

	{
		if (Session::has('empid') && Session::has('empname')) {

			$id = Session::get('empid', 'default');

			$name = Session::get('empname', 'default');

			$pic = Session::get('emppic', 'default');

			$employs = DB::table('ranks')
							->join('employs', 'ranks.id', '=', 'employs.RankID')

							->where('employs.SupervisorID', '=', $id)
							->where('isActive', '=', 1)

							->get();

			$employ = DB::table('employs')
			->where('id', '=', $id)
			->first();

			$users = DB::table('users')->get();

			#DAGDAG
			$iffirsttime = DB::table('main_activities')
			->where('EmpID','=',$id)
			->first();

			$CurrentDate = date('Y-m-d');
			$CurrentDateFormat = "";
			if(date("w",strtotime($CurrentDate)) == 0)
			{
				$CurrentDateFormat = 6;
			}
			else
			{
				$CurrentDateFormat = date("w",strtotime($CurrentDate.'-'. '1'.'days'));
			}
			$StartDate = date("Y/m/d", strtotime($CurrentDate.'-'. $CurrentDateFormat. 'days'));
			$EndDate = date("Y/m/d", strtotime($StartDate.'+'. '6' . 'days'));

			$StartDateCovered = "";
	        $EndDateCovered = "";			

			$StartDateFormatter = date("m", strtotime($StartDate));
		    $EndDateFormatter = date("m", strtotime($EndDate));
		    if($StartDateFormatter==$EndDateFormatter)
		    {
		    	$StartDateCovered = date("F d-", strtotime($StartDate));
	        	$EndDateCovered = date("d, Y", strtotime($EndDate));
		    }
		    else
		    {
		    	$StartDateCovered = date("M d, Y - ", strtotime($StartDate));
	        	$EndDateCovered = date("M d, Y", strtotime($EndDate));
		    }

		    $DateCovered = $StartDateCovered.$EndDateCovered;


		    $LastWeekStartDate = date("Y/m/d", strtotime($StartDate.'-'. '7' . 'days'));
			$LastWeekEndDate = date("Y/m/d", strtotime($StartDate.'-'. '1' . 'days'));

			$LastWeekStartDateCovered = "";
	        $LastWeekEndDateCovered = "";			

			$LastWeekStartDateFormatter = date("m", strtotime($LastWeekStartDate));
		    $LastWeekEndDateFormatter = date("m", strtotime($LastWeekEndDate));
		    if($LastWeekStartDateFormatter==$LastWeekEndDateFormatter)
		    {
		    	$LastWeekStartDateCovered = date("F d-", strtotime($LastWeekStartDate));
	        	$LastWeekEndDateCovered = date("d, Y", strtotime($LastWeekEndDate));
		    }
		    else
		    {
		    	$LastWeekStartDateCovered = date("M d, Y - ", strtotime($LastWeekStartDate));
	        	$LastWeekEndDateCovered = date("M d, Y", strtotime($LastWeekEndDate));
		    }

		    $LastWeekDateCovered = $LastWeekStartDateCovered.$LastWeekEndDateCovered;


			$myrecord = DB::table('employs')
			->where('id','=',$id)
			->get();

			

			foreach($myrecord as $myrecords)
			{
					$unitoffice = DB::table('unit_admins')
					->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
					->get();
			}

				$today = new DateTime("now");

			 $dt_min = new DateTime("monday");

            if ($dt_min > $today)

            {

                $dt_min = new DateTime("last monday");

            }

			$submitted = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('target_approval.status', '=', 'submitted')
						->where('employs.SupervisorID', '=', $id)
						->where('employs.isActive', '=', 1)
						->where('date', '=', $dt_min)
						->groupBy('employs.id')
						->get();

			$didNotSubmitted = DB::table('employs')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('employs.SupervisorID', '=', $id)
						->where('employs.isActive', '=', 1)
						->whereNotIn('employs.id', function($q2)
						{
							//===================================COPY PASTE
							$CurrentDate = date('Y-m-d');
							$CurrentDateFormat = "";
							if(date("w",strtotime($CurrentDate)) == 0)
							{
								$CurrentDateFormat = 6;
							}
							else
							{
								$CurrentDateFormat = date("w",strtotime($CurrentDate.'-'. '1'.'days'));
							}
							$StartDate = date("Y/m/d", strtotime($CurrentDate.'-'. $CurrentDateFormat. 'days'));
							$EndDate = date("Y/m/d", strtotime($StartDate.'+'. '6' . 'days'));
							$today = new DateTime("now");
							$dt_min = new DateTime("monday");
				            if ($dt_min > $today)
				            {
				                $dt_min = new DateTime("last monday");
				            }
				            $LastWeekStartDate = date("Y/m/d", strtotime($StartDate.'-'. '7' . 'days'));
				            //COPY PASTE=======================================

							$q2->select('empID')->from('target_approval')
								->where('target_approval.status', '=', 'submitted')
								->where('target_approval.date', '=', $LastWeekStartDate)
								->orWhere('target_approval.date', '=', $dt_min);
						})
						
						
						->get();
			

			$lastSubmitted = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('target_approval.status', '=', 'submitted')
						->where('employs.SupervisorID', '=', $id)
						->where('employs.isActive', '=', 1)
						->where('date', '=', $LastWeekStartDate)
						->groupBy('employs.id')
						->get();

			$noScorecard = DB::table('employs')
				->where('employs.SupervisorID', '=', $id)
				->where('employs.isActive', '=', 1)
				->whereNotIn('employs.id', function($q)
					{
						$q->select('empID')->from('target_approval');
					})
				->count();
		
			$noScorecardList = DB::table('employs')
				->join('ranks', 'ranks.id', '=', 'employs.RankID')
				->where('employs.SupervisorID', '=', $id)
				->where('employs.isActive', '=', 1)
				->whereNotIn('employs.id', function($q)
					{
						$q->select('empID')->from('target_approval');
					})
				->get();
			
			$whosub = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->where('target_approval.status', '=', 'submitted')
						->where('employs.SupervisorID', '=', $id)
						->where('employs.isActive', '=', 1)
						->where('date', '=', $dt_min)
						->distinct('target_approval.empID')
						->count('target_approval.empID');

			$whoDidNotSub = DB::table('employs')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('employs.SupervisorID', '=', $id)
						->where('employs.isActive', '=', 1)
						->whereNotIn('employs.id', function($q2)
						{
							//===================================COPY PASTE
							$CurrentDate = date('Y-m-d');
							$CurrentDateFormat = "";
							if(date("w",strtotime($CurrentDate)) == 0)
							{
								$CurrentDateFormat = 6;
							}
							else
							{
								$CurrentDateFormat = date("w",strtotime($CurrentDate.'-'. '1'.'days'));
							}
							$StartDate = date("Y/m/d", strtotime($CurrentDate.'-'. $CurrentDateFormat. 'days'));
							$EndDate = date("Y/m/d", strtotime($StartDate.'+'. '6' . 'days'));
							$today = new DateTime("now");
							$dt_min = new DateTime("monday");
				            if ($dt_min > $today)
				            {
				                $dt_min = new DateTime("last monday");
				            }
				            $LastWeekStartDate = date("Y/m/d", strtotime($StartDate.'-'. '7' . 'days'));
				            //COPY PASTE=======================================

							$q2->select('empID')->from('target_approval')
								->where('target_approval.status', '=', 'submitted')
								->where('target_approval.date', '=', $LastWeekStartDate)
								->orWhere('target_approval.date', '=', $dt_min);
						})
						
						
						->count('employs.id');

			/*$whoDidNotSub = DB::table('target_approval')
							->join('employs', 'target_approval.EmpID', '=', 'employs.id')
							->join('ranks', 'ranks.id', '=', 'employs.RankID')
							->where('employs.SupervisorID', '=', $id)
							->where('target_approval.date', '!=', $dt_min)
							->where('target_approval.status', '=', 'submitted')
							->distinct('target_approval.empID')
							->count('target_approval.empID');*/
			

			$whoSubLast = DB::table('target_approval')
							->join('employs', 'target_approval.EmpID', '=', 'employs.id')
							->where('target_approval.status', '=', 'submitted')
							->where('employs.SupervisorID', '=', $id)
							->where('employs.isActive', '=', 1)
							->where('date', '=', $LastWeekStartDate)
							->distinct('target_approval.empID')
							->count('target_approval.empID');
						
			$pending =DB::table('employs')
			->join('ranks', 'ranks.id', '=', 'employs.RankID')

			->join('target_approval','employs.id','=','target_approval.empID')


			->where('target_approval.status','=','pending')

			->where('employs.SupervisorID','=',$id)

			->where('employs.isActive', '=', 1)

			->where('date', '=', $dt_min)

			->get();

			$supervisor = DB::table('employs')
			->where('employs.id', '=', $id)
			->first();

			$supervisorname = DB::table('employs')
			->where('employs.id', '=', $supervisor->SupervisorID)
			->first();

			//dd($supervisor->SupervisorID);

			$supervisorrank = DB::table('ranks')
			->where('ranks.id', '=', $supervisorname->RankID)
			->first();
		

			$notification = DB::table('target_approval')
			->where('empID','=',$id)
			->where('date', '=', $dt_min)
			->get();


			$remarks = DB::table('approval_remarks')
			->where('EmpID','=',$id)
			->where('RemarksDate', '=', $dt_min)
			->first();

		
			
			return View::make('employeedashboard')

				->with('id', $id)

				->with('unitoffice',$unitoffice)

				->with('name', $name)

				->with('myrecord',$myrecord)

				->with('remarks',$remarks)

				->with('pic', $pic)

				->with('employ', $employ)

				->with('employs', $employs)

				->with('pending',$pending)

				->with('notification',$notification)

				->with('supervisor', $supervisor)

				->with('supervisorname',$supervisorname)

				->with('supervisorrank',$supervisorrank)

				->with('DateCovered', $DateCovered)

				->with('LastWeekDateCovered', $LastWeekDateCovered)

				->with('submitted', $submitted)

				->with('didNotSubmitted', $didNotSubmitted)

				->with('noScorecard', $noScorecard)
			
				->with('noScorecardList', $noScorecardList)

				->with('lastSubmitted', $lastSubmitted)

				->with('whosub', $whosub)

				->with('whoDidNotSub', $whoDidNotSub)

				->with('whoSubLast', $whoSubLast)

				->with('users',$users)

				->with('iffirsttime',$iffirsttime);

		}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/employee');

		}

	}

	public function subordinateReport()
    {
    	$id = Session::get('empid', 'default');

    	$employs = DB::table('ranks')
							->join('employs', 'ranks.id', '=', 'employs.RankID')

							->where('employs.SupervisorID', '=', $id)
							->where('isActive', '=', 1)

							->select('employs.id as id', 'employs.EmpLastName as LastName', 'employs.EmpFirstName as FirstName', 'ranks.RankCode as Rank' );

		 return Datatables::of($employs)

		

        ->add_column('Select', '{{Form::radio(\'emp_id\', $id, false)}}')
        ->remove_column('id')
        ->make(true);					

    }


	
//Notification Submitted Last week

	public function notifSubmitted()
    {
    	$id = Session::get('empid', 'default');
    	$CurrentDate = date('Y-m-d');
			$CurrentDateFormat = "";
			if(date("w",strtotime($CurrentDate)) == 0)
			{
				$CurrentDateFormat = 6;
			}
			else
			{
				$CurrentDateFormat = date("w",strtotime($CurrentDate.'-'. '1'.'days'));
			}
			$StartDate = date("Y/m/d", strtotime($CurrentDate.'-'. $CurrentDateFormat. 'days'));
			$EndDate = date("Y/m/d", strtotime($StartDate.'+'. '6' . 'days'));

			$StartDateCovered = "";
	        $EndDateCovered = "";			

			$StartDateFormatter = date("m", strtotime($StartDate));
		    $EndDateFormatter = date("m", strtotime($EndDate));
		    if($StartDateFormatter==$EndDateFormatter)
		    {
		    	$StartDateCovered = date("F d-", strtotime($StartDate));
	        	$EndDateCovered = date("d, Y", strtotime($EndDate));
		    }
		    else
		    {
		    	$StartDateCovered = date("M d, Y - ", strtotime($StartDate));
	        	$EndDateCovered = date("M d, Y", strtotime($EndDate));
		    }

		    $DateCovered = $StartDateCovered.$EndDateCovered;


		    $LastWeekStartDate = date("Y/m/d", strtotime($StartDate.'-'. '7' . 'days'));
			$LastWeekEndDate = date("Y/m/d", strtotime($StartDate.'-'. '1' . 'days'));

			$LastWeekStartDateCovered = "";
	        $LastWeekEndDateCovered = "";			

			$LastWeekStartDateFormatter = date("m", strtotime($LastWeekStartDate));
		    $LastWeekEndDateFormatter = date("m", strtotime($LastWeekEndDate));
		    if($LastWeekStartDateFormatter==$LastWeekEndDateFormatter)
		    {
		    	$LastWeekStartDateCovered = date("F d-", strtotime($LastWeekStartDate));
	        	$LastWeekEndDateCovered = date("d, Y", strtotime($LastWeekEndDate));
		    }
		    else
		    {
		    	$LastWeekStartDateCovered = date("M d, Y - ", strtotime($LastWeekStartDate));
	        	$LastWeekEndDateCovered = date("M d, Y", strtotime($LastWeekEndDate));
		    }

		    $LastWeekDateCovered = $LastWeekStartDateCovered.$LastWeekEndDateCovered;



		$today = new DateTime("now");

		$dt_min = new DateTime("monday");

        if ($dt_min > $today)
        {

            $dt_min = new DateTime("last monday");

        }


        $lastSubmitted = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('target_approval.status', '=', 'submitted')
						->where('employs.SupervisorID', '=', $id)
						->where('employs.isActive', '=', 1)
						->where('date', '=', $LastWeekStartDate)
						->groupBy('employs.id')
						->orderBy('ranks.Hierarchy')
						->select('employs.id as id', 'employs.EmpPicturePath as picpath', 'employs.EmpLastName as lastname', 'employs.EmpFirstName as firstname', 'ranks.RankCode as rank' );


        return Datatables::of($lastSubmitted)
        ->add_column('Pictures', '<img style = "height:60px; width:60px;" src="{{URL::asset($picpath)}}">')
        ->add_column('Actions', '<a class = \'btn btn-primary\' href="{{ URL::to(\'SubmittedScorecardForLastWeek/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'SubmittedScorecardForLastWeek/\' . $id) }}\', \'newwindow\'); return false;">View</a>')
        ->remove_column('id')
        ->remove_column('picpath')
        ->make(true);
    }
          

//Notif Submitted this week

public function notifSubmittedThisWeek()
    {
    	$id = Session::get('empid', 'default');
    	$CurrentDate = date('Y-m-d');
			$CurrentDateFormat = "";
			if(date("w",strtotime($CurrentDate)) == 0)
			{
				$CurrentDateFormat = 6;
			}
			else
			{
				$CurrentDateFormat = date("w",strtotime($CurrentDate.'-'. '1'.'days'));
			}
			$StartDate = date("Y/m/d", strtotime($CurrentDate.'-'. $CurrentDateFormat. 'days'));
			$EndDate = date("Y/m/d", strtotime($StartDate.'+'. '6' . 'days'));

			$StartDateCovered = "";
	        $EndDateCovered = "";			

			$StartDateFormatter = date("m", strtotime($StartDate));
		    $EndDateFormatter = date("m", strtotime($EndDate));
		    if($StartDateFormatter==$EndDateFormatter)
		    {
		    	$StartDateCovered = date("F d-", strtotime($StartDate));
	        	$EndDateCovered = date("d, Y", strtotime($EndDate));
		    }
		    else
		    {
		    	$StartDateCovered = date("M d, Y - ", strtotime($StartDate));
	        	$EndDateCovered = date("M d, Y", strtotime($EndDate));
		    }

		    $DateCovered = $StartDateCovered.$EndDateCovered;


		    $LastWeekStartDate = date("Y/m/d", strtotime($StartDate.'-'. '7' . 'days'));
			$LastWeekEndDate = date("Y/m/d", strtotime($StartDate.'-'. '1' . 'days'));

			$LastWeekStartDateCovered = "";
	        $LastWeekEndDateCovered = "";			

			$LastWeekStartDateFormatter = date("m", strtotime($LastWeekStartDate));
		    $LastWeekEndDateFormatter = date("m", strtotime($LastWeekEndDate));
		    if($LastWeekStartDateFormatter==$LastWeekEndDateFormatter)
		    {
		    	$LastWeekStartDateCovered = date("F d-", strtotime($LastWeekStartDate));
	        	$LastWeekEndDateCovered = date("d, Y", strtotime($LastWeekEndDate));
		    }
		    else
		    {
		    	$LastWeekStartDateCovered = date("M d, Y - ", strtotime($LastWeekStartDate));
	        	$LastWeekEndDateCovered = date("M d, Y", strtotime($LastWeekEndDate));
		    }

		    $LastWeekDateCovered = $LastWeekStartDateCovered.$LastWeekEndDateCovered;



		$today = new DateTime("now");

		$dt_min = new DateTime("monday");

        if ($dt_min > $today)
        {

            $dt_min = new DateTime("last monday");

        }


			$submitted = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('target_approval.status', '=', 'submitted')
						->where('employs.SupervisorID', '=', $id)
						->where('employs.isActive', '=', 1)
						->where('date', '=', $dt_min)
						->groupBy('employs.id')
						->orderBy('ranks.Hierarchy')
						->select('employs.id as id', 'employs.EmpPicturePath as picpath', 'employs.EmpLastName as lastname', 'employs.EmpFirstName as firstname', 'ranks.RankCode as rank' );
        
	
        return Datatables::of($submitted)
        ->add_column('Pictures', '<img style = "height:60px; width:60px;" src="{{URL::asset($picpath)}}">')
        ->add_column('Actions', '<a class = \'btn btn-primary\' href="{{ URL::to(\'SubmittedScorecardForThisWeek/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'SubmittedScorecardForThisWeek/\' . $id) }}\', \'newwindow\'); return false;">View</a>')
        ->remove_column('id')
        ->remove_column('picpath')
        ->make(true);
    }


//notif did not submitted

    public function notifDidNotSubmitted()
    {
    	$id = Session::get('empid', 'default');
    	$CurrentDate = date('Y-m-d');
			$CurrentDateFormat = "";
			if(date("w",strtotime($CurrentDate)) == 0)
			{
				$CurrentDateFormat = 6;
			}
			else
			{
				$CurrentDateFormat = date("w",strtotime($CurrentDate.'-'. '1'.'days'));
			}
			$StartDate = date("Y/m/d", strtotime($CurrentDate.'-'. $CurrentDateFormat. 'days'));
			$EndDate = date("Y/m/d", strtotime($StartDate.'+'. '6' . 'days'));

			$StartDateCovered = "";
	        $EndDateCovered = "";			

			$StartDateFormatter = date("m", strtotime($StartDate));
		    $EndDateFormatter = date("m", strtotime($EndDate));
		    if($StartDateFormatter==$EndDateFormatter)
		    {
		    	$StartDateCovered = date("F d-", strtotime($StartDate));
	        	$EndDateCovered = date("d, Y", strtotime($EndDate));
		    }
		    else
		    {
		    	$StartDateCovered = date("M d, Y - ", strtotime($StartDate));
	        	$EndDateCovered = date("M d, Y", strtotime($EndDate));
		    }

		    $DateCovered = $StartDateCovered.$EndDateCovered;


		    $LastWeekStartDate = date("Y/m/d", strtotime($StartDate.'-'. '7' . 'days'));
			$LastWeekEndDate = date("Y/m/d", strtotime($StartDate.'-'. '1' . 'days'));

			$LastWeekStartDateCovered = "";
	        $LastWeekEndDateCovered = "";			

			$LastWeekStartDateFormatter = date("m", strtotime($LastWeekStartDate));
		    $LastWeekEndDateFormatter = date("m", strtotime($LastWeekEndDate));
		    if($LastWeekStartDateFormatter==$LastWeekEndDateFormatter)
		    {
		    	$LastWeekStartDateCovered = date("F d-", strtotime($LastWeekStartDate));
	        	$LastWeekEndDateCovered = date("d, Y", strtotime($LastWeekEndDate));
		    }
		    else
		    {
		    	$LastWeekStartDateCovered = date("M d, Y - ", strtotime($LastWeekStartDate));
	        	$LastWeekEndDateCovered = date("M d, Y", strtotime($LastWeekEndDate));
		    }

		    $LastWeekDateCovered = $LastWeekStartDateCovered.$LastWeekEndDateCovered;



		$today = new DateTime("now");

		$dt_min = new DateTime("monday");

        if ($dt_min > $today)
        {

            $dt_min = new DateTime("last monday");

        }


        $didNotSubmitted = DB::table('employs')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('employs.SupervisorID', '=', $id)
						->where('employs.isActive', '=', 1)
						->whereNotIn('employs.id', function($q2)
						{
							//===================================COPY PASTE
							$CurrentDate = date('Y-m-d');
							$CurrentDateFormat = "";
							if(date("w",strtotime($CurrentDate)) == 0)
							{
								$CurrentDateFormat = 6;
							}
							else
							{
								$CurrentDateFormat = date("w",strtotime($CurrentDate.'-'. '1'.'days'));
							}
							$StartDate = date("Y/m/d", strtotime($CurrentDate.'-'. $CurrentDateFormat. 'days'));
							$EndDate = date("Y/m/d", strtotime($StartDate.'+'. '6' . 'days'));
							$today = new DateTime("now");
							$dt_min = new DateTime("monday");
				            if ($dt_min > $today)
				            {
				                $dt_min = new DateTime("last monday");
				            }
				            $LastWeekStartDate = date("Y/m/d", strtotime($StartDate.'-'. '7' . 'days'));
				            //COPY PASTE=======================================

							$q2->select('empID')->from('target_approval')
								->where('target_approval.status', '=', 'submitted')
								->where('target_approval.date', '=', $LastWeekStartDate)
								->orWhere('target_approval.date', '=', $dt_min);
						})
						
						->orderBy('ranks.Hierarchy')
						->select('employs.id as id', 'employs.EmpPicturePath as picpath', 'employs.EmpLastName as lastname', 'employs.EmpFirstName as firstname', 'ranks.RankCode as rank' );
        


      
        return Datatables::of($didNotSubmitted)
        ->add_column('Pictures', '<img style = "height:60px; width:60px;" src="{{URL::asset($picpath)}}">')
 
        ->remove_column('id')
        ->remove_column('picpath')
        ->make(true);

    }
          



	public function createScorecard()

	{

		if (Session::has('empid') && Session::has('empname')) {

			$id = Session::get('empid', 'default');

			$name = Session::get('empname', 'default');

			$pic = Session::get('emppic', 'default');

			$perspectives = DB::table('perspectives')->get();

			$objectives = DB::table('objectives')->get();

			$main_activities = DB::table('main_activities')->where('EmpID', '=', $id)->get();

			$sub_activities = DB::table('sub_activities')->where('EmpID', '=', $id)->get();

			$measures = DB::table('measures')->where('EmpID', '=', $id)->get();

			$users = DB::table('users')->get();

			$myrecord = DB::table('employs')
			->where('id','=',$id)
			->get();

			

			foreach($myrecord as $myrecords)
			{
					$unitoffice = DB::table('unit_admins')
					->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
					->get();
			}

			$emp_activities = DB::table('main_activities')

				->join('employs','main_activities.EmpID','=','employs.id')

				->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')

				->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')

				->where('employs.id','=',$id)

    			->where('main_activities.EmpID', '=', $id)

    			->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    				AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
		    				AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
		    				AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")

    			->orderBy('main_activities.id','asc')

    			->orderBy('sub_activities.id','asc')

    			->get();

			return View::make('scorecard')

				->with('id', $id)

				->with('name', $name)

				->with('pic', $pic)

				->with('perspectives',$perspectives)

				->with('objectives',$objectives)

				->with('main_activities', $main_activities)

				->with('sub_activities', $sub_activities)

				->with('measures', $measures)

				->with('emp_activities', $emp_activities)

				->with('users',$users)

				->with('unitoffice',$unitoffice)

				->with('myrecord',$myrecord);

		}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/employee');

		}

	}

	public function editEmployeeMainActivity()
		{
			if (Session::has('empid') && Session::has('empname')) {

			$id = Session::get('empid', 'default');

			$name = Session::get('empname', 'default');

			$pic = Session::get('emppic', 'default');
			$users = DB::table('users')->get();
			$myrecord = DB::table('employs')
			->where('id','=',$id)
			->get();

			

			foreach($myrecord as $myrecords)
			{
					$unitoffice = DB::table('unit_admins')
					->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
					->get();
			}
			


			$main_activities = DB::table('employs')
			->join('main_activities','employs.id','=','main_activities.EmpID')
			->where('employs.id','=',$id)
		   	->where('main_activities.EmpID','=',$id)
			->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
		    						AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
		    						AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
			->get();

			return View::make('employeeeditmain')
			->with('main_activities',$main_activities)
			->with('id',$id)
			->with('name', $name)
			->with('pic', $pic)
			->with('users',$users)
			->with('myrecord',$myrecord)
			->with('unitoffice',$unitoffice);

			}
		

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/employee');

		}
		}

		public function postEditMainEmp()
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
            return Redirect::to('employee/employeeeditmain');
		}





	public function postCreateScoreCard()

	{

		$id = Session::get('empid', 'default');

		$name = Session::get('empname', 'default');

		$pic = Session::get('emppic', 'default');

		$unit = Session::get('unitoffice' , 'default');
		$secon = Session::get('secondaryoffice','default');
		$tertia = Session::get('tertiaryoffice','default');
		$quater = Session::get('quaternaryoffice','default');

		$MainActivity =Input::get('main_activity');

		$SubActivities =Input::get('sub_activities');

		$count = DB::table('main_activities')->where('EmpID', '=', $id)->count();

		if($count == 0){

			$count = 1;

		}

		else{

		$count = $count + 1;

		}

		$users = DB::table('users')->get();

		$myrecord = DB::table('employs')
			->where('id','=',$id)
			->get();

			

			foreach($myrecord as $myrecords)
			{
					$unitoffice = DB::table('unit_admins')
					->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
					->get();
			}

		if($MainActivity != "")

		{


		$tempmain = DB::table('main_activities')->where('EmpID', '=', $id)->where('MainActivityName', '=', $MainActivity)->first();

		if($tempmain == null)
		{
		//DB::insert('insert into main_activities (Main_ID, MainActivityName, EmpID) values (?,?,?)', array($count, $MainActivity, $id));
		DB::insert('insert into main_activities (Main_ID, MainActivityName, EmpID, UnitOfficeID, UnitOfficeSecondaryID, UnitOfficeTertiaryID, UnitOfficeQuaternaryID) values (?,?,?,?,?,?,?)', array($count, $MainActivity, $id, $unit, $secon, $tertia,$quater));
		}
		$main_id = DB::table('main_activities')->max('id');

		foreach ($SubActivities as $SubActivity) 

		{

			if($SubActivity != "")

			{
			  if($tempmain == null)
		{
				DB::insert('insert into sub_activities (SubActivityName, MainActivityID ,EmpID) values (?,?,?)', array($SubActivity, $main_id, $id));
		}
			}



		}



		$MainActivityOfEmp=DB::table('main_activities')->where('EmpID','=', $id)->where('id', '=', $main_id)->get();

		$SubActivityOfEmp=DB::table('sub_activities')->where('EmpID','=', $id)->get();



		return View::make('scorecard_measures')

			->with('id', $id)

			->with('name', $name)

			->with('pic', $pic)

			->with('MainActivityOfEmp', $MainActivityOfEmp)

			->with('SubActivityOfEmp', $SubActivityOfEmp)

			->with('myrecord',$myrecord)

			->with('unitoffice',$unitoffice)

			->with('users',$users);

		}

		else

		{

			Session::flash('message', 'Please input Main Activity Name');

				return Redirect::to('employee/scorecard');

		}

	}



	public function showEmployeeAccomplishment()

    {

    	if (Session::has('empid') && Session::has('empname')) {
    	$start_date = Input::get('StartDate');
        $StartDate = date("Y/m/d", strtotime($start_date));

        $id = Session::get('empid', 'default');
		$name = Session::get('empname', 'default');
		$pic = Session::get('emppic', 'default');
    	Session::put('yung_id', $id);
    	Session::put('StartDate', $StartDate);
    	$users = DB::table('users')->get();

    	$myrecord = DB::table('employs')
			->where('id','=',$id)
			->get();

			

			foreach($myrecord as $myrecords)
			{
					$unitoffice = DB::table('unit_admins')
					->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
					->get();
			}

    	$filename='reports/'.Session::get('Emp_id', $id).'.pdf';
		Session::put('report_filename', $filename);
    	return View::make('emp-accomplishment')
    	->with('id', $id)
    	->with('myrecord',$myrecord)
    	->with('unitoffice',$unitoffice)
		->with('name', $name)
		->with('pic', $pic)
		->with('users',$users);
		}
		else
		{
			Session::flash('message', 'Please login first!');
				return Redirect::to('login/employee');
		}

    }



    public function showEmployeeAccomplishmentPost()

    {

    	if (Session::has('empid') && Session::has('empname')) 
    	{
	    	$start_date = Input::get('StartDate');
	        $StartDate = date("Y/m/d", strtotime($start_date));

	        $DateValidate = 'HaveValue';
	        if($start_date == null)
	        {
	            $DateValidate = '';
	        }

	        $id = Session::get('empid', 'default');
			$name = Session::get('empname', 'default');
			$pic = Session::get('emppic', 'default');
			if(Input::get('weekly')) 
            {
				Session::put('DateValidate', $DateValidate);
		    	Session::put('emp_id', $id);
		    	Session::put('StartDate', $StartDate);
		    	$pdf = PDF::loadView('PDFWeeklyEmployee')->setPaper('Letter')->setOrientation('Portrait');
		        return $pdf->stream();
		    }
            elseif(Input::get('monthly'))
            {
                Session::put('DateValidate', $DateValidate);
                Session::put('emp_id', $id);
                Session::put('StartDate', $StartDate);
                $pdf = PDF::loadView('PDFMonthly')->setPaper('Folio')->setOrientation('Landscape');
                return $pdf->stream();
            }
        }
		else
		{
			Session::flash('message', 'Please login first!');
			return Redirect::to('login/employee');
		}

    }



	public function postCreateScoreCardMeasure()

	{

		$id = Session::get('empid', 'default');

		$name = Session::get('empname', 'default');

		$pic = Session::get('emppic', 'default');

		$sub_id = Input::get('sub_id');

		$measures = Input::get('measures');

		$measuretype = Input::get('measure_type');

		if($sub_id == null)

		{

			return Redirect::to('employee/scorecard');

		}

		else

		{

				$count = 0;

				foreach ($sub_id as $Sub) 

				{
					$tempmeasure = DB::table('measures')->where('EmpID', '=', $id)->where('MeasureName', '=', $measures[$count])->where('SubActivityID', '=', $Sub)->first();


					if($measures[$count] != "" and $tempmeasure == null)

					{

						DB::insert('insert into measures (MeasureName, SubActivityID ,MeasureType, EmpID) values (?,?,?,?)', array($measures[$count], $Sub, $measuretype[$count], $id));

					}

					

					$count++;

				}

		}	

		Session::flash('message', 'Activity successfully added!');

		return Redirect::to('employee/scorecard');

	}



	public function addSubactivities()

	{

		if (Session::has('empid') && Session::has('empname')) {

			$id = Session::get('empid', 'default');

			$name = Session::get('empname', 'default');

			$pic = Session::get('emppic', 'default');

			$users = DB::table('users')->get();

			$myrecord = DB::table('employs')
			->where('id','=',$id)
			->get();

			

			foreach($myrecord as $myrecords)
			{
					$unitoffice = DB::table('unit_admins')
					->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
					->get();
			}

			$MainActivityOfEmp= DB::table('employs')
			->join('main_activities','employs.id','=','main_activities.EmpID')
			->where('employs.id','=',$id)
			->where('main_activities.EmpID','=',$id)
		    					->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
		    						AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
		    						AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
			->orderBy('main_activities.Main_ID','asc')
			->get();

			
			return View::make('addsubactivities')

				->with('id', $id)

				->with('name', $name)

				->with('pic', $pic)

				->with('myrecord',$myrecord)

				->with('unitoffice',$unitoffice)

				->with('MainActivityOfEmp', $MainActivityOfEmp)

				->with('users',$users);

		}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/employee');

		}

	}



	public function postaddsubactivities()

	{

		$id = Session::get('empid', 'default');

		$name = Session::get('empname', 'default');

		$pic = Session::get('emppic', 'default');

		$main_id = Input::get('main_id');

		$sub_id = Input::get('subactivity');

		$users = DB::table('users')->get();

		$myrecord = DB::table('employs')
			->where('id','=',$id)
			->get();

		

			foreach($myrecord as $myrecords)
			{
					$unitoffice = DB::table('unit_admins')
					->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
					->get();
			}





			$count = 0;

			$index = 0;

			$counter = 0;

		if($main_id != null)
		{
			foreach ($main_id as $main) 

			{

				if($sub_id[$index] != "")

				{
					$tempsub = DB::table('sub_activities')->where('EmpID', '=', $id)->where('MainActivityID', '=', $main)->where('SubActivityName', '=', $sub_id[$index])->first();
				
					if($tempsub == null)
					{
						DB::insert('insert into sub_activities (SubActivityName, TerminationDate, MainActivityID , PerspectiveID, ObjectiveID, EmpID) values (?,?,?,?,?,?)', array($sub_id[$index], null, $main, null, null, $id));
					}
					//$count++;

					$counter++;

				}

				$index++;

				

			}

			$subactivities = DB::table('sub_activities')

			->where('EmpID','=',$id)

			->orderBy('id','desc')

			->take($counter)

			->get();



			Session::flash('message', 'Sub-Activity successfully added!');

			return View::make('addsubactivities_measures')

			->with('counter',$counter)

			->with('subactivities',$subactivities)

			->with('name',$name)

			->with('pic', $pic)

			->with('id',$id)

			->with('unitoffice',$unitoffice)

			->with('myrecord',$myrecord)

			->with('users',$users);

			}
			else

	 		{
	 	


			Session::flash('messages', 'Please add Main Activity first.');

			return Redirect::to('employee/addsubactivities');

		
	 		}


	

	}



	public function postaddsubactivities_measures()

	{

		$id = Session::get('empid', 'default');

		$name = Session::get('empname', 'default');

		$pic = Session::get('emppic', 'default');

		$sub_id = Input::get('sub_id');

		$measures = Input::get('measures');

		$measuretype = Input::get('measure_type');
		
	    $TargetHasEmptyString = true;

		$count = 0;

		if($measures != null)
    	{
    		
	    	foreach ($measures as $mae) 
	    	{
	    		if ($mae == "")
	    		{
	    			$TargetHasEmptyString = true;
	    			break;
	    		}
	    		else
	    		{
	    			$TargetHasEmptyString = false;
	    		}
	    	}
	   	

			    if ($TargetHasEmptyString == false) 
			    	{
			    		
						foreach ($sub_id as $Sub) 

						{

							$tempmeasure = DB::table('measures')->where('EmpID', '=', $id)->where('MeasureName', '=', $measures[$count])->where('SubActivityID', '=', $Sub)->first();



							if($measures[$count] != "" and $tempmeasure == null)
							{
								DB::insert('insert into measures (MeasureName, SubActivityID ,MeasureType, EmpID) values (?,?,?,?)', array($measures[$count], $Sub, $measuretype[$count], $id));
							}

							$count++;
						}


				}
				else{
						Session::flash('message', 'Please add a value in a measure for the sub-activity!');

						return Redirect::to('employee/addsubactivities');
				}
				
		Session::flash('message', 'Activity successfully added!');

			return Redirect::to('employee/scorecard');


		}


	}



	public function showAssignObjective()

	{

		if (Session::has('empid') && Session::has('empname')) {

			$id = Session::get('empid', 'default');

			$name = Session::get('empname', 'default');

			$pic = Session::get('emppic', 'default');

			$users = DB::table('users')->get();


			$perspectives_id = ['Select Perspective...'] + DB::table('perspectives')

			->orderBy('PerspectiveName','asc')

			->lists('PerspectiveName','id');

			$objectives_id= ['none...'];


		
			$myrecord = DB::table('employs')
			->where('id','=',$id)
			->get();

			

			foreach($myrecord as $myrecords)
			{
					$unitoffice = DB::table('unit_admins')
					->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
					->get();
			}


			foreach($users as $user)
			{
			if($user->state == 'Disable' or $user->state == 'Enable')
				{
			 foreach($myrecord as $records)
                 {
                 foreach($unitoffice as $unitoffices)
                  {            
                   if($unitoffices->UnitOfficeSecondaryID != '0' or $unitoffices->UnitOfficeSecondaryID == '0')
                     {             
                      if($unitoffices->UnitOfficeSecondaryID == $records->UnitOfficeSecondaryID
                      	or $unitoffices->UnitOfficeSecondaryID != $records->UnitOfficeSecondaryID)
                      	{
                           if($unitoffices->state == 'Disable')
							{
								$sub_activities = DB::table('sub_activities')->join('main_activities', 'sub_activities.MainActivityID', '=', 'main_activities.id')

								->where('sub_activities.EmpID','=',$id)

								->where('Main_ID', '=', '3')
								->where('ObjectiveID', '=', null)

								->get();

								$sub_activities2 = DB::table('sub_activities')->join('main_activities', 'sub_activities.MainActivityID', '=', 'main_activities.id')

								->where('sub_activities.EmpID','=',$id)
								->where('Main_ID', '=', '3')
								->whereNotNull('ObjectiveID')
								->get();

								

								//$mainactivities_id = DB::table('main_activities')

								//->where('EmpID','=',$id)

								//->where('Main_ID','=','3')

								//->lists('MainActivityName','id');

								$mainactivities_id = DB::table('main_activities')
		    					->join('employs','main_activities.EmpID','=','employs.id')
		    					->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
		    					->where('employs.id','=',$id)
		    					->where('main_activities.EmpID','=',$id)
		    					->where('main_activities.Main_ID','=','3')
		    					->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
		    						AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
		    						AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
		    					->lists('MainActivityName','id');

								//$main_activities = DB::table('main_activities')

								//->where('EmpID','=',$id)

								//->where('Main_ID','=','3')
								
								//->get();

								$main_activities = DB::table('main_activities')
                                     ->join('employs','main_activities.EmpID','=','employs.id')
                                     ->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
                                      ->where('employs.id','=',$id)
                                      ->where('main_activities.EmpID','=',$id)
                                      ->where('main_activities.Main_ID','=','3')
                                     ->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
                    AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
                    AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
                    AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
                  ->get();

								}
								if($unitoffices->state == 'Enable')
								{
									$sub_activities = DB::table('sub_activities')

									->where('EmpID','=',$id)

									->where('ObjectiveID', '=', null)

									->get();

									$sub_activities2 = DB::table('sub_activities')
									->where('EmpID','=',$id)

									->whereNotNull('ObjectiveID')
									->get();


									//$mainactivities_id = ['Select Main Activity...']  + DB::table('main_activities')

									//->where('EmpID','=',$id)

									//->lists('MainActivityName','id');

									$mainactivities_id = ['Select Main Activity...'] + DB::table('main_activities')
									->join('employs','main_activities.EmpID','=','employs.id')
		    					->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
		    					->where('employs.id','=',$id)
		    					->where('main_activities.EmpID','=',$id)
		    					->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
		    						AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
		    						AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
		    					->lists('MainActivityName','id');


									//$main_activities = DB::table('main_activities')

									//->where('EmpID','=',$id)
									
									//->get();
		    					$main_activities = DB::table('main_activities')
                                     ->join('employs','main_activities.EmpID','=','employs.id')
                                     ->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
                                      ->where('employs.id','=',$id)
                                      ->where('main_activities.EmpID','=',$id)
                                      ->where('main_activities.Main_ID','=','3')
                                     ->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
                    AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
                    AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
                    AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
                  ->get();
									}
					
								}
							}
							break;
						}				
					}
                 }
			}

			$id_dropdown="0";

			$id_dropdown2="0";

			$users = DB::table('users')->get();	


				return View::make('assignobjective')

					->with('id', $id)

					->with('name', $name)

					->with('pic', $pic)

					->with('users',$users)

					->with('perspectives_id',$perspectives_id)

					->with('objectives_id',$objectives_id)

					->with('main_activities',$main_activities)

					->with('sub_activities',$sub_activities)

					->with('mainactivities_id',$mainactivities_id)

					->with('id_dropdown2',$id_dropdown2)

					->with('id_dropdown',$id_dropdown)

					->with('users',$users)

					->with('myrecord',$myrecord)

					->with('sub_activities2',$sub_activities2)

					->with('unitoffice',$unitoffice);

		}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/employee');

		}

	}



	public function ajaxperspectiveid()
	{	
		$perspectiveID = $_REQUEST['perspectiveID'];
		$empid = $_REQUEST['empid'];

		$checkIfSecondary = DB::table('employs')
								->where('id', '=',$empid)
								->first();

		if($checkIfSecondary->UnitOfficeSecondaryID > 0)
		{
			$objectives_secondary = DB::table('obj_secondaryunitoffice')
										->join('objectives','obj_secondaryunitoffice.ObjectiveID','=','objectives.id')
										->where('obj_secondaryunitoffice.SecondaryUnitOfficeID', '=', $checkIfSecondary->UnitOfficeSecondaryID)
										->where('objectives.PerspectiveID','=', $perspectiveID)
										->select('objectives.ObjectiveName as ObjectiveName','objectives.id as id');
			
			$objectives_primary = DB::table('obj_primaryunitoffice')
									->join('objectives','obj_primaryunitoffice.ObjectiveID','=','objectives.id')
									->where('obj_primaryunitoffice.PrimaryUnitOfficeID', '=', $checkIfSecondary->UnitOfficeID)
									->where('objectives.PerspectiveID','=', $perspectiveID)
									->select('objectives.ObjectiveName as ObjectiveName','objectives.id as id');

			$objectives_id = $objectives_secondary
			 				->union($objectives_primary)
			 				->get();
				
		}
		else
		{
			$objectives_id = DB::table('obj_primaryunitoffice')
								->join('objectives','obj_primaryunitoffice.ObjectiveID','=','objectives.id')
								->join('employs','obj_primaryunitoffice.PrimaryUnitOfficeID','=','employs.UnitOfficeID')
								->select('objectives.ObjectiveName as ObjectiveName','objectives.id as id')
								->where('employs.id','=', $empid)
								->where('objectives.PerspectiveID','=', $perspectiveID)
								->get();
		}

		return Response::json($objectives_id);

	}


	public function saveupdateObjective()
	{
		$id_checkbox1 = Input::get('checkboxid1');
		$id_checkbox2 = Input::get('checkboxid2');
		$objectives_id = Input::get('ObjectiveID');

		
		if(Input::get('save')) 
            {
				if ($id_checkbox1 != null and $objectives_id != 0)
				{
					foreach($id_checkbox1 as $id)
					{
						$queries = DB::table('sub_activities')
						->where('id','=',$id)
						->get();


							foreach($queries as $query)
							{
									DB::table('sub_activities')
									->where('id','=',$query->id)
									->update(array('ObjectiveID' => $objectives_id));
							}
					}
				
					Session::flash('messages', 'Sub Activity successfully assigned to objective!');
					return Redirect::to('employee/assignobjective');
				}
				else
				{
					Session::flash('message', 'Incomplete inputs. Please assign perspective, objective and check corresponding sub-activities or main activity has no sub-activities!');
					return Redirect::to('employee/assignobjective');			
				}
            }
            elseif(Input::get('update'))
            {
				if ($id_checkbox2 != null and $objectives_id != 0)
				{
					foreach($id_checkbox2 as $id)
					{
						$queries = DB::table('sub_activities')
										->where('id','=',$id)
										->get();

						foreach($queries as $query)
						{			
							DB::table('sub_activities')
								->where('id','=',$query->id)
								->update(array('ObjectiveID' => $objectives_id));
						}
					}
				
					Session::flash('messages', 'Sub Activity Objective successfully updated!');
					return Redirect::to('employee/assignobjective');
				}
				else
				{
					Session::flash('message', 'Incomplete inputs. Please assign perspective, objective and check corresponding sub-activities or main activity has no sub-activities!');
					return Redirect::to('employee/assignobjective');	
				}
            }
		

	}

	//public function updateObjective(){}


	public function postAssignObjective()

	{

		$id = Session::get('empid', 'default');

		$name = Session::get('empname', 'default');

		$pic = Session::get('emppic', 'default');

		$users = DB::table('users')->get();

		$id_dropdown = Input::get('PerspectiveID');

		$id_dropdown2="0";	

		$perspectives_id = ['Select Perspective...'] + DB::table('perspectives')

			->lists('PerspectiveName','id');

		//$objectives_id = ['Select Objective...'] + DB::table('objectives')

		//->where('PerspectiveID','=',$id_dropdown)

		//->lists('ObjectiveName','id');

		$checkIfSecondary = DB::table('employs')
			->where('id', '=', $id)
			->first();

		if($checkIfSecondary->UnitOfficeSecondaryID > 0)
		{
			
			$objectives_id = ['Select Objective...'] + DB::table('obj_secondaryunitoffice')
			->join('objectives','obj_secondaryunitoffice.ObjectiveID','=','objectives.id')
			//->join('employs','obj_secondaryunitoffice.SecondaryUnitOfficeID','=','employs.UnitOfficeSecondaryID')
			->select('objectives.ObjectiveName as ObjectiveName','objectives.id as id')
			//->where('employs.id','=',$id)
			->where('obj_secondaryunitoffice.SecondaryUnitOfficeID', '=', $checkIfSecondary->UnitOfficeSecondaryID)
			->where('objectives.PerspectiveID','=',$id_dropdown)
			->lists('ObjectiveName','id');
			
			$objectives_id = $objectives_id + DB::table('obj_primaryunitoffice')
			->join('objectives','obj_primaryunitoffice.ObjectiveID','=','objectives.id')
			//->join('employs','obj_primaryunitoffice.PrimaryUnitOfficeID','=','employs.UnitOfficeID')
			->select('objectives.ObjectiveName as ObjectiveName','objectives.id as id')
			//->where('employs.id','=',$id)
			->where('obj_primaryunitoffice.PrimaryUnitOfficeID', '=', $checkIfSecondary->UnitOfficeID)
			->where('objectives.PerspectiveID','=',$id_dropdown)
			->lists('ObjectiveName','id');
			

			/*

			$objectives_id = ['Select Objective...'] + DB::table('obj_primaryunitoffice')
			->join('objectives','obj_primaryunitoffice.ObjectiveID','=','objectives.id')
			->join('employs','obj_primaryunitoffice.PrimaryUnitOfficeID','=','employs.UnitOfficeID')
			->select('objectives.ObjectiveName as ObjectiveName','objectives.id as id')
			->where('employs.id','=',$id)
			->where('objectives.PerspectiveID','=',$id_dropdown)
			->lists('ObjectiveName','id');
			*/
			
		}

		else
		{
			$objectives_id = ['Select Objective...'] + DB::table('obj_primaryunitoffice')
			->join('objectives','obj_primaryunitoffice.ObjectiveID','=','objectives.id')
			->join('employs','obj_primaryunitoffice.PrimaryUnitOfficeID','=','employs.UnitOfficeID')
			->select('objectives.ObjectiveName as ObjectiveName','objectives.id as id')
			->where('employs.id','=',$id)
			->where('objectives.PerspectiveID','=',$id_dropdown)
			->lists('ObjectiveName','id');
		}

		
		

			$myrecord = DB::table('employs')
			->where('id','=',$id)
			->get();

			

			foreach($myrecord as $myrecords)
			{
					$unitoffice = DB::table('unit_admins')
					->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
					->get();
			}


			foreach($users as $user)
			{
			if($user->state == 'Disable' or $user->state != 'Disable')
				{
			 foreach($myrecord as $records)
                 {
                 foreach($unitoffice as $unitoffices)
                  {            
                   if($unitoffices->UnitOfficeSecondaryID != '0' or $unitoffices->UnitOfficeSecondaryID == '0')
                     {             
                      if($unitoffices->UnitOfficeSecondaryID == $records->UnitOfficeSecondaryID
                      	or $unitoffices->UnitOfficeSecondaryID != $records->UnitOfficeSecondaryID)
                      	{
                           if($unitoffices->state == 'Disable')
							{
								$sub_activities = DB::table('sub_activities')->join('main_activities', 'sub_activities.MainActivityID', '=', 'main_activities.id')

								->where('sub_activities.EmpID','=',$id)

								->where('Main_ID', '=', '3')
								->where('ObjectiveID', '=', null)

								->get();

								$sub_activities2 = DB::table('sub_activities')->join('main_activities', 'sub_activities.MainActivityID', '=', 'main_activities.id')

								->where('sub_activities.EmpID','=',$id)
								->where('Main_ID', '=', '3')
								->whereNotNull('ObjectiveID')
								->get();

								//$mainactivities_id = DB::table('main_activities')

								//->where('EmpID','=',$id)

								//->where('Main_ID','=','3')

								//->lists('MainActivityName','id');
								$mainactivities_id = DB::table('main_activities')
		    					->join('employs','main_activities.EmpID','=','employs.id')
		    					->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
		    					->where('employs.id','=',$id)
		    					->where('main_activities.EmpID','=',$id)
		    					->where('main_activities.Main_ID','=','3')
		    					->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
		    						AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
		    						AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
		    					->lists('MainActivityName','id');

		    					$main_activities = DB::table('main_activities')
                                     ->join('employs','main_activities.EmpID','=','employs.id')
                                     ->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
                                      ->where('employs.id','=',$id)
                                      ->where('main_activities.EmpID','=',$id)
                                      ->where('main_activities.Main_ID','=','3')
                                     ->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
                    AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
                    AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
                    AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
                  ->get();


								//$main_activities = DB::table('main_activities')

								//->where('EmpID','=',$id)

								//->where('Main_ID','=','3')
								
								//->get();

								}
								if($unitoffices->state == 'Enable')
								{
									$sub_activities = DB::table('sub_activities')

									->where('EmpID','=',$id)

									->where('ObjectiveID', '=', null)

									->get();

									$sub_activities2 = DB::table('sub_activities')
									->where('EmpID','=',$id)

									->whereNotNull('ObjectiveID')
									->get();

									//$mainactivities_id = ['Select Main Activity...']  + DB::table('main_activities')

									//->where('EmpID','=',$id)

									//->lists('MainActivityName','id');
									$mainactivities_id = ['Select Main Activity...'] + DB::table('main_activities')
									->join('employs','main_activities.EmpID','=','employs.id')
		    					->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
		    					->where('employs.id','=',$id)
		    					->where('main_activities.EmpID','=',$id)
		    					->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
		    						AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
		    						AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
		    					->lists('MainActivityName','id');

		    					$main_activities = DB::table('main_activities')
                                     ->join('employs','main_activities.EmpID','=','employs.id')
                                     ->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
                                      ->where('employs.id','=',$id)
                                      ->where('main_activities.EmpID','=',$id)
                                      ->where('main_activities.Main_ID','=','3')
                                     ->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
                    AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
                    AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
                    AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
                  ->get();


									//$main_activities = DB::table('main_activities')

									//->where('EmpID','=',$id)
									
									//->get();
									}
					
								}
							}
							break;
						}				
					}
                 }
			}

			return View::make('assignobjective')

				->with('id', $id)

				->with('name', $name)

				->with('pic', $pic)

				->with('users',$users)

				->with('perspectives_id',$perspectives_id)

				->with('objectives_id',$objectives_id)

				->with('sub_activities',$sub_activities)

				->with('mainactivities_id',$mainactivities_id)

				->with('id_dropdown',$id_dropdown)

				->with('id_dropdown2',$id_dropdown2)

				->with('unitoffice',$unitoffice)

				->with('myrecord',$myrecord)
				->with('sub_activities2',$sub_activities2);



	}



	public function postAssignObjective2()

	{

		$id = Session::get('empid', 'default');

		$name = Session::get('empname', 'default');

		$pic = Session::get('emppic', 'default');

		$users = DB::table('users')->get();

		$id_dropdown = Input::get('PerspectivesID');

		$id_dropdown2 = Input::get('ObjectiveID');

		$perspectives_id = DB::table('perspectives')

		->where('id','=',$id_dropdown)

			->lists('PerspectiveName','id');

		$checkIfSecondary = DB::table('employs')
			->where('id', '=', $id)
			->first();

		if($checkIfSecondary->UnitOfficeSecondaryID > 0)
		{
			
			$objectives_id = ['Select Objective...'] + DB::table('obj_secondaryunitoffice')
			->join('objectives','obj_secondaryunitoffice.ObjectiveID','=','objectives.id')
			//->join('employs','obj_secondaryunitoffice.SecondaryUnitOfficeID','=','employs.UnitOfficeSecondaryID')
			->select('objectives.ObjectiveName as ObjectiveName','objectives.id as id')
			//->where('employs.id','=',$id)
			->where('obj_secondaryunitoffice.SecondaryUnitOfficeID', '=', $checkIfSecondary->UnitOfficeSecondaryID)
			->where('objectives.PerspectiveID','=',$id_dropdown)
			->lists('ObjectiveName','id');
			
			$objectives_id = $objectives_id + DB::table('obj_primaryunitoffice')
			->join('objectives','obj_primaryunitoffice.ObjectiveID','=','objectives.id')
			//->join('employs','obj_primaryunitoffice.PrimaryUnitOfficeID','=','employs.UnitOfficeID')
			->select('objectives.ObjectiveName as ObjectiveName','objectives.id as id')
			//->where('employs.id','=',$id)
			->where('obj_primaryunitoffice.PrimaryUnitOfficeID', '=', $checkIfSecondary->UnitOfficeID)
			->where('objectives.PerspectiveID','=',$id_dropdown)
			->lists('ObjectiveName','id');
			

			/*

			$objectives_id = ['Select Objective...'] + DB::table('obj_primaryunitoffice')
			->join('objectives','obj_primaryunitoffice.ObjectiveID','=','objectives.id')
			->join('employs','obj_primaryunitoffice.PrimaryUnitOfficeID','=','employs.UnitOfficeID')
			->select('objectives.ObjectiveName as ObjectiveName','objectives.id as id')
			->where('employs.id','=',$id)
			->where('objectives.PerspectiveID','=',$id_dropdown)
			->lists('ObjectiveName','id');
			*/
			
		}

		else
		{
			$objectives_id = ['Select Objective...'] + DB::table('obj_primaryunitoffice')
			->join('objectives','obj_primaryunitoffice.ObjectiveID','=','objectives.id')
			->join('employs','obj_primaryunitoffice.PrimaryUnitOfficeID','=','employs.UnitOfficeID')
			->select('objectives.ObjectiveName as ObjectiveName','objectives.id as id')
			->where('employs.id','=',$id)
			->where('objectives.PerspectiveID','=',$id_dropdown)
			->lists('ObjectiveName','id');
		}

	

			$myrecord = DB::table('employs')
			->where('id','=',$id)
			->get();

			

			foreach($myrecord as $myrecords)
			{
					$unitoffice = DB::table('unit_admins')
					->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
					->get();
			}
			foreach($users as $user)
			{
			if($user->state == 'Disable' or $user->state == 'Enable')
				{
			 foreach($myrecord as $records)
                 {
                 foreach($unitoffice as $unitoffices)
                  {            
                   if($unitoffices->UnitOfficeSecondaryID != '0' or $unitoffices->UnitOfficeSecondaryID == '0')
                     {             
                      if($unitoffices->UnitOfficeSecondaryID == $records->UnitOfficeSecondaryID
                      	or $unitoffices->UnitOfficeSecondaryID != $records->UnitOfficeSecondaryID)
                      	{
                           if($unitoffices->state == 'Disable')
							{
								$sub_activities = DB::table('sub_activities')->join('main_activities', 'sub_activities.MainActivityID', '=', 'main_activities.id')

								->where('sub_activities.EmpID','=',$id)

								->where('Main_ID', '=', '3')
								->where('ObjectiveID', '=', null)

								->get();

								$sub_activities2 = DB::table('sub_activities')->join('main_activities', 'sub_activities.MainActivityID', '=', 'main_activities.id')

								->where('sub_activities.EmpID','=',$id)
								->where('Main_ID', '=', '3')
								->whereNotNull('ObjectiveID')
								->get();

								//$mainactivities_id = DB::table('main_activities')

								//->where('EmpID','=',$id)

								//->where('Main_ID','=','3')

								//->lists('MainActivityName','id');

								$mainactivities_id = DB::table('main_activities')
		    					->join('employs','main_activities.EmpID','=','employs.id')
		    					->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
		    					->where('employs.id','=',$id)
		    					->where('main_activities.EmpID','=',$id)
		    					->where('main_activities.Main_ID','=','3')
		    					->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
		    						AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
		    						AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
		    					->lists('MainActivityName','id');

		    					$main_activities = DB::table('main_activities')
                                     ->join('employs','main_activities.EmpID','=','employs.id')
                                     ->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
                                      ->where('employs.id','=',$id)
                                      ->where('main_activities.EmpID','=',$id)
                                      ->where('main_activities.Main_ID','=','3')
                                     ->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
                    AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
                    AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
                    AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
                  ->get();

								//$main_activities = DB::table('main_activities')

								//->where('EmpID','=',$id)

								//->where('Main_ID','=','3')
								
								//->get();

								}
								if($unitoffices->state == 'Enable')
								{
									$sub_activities = DB::table('sub_activities')

									->where('EmpID','=',$id)

									->where('ObjectiveID', '=', null)

									->get();


									$sub_activities2 = DB::table('sub_activities')
									->where('EmpID','=',$id)

									->whereNotNull('ObjectiveID')
									->get();
									//$mainactivities_id = ['Select Main Activity...']  + DB::table('main_activities')

									//->where('EmpID','=',$id)

									//->lists('MainActivityName','id');

									$mainactivities_id = ['Select Main Activity...'] + DB::table('main_activities')
									->join('employs','main_activities.EmpID','=','employs.id')
		    					->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
		    					->where('employs.id','=',$id)
		    					->where('main_activities.EmpID','=',$id)
		    					->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
		    						AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
		    						AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
		    					->lists('MainActivityName','id');

		    					$main_activities = DB::table('main_activities')
                                     ->join('employs','main_activities.EmpID','=','employs.id')
                                     ->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
                                      ->where('employs.id','=',$id)
                                      ->where('main_activities.EmpID','=',$id)
                                      ->where('main_activities.Main_ID','=','3')
                                     ->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
                    AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
                    AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
                    AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
                  ->get();

									//$main_activities = DB::table('main_activities')

									//->where('EmpID','=',$id)
									
									//->get();
									}
					
								}
							}
							break;
						}				
					}
                 }
			}

			return View::make('assignobjective')

				->with('id', $id)

				->with('name', $name)

				->with('pic', $pic)

				->with('users',$users)

				->with('perspectives_id',$perspectives_id)

				->with('sub_activities',$sub_activities)

				->with('mainactivities_id',$mainactivities_id)

				->with('id_dropdown2',$id_dropdown2)

				->with('id_dropdown',$id_dropdown)

				->with('objectives_id',$objectives_id)

				->with('unitoffice',$unitoffice)

				->with('myrecord',$myrecord)

				->with('sub_activities2',$sub_activities2);

	}


	//measure only
		public function EmployeeMeasureAdd()
		{
			if (Session::has('empid') && Session::has('empname')) {

			$id = Session::get('empid', 'default');

			$name = Session::get('empname', 'default');

			$pic = Session::get('emppic', 'default');

			$users = DB::table('users')->get();
					

			$myrecord = DB::table('employs')
			->where('id','=',$id)
			->get();


			foreach($myrecord as $myrecords)
			{
					$unitoffice = DB::table('unit_admins')
					->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
					->get();
			}



			foreach($users as $user)
			{
			if($user->state == 'Disable' or $user->state == 'Enable')
				{
			 foreach($myrecord as $records)
                 {
                 foreach($unitoffice as $unitoffices)
                  {            
                   if($unitoffices->UnitOfficeSecondaryID != '0' or $unitoffices->UnitOfficeSecondaryID == '0')
                     {             
                      if($unitoffices->UnitOfficeSecondaryID == $records->UnitOfficeSecondaryID
                      	or $unitoffices->UnitOfficeSecondaryID != $records->UnitOfficeSecondaryID)
                      	{
                           if($unitoffices->state == 'Disable')
							{
								$subactivities = DB::table('sub_activities')->join('main_activities', 'sub_activities.MainActivityID', '=', 'main_activities.id')
								->where('sub_activities.EmpID','=',$id)
								->where('Main_ID', '=', '3')
								->where('ObjectiveID', '=', null)
								->get();


								//$mainactivities = DB::table('main_activities')
								//->where('EmpID','=',$id)
								//->where('Main_ID','=','3')
								//->get();
								$mainactivities = DB::table('main_activities')
                                     ->join('employs','main_activities.EmpID','=','employs.id')
                                     ->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
                                      ->where('employs.id','=',$id)
                                      ->where('main_activities.EmpID','=',$id)
                                     ->where('main_activities.Main_ID','=','3')
                                     ->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
                    AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
                    AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
                    AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
                  ->get();

							}
								if($unitoffices->state == 'Enable')
								{
										//$mainactivities = DB::table('main_activities')
										//->where('EmpID', '=', $id)
										//->get();
										$mainactivities = DB::table('main_activities')
                                     ->join('employs','main_activities.EmpID','=','employs.id')
                                     ->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
                                      ->where('employs.id','=',$id)
                                      ->where('main_activities.EmpID','=',$id)
                                     
                                     ->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
                    AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
                    AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
                    AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
                  ->get();
										
										$subactivities = DB::table('sub_activities')
										->where('EmpID','=',$id)
										->get();
									
								}
					
								}
							}
							break;
						}				
					}
                 }
			}

			
						return View::make('EmpAddMeasure')
						->with('subactivities',$subactivities)
						->with('mainactivities', $mainactivities)
						->with('pic', $pic)
						->with('users',$users)
						->with('name', $name)
						->with('myrecord', $myrecord)
						->with('unitoffice', $unitoffice)
						->with('id', $id);
			}
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/employee');
			}       	
				
		}

		public function Employeesubmeasure()
		{
			$id = Session::get('empid', 'default');
			$sub_id = Input::get('sub_id');
			$measures = Input::get('measures');
			$measuretype = Input::get('measure_type');

			$count = 0;
			  $TargetHasEmptyString = true;

		$count = 0;

		if($measures != null)
    	{
    		
	    	foreach ($measures as $mae) 
	    	{
	    		if ($mae == "")
	    		{
	    			$TargetHasEmptyString = true;
	    			
	    		}
	    		else
	    		{
	    			$TargetHasEmptyString = false;
	    			break;
	    		}
	    	}
	   	

			    if ($TargetHasEmptyString == false) 
			    	{
					
					    		
								foreach ($sub_id as $Sub) 

								{

									if($measures[$count] != "")
									{
										DB::insert('insert into measures (MeasureName, SubActivityID ,MeasureType, EmpID) values (?,?,?,?)', array($measures[$count], $Sub, $measuretype[$count], $id));
									}

									$count++;
							}

						Session::flash('message', 'Activity successfully added!');
						return Redirect::to('employee/addmeasures');
							}

			else{
						Session::flash('messaged', 'Please add a value in a measure for the sub-activity!');

						return Redirect::to('employee/addmeasures');
				}
		}
		else{
			Session::flash('messaged', 'Please add Main Activity first.');

						return Redirect::to('employee/addmeasures');
		}
		

		}



	public function showSubordinatePendingTargets($id)

	{

		$employee = DB::table('employs')

			->where('id','=',$id)

			->get();

			$users = DB::table('users')->get();

			$myrecord = DB::table('employs')
			->where('id','=',$id)
			->get();

			

			foreach($myrecord as $myrecords)
			{
					$unitoffice = DB::table('unit_admins')
					->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
					->get();
			}

			$rank = DB::table('ranks')

			->get();

			$position = DB::table('positions')

			->get();			

			date_default_timezone_set('Asia/Singapore');

 			 $today = new DateTime("now");

            $dt_min = new DateTime("monday");

            if ($dt_min > $today)

            {

                $dt_min = new DateTime("last monday");

            }

 			$dt_max = clone($dt_min);

 			$dt_max->modify('+6 days');

 			$datenow = date('yyyy-mm-dd');

 			$monthnow = date('M');

 			$yearnow = date('Y');

 			$month = date("F", strtotime($monthnow));

 			//count to see if there's current entry already.

 			$target_count = DB::table('measure_variants')

 				->join('daily_accomplishments', 'daily_accomplishments.MeasureVariantID', '=', 'measure_variants.id')

 				->where('measure_variants.EmpID', '=', $id)

 				->where('Date', '=', $dt_min->format('Y-m-d'))

 				->count();



 		 			$target_status = DB::table('measure_variants')

	 				->join('daily_accomplishments', 'daily_accomplishments.MeasureVariantID', '=', 'measure_variants.id')

	 				->where('measure_variants.EmpID', '=', $id)

	 				->where('daily_accomplishments.Date', '=', $dt_min->format('Y-m-d'))

	 				->pluck('daily_accomplishments.Status');

	 				

	 		

	 				//dd('approved');

	 				$mainactivity = DB::table('main_activities')->where('EmpID', '=', $id)->get();

					$subactivity = DB::table('sub_activities')->where('EmpID', '=', $id)->get();

					$measure = DB::table('measures')->where('EmpID', '=', $id)->get();



					$emp_activities = DB::table('main_activities')

					->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')

					->join('objectives', 'objectives.id', '=', 'sub_activities.ObjectiveID')

					->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')

					->join('target_approval', 'measures.id' , '=', 'target_approval.measureID')

					->where('target_approval.empID', '=', $id)

	    			->where('main_activities.EmpID', '=', $id)

	    			->where('sub_activities.TerminationDate', '>', $today)

	    			->orWhere('sub_activities.TerminationDate', NULL )

	    			->where('sub_activities.EmpID', '=', $id)

					->where('target_approval.date', '=', $dt_min)

	    			->orderBy('main_activities.id','asc')

	    			->orderBy('sub_activities.id', 'asc')

	    			->orderBy('objectives.id','asc')

	    			->select('main_activities.id as MainActivityID' , 'sub_activities.id as SubActivityID', 'measures.id as MeasureID', 'MainActivityName', 

	    				'SubActivityName', 'MeasureName' , 'ObjectiveName', 'target_approval.status as targetstatus', 'target_approval.value as targetvalue')

	    			->get();



		    			



	 				$set_activities = DB::table('measure_variants')

		 				->join('daily_accomplishments', 'daily_accomplishments.MeasureVariantID', '=', 'measure_variants.id')

		 				->join('activity_variants', 'activity_variants.id', '=', 'measure_variants.ActivityVariantID')

		 				->where('measure_variants.EmpID', '=', $id)

		 				->where('daily_accomplishments.Date', '=', $dt_min->format('Y-m-d'))

		 				->where('daily_accomplishments.Status', '=', 'pending')

		 				->select('daily_accomplishments.Target as Target', 'daily_accomplishments.MeasureVariantID as MeasureVariantID', 'measure_variants.MeasureID as MeasureID')

		 				->get();



		 			return View::make('subordinatepending')

	 					->with('id', $id)

						->with('users',$users)

						->with('employee',$employee)

						->with('rank',$rank)

						->with('position',$position)

						->with('dt_min',$dt_min)

						->with('dt_max',$dt_max)

						->with('target_status',$target_status)

						->with('month',$month)

						->with('yearnow',$yearnow)

						->with('mainactivity',$mainactivity)

						->with('subactivity',$subactivity)

						->with('emp_activities', $emp_activities)

						->with('set_activities', $set_activities)

						->with('measure',$measure)

						->with('myrecord',$myrecord)

						->with('unitoffice',$unitoffice);

	}



	public function ApprovePending()

	{

		$emp_id = Input::get('pending_id');

		if($emp_id == null)

		{

			Session::flash('message3','Please select atleast one checkbox!');

			return Redirect::to('employee/dashboard');

		}

		date_default_timezone_set('Asia/Singapore');

 		$today = new DateTime("now");

        $dt_min = new DateTime("monday");

        if ($dt_min > $today)

        {

            $dt_min = new DateTime("last monday");

        }

 		$dt_max = clone($dt_min);

 		$dt_max->modify('+6 days');



		foreach($emp_id as $emp)

		{

			DB::table('target_approval')

			->where('empID','=',$emp)

			->where('date', '>=',$dt_min)

			->where('date','<=',$dt_max)

			->update(array('status' => 'approved'));

			 DB::table('approval_remarks')->where('EmpID', '=', $emp)->where('RemarksDate', '=', $dt_min)->delete();

		}

		

		Session::flash('messageapproved', 'Pending target approved!');

		return Redirect::to('employee/dashboard');

	}



	public function RejectPending()

	{

		$emp_id = Input::get('pending_id');

		if($emp_id == null)

		{

			Session::flash('message3','Please select atleast one checkbox!');

			return Redirect::to('employee/dashboard'); 

		}

		date_default_timezone_set('Asia/Singapore');

 		$today = new DateTime("now");

        $dt_min = new DateTime("monday");

        if ($dt_min > $today)

        {

            $dt_min = new DateTime("last monday");

        }

 		$dt_max = clone($dt_min);

 		$dt_max->modify('+6 days');

 		$message = Input::get('Remarks');


		foreach($emp_id as $emp)

		{

			DB::table('target_approval')

			->where('empID','=',$emp)

			->where('date', '>=',$dt_min)

			->where('date','<=',$dt_max)

			->update(array('status' => 'rejected'));

			$rem = DB::table('approval_remarks')->where('EmpID', '=', $emp)->get();
			if($rem == null)
			{
			DB::insert('insert into approval_remarks (messages, EmpID, RemarksDate) values (?,?,?)', array($message, $emp, $dt_min));
			}
			else
			{
			DB::table('approval_remarks')->where('EmpID', '=', $emp)->delete();
			DB::insert('insert into approval_remarks (messages, EmpID, RemarksDate) values (?,?,?)', array($message, $emp, $dt_min));
			}
	
		}

		

		Session::flash('message2', 'Pending target rejected!');

		return Redirect::to('employee/dashboard');

	}











	}



	



?>