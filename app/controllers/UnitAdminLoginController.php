	<?php



class UnitAdminLoginController extends BaseController
{


public function showLogin()
{
		$users= DB::table('users')->get();
		$name = "";
		return View::make('unitadminlogin')
			->with('users',$users)
			->with('name',$name);

}

public function doLogin()
{
		$rules = array(

			'username'   => 'required', 

			'password'=> 'required|alphaNum|min:4'

			);


		$validator = Validator::make(Input::all(), $rules);

		$users = DB::table('users')->get();

		if($validator -> fails()){

			Session::flash('message', 'Username and password required.');

			return Redirect::to('login/unitadmin')

			->withErrors($validator)

			->with('users',$users)

			->withInput(Input::except('password')); 

		}

		else

		{

			$user = Input::get('username');

			$pass = Input::get('password');

			
		

			$credentials = DB::table('unit_admins')->where('UserName', '=', $user)->where('Password', '=', $pass)->get();

			

			if (count($credentials) > 0) {

				foreach ($credentials as $key => $value) {

					$employeename = $value->FirstName. ' ' .$value->LastName;

					$employeeid = $value->id;

					$employeeusername = $value->UserName;

					$employeeunitoffice = $value->UnitOfficeID;

					$employeesecondaryoffice = $value->UnitOfficeSecondaryID;

					$state = $value->state;

				}

				Session::put('unitadminid', $employeeid);

				Session::put('unitadminname', $employeename);

				Session::put('unitadminusername',$employeeusername);

				Session::put('primaryunit', $employeeunitoffice);

				Session::put('secondaryunit', $employeesecondaryoffice);

				Session::put('state', $state);



				return Redirect::to('Unitadmindashboard');

		

			}

			else

			{

				Session::flash('message', 'Sorry! Incorrect username/password. Please try again.');

				return Redirect::to('login/unitadmin');

			}

		}
	}

	public function doLogout()

	{
		$unitadmin_id = Session::get('unitadminid', 'default');

		Session::flush();	

		Session::flash('message2', 'Successfully logged out. Have a good day!');


		DB::table('unit_admins')
		->where('id','=',$unitadmin_id)
		->update(array('firstlogin' => 1));

		return Redirect::to('login/unitadmin');

	}


	public function ChangePassword()
	{
		$name = Session::get('unitadminname', 'default');
		return View::make('UnitAdminChangePassword')
		->with('name',$name);
	}

	public function postChangePassword()
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

			return Redirect::to('unitadmin/changepassword')

				->withErrors($validator);

		}

		else 
		{

			$unit_admin_id = Session::get('unitadminid', 'default');
			$old_password = DB::table('unit_admins')->select('Password as old_password')->where('id', '=', $unit_admin_id)->first();
			
			if (Input::get('old_password') == $old_password->old_password) 

				{

					DB::table('unit_admins')->where('id', '=', $unit_admin_id)->update(array('Password' => Input::get('new_password')));

					Session::flash('changepw_success', 'Change password success!');

					return Redirect::to('unitadmin/changepassword');	

				}
			else

				{

					Session::flash('changepw_error', 'Invalid old password!');

					return Redirect::to('unitadmin/changepassword');

				}
		}

	}

	public function postRemoveScorecard()
	{

	
		$empid = Input::get('empid');
		

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

       		Session::flash('message', 'Submitted Scorecard successfully removed.');
			return Redirect::to('UAEactivities');

       } 
       else{
       		Session::flash('message', 'Scorecard not yet submitted.');
			return Redirect::to('UAEactivities');
       }
       


	}

	public function showGraph()
	{
	if (Session::has('unitadminid') && Session::has('unitadminname')) 
		{
			$unit_admin_id = Session::get('unitadminid', 'default');
			$name = Session::get('unitadminname', 'default');
			$users = DB::table('users')->get();
			$employs = DB::table('employs')->get();

			$unitoffice_id = Session::get('primaryunit','default');

			$secondaryoffice_id = Session::get('secondaryunit','default');

			$adminstate = DB::table('users')
			->get();

			$employs = DB::table('ranks')
			->join('employs', 'ranks.id', '=', 'employs.RankID')
			->where('UnitOfficeID','=',$unitoffice_id)
			->where('employs.isActive', '!=', '0')
			->get();

			$sub_unit = DB::table('unit_offices')
			->where('id', '=', $unitoffice_id)
			->where('UnitOfficeHasField', '=', 'True')
			->get();

			$unitoffice = DB::table('unit_admins')
			->where('id','=',$unit_admin_id)
			->get();

			$primaryoffice = DB::table('unit_offices')
			->get();
			$secondaryoffice = DB::table('unit_office_secondaries')
			->get();
			foreach($unitoffice as $unitadmin)
			{
				if($unitadmin->UnitOfficeSecondaryID != '0')
				{
					$employs = DB::table('ranks')
					->join('employs', 'ranks.id', '=', 'employs.RankID')
					->where('UnitOfficeID','=',$unitoffice_id)
					->where('UnitOfficeSecondaryID','=',$secondaryoffice_id)
					->get();
					
				}

				if($unitadmin->UnitOfficeSecondaryID == '0')
				{
					$employs = DB::table('ranks')
					->join('employs', 'ranks.id', '=', 'employs.RankID')
					->where('UnitOfficeID','=',$unitoffice_id)
					->get();
				}
				


			}

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
		
		return View::make('UAEselectemp')
			->with('employs', $employs)
			->with('users', $users)
			->with('DateCovered', $DateCovered)
			->with('unit_admin_id', $unit_admin_id)
			->with('name', $name)
			->with('unitoffice', $unitoffice)
			->with('LastWeekDateCovered', $LastWeekDateCovered);
		}
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}
	}
	public function postGraph()
	{
		if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');
	

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
			
						return View::make('UAEgraph')
							->with('summations', $summations)
							->with('employsname', $employsname)
							->with('unit_admin_id', $unit_admin_id)
							->with('name', $name)
							->with('StartDate', $StartDate)
							->with('empid', $empid);
			}
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}
	}

public function showDashboard()
	{
		if (Session::has('unitadminid') && Session::has('unitadminname')) 
		{

			$id = Session::get('unitadminid', 'default');

			$name = Session::get('unitadminname', 'default');

			$unitoffice_id = Session::get('primaryunit','default');

			$secondaryoffice_id = Session::get('secondaryunit','default');


			$iffirsttime = DB::table('unit_admins')
			->where('id' ,'=', $id)
			->first();

			$state = DB::table('unit_admins')
		 	->where('id','=',$id)
		 	->get();
		
			if($secondaryoffice_id == '0')
			{
				$unitofficestate = DB::table('users')
		 		->get();
		 		$officeHierarchy = 'primary';
		 		$officeId = $unitoffice_id;
			}
			else
			{
				$unitofficestate = DB::table('unit_admins')
				->where('UnitOfficeID','=',$unitoffice_id)
				->where('id','!=',$id)
				->get();

				$officeHierarchy = 'secondary';
		 		$officeId = $secondaryoffice_id;
			}
			
		 	
			


			$adminstate = DB::table('users')
			->get();

			$employs = DB::table('ranks')
			->join('employs', 'ranks.id', '=', 'employs.RankID')
			->where('UnitOfficeID','=',$unitoffice_id)
			->where('employs.isActive', '!=', '0')
			->get();

			$sub_unit = DB::table('unit_offices')
			->where('id', '=', $unitoffice_id)
			->where('UnitOfficeHasField', '=', 'True')
			->get();

			$unitoffice = DB::table('unit_admins')
			->where('id','=',$id)
			->get();

			$primaryoffice = DB::table('unit_offices')
			->get();
			$secondaryoffice = DB::table('unit_office_secondaries')
			->get();
			foreach($unitoffice as $unitadmin)
			{
				if($unitadmin->UnitOfficeSecondaryID != '0')
				{
					$employs = DB::table('ranks')
					->join('employs', 'ranks.id', '=', 'employs.RankID')
					->where('UnitOfficeID','=',$unitoffice_id)
					->where('UnitOfficeSecondaryID','=',$secondaryoffice_id)
					->where('employs.isActive', '!=', '0')
					->get();
					
				}

				if($unitadmin->UnitOfficeSecondaryID == '0')
				{
					$employs = DB::table('ranks')
					->join('employs', 'ranks.id', '=', 'employs.RankID')
					->where('UnitOfficeID','=',$unitoffice_id)
					->where('employs.isActive', '!=', '0')
					->get();
				}
				


			}

			
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

        if($officeHierarchy == 'primary')
        {
        	$submitted = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('target_approval.status', '=', 'submitted')
						->where('UnitOfficeID', '=', $officeId)
						->where('date', '=', $dt_min)
						->where('employs.isActive', '!=', '0')
						->groupBy('employs.id')
						->get();

		$didNotSubmitted = DB::table('employs')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')

						
						
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
						->where('UnitOfficeID', '=', $officeId)
						->where('employs.isActive', '!=', '0')
						
						
						->get();


		$noScorecard = DB::table('employs')
				->whereNotIn('employs.id', function($q)
					{
						$q->select('empID')->from('target_approval');
					})
				->where('UnitOfficeID', '=', $officeId)
				->where('employs.isActive', '!=', '0')
				->count();
		
		$noScorecardList = DB::table('employs')
				->join('ranks', 'ranks.id', '=', 'employs.RankID')
				->whereNotIn('employs.id', function($q)
					{
						$q->select('empID')->from('target_approval');
					})
				->where('UnitOfficeID', '=', $officeId)
				->where('employs.isActive', '!=', '0')
				->get();


		$lastSubmitted = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('target_approval.status', '=', 'submitted')
						->where('date', '=', $LastWeekStartDate)
						->where('UnitOfficeID', '=', $officeId)
						->where('employs.isActive', '!=', '0')
						->groupBy('employs.id')
						->get();
			
		$whosub = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->where('target_approval.status', '=', 'submitted')
						->where('date', '=', $dt_min)
						->where('UnitOfficeID', '=', $officeId)
						->where('employs.isActive', '!=', '0')
						->distinct('target_approval.empID')
						->count('target_approval.empID');


		$whoDidNotSub = DB::table('employs')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						
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
						->where('UnitOfficeID', '=', $officeId)
						->where('employs.isActive', '!=', '0')
						
						->count('employs.id');

			

		$whoSubLast = DB::table('target_approval')
							->join('employs', 'target_approval.EmpID', '=', 'employs.id')
							->where('target_approval.status', '=', 'submitted')
							->where('date', '=', $LastWeekStartDate)
							->where('UnitOfficeID', '=', $officeId)
							->where('employs.isActive', '!=', '0')
							->distinct('target_approval.empID')
							->count('target_approval.empID');
        }

        	

        


        else
        {


        	$submitted = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('target_approval.status', '=', 'submitted')
						->where('UnitOfficeSecondaryID', '=', $officeId)
						->where('date', '=', $dt_min)
						->where('employs.isActive', '!=', '0')
						->groupBy('employs.id')
						->get();

		$didNotSubmitted = DB::table('employs')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')

						
						
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
						->where('UnitOfficeSecondaryID', '=', $officeId)
						->where('employs.isActive', '!=', '0')
						
						
						->get();

		/*SELECT * FROM employs e
		INNER JOIN ranks r ON r.id = employs.RankID
		WHERE e.id 
		NOT IN (SELECT empID 
				FROM target_approval 
				WHERE target_approval.status = 'submitted' 
				AND target_approval.date = $LastWeekStartDate 
				OR target_approval.date = $dt_min)
		AND e.supervisorID = $id */

		$noScorecard = DB::table('employs')
				->whereNotIn('employs.id', function($q)
					{
						$q->select('empID')->from('target_approval');
					})
				->where('UnitOfficeSecondaryID', '=', $officeId)
				->where('employs.isActive', '!=', '0')
				->count();
		
		$noScorecardList = DB::table('employs')
				->join('ranks', 'ranks.id', '=', 'employs.RankID')
				->whereNotIn('employs.id', function($q)
					{
						$q->select('empID')->from('target_approval');
					})
				->where('UnitOfficeSecondaryID', '=', $officeId)
				->where('employs.isActive', '!=', '0')
				->get();


		$lastSubmitted = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('target_approval.status', '=', 'submitted')
						->where('date', '=', $LastWeekStartDate)
						->where('UnitOfficeSecondaryID', '=', $officeId)
						->where('employs.isActive', '!=', '0')
						->groupBy('employs.id')
						->get();
			
		$whosub = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->where('target_approval.status', '=', 'submitted')
						->where('date', '=', $dt_min)
						->where('UnitOfficeSecondaryID', '=', $officeId)
						->where('employs.isActive', '!=', '0')
						->distinct('target_approval.empID')
						->count('target_approval.empID');


		$whoDidNotSub = DB::table('employs')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						
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
						->where('UnitOfficeSecondaryID', '=', $officeId)
						->where('employs.isActive', '!=', '0')
						
						->count('employs.id');

			

		$whoSubLast = DB::table('target_approval')
							->join('employs', 'target_approval.EmpID', '=', 'employs.id')
							->where('target_approval.status', '=', 'submitted')
							->where('date', '=', $LastWeekStartDate)
							->where('UnitOfficeSecondaryID', '=', $officeId)
							->where('employs.isActive', '!=', '0')
							->distinct('target_approval.empID')
							->count('target_approval.empID');


        }

			$unit_offices_secondaries_id = ['Select Unit Secondary Office First...'] +  DB::table('unit_office_secondaries')
											->where('UnitOfficeID', '=', $unitoffice_id)
											->orderBy('UnitOfficeSecondaryName','asc')
											->lists('UnitOfficeSecondaryName','id');
        	if($secondaryoffice_id == '0')
			{
				$unit_offices_tertiaries_id = ['Select Unit Tertiary Office...'];
			}
			else
			{
				$unit_offices_tertiaries_id = ['Select Unit Tertiary Office First...'] +  DB::table('unit_office_tertiaries')
												->where('UnitOfficeSecondaryID', '=', $secondaryoffice_id)
												->orderBy('UnitOfficeTertiaryName','asc')
												->lists('UnitOfficeTertiaryName','id');
			}
        	
			$unit_offices_quaternaries_id = ['Select Unit Quaternary Office...'];

        	$filterby = ['none...'];
			return View::make('Unitadmindashboard')
				->with('id', $id)
				->with('sub_unit', $sub_unit)	
				->with('adminstate',$adminstate)
				->with('name', $name)
				->with('employs',$employs)
				->with('state',$state)
				->with('unitoffice',$unitoffice)
				->with('primaryoffice',$primaryoffice)
				->with('secondaryoffice',$secondaryoffice)
				->with('unitofficestate',$unitofficestate)
				->with('iffirsttime',$iffirsttime)
				->with('DateCovered', $DateCovered)
				->with('LastWeekDateCovered', $LastWeekDateCovered)
				->with('submitted', $submitted)
				->with('didNotSubmitted', $didNotSubmitted)
				->with('lastSubmitted', $lastSubmitted)
				->with('whosub', $whosub)
				->with('whoDidNotSub', $whoDidNotSub)
				->with('whoSubLast', $whoSubLast)
				->with('noScorecard', $noScorecard)
				->with('filterby', $filterby)
				->with('noScorecardList', $noScorecardList)
				->with('unit_offices_secondaries_id', $unit_offices_secondaries_id)
				->with('unit_offices_tertiaries_id', $unit_offices_tertiaries_id)
				->with('unit_offices_quaternaries_id', $unit_offices_quaternaries_id);

		}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');

		}
		
	}

	public function personnelReport()
	{
		$FilterBy = $_REQUEST['filter'];

		if($FilterBy == 1)
		{
			$filterby = DB::table('positions')->orderBy('PositionName', 'asc')->get();
			return Response::json($filterby);
		}
		if($FilterBy == 2)
		{
			$filterby = DB::table('ranks')->orderBy('Hierarchy', 'asc')->get();
			return Response::json($filterby);
		}
	}

	public function postDashboard()
	{
		if (Session::has('unitadminid') && Session::has('unitadminname')) {


			$id = Session::get('unitadminid', 'default');

			$name = Session::get('unitadminname', 'default');

			$unitoffice_id = Session::get('primaryunit','default');

			$unitofficestate = DB::table('unit_admins')
		 	->where('UnitOfficeID','=',$unitoffice_id)
		 	->where('id','!=',$id)
		 	->get();

			$secondaryoffice_id = Session::get('secondaryunit','default');

			$state = Input::get('state');
			if($secondaryoffice_id == '0')
			{
				DB::statement('UPDATE unit_admins SET state=:sur where UnitOfficeID=:res' ,
                             array('sur' => $state, 'res' => $unitoffice_id) );
				$officeHierarchy = 'primary';
				$officeId = $unitoffice_id;
			}
			else
			{
				DB::statement('UPDATE unit_admins SET state=:sur where id=:res' ,
                             array('sur' => $state, 'res' => $id) );
				$officeHierarchy = 'secondary';
				$officeId = $unitoffice_id;
			}
		 	
		 	$iffirsttime = DB::table('unit_admins')
			->where('id' ,'=', $id)
			->first();
			
		 	
		 	$state = DB::table('unit_admins')
		 	->where('id','=',$id)
		 	->get();
			$adminstate = DB::table('users')
			->get();

			
			$sub_unit = DB::table('unit_offices')
			->where('id', '=', $unitoffice_id)
			->where('UnitOfficeHasField', '=', 'True')
			->get();

			$employs = DB::table('ranks')
			->join('employs', 'ranks.id', '=', 'employs.RankID')
			->where('UnitOfficeID','=',$unitoffice_id)
			->where('employs.isActive', '!=', '0')
			->get();

			$unitoffice = DB::table('unit_admins')
			->where('id','=',$id)
			->get();

			$primaryoffice = DB::table('unit_offices')
			->get();
			$secondaryoffice = DB::table('unit_office_secondaries')
			->get();
			foreach($unitoffice as $unitadmin)
			{
				if($unitadmin->UnitOfficeSecondaryID != '0')
				{
					$employs = DB::table('ranks')
					->join('employs', 'ranks.id', '=', 'employs.RankID')
					->where('UnitOfficeID','=',$unitoffice_id)
					->where('UnitOfficeSecondaryID','=',$secondaryoffice_id)
					->where('employs.isActive', '!=', '0')
					->get();
					
				}

				if($unitadmin->UnitOfficeSecondaryID == '0')
				{
					$employs = DB::table('ranks')
					->join('employs', 'ranks.id', '=', 'employs.RankID')
					->where('UnitOfficeID','=',$unitoffice_id)
					->where('employs.isActive', '!=', '0')
					->get();
				}
				


			}

			if($secondaryoffice_id == '0')
			{
				$unitofficestate = DB::table('users')
		 		->get();
			}
			else
			{
				$unitofficestate = DB::table('unit_admins')
				->where('UnitOfficeID','=',$unitoffice_id)
				->where('id','!=',$id)
				->get();
			}

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
	        if($officeHierarchy == 'primary')
        {
        	$submitted = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('target_approval.status', '=', 'submitted')
						->where('UnitOfficeID', '=', $officeId)
						->where('date', '=', $dt_min)
						->where('employs.isActive', '!=', '0')
						->groupBy('employs.id')
						->get();

		$didNotSubmitted = DB::table('employs')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')

						
						
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
						->where('UnitOfficeID', '=', $officeId)
						->where('employs.isActive', '!=', '0')
						
						
						->get();


		$noScorecard = DB::table('employs')
				->whereNotIn('employs.id', function($q)
					{
						$q->select('empID')->from('target_approval');
					})
				->where('UnitOfficeID', '=', $officeId)
				->where('employs.isActive', '!=', '0')
				->count();
		
		$noScorecardList = DB::table('employs')
				->join('ranks', 'ranks.id', '=', 'employs.RankID')
				->whereNotIn('employs.id', function($q)
					{
						$q->select('empID')->from('target_approval');
					})
				->where('UnitOfficeID', '=', $officeId)
				->where('employs.isActive', '!=', '0')
				->get();


		$lastSubmitted = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('target_approval.status', '=', 'submitted')
						->where('date', '=', $LastWeekStartDate)
						->where('UnitOfficeID', '=', $officeId)
						->where('employs.isActive', '!=', '0')
						->groupBy('employs.id')
						->get();
			
		$whosub = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->where('target_approval.status', '=', 'submitted')
						->where('date', '=', $dt_min)
						->where('UnitOfficeID', '=', $officeId)
						->where('employs.isActive', '!=', '0')
						->distinct('target_approval.empID')
						->count('target_approval.empID');


		$whoDidNotSub = DB::table('employs')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						
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
						->where('UnitOfficeID', '=', $officeId)
						->where('employs.isActive', '!=', '0')
						
						->count('employs.id');

			

		$whoSubLast = DB::table('target_approval')
							->join('employs', 'target_approval.EmpID', '=', 'employs.id')
							->where('target_approval.status', '=', 'submitted')
							->where('date', '=', $LastWeekStartDate)
							->where('UnitOfficeID', '=', $officeId)
							->where('employs.isActive', '!=', '0')
							->distinct('target_approval.empID')
							->count('target_approval.empID');
        }

        	

        


        else
        {


        	$submitted = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('target_approval.status', '=', 'submitted')
						->where('UnitOfficeSecondaryID', '=', $officeId)
						->where('date', '=', $dt_min)
						->where('employs.isActive', '!=', '0')
						->groupBy('employs.id')
						->get();

		$didNotSubmitted = DB::table('employs')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')

						
						
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
						->where('UnitOfficeSecondaryID', '=', $officeId)
						->where('employs.isActive', '!=', '0')
						
						
						->get();

		/*SELECT * FROM employs e
		INNER JOIN ranks r ON r.id = employs.RankID
		WHERE e.id 
		NOT IN (SELECT empID 
				FROM target_approval 
				WHERE target_approval.status = 'submitted' 
				AND target_approval.date = $LastWeekStartDate 
				OR target_approval.date = $dt_min)
		AND e.supervisorID = $id */

		$noScorecard = DB::table('employs')
				->whereNotIn('employs.id', function($q)
					{
						$q->select('empID')->from('target_approval');
					})
				->where('UnitOfficeSecondaryID', '=', $officeId)
				->where('employs.isActive', '!=', '0')
				->count();
		
		$noScorecardList = DB::table('employs')
				->join('ranks', 'ranks.id', '=', 'employs.RankID')
				->whereNotIn('employs.id', function($q)
					{
						$q->select('empID')->from('target_approval');
					})
				->where('UnitOfficeSecondaryID', '=', $officeId)
				->where('employs.isActive', '!=', '0')
				->get();


		$lastSubmitted = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('target_approval.status', '=', 'submitted')
						->where('date', '=', $LastWeekStartDate)
						->where('UnitOfficeSecondaryID', '=', $officeId)
						->where('employs.isActive', '!=', '0')
						->groupBy('employs.id')
						->get();
			
		$whosub = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->where('target_approval.status', '=', 'submitted')
						->where('date', '=', $dt_min)
						->where('UnitOfficeSecondaryID', '=', $officeId)
						->where('employs.isActive', '!=', '0')
						->distinct('target_approval.empID')
						->count('target_approval.empID');


		$whoDidNotSub = DB::table('employs')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						
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
						->where('UnitOfficeSecondaryID', '=', $officeId)
						->where('employs.isActive', '!=', '0')
						
						->count('employs.id');

			

		$whoSubLast = DB::table('target_approval')
							->join('employs', 'target_approval.EmpID', '=', 'employs.id')
							->where('target_approval.status', '=', 'submitted')
							->where('date', '=', $LastWeekStartDate)
							->where('UnitOfficeSecondaryID', '=', $officeId)
							->where('employs.isActive', '!=', '0')
							->distinct('target_approval.empID')
							->count('target_approval.empID');


        }

			return View::make('Unitadmindashboard')
				->with('id', $id)
				->with('name', $name)
				->with('sub_unit', $sub_unit)
				->with('employs',$employs)
				->with('state',$state)
				->with('iffirsttime',$iffirsttime)
				->with('DateCovered',$DateCovered)
				->with('LastWeekDateCovered',$LastWeekDateCovered)
				->with('submitted', $submitted)
				->with('whosub', $whosub)
				->with('lastSubmitted', $lastSubmitted)
				->with('didNotSubmitted', $didNotSubmitted)
				->with('noScorecard', $noScorecard) 
				->with('whoSubLast', $whoSubLast)
				->with('noScorecardList', $noScorecardList)
				->with('whoDidNotSub', $whoDidNotSub)
				->with('adminstate',$adminstate)
				->with('unitoffice',$unitoffice)
				->with('primaryoffice',$primaryoffice)
				->with('secondaryoffice',$secondaryoffice)
				->with('unitofficestate',$unitofficestate);

		}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');

		}
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		public function showEmployeeActivities()
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');
				$unitoffice_id = Session::get('primaryunit','default');
				$secondaryoffice_id = Session::get('secondaryunit','default');
				
				$employs = DB::table('employs')
				->where('UnitOfficeID','=',$unitoffice_id)
				->where('employs.isActive', '!=', '0')
				->get();

				$unitoffice = DB::table('unit_admins')
				->where('id','=',$id)
				->get();

				$primaryoffice = DB::table('unit_offices')
				->get();
				$secondaryoffice = DB::table('unit_office_secondaries')
				->get();
				foreach($unitoffice as $unitadmin)
				{
					if($unitadmin->UnitOfficeSecondaryID != '0')
					{
						$employs = DB::table('employs')
						->where('UnitOfficeID','=',$unitoffice_id)
						->where('UnitOfficeSecondaryID','=',$secondaryoffice_id)
						->where('employs.isActive', '!=', '0')
						->get();
					}

					if($unitadmin->UnitOfficeSecondaryID == '0')
					{
						$employs = DB::table('employs')
						->where('UnitOfficeID','=',$unitoffice_id)
						->where('employs.isActive', '!=', '0')
						->get();
					}
				}
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
				return View::make('UAEactivities')
					->with('secondaryoffice_id', $secondaryoffice_id)
					->with('id', $id)
					->with('name', $name)
					->with('OfficeName', $OfficeName)
					->with('employs',$employs);
			}
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}

		}

		public function ajaxShowEmployeeActivities()
		{
			$id = Session::get('unitadminid', 'default');
			$unitoffice_id = Session::get('primaryunit','default');
			$secondaryoffice_id = Session::get('secondaryunit','default');

			$employs = DB::table('ranks')
									->join('employs', 'ranks.id', '=', 'employs.RankID')
									->where('UnitOfficeID','=',$unitoffice_id)
									->where('employs.isActive', '!=', '0')
									->select('employs.id as id', 'ranks.RankCode as RankCode', 'employs.EmpLastName as LastName', 'employs.EmpFirstName as FirstName')
									->orderBy('ranks.Hierarchy', 'asc');

			$unitoffice = DB::table('unit_admins')
				->where('id','=',$id)
				->get();

			foreach($unitoffice as $unitadmin)
			{
				if($unitadmin->UnitOfficeSecondaryID != '0')
				{
					$employs = DB::table('ranks')
								->join('employs', 'ranks.id', '=', 'employs.RankID')
								->where('UnitOfficeID','=',$unitoffice_id)
								->where('UnitOfficeSecondaryID','=',$secondaryoffice_id)
								->where('employs.isActive', '!=', '0')
								->select('employs.id as id', 'ranks.RankCode as RankCode', 'employs.EmpLastName as LastName', 'employs.EmpFirstName as FirstName')
								->orderBy('ranks.Hierarchy', 'asc');
				}
				if($unitadmin->UnitOfficeSecondaryID == '0')
				{
					$employs = DB::table('ranks')
								->join('employs', 'ranks.id', '=', 'employs.RankID')
								->where('UnitOfficeID','=',$unitoffice_id)
								->where('employs.isActive', '!=', '0')
								->select('employs.id as id', 'ranks.RankCode as RankCode', 'employs.EmpLastName as LastName', 'employs.EmpFirstName as FirstName')
								->orderBy('ranks.Hierarchy', 'asc');
				}
			}
			
			return Datatables::of($employs)
	        ->add_column('Add Activities', '
                            <a class = \'btn btn-info\' style= "margin-bottom:5px" href="{{ URL::to(\'UAEaddemployeemain/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'UAEaddemployeemain/\' . $id) }}\', \'newwindow\'); return false;">Add Main Activities</a>
                            <br> 
                            <a class = \'btn btn-info\' style= "margin-bottom:5px" href="{{ URL::to(\'UAEotheractivity/otheractivities/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'UAEotheractivity/otheractivities/\' . $id) }}\', \'newwindow\'); return false;">Add Other Activities</a>
                            <br> 
                            <a class = \'btn btn-info\' style= "margin-bottom:5px" href="{{ URL::to(\'UAEaddemployeesub/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'UAEaddemployeesub/\' . $id) }}\', \'newwindow\'); return false;">Add Sub Activities</a>
                            <br> 
                            <a class = \'btn btn-info\' style= "margin-bottom:5px"  href="{{ URL::to(\'UAEaddemployeemeasure/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'UAEaddemployeemeasure/\' . $id) }}\', \'newwindow\'); return false;">Add Measures</a>
	                    ')
			->add_column('Edit Activities', '
	        				<a class = \'btn btn-warning\' style= "margin-bottom:5px" href="{{ URL::to(\'UAEsetemployeemain/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'UAEsetemployeemain/\' . $id) }}\', \'newwindow\'); return false;">Edit Main Activities</a>                                 
                            <br> 
                            <a class = \'btn btn-warning\' style= "margin-bottom:5px" href="{{ URL::to(\'UAEsetemployeesub/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'UAEsetemployeesub/\' . $id) }}\', \'newwindow\'); return false;">Edit Sub Activities</a>
                            <br> 
                            <a class = \'btn btn-warning\' style= "margin-bottom:5px" href="{{ URL::to(\'UAEsetemployeemeasure/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'UAEsetemployeemeasure/\' . $id) }}\', \'newwindow\'); return false;">Edit Measures</a>
	                    ')
			->add_column('Delete Activities', '
	        				<a class = \'btn btn-danger\' style= "margin-bottom:5px" href="{{ URL::to(\'uaremoveempact/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'uaremoveempact/\' . $id) }}\', \'newwindow\'); return false;">Delete Activities</a>   
							{{ HTML::link(\'#my_modal\', \'Remove Current Scorecard\', array(\'data-book-id\' => $id, \'class\' => \'btn btn-danger\', \'data-toggle\' => \'modal\', \'style\' => \'margin-bottom:5px\'))}}
                            ')
			->add_column('Assign Objectives', '
	        				<a class = \'btn btn-success\' href="{{ URL::to(\'UAEsetemployeeobjective/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'UAEsetemployeeobjective/\' . $id) }}\', \'newwindow\'); return false;">Assign Objectives</a>
	                    	')
	        ->remove_column('id')
	        ->make(true);
		}

		public function addEmployeeMainActivity($id)
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');
				$main_activities = DB::table('main_activities')->where('EmpID', '=', $id)->get();
				$sub_activities = DB::table('sub_activities')->where('EmpID', '=', $id)->get();
				$measures = DB::table('measures')->where('EmpID', '=', $id)->get();
				$emp_activities = DB::table('main_activities')
					->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')
					->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')
					->join('employs','main_activities.EmpID','=','employs.id')
	    			->where('main_activities.EmpID', '=', $id)
	    			->where('employs.id','=',$id)
	    			->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID")
	    			->orderBy('main_activities.id','asc')
	    			->orderBy('sub_activities.id','asc')
	    			->get();
	    		$Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
				$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;
				return View::make('UAEaddmainactivity')
				    ->with('PersonnelName', $PersonnelName)
					->with('main_activities', $main_activities)
					->with('sub_activities', $sub_activities)
					->with('measures', $measures)
					->with('emp_activities', $emp_activities)
					->with('emp_id', $id)
					->with('name', $name)
					->with('id',$unit_admin_id);
			}
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}
		}

		public function postaddEmployeeMainActivity()
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');
				$id = Input::get('empid');
				$MainActivity =Input::get('main_activity');
				$SubActivities =Input::get('sub_activities');
				$count = DB::table('main_activities')->where('EmpID', '=', $id)->count();
				if($count == 0){
					$count = 1;
				}
				else{
				$count = $count + 1;
				}
				$employeeinfo = DB::table('employs')
				->where('id','=',$id)
				->first();

				if($MainActivity != "")
				{
					$tempmain = DB::table('main_activities')->where('EmpID', '=', $id)->where('MainActivityName', '=', $MainActivity)->first();

				if($tempmain == null)
					{
					//DB::insert('insert into main_activities (Main_ID, MainActivityName, EmpID) values (?,?,?)', array($count, $MainActivity, $id));
					DB::insert('insert into main_activities (Main_ID, MainActivityName, EmpID, UnitOfficeID, UnitOfficeSecondaryID, UnitOfficeTertiaryID, UnitOfficeQuaternaryID) values (?,?,?,?,?,?,?)', array($count, $MainActivity, $id, $employeeinfo->UnitOfficeID, $employeeinfo->UnitOfficeSecondaryID, $employeeinfo->UnitOfficeTertiaryID,$employeeinfo->UnitOfficeQuaternaryID));
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

				$Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
				$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;
				
				return View::make('UAEaddmainactivitymeasure')
				    ->with('PersonnelName', $PersonnelName)
					->with('MainActivityOfEmp', $MainActivityOfEmp)
					->with('SubActivityOfEmp', $SubActivityOfEmp)
					->with('emp_id',$id)
					->with('name', $name)
					->with('id',$unit_admin_id);
					
				}
				else
				{
					Session::flash('message', 'Please input main Activity!');
					return Redirect::to('UAEaddemployeemain/' . $id);
				}#
			}
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}
		}

		public function postaddEmployeeMeasure()
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$id = Input::get('empid');
				$pic = Session::get('emppic', 'default');
				$sub_id = Input::get('sub_id');
				$measures = Input::get('measures');
				$measuretype = Input::get('measure_type');
				if($sub_id == null)
				{
					return Redirect::to('UAEactivities');
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
				return Redirect::to('UAEactivities');
			}
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}
		}
////////////////////////////////////////////////////////////////////////////////////////
		public function addEmployeeSubActivity($id)
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');

				//$MainActivityOfEmp=DB::table('main_activities')->where('EmpID','=', $id)->orderBy('Main_ID','asc')->get();
			$MainActivityOfEmp=DB::table('employs')
				->join('main_activities','employs.id','=','main_activities.EmpID')
				->where('employs.id','=',$id)
				->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID")
				->get();

				$Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
				$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;
			
				return View::make('UAEaddsubactivity')
				    ->with('PersonnelName', $PersonnelName)
					->with('MainActivityOfEmp', $MainActivityOfEmp)
					->with('emp_id',$id)
					->with('name', $name)
					->with('id',$unit_admin_id);
			}
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}
		}

		public function postaddEmployeeSubactivity()
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');

				$main_id = Input::get('main_id');
				$id = Input::get('empid');
				$sub_id = Input::get('subactivity');
				$count = 0;
				$index = 0;
				$counter = 0;
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

				$Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
				$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;

				Session::flash('message', 'Sub-Activity successfully added!');
				return View::make('UAEaddsubactivitymeasure')
				    ->with('PersonnelName', $PersonnelName)
					->with('counter',$counter)
					->with('subactivities',$subactivities)
					->with('emp_id',$id)
					->with('name', $name)
					->with('id',$unit_admin_id);
				}
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}
		}

		public function postAddEmployeeSubMeasure()
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$id = Input::get('empid');
				$sub_id = Input::get('sub_id');
				$measures = Input::get('measures');
				$measuretype = Input::get('measure_type');
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
				Session::flash('message', 'Activity successfully added!');
				return Redirect::to('UAEactivities');
			}
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}
		}
////////////////////////////////////////////////////////////////////////////////////////////////////////
		public function setEmployeeSubActivity($id)
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');
	            $main = 0;
	            $main_activities = DB::table('main_activities')->get();
	            $sub_activities = DB::table('sub_activities')->where('id', '=',  '0')->get();
	            //$main_id= ['Select Main Activity...'] + DB::table('main_activities')->orderBy('MainActivityName','asc')->where('EmpID', '=', $id)
	            //->lists('MainActivityName','id');
	             $main_id = ['Select Main Activity...'] + DB::table('main_activities')
				            ->join('employs','main_activities.EmpID','=','employs.id')
				            ->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
				            ->where('employs.id','=',$id)
				           	->where('main_activities.EmpID','=',$id)
				           	->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
					    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
					    						AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
					    						AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
				            ->orderBy('MainActivityName','asc')
				            ->lists('MainActivityName','id');
				$Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
				$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;
	    		return View::make('UAEsetsubactivity')
				    ->with('PersonnelName', $PersonnelName)
		            ->with('main_activities', $main_activities)
		            ->with('main_id', $main_id)
		            ->with('main', $main)
		            ->with('emp_id',$id)
		            ->with('sub_activities', $sub_activities)
		            ->with('name', $name)
					->with('id',$unit_admin_id);
			}
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}
		}

		public function postsetEmployeeSubActivity()
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');
				$id = Input::get('empid');
				$main = Input::get('main_id');
	            $main_activities = DB::table('main_activities')->get();
	            $main = Input::get('main_id');
	            //$main_id= ['Select Main Activity...'] + DB::table('main_activities')->orderBy('MainActivityName','asc')->where('EmpID', '=', $id)
	            //->lists('MainActivityName','id');
	             $main_id= ['Select Main Activity...'] + DB::table('main_activities')
	            ->join('employs','main_activities.EmpID','=','employs.id')
	            ->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
	            ->where('employs.id','=',$id)
	           	->where('main_activities.EmpID','=',$id)
	           	->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
		    						AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
		    						AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
	            ->orderBy('MainActivityName','asc')
	      	
	            ->lists('MainActivityName','id');
	            $sub_activities = DB::table('sub_activities')->join('main_activities', 'main_activities.id', '=', 
	                'sub_activities.MainActivityID')->where('MainActivityID', '=', $main)->select('main_activities.id as MainActivityID' ,'Main_ID', 'sub_activities.id as SubActivityID', 'MainActivityName', 
	                    'SubActivityName', 'TerminationDate')->get();

	            $Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
				$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;
	            return View::make('UAEsetsubactivity')
				    ->with('PersonnelName', $PersonnelName)
		            ->with('main_activities', $main_activities)
		            ->with('main_id', $main_id)
		            ->with('main', $main)
		            ->with('emp_id',$id)
		            ->with('sub_activities', $sub_activities)
		            ->with('name', $name)
		            ->with('id', $unit_admin_id);
	        }
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}
		}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		public function postEdit()
    	{
        
            $id = Input::get('empid');
           
            $main_activities = DB::table('main_activities')->get();
          
            $main = Input::get('main');
            
        
            $subs = Input::get('sub_activity');
            
            $sub_id = Input::get('subactivity');
            $state_ids = Input::get('state_id');

            //$main_id= ['Select Main Activity...'] + DB::table('main_activities')->where('EmpID', '=', $id)->orderBy('MainActivityName','asc')
            //->lists('MainActivityName','id');
             $main_id= ['Select Main Activity...'] + DB::table('main_activities')
	            ->join('employs','main_activities.EmpID','=','employs.id')
	            ->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
	            ->where('employs.id','=',$id)
	           	->where('main_activities.EmpID','=',$id)
	           	->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
		    						AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
		    						AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
	            ->orderBy('MainActivityName','asc')
	      	
	            ->lists('MainActivityName','id');
            $sub_activities = DB::table('sub_activities')->join('main_activities', 'main_activities.id', '=', 
                'sub_activities.MainActivityID')->where('MainActivityID', '=', $main)->select('main_activities.id as MainActivityID' ,'Main_ID', 'sub_activities.id as SubActivityID', 'MainActivityName', 
                    'SubActivityName', 'TerminationDate')->get();
            

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
            $dt_max->modify('+6 days');
            
             $i = 0;   
            if ($subs != null)
            {
                foreach($subs as $sub)
                {

                        DB::statement('UPDATE sub_activities SET SubActivityName=:sur WHERE EmpID=:res AND id=:res2' ,
                             array('sur' => $sub, 'res' => $id, 'res2' =>$sub_id[$i]) );
                        $i++;
                }
            }
             if ($state_ids != null)
            {
            $x = 0;
            foreach($state_ids as $state_id)
            {
                if ($state[$x] == 'Disable'){
                DB::statement('UPDATE sub_activities SET TerminationDate=:sur WHERE EmpID=:res AND id=:res2' ,
                         array('sur' => $dt_max, 'res' => $id, 'res2' =>$state_id) );
                }
               if ($state[$x] == 'Enable'){
                      DB::statement('UPDATE sub_activities SET TerminationDate=:sur WHERE EmpID=:res AND id=:res2' ,
                         array('sur' => NULL, 'res' => $id, 'res2' =>$state_id) );
                }    
                 $x++;
                }

            }

           
           Session::flash('message', 'Changes Saved!');
            return Redirect::to('UAEactivities');
        }

		public function setEmployeeMeasure($id)
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');
				$main = 0;
	            $main_activities = DB::table('main_activities')->get();
	            $sub_activities = ['None...'];
	            $measures = DB::table('measures')->where('id', '=',  '0')->get();
	            //$main_id= ['Select Main Activity...'] + DB::table('main_activities')->where('EmpID', '=', $id)->orderBy('MainActivityName','asc')
	            //->lists('MainActivityName','id');
	            $main_id = ['Select Main Activity...'] + DB::table('main_activities')
		    					->join('employs','main_activities.EmpID','=','employs.id')
		    					->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
		    					->where('employs.id','=',$id)
		    					->where('main_activities.EmpID','=',$id)
		    					->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID")
		    					->orderBy('MainActivityName','asc')
		    					->lists('MainActivityName','id');
		    	$Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
				$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;
	    		return View::make('UAEsetmeasure')
				    ->with('PersonnelName', $PersonnelName)
		            ->with('main_activities', $main_activities)
		            ->with('main_id', $main_id)
		            ->with('main', $main)
		            ->with('sub_activities', $sub_activities)
		            ->with('measures',$measures)
		            ->with('emp_id',$id)
	                ->with('name', $name)
		            ->with('id', $unit_admin_id);
	        }
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}
		}
		public function postsetEmployeeMeasure()
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');
				$id = Input::get('empid');
				$main = Input::get('main_id');
	            $main_activities = DB::table('main_activities')->get();
	             $measures = DB::table('measures')->where('id', '=',  '0')->get();
	            //$main_id= ['Select Main Activity...'] + DB::table('main_activities')->where('EmpID', '=', $id)->orderBy('MainActivityName','asc')
	            //->lists('MainActivityName','id');
	             $main_id = ['Select Main Activity...'] + DB::table('main_activities')
		    					->join('employs','main_activities.EmpID','=','employs.id')
		    					->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
		    					->where('employs.id','=',$id)
		    					->where('main_activities.EmpID','=',$id)
		    					->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID")
		    					->orderBy('MainActivityName','asc')
		    					->lists('MainActivityName','id');
	            $sub_activities = ['Select Sub Activity...'] + DB::table('sub_activities')->where('EmpID', '=', $id)->where('MainActivityID', '=', $main)->lists('SubActivityName','id');
	            $Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
				$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;
	            return View::make('UAEsetmeasure')
				   	->with('PersonnelName', $PersonnelName)
		            ->with('main_activities', $main_activities)
		            ->with('main_id', $main_id)
		            ->with('main', $main)
		            ->with('sub_activities', $sub_activities)
		            ->with('measures',$measures)
		            ->with('emp_id',$id)
	                ->with('name', $name)
		            ->with('id', $unit_admin_id);
	        }
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}

		}

		public function postsetEmployeeMeasure2()
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');
				$id = Input::get('empid');
				$main = Input::get('main_id');
	            $main_activities = DB::table('main_activities')->get();
	            //$main_id= ['Select Main Activity...'] + DB::table('main_activities')->where('EmpID', '=', $id)->orderBy('MainActivityName','asc')
	            //->lists('MainActivityName','id');
	            $main_id = ['Select Main Activity...'] + DB::table('main_activities')
		    					->join('employs','main_activities.EmpID','=','employs.id')
		    					->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
		    					->where('employs.id','=',$id)
		    					->where('main_activities.EmpID','=',$id)
		    					->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID")
		    					->orderBy('MainActivityName','asc')
		    					->lists('MainActivityName','id');
	            $sub_id = Input::get('sub_activities');
	            $sub_activities = DB::table('sub_activities')->where('EmpID', '=', $id)->lists('SubActivityName','id');
	            $measures = DB::table('measures')->join('sub_activities', 'sub_activities.id', '=', 
	                'measures.SubActivityID')->join('main_activities', 'main_activities.id', '=', 
	                'sub_activities.MainActivityID')->where('SubActivityID', '=', $sub_id)->select('sub_activities.id as SubActivityID' ,'Main_ID', 'measures.id as MeasureID', 'MeasureName', 
	                    'SubActivityName', 'measures.TerminationDate as TermDate','measures.MeasureType as MeasureType')->get();
	            $Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
				$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;
	            return View::make('UAEsetmeasure')
				    ->with('PersonnelName', $PersonnelName)
		            ->with('emp_id',$id)
		            ->with('main_activities', $main_activities)
		            ->with('main_id', $main_id)
		            ->with('main', $main)
		            ->with('sub_activities', $sub_activities)
		            ->with('measures',$measures)
	                ->with('name', $name)
		            ->with('id', $unit_admin_id);
	        }
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}

		} 
		public function postEditMeasure()
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$id = Input::get('empid');
				$main = Input::get('main_id');
	            $main_activities = DB::table('main_activities')->get();
	            //$main_id= ['Select Main Activity...'] + DB::table('main_activities')->where('EmpID', '=', $id)->orderBy('MainActivityName','asc')
	            //->lists('MainActivityName','id');
	            $main_id = ['Select Main Activity...'] + DB::table('main_activities')
		    					->join('employs','main_activities.EmpID','=','employs.id')
		    					->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
		    					->where('employs.id','=',$id)
		    					->where('main_activities.EmpID','=',$id)
		    					->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID")
		    					->orderBy('MainActivityName','asc')
		    					->lists('MainActivityName','id');
	            $sub_id = Input::get('sub_activities');
	            $sub_activities = DB::table('sub_activities')->where('EmpID', '=', $id)->lists('SubActivityName','id');
	            
	            $measure1 = Input::get('measures');
	            $measures_id = Input::get('measures_id');
	            $state_ids = Input::get('state_id');
	            $measuretype = Input::get('measure_types');
	           
	           $measures = DB::table('measures')->join('sub_activities', 'sub_activities.id', '=', 
	                'measures.SubActivityID')->join('main_activities', 'main_activities.id', '=', 
	                'sub_activities.MainActivityID')->where('SubActivityID', '=', $sub_id)->select('sub_activities.id as SubActivityID' , 'Main_ID', 'measures.id as MeasureID', 'MeasureName', 
	                    'SubActivityName', 'measures.TerminationDate as TermDate','measures.MeasureType as MeasureType')->get();
	            

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
	            $dt_max->modify('+6 days');
	            
	             $i = 0;   
	            if ($measure1 != null)
	            {
	                foreach($measure1 as $measure)
	                {

	                        DB::statement('UPDATE measures SET MeasureName=:sur,MeasureType=:sur2 WHERE EmpID=:res AND id=:res2' ,
	                             array('sur' => $measure,'sur2' => $measuretype[$i],'res' => $id, 'res2' =>$measures_id[$i]) );
	                        $i++;
	                }
	            }
	             if ($state_ids != null)
	            {
	            $x = 0;
	            foreach($state_ids as $state_id)
	            {
	                if ($state[$x] == 'Disable'){
	                DB::statement('UPDATE measures SET TerminationDate=:sur WHERE EmpID=:res AND id=:res2' ,
	                         array('sur' => $dt_max, 'res' => $id, 'res2' =>$state_id) );
	                }
	               if ($state[$x] == 'Enable'){
	                      DB::statement('UPDATE measures SET TerminationDate=:sur WHERE EmpID=:res AND id=:res2' ,
	                         array('sur' => NULL, 'res' => $id, 'res2' =>$state_id) );
	                }    
	                 $x++;
	                }

	            }



	           
	           Session::flash('message', 'Changes Saved!');
	            return Redirect::to('UAEactivities');  
	        }
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}       
		}


		//measure only
		public function addEmployeeMeasure($id)
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');
			//$mainactivities = DB::table('main_activities')
			//->where('EmpID', '=', $id)
			//->get();
			$mainactivities = DB::table('main_activities')
		    					->join('employs','main_activities.EmpID','=','employs.id')
		    					->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
		    					->where('employs.id','=',$id)
		    					->where('main_activities.EmpID','=',$id)
		    					->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID")
		    					->get();
			$subactivities = DB::table('sub_activities')
			->where('EmpID','=',$id)
			->get();

				$Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
				$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;
				return View::make('UAEaddemployeemeasure')
				    ->with('PersonnelName', $PersonnelName)
					->with('subactivities',$subactivities)
					->with('mainactivities', $mainactivities)
					->with('unit_admin_id', $unit_admin_id)
					->with('name', $name)
					->with('id', $id);
			}
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}       	
				
		}

		public function UAEaddemployeesubmeasure()
		{
			$id = Input::get('empid');
			$sub_id = Input::get('sub_id');
			$measures = Input::get('measures');
			$measuretype = Input::get('measure_type');
			$count = 0;
			foreach ($sub_id as $Sub) 
			{
				if($measures[$count] != "")
				{
					DB::insert('insert into measures (MeasureName, SubActivityID ,MeasureType, EmpID) values (?,?,?,?)', array($measures[$count], $Sub, $measuretype[$count], $id));
					
				}
				$count++;
			
			}	
			Session::flash('message', 'Activity successfully added!');
			return Redirect::to('UAEactivities');

		}

///////////////////////////////OBJECTIVE///////////////////////////////////////////////////////////////////////
		public function setEmployeeObjective($id)
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');
				$perspectives_id = ['Select Perspective...'] + DB::table('perspectives')
				->orderBy('PerspectiveName','asc')
				->lists('PerspectiveName','id');
				$objectives_id= ['none...'];
				$main_activities = DB::table('main_activities')
				->where('EmpID','=',$id)
				->get();
				$sub_activities = DB::table('sub_activities')
				->where('EmpID','=',$id)
				->where('ObjectiveID', '=', null)
				->get();

				$sub_activities2 = DB::table('sub_activities')
				->where('EmpID','=',$id)
				->whereNotNull('ObjectiveID')
				->get();
				//$mainactivities_id = DB::table('main_activities')
				//->where('EmpID','=',$id)
				//->lists('MainActivityName','id');
				$mainactivities_id = DB::table('main_activities')
		    					->join('employs','main_activities.EmpID','=','employs.id')
		    					->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
		    					->where('employs.id','=',$id)
		    					->where('main_activities.EmpID','=',$id)
		    					->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
		    						AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
		    						AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
		    					->lists('MainActivityName','id');
				$id_dropdown="0";
				$id_dropdown2="0";
				$users = DB::table('users')->get();	
				$Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
				$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;
				return View::make('UAEsetobjective')
				    ->with('PersonnelName', $PersonnelName)
					->with('perspectives_id',$perspectives_id)
					->with('objectives_id',$objectives_id)
					->with('main_activities',$main_activities)
					->with('sub_activities',$sub_activities)
					->with('mainactivities_id',$mainactivities_id)
					->with('id_dropdown2',$id_dropdown2)
					->with('id_dropdown',$id_dropdown)
					->with('users',$users)
					->with('emp_id',$id)
					->with('name', $name)
		            ->with('id', $unit_admin_id)
		            ->with('sub_activities2',$sub_activities2);
	        }
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}
		}


			public function ajaxUAsetObjective()
		{
			
			$perspectiveID = $_REQUEST['PerspectiveID'];
			$empid = $_REQUEST['emp_id'];
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
			->where('employs.id','=',$empid)
			->where('objectives.PerspectiveID','=',$perspectiveID)
			->get();
		}
					//$objectives_id = DB::table('objectives')
					//->get();

		
			return Response::json($objectives_id);
			

		}


		public function saveupdatePostSetEmployeeObjective()
		{
			$id_checkbox1 = Input::get('checkboxid1');
			$id_checkbox2 = Input::get('checkboxid2');
			$objectives_id = Input::get('ObjectiveID');
			
			$emp_id = Input::get('empid');


			if(Input::get('save')) 
            {
				if($id_checkbox1 != null and $objectives_id != 0)
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

					Session::flash('message', 'Sub Activity successfully assigned to objective!');
					return Redirect::to('UAEactivities');
				}
				else
				{
					Session::flash('message', 'Incomplete inputs. Please assign objective,perspective and check corresponding sub-activities!');
					return Redirect::to('UAEsetemployeeobjective/' . $emp_id);
				}
            }
            elseif(Input::get('update'))
            {
				if($id_checkbox2 != null and $objectives_id != 0)
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

					Session::flash('message', 'Sub Activity Objective successfully updated!');
					return Redirect::to('UAEactivities');
				}
				else
				{
					Session::flash('message', 'Incomplete inputs. Please assign objective,perspective and check corresponding sub-activities!');
					return Redirect::to('UAEsetemployeeobjective/' . $emp_id);
				}
            }

            
		}


		public function postsetEmployeeObjective()
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');
				$unitoffice_id = Session::get('primaryunit','default');
				$secondaryoffice_id = Session::get('secondaryunit','default');

				$id = Input::get('empid');
				$id_dropdown = Input::get('PerspectiveID');
				$id_dropdown2="0";	
				$perspectives_id = ['Select Perspective...'] + DB::table('perspectives')
					->lists('PerspectiveName','id');

				//$objectives_id = ['Select Objective...'] + DB::table('objectives')
				//			->where('PerspectiveID','=',$id_dropdown)
				//			->lists('ObjectiveName','id');

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
						->select('objectives.ObjectiveName as ObjectiveName','objectives.id as id')
						->where('obj_primaryunitoffice.PrimaryUnitOfficeID','=',$unitoffice_id)
						->where('objectives.PerspectiveID','=',$id_dropdown)
						->lists('ObjectiveName','id');
					}

				//$mainactivities_id = DB::table('main_activities')
				//				->where('EmpID','=',$id)
				//				->lists('MainActivityName','id');
				$mainactivities_id = DB::table('main_activities')
		    					->join('employs','main_activities.EmpID','=','employs.id')
		    					->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
		    					->where('employs.id','=',$id)
		    					->where('main_activities.EmpID','=',$id)
		    					->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
		    						AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
		    						AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
		    					->lists('MainActivityName','id');
				$sub_activities = DB::table('sub_activities')
							->where('EmpID','=',$id)
							->where('ObjectiveID', '=', null)
							->get();
				$sub_activities2 = DB::table('sub_activities')
							->where('EmpID','=',$id)
							->whereNotNull('ObjectiveID')
							->get();
				$Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
				$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;
				return View::make('UAEsetobjective')
				    ->with('PersonnelName', $PersonnelName)
					->with('emp_id',$id)
					->with('perspectives_id',$perspectives_id)
					->with('objectives_id',$objectives_id)
					->with('sub_activities',$sub_activities)
					->with('mainactivities_id',$mainactivities_id)
					->with('id_dropdown',$id_dropdown)
					->with('id_dropdown2',$id_dropdown2)
					->with('name', $name)
		            ->with('id', $unit_admin_id)
		            ->with('sub_activities2',$sub_activities2);
	        }
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}


		}
		public function postsetEmployeeObjective2()
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');
				$unitoffice_id = Session::get('primaryunit','default');
				$secondaryoffice_id = Session::get('secondaryunit','default');

				$id = Input::get('empid');
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
						->select('objectives.ObjectiveName as ObjectiveName','objectives.id as id')
						->where('obj_primaryunitoffice.PrimaryUnitOfficeID','=',$unitoffice_id)
						->where('objectives.PerspectiveID','=',$id_dropdown)
						->lists('ObjectiveName','id');
					}
				//$mainactivities_id = DB::table('main_activities')
				//		->where('EmpID','=',$id)
				//		->lists('MainActivityName','id');
				$mainactivities_id = DB::table('main_activities')
		    					->join('employs','main_activities.EmpID','=','employs.id')
		    					->select('main_activities.MainActivityName as MainActivityName','main_activities.id as id')
		    					->where('employs.id','=',$id)
		    					->where('main_activities.EmpID','=',$id)
		    					->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    						AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
		    						AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
		    						AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
		    					->lists('MainActivityName','id');
				$sub_activities = DB::table('sub_activities')
						->where('EmpID','=',$id)
						->where('ObjectiveID', '=', null)
						->get();
				$sub_activities2 = DB::table('sub_activities')
						->where('EmpID','=',$id)
						->whereNotNull('ObjectiveID')
						->get();
				$Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
				$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;
				return View::make('UAEsetobjective')
				    ->with('PersonnelName', $PersonnelName)
					->with('emp_id', $id)
					->with('perspectives_id',$perspectives_id)
					->with('sub_activities',$sub_activities)
					->with('mainactivities_id',$mainactivities_id)
					->with('id_dropdown2',$id_dropdown2)
					->with('id_dropdown',$id_dropdown)
					->with('objectives_id',$objectives_id)
					->with('name', $name)
		            ->with('id', $unit_admin_id)
		            ->with('sub_activities2',$sub_activities2);
	        }
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}
		}

		public function savePostSetEmployeeObjective()
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$id_checkbox = Input::get('checkboxid');
				$objectives_id = Input::get('ObjectivesID');

				$emp_id = Input::get('empid');
				if($id_checkbox != null and $objectives_id != 0)
				{
					foreach($id_checkbox as $id)
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

					Session::flash('message', 'Sub Activity successfully assigned to objective!');
					return Redirect::to('UAEactivities');
				}
				else
				{
					Session::flash('message', 'Incomplete inputs. Please assign objective,perspective and check corresponding sub-activities!');
					return Redirect::to('UAEsetemployeeobjective/' . $emp_id);
				}
			}
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}
		}

		public function updateEmployeeObjectiveUnitadmin()
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$id_checkbox = Input::get('checkboxid');
				$objectives_id = Input::get('ObjectivesID');

				$emp_id = Input::get('empid');
				if($id_checkbox != null and $objectives_id != 0)
				{
					foreach($id_checkbox as $id)
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

					Session::flash('message', 'Sub Activity Objective successfully updated!');
					return Redirect::to('UAEactivities');
				}
				else
				{
					Session::flash('message', 'Incomplete inputs. Please assign objective,perspective and check corresponding sub-activities!');
					return Redirect::to('UAEsetemployeeobjective/' . $emp_id);
				}
			}
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}
		}

////////////////FROM LINE 385?????????????????????????????????????????????????????????????????????????????????????????????
		public function assignObjectiveOfficeGet()
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');
				$unitoffice_id = Session::get('primaryunit','default');
				$secondaryoffice_id = Session::get('secondaryunit','default');



				$users = DB::table('users')->get();
				$id = Input::get('empid');
				$id_dropdown = Input::get('PerspectiveID');
				$perspectives_id = ['Select Perspective...'] + DB::table('perspectives')
				->lists('PerspectiveName','id');



				$unitadmintype = DB::table('unit_admins')
					->where('id', '=', $unit_admin_id)
					->first();

				if($unitadmintype->UnitOfficeSecondaryID == 0)
				{
					$objectives = DB::table('objectives')
						->join('obj_primaryunitoffice', 'objectives.id', '=', 'obj_primaryunitoffice.ObjectiveID')
						->where('obj_primaryunitoffice.PrimaryUnitOfficeID', '=', $unitoffice_id)
						->get();
				}
				else
				{
					$objectives = DB::table('objectives')
						->join('obj_secondaryunitoffice', 'objectives.id', '=', 'obj_secondaryunitoffice.ObjectiveID')
						->where('obj_secondaryunitoffice.SecondaryUnitOfficeID', '=', $secondaryoffice_id)
						->get();
				}
				

				$primaryoffices = DB::table('unit_offices')->get();
				$secondaryoffices = DB::table('unit_office_secondaries')
				->where('UnitOfficeID', '=', $unitoffice_id)
				->get();
				
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
					
					return View::make('UAEobjectiveunitoffices')
						->with('OfficeName', $OfficeName)
						->with('empid', $id)
						->with('perspectives_id',$perspectives_id)
						->with('objectives',$objectives)
						->with('users',$users)
						->with('primaryoffices', $primaryoffices)
						->with('secondaryoffices', $secondaryoffices)
						->with('name', $name)
		            	->with('id', $unit_admin_id);
	        }
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}

		}

		public function assignObjectiveOfficePost()
		{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');
				$unitoffice_id = Session::get('primaryunit','default');
				$secondaryoffice_id = Session::get('secondaryunit','default');

				$users = DB::table('users')->get();
				$id = Input::get('empid');
				$id_dropdown = Input::get('PerspectiveID');
				$perspectives_id = ['Select Perspective...'] + DB::table('perspectives')
					->lists('PerspectiveName','id');
				$objectives = DB::table('objectives')->get();

				$primaryoffices = DB::table('unit_offices')->get();
				$secondaryoffices = DB::table('unit_office_secondaries')->get();

				$primarychecks = Input::get('primarycheckboxid');
				$secondarychecks = Input::get('secondarycheckboxid');
				$objectivechecks = Input::get('objectivecheckboxid');
				
				if($primarychecks != null)
				{
						foreach($primarychecks as $primarycheck)
						{
							
								foreach($objectivechecks as $objectivecheck)
								{
									$query = DB::table('obj_primaryunitoffice')
									->where('PrimaryUnitOfficeID', '=', $primarycheck)
									->where('ObjectiveID', '=', $objectivecheck)
									->get();

									if($query == null)
									{
										DB::insert('insert into obj_primaryunitoffice (PrimaryUnitOfficeID, ObjectiveID) values (?,?)', array($primarycheck, $objectivecheck));
									}
									
								}
									
							
							
						}
						Session::flash('message', 'Objectives succesfully assigned to Unit offices!');
				return Redirect::to('UAEofficeobjectives');
				}


				
				if($secondarychecks != null)
				{
					foreach($secondarychecks as $secondarycheck)
					{

						foreach($objectivechecks as $objectivecheck)
						{
							$query = DB::table('obj_secondaryunitoffice')
							->where('SecondaryUnitOfficeID', '=', $secondarycheck)
							->where('ObjectiveID', '=', $objectivecheck)
							->get();
							if($query == null)
							{
								DB::insert('insert into obj_secondaryunitoffice (SecondaryUnitOfficeID, ObjectiveID) values (?,?)', array($secondarycheck, $objectivecheck));
							}
							
						}
						
						
					

					}
					Session::flash('message', 'Objectives succesfully assigned to Unit offices!');
				return Redirect::to('UAEofficeobjectives');
				}


				

				Session::flash('message', 'Please Check the box of the objectives you want to assign to certain unit offices.');
					return Redirect::to('UAEofficeobjectives');

			}
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}
			


		}

		public function secondaryoffices()
		{
			$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');
				$unitoffice_id = Session::get('primaryunit','default');
				$secondaryoffice_id = Session::get('secondaryunit','default');
		

				$secondaryoffices = DB::table('unit_office_secondaries')
				->where('UnitOfficeID', '=', $unitoffice_id)
				->select('UnitOfficeSecondaryName','id');
				
				

				return Datatables::of($secondaryoffices)
				->add_column('Actions','{{ Form::checkbox(\'secondarycheckboxid[]\',$id) }}')
				->remove_column('id')
        		->make(true);

		}

		public function objectives()
		{
				$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');
				$unitoffice_id = Session::get('primaryunit','default');
				$secondaryoffice_id = Session::get('secondaryunit','default');




				$unitadmintype = DB::table('unit_admins')
					->where('id', '=', $unit_admin_id)
					->first();

				if($unitadmintype->UnitOfficeSecondaryID == 0)
				{
					$objectives = DB::table('objectives')
						->join('obj_primaryunitoffice', 'objectives.id', '=', 'obj_primaryunitoffice.ObjectiveID')
						->where('obj_primaryunitoffice.PrimaryUnitOfficeID', '=', $unitoffice_id)
						->select('objectives.ObjectiveName as ObjectiveName','objectives.id as id');
				}
				else
				{
					$objectives = DB::table('objectives')
						->join('obj_secondaryunitoffice', 'objectives.id', '=', 'obj_secondaryunitoffice.ObjectiveID')
						->where('obj_secondaryunitoffice.SecondaryUnitOfficeID', '=', $secondaryoffice_id)
						->select('objectives.ObjectiveName as ObjectiveName','objectives.id as id');
				}

				return Datatables::of($objectives)
				->add_column('Actions', '{{ Form::checkbox(\'objectivecheckboxid[]\',$id) }}')
				->remove_column('id')
        		->make(true);
				

				
		}

		public function ajaxobjectives($id)
		{
			$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');
				$unitoffice_id = Session::get('primaryunit','default');
				$secondaryoffice_id = Session::get('secondaryunit','default');




				$unitadmintype = DB::table('unit_admins')
					->where('id', '=', $unit_admin_id)
					->first();

				if($unitadmintype->UnitOfficeSecondaryID == 0)
				{
					$objectives = DB::table('objectives')
						->join('obj_primaryunitoffice', 'objectives.id', '=', 'obj_primaryunitoffice.ObjectiveID')
						->where('obj_primaryunitoffice.PrimaryUnitOfficeID', '=', $unitoffice_id)
						->where('objectives.PerspectiveID','=',$id)
						->select('objectives.ObjectiveName as ObjectiveName','objectives.id as id');
				}
				else
				{
					$objectives = DB::table('objectives')
						->join('obj_secondaryunitoffice', 'objectives.id', '=', 'obj_secondaryunitoffice.ObjectiveID')
						->where('obj_secondaryunitoffice.SecondaryUnitOfficeID', '=', $secondaryoffice_id)
						->where('objectives.PerspectiveID','=',$id)
						->select('objectives.ObjectiveName as ObjectiveName','objectives.id as id');
				}

				return Datatables::of($objectives)
				->add_column('Actions', '{{ Form::checkbox(\'objectivecheckboxid[]\',$id) }}')
				->remove_column('id')
        		->make(true);
		}

}





?>