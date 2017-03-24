<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showHomepage()
	{
		$empid = Session::get('empid', 'default');
		return View::make('homepage')
		->with('empid', $empid);
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
			return Redirect::to('employeeactivities');

       } 
       else{
       		Session::flash('message', 'Scorecard not yet submitted.');
			return Redirect::to('employeeactivities');
       }
       


	}
	

	public function showLogin()
	{
		return View::make('login');
	}
	public function showGraph()
	{
		$users = DB::table('users')->get();
		$employs = DB::table('ranks')
				->join('employs', 'ranks.id', '=', 'employs.RankID')
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
		
		
		return View::make('selectemp')
			->with('employs', $employs)
			->with('users', $users)
			->with('DateCovered', $DateCovered)

			->with('LastWeekDateCovered', $LastWeekDateCovered);
	}
	public function postGraph()
	{
		
	

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



		
		return View::make('graph')
			->with('summations', $summations)
			->with('employsname', $employsname)
			->with('StartDate', $StartDate)
			->with('empid', $empid);
	}

	public function showDashboard()
	{
		$users = DB::table('users')->get();
		$employs = DB::table('ranks')
				->join('employs', 'ranks.id', '=', 'employs.RankID')
				->where('employs.isActive', '!=', '0')
				->take(5)
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
        /*
        $submitted = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('target_approval.status', '=', 'submitted')
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
						->where('employs.isActive', '!=', '0')
						
						
						->get();

		


		$lastSubmitted = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('target_approval.status', '=', 'submitted')
						->where('date', '=', $LastWeekStartDate)
						->where('employs.isActive', '!=', '0')
						->groupBy('employs.id')
						->get();
		*/	
		$noScorecard = DB::table('employs')
				->whereNotIn('employs.id', function($q)
					{
						$q->select('empID')->from('target_approval');
					})
				->where('employs.isActive', '!=', '0')
				->count();
		
		$whosub = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->where('target_approval.status', '=', 'submitted')
						->where('date', '=', $dt_min)
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
						->where('employs.isActive', '!=', '0')
						->count('employs.id');

			

		$whoSubLast = DB::table('target_approval')
							->join('employs', 'target_approval.EmpID', '=', 'employs.id')
							->where('target_approval.status', '=', 'submitted')
							->where('date', '=', $LastWeekStartDate)
							->where('employs.isActive', '!=', '0')
							->distinct('target_approval.empID')
							->count('target_approval.empID');

		$unit_offices_id = ['Select Unit Office...'] + DB::table('unit_offices')->orderBy('UnitOfficeName','asc')
		->lists('UnitOfficeName','id');
		$unit_offices_secondaries_id = ['Select Unit Secondary Office...'];
		$unit_offices_tertiaries_id = ['Select Unit Tertiary Office...'];
		$unit_offices_quaternaries_id = ['Select Unit Quaternary Office...'];
		$filterby = ['Select...'];

		return View::make('dashboard')
			->with('employs', $employs)
			->with('users', $users)
			->with('DateCovered', $DateCovered)
			->with('filterby', $filterby)
			->with('LastWeekDateCovered', $LastWeekDateCovered)
			->with('whosub', $whosub)
			->with('whoDidNotSub', $whoDidNotSub)
			->with('whoSubLast', $whoSubLast)
			->with('noScorecard', $noScorecard)
			->with('unit_offices_id', $unit_offices_id)
			->with('unit_offices_secondaries_id', $unit_offices_secondaries_id)
			->with('unit_offices_tertiaries_id', $unit_offices_tertiaries_id)
			->with('unit_offices_quaternaries_id', $unit_offices_quaternaries_id);
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
	{	$state = Input::get('state');
		 DB::statement('UPDATE users SET state=:sur' ,
                             array('sur' => $state) );
		 DB::statement('UPDATE unit_admins SET state=:sur',
		 					array('sur' => $state) );
		$users = DB::table('users')->get();
				$employs = DB::table('ranks')
				->join('employs', 'ranks.id', '=', 'employs.RankID')
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

		$noScorecard = DB::table('employs')
				->whereNotIn('employs.id', function($q)
					{
						$q->select('empID')->from('target_approval');
					})
				->count();
		
		$noScorecardList = DB::table('employs')
				->join('ranks', 'ranks.id', '=', 'employs.RankID')
				->whereNotIn('employs.id', function($q)
					{
						$q->select('empID')->from('target_approval');
					})
				->get();

		
		$whosub = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->where('target_approval.status', '=', 'submitted')
						->where('date', '=', $dt_min)
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
						
						
						->count('employs.id');

			

		$whoSubLast = DB::table('target_approval')
							->join('employs', 'target_approval.EmpID', '=', 'employs.id')
							->where('target_approval.status', '=', 'submitted')
							->where('date', '=', $LastWeekStartDate)
							->distinct('target_approval.empID')
							->count('target_approval.empID');
		$unit_offices_id = ['Select Unit Office...'] + DB::table('unit_offices')->orderBy('UnitOfficeName','asc')
		->lists('UnitOfficeName','id');

		return View::make('dashboard')
			->with('users', $users)
			->with('DateCovered', $DateCovered)

			->with('LastWeekDateCovered', $LastWeekDateCovered)

			->with('whosub', $whosub)

			->with('whoDidNotSub', $whoDidNotSub)

			->with('whoSubLast', $whoSubLast)
			->with('noScorecard', $noScorecard)
			->with('noScorecardList', $noScorecardList)
			->with('unit_offices_id', $unit_offices_id);
	}

	public function doLogin()
	{
		$rules = array(
			'username'   => 'required', 
			'password'=> 'required|alphaNum|min:4'

			);

		$validator = Validator::make(Input::all(), $rules);

		if($validator -> fails()){
			Session::flash('message', 'Sorry! Incorrect username/password. Please try again.');
			return Redirect::to('login/@den2')
			->withErrors($validator)
			->withInput(Input::except('password')); 
		}
		else
		{
			$userdata = array(
				'username'    => Input::get('username'),
				'password' => Input::get('password')
				);

				if(Auth::attempt($userdata))
				{
					return Redirect::to('dashboard');
				}
				else
				{
					Session::flash('message', 'Sorry! Incorrect username/password. Please try again.');
					return Redirect::to('login/@den2');
				}
				
			}
		}

		public function doLogout()
		{
	    	Auth::logout();
	    	Session::flash('message', 'Successfully Logout');
	    	return Redirect::to('login/@den2');
		}

		public function showMaintenance()
		{
			return View::make('maintenance');
		}

		public function showEmployeeActivities()
		{
			$employs = DB::table('ranks')
			->join('employs', 'ranks.id', '=', 'employs.RankID')
			->where('employs.isActive', '!=', '0')
			->get();
			return View::make('employee_activities')
			->with('employs',$employs);
		}

		public function ajaxShowEmployeeActivities()
		{
			$employs = DB::table('ranks')
							->join('employs', 'ranks.id', '=', 'employs.RankID')
							->where('employs.isActive', '!=', '0')
							->select('employs.id as id', 'ranks.RankCode as RankCode', 'employs.EmpLastName as LastName', 'employs.EmpFirstName as FirstName')
							->orderBy('ranks.Hierarchy', 'asc');
			
			return Datatables::of($employs)
	        ->add_column('Add Activities', '
                            <a class = \'btn btn-info\' style= "margin-bottom:5px" href="{{ URL::to(\'addemployeemain/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'addemployeemain/\' . $id) }}\', \'newwindow\'); return false;">Add Main Activities</a>
                            <br> 
                            <a class = \'btn btn-info\' style= "margin-bottom:5px" href="{{ URL::to(\'SUotheractivity/otheractivities/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'SUotheractivity/otheractivities/\' . $id) }}\', \'newwindow\'); return false;">Add Other Activities</a>
                            <br> 
                            <a class = \'btn btn-info\' style= "margin-bottom:5px" href="{{ URL::to(\'addemployeesub/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'addemployeesub/\' . $id) }}\', \'newwindow\'); return false;">Add Sub Activities</a>
                            <br> 
                            <a class = \'btn btn-info\' style= "margin-bottom:5px"  href="{{ URL::to(\'addemployeemeasure/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'addemployeemeasure/\' . $id) }}\', \'newwindow\'); return false;">Add Measures</a>
	                    ')
			->add_column('Edit Activities', '
	        				<a class = \'btn btn-warning\' style= "margin-bottom:5px" href="{{ URL::to(\'setemployeemain/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'setemployeemain/\' . $id) }}\', \'newwindow\'); return false;">Edit Main Activities</a>                                 
                            <br> 
                            <a class = \'btn btn-warning\' style= "margin-bottom:5px" href="{{ URL::to(\'setemployeesub/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'setemployeesub/\' . $id) }}\', \'newwindow\'); return false;">Edit Sub Activities</a>
                            <br> 
                            <a class = \'btn btn-warning\' style= "margin-bottom:5px" href="{{ URL::to(\'setemployeemeasure/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'setemployeemeasure/\' . $id) }}\', \'newwindow\'); return false;">Edit Measures</a>
	                    ')
			->add_column('Delete Activities', '
	        				<a class = \'btn btn-danger\' style= "margin-bottom:5px" href="{{ URL::to(\'removeempact/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'removeempact/\' . $id) }}\', \'newwindow\'); return false;">Delete Activities</a>   
							<a class = \'btn btn-danger\' style = "margin-bottom:5px" data-book-id = "{{ $id }}" data-target="#my_modal" data-toggle="modal">Remove Current Scorecard</a>
                            ')
			->add_column('Assign Objectives', '
	        				<a class = \'btn btn-success\' href="{{ URL::to(\'setemployeeobjective/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'setemployeeobjective/\' . $id) }}\', \'newwindow\'); return false;">Assign Objectives</a>
	                    	')
	        ->remove_column('id')
	        ->make(true);
		}

		public function addEmployeeMainActivity($id)
		{
			$main_activities = DB::table('main_activities')->where('EmpID', '=', $id)->get();
			$sub_activities = DB::table('sub_activities')->where('EmpID', '=', $id)->get();
			$measures = DB::table('measures')->where('EmpID', '=', $id)->get();
			$emp_activities = DB::table('main_activities')
				->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')
				->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')
    			->where('main_activities.EmpID', '=', $id)
    			->orderBy('main_activities.id','asc')
    			->orderBy('sub_activities.id','asc')
    			->get();
    		$Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
			$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;
			return View::make('addemployeemainactivity')
				->with('PersonnelName', $PersonnelName)
				->with('main_activities', $main_activities)
				->with('sub_activities', $sub_activities)
				->with('measures', $measures)
				->with('emp_activities', $emp_activities)
				->with('id',$id);
		}

		public function postaddEmployeeMainActivity()
		{
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
			
			if($MainActivity != "")
			{
				$tempmain = DB::table('main_activities')->where('EmpID', '=', $id)->where('MainActivityName', '=', $MainActivity)->first();

				if($tempmain == null)
				{
				DB::insert('insert into main_activities (Main_ID, MainActivityName, EmpID) values (?,?,?)', array($count, $MainActivity, $id));
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
			return View::make('addemployeemainactivitymeasure')
			    ->with('PersonnelName', $PersonnelName)
				->with('MainActivityOfEmp', $MainActivityOfEmp)
				->with('SubActivityOfEmp', $SubActivityOfEmp)
				->with('id',$id);
				
			}
			else
			{
				Session::flash('message', 'Please input main Activity!');
				return Redirect::to('addemployeemain/' . $id);
			}#
		}

		public function postaddEmployeeMeasure()
		{
			$id = Input::get('empid');
			$pic = Session::get('emppic', 'default');
			$sub_id = Input::get('sub_id');
			$measures = Input::get('measures');
			$measuretype = Input::get('measure_type');
			if($sub_id == null)
			{
				return Redirect::to('employeeactivities');
			}
			else
			{
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

						return Redirect::to('employeeactivities');
				}
				
			Session::flash('message', 'Activity successfully added!');

			return Redirect::to('employeeactivities');


		}
	}
			
		}

		public function addEmployeeSubActivity($id)
		{

			$MainActivityOfEmp=DB::table('main_activities')->where('EmpID','=', $id)->get();
			$Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
			$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;

			return View::make('addemployeesubactivity')
			    ->with('PersonnelName', $PersonnelName)
				->with('MainActivityOfEmp', $MainActivityOfEmp)
				->with('id',$id);
		}

		public function postaddEmployeeSubactivity()
		{
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
					return View::make('addemployeesubactivitymeasure')
					    ->with('PersonnelName', $PersonnelName)
						->with('counter',$counter)
						->with('subactivities',$subactivities)
						->with('id',$id);
				
				
		}

		//measure only
		public function postAddEmployeeSubMeasure()
		{
			$id = Input::get('empid');
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

						return Redirect::to('employeeactivities');
				}
				
		Session::flash('message', 'Activity successfully added!');

			return Redirect::to('employeeactivities');


		}
			

		}

		//measure only
		public function addEmployeeMeasure($id)
		{
			
			$mainactivities = DB::table('main_activities')
			->where('EmpID', '=', $id)
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
					return View::make('addemployeemeasure')
					    ->with('PersonnelName', $PersonnelName)
						->with('subactivities',$subactivities)
						->with('mainactivities', $mainactivities)
						->with('id',$id);
				
				
		}

		public function setEmployeeMainActivity($id)
		{
			$main_activities = DB::table('main_activities')
			->where('EmpID','=',$id)
			->get();
			$Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
			$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;
			return View::make('setemployeemainactivity')
			    ->with('PersonnelName', $PersonnelName)
				->with('main_activities',$main_activities)
				->with('id',$id);
		}

		public function postEditMain()
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
            return Redirect::to('employeeactivities');
		}

		public function setEmployeeSubActivity($id)
		{
            $main = 0;
            $main_activities = DB::table('main_activities')->get();
            $sub_activities = DB::table('sub_activities')->where('id', '=',  '0')->get();
            $main_id= ['Select Main Activity...'] + DB::table('main_activities')->orderBy('MainActivityName','asc')->where('EmpID', '=', $id)
            ->lists('MainActivityName','id');
            $Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
			$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;
    		return View::make('setemployeesubactivity')
			    ->with('PersonnelName', $PersonnelName)
	            ->with('main_activities', $main_activities)
	            ->with('main_id', $main_id)
	            ->with('main', $main)
	            ->with('id',$id)
	            ->with('sub_activities', $sub_activities);
		}

		public function postsetEmployeeSubActivity()
		{
			$id = Input::get('empid');
			$main = Input::get('main_id');
            $main_activities = DB::table('main_activities')->get();
            $main = Input::get('main_id');
            $main_id= ['Select Main Activity...'] + DB::table('main_activities')->orderBy('MainActivityName','asc')->where('EmpID', '=', $id)
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
            return View::make('setemployeesubactivity')
			    ->with('PersonnelName', $PersonnelName)
	            ->with('main_activities', $main_activities)
	            ->with('main_id', $main_id)
	            ->with('main', $main)
	            ->with('id',$id)
	            ->with('sub_activities', $sub_activities);
		}
		public function postEdit()
    	{
        
            $id = Input::get('empid');
           
            $main_activities = DB::table('main_activities')->get();
          
            $main = Input::get('main');
            
        
            $subs = Input::get('sub_activity');
            
            $sub_id = Input::get('subactivity');
            $state_ids = Input::get('state_id');

            $main_id= ['Select Main Activity...'] + DB::table('main_activities')->where('EmpID', '=', $id)->orderBy('MainActivityName','asc')
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

            $dt_max->modify('-6 days');
            
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
            return Redirect::to('employeeactivities');
        }

		public function setEmployeeMeasure($id)
		{
			 $main = 0;
            $main_activities = DB::table('main_activities')->get();
            $sub_activities = ['None...'];
            $measures = DB::table('measures')->where('id', '=',  '0')->get();
            $main_id= ['Select Main Activity...'] + DB::table('main_activities')->where('EmpID', '=', $id)->orderBy('MainActivityName','asc')
            ->lists('MainActivityName','id');
            $Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
			$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;
    		return View::make('setemployeemeasure')
			    ->with('PersonnelName', $PersonnelName)
	            ->with('main_activities', $main_activities)
	            ->with('main_id', $main_id)
	            ->with('main', $main)
	            ->with('sub_activities', $sub_activities)
	            ->with('measures',$measures)
	            ->with('id',$id);
		}
		public function postsetEmployeeMeasure()
		{

			$id = Input::get('empid');
			$main = Input::get('main_id');
            $main_activities = DB::table('main_activities')->get();
             $measures = DB::table('measures')->where('id', '=',  '0')->get();
            $main_id= ['Select Main Activity...'] + DB::table('main_activities')->where('EmpID', '=', $id)->orderBy('MainActivityName','asc')
            ->lists('MainActivityName','id');
            $sub_activities = ['Select Sub Activity...'] + DB::table('sub_activities')->where('EmpID', '=', $id)->where('MainActivityID', '=', $main)->lists('SubActivityName','id');
            $Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
			$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;
            return View::make('setemployeemeasure')
			    ->with('PersonnelName', $PersonnelName)
	            ->with('main_activities', $main_activities)
	            ->with('main_id', $main_id)
	            ->with('main', $main)
	            ->with('sub_activities', $sub_activities)
	            ->with('measures',$measures)
	            ->with('id',$id);

		}

		public function postsetEmployeeMeasure2()
		{
			$id = Input::get('empid');
			$main = Input::get('main_id');
            $main_activities = DB::table('main_activities')->get();
            $main_id= ['Select Main Activity...'] + DB::table('main_activities')->where('EmpID', '=', $id)->orderBy('MainActivityName','asc')
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
            return View::make('setemployeemeasure')
			    ->with('PersonnelName', $PersonnelName)
	            ->with('id', $id)
	            ->with('main_activities', $main_activities)
	            ->with('main_id', $main_id)
	            ->with('main', $main)
	            ->with('sub_activities', $sub_activities)
	            ->with('measures',$measures);

		} 
		public function postEditMeasure()
		{
			$id = Input::get('empid');
			$main = Input::get('main_id');
            $main_activities = DB::table('main_activities')->get();
            $main_id= ['Select Main Activity...'] + DB::table('main_activities')->where('EmpID', '=', $id)->orderBy('MainActivityName','asc')
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
                             array('sur' => $measure, 'sur2' => $measuretype[$i],'res' => $id, 'res2' =>$measures_id[$i]) );
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
                    				array('sur' => NULL, 'res' => $id, 'res2' =>$state_id));
                }    
                 $x++;
                }
            }

           Session::flash('message', 'Changes Saved!');
            return Redirect::to('employeeactivities');         
		}

		public function setEmployeeObjective($id)
		{
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

			$mainactivities_id = DB::table('main_activities')
			->where('EmpID','=',$id)
			->lists('MainActivityName','id');

			$id_dropdown="0";
			$id_dropdown2="0";
			$Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
			$PersonnelName = $Employees->RankCode.' '.$Employees->EmpFirstName.' '.$Employees->EmpMidInit.' '.$Employees->EmpLastName.' '.$Employees->EmpQualifier;
			$users = DB::table('users')->get();	
				return View::make('setemployeeobjective')
			    	->with('PersonnelName', $PersonnelName)
					->with('perspectives_id',$perspectives_id)
					->with('objectives_id',$objectives_id)
					->with('main_activities',$main_activities)
					->with('sub_activities',$sub_activities)
					->with('mainactivities_id',$mainactivities_id)
					->with('id_dropdown2',$id_dropdown2)
					->with('id_dropdown',$id_dropdown)
					->with('users',$users)
					->with('sub_activities2',$sub_activities2)
					->with('id',$id);
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
					return Redirect::to('employeeactivities');
				}
				else
				{
					Session::flash('message', 'Incomplete inputs. Please assign objective,perspective and check corresponding sub-activities!');
					return Redirect::to('setemployeeobjective/' . $emp_id);
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
					return Redirect::to('employeeactivities');
				}
				else
				{
					Session::flash('message', 'Incomplete inputs. Please assign objective,perspective and check corresponding sub-activities!');
					return Redirect::to('setemployeeobjective/' . $emp_id);
				}
            }

            
		}

		//public function updateEmployeeObjective(){}

		public function postsetEmployeeObjective()
		{
			$id = Input::get('empid');
			$id_dropdown = Input::get('PerspectiveID');
			$id_dropdown2="0";	
			$perspectives_id = ['Select Perspective...'] + DB::table('perspectives')
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
			$mainactivities_id = DB::table('main_activities')
				->where('EmpID','=',$id)
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
			return View::make('setemployeeobjective')
			    ->with('PersonnelName', $PersonnelName)
				->with('id', $id)
				->with('perspectives_id',$perspectives_id)
				->with('objectives_id',$objectives_id)
				->with('sub_activities',$sub_activities)
				->with('mainactivities_id',$mainactivities_id)
				->with('id_dropdown',$id_dropdown)
				->with('id_dropdown2',$id_dropdown2)
				->with('sub_activities2',$sub_activities2);


		}

		public function postsetEmployeeObjective2()
		{
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
						->where('obj_primaryunitoffice.PrimaryUnitOfficeID','=',$checkIfSecondary->UnitOfficeID)
						->where('objectives.PerspectiveID','=',$id_dropdown)
						->lists('ObjectiveName','id');
					}
			$mainactivities_id = DB::table('main_activities')
				->where('EmpID','=',$id)
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
			return View::make('setemployeeobjective')
			    ->with('PersonnelName', $PersonnelName)
				->with('id', $id)
				->with('perspectives_id',$perspectives_id)
				->with('sub_activities',$sub_activities)
				->with('mainactivities_id',$mainactivities_id)
				->with('id_dropdown2',$id_dropdown2)
				->with('id_dropdown',$id_dropdown)
				->with('objectives_id',$objectives_id)
				->with('sub_activities2',$sub_activities2);
		}


		public function assignObjectiveOfficeGet()
		{
			$users = DB::table('users')->get();
			$id = Input::get('empid');
			$id_dropdown = Input::get('PerspectiveID');
			$perspectives_id = ['Select Perspective...'] + DB::table('perspectives')
				->lists('PerspectiveName','id');
			$objectives = DB::table('objectives')->get();

			$primaryoffices = DB::table('unit_offices')->get();
			$secondaryoffices = DB::table('unit_office_secondaries')->get();
			
				return View::make('objectiveunitoffices')
					->with('id', $id)
					->with('perspectives_id',$perspectives_id)
					->with('objectives',$objectives)
					->with('users',$users)
					->with('primaryoffices', $primaryoffices)
					->with('secondaryoffices', $secondaryoffices);

		}

		public function assignObjectiveOfficePost()
		{
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
			return Redirect::to('office_objectives');
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
			return Redirect::to('office_objectives');
			}


			

			Session::flash('message', 'Please Check the box of the objectives you want to assign to certain unit offices.');
				return Redirect::to('office_objectives');
			


		}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		public function unit($id)
	{
		
		$unit_offices = DB::table('unit_offices')->get();
		$unit_offices_id= ['Select Unit Office...'] + DB::table('unit_offices')->orderBy('UnitOfficeName','asc')
		->lists('UnitOfficeName','id');
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();
		$unit_offices_secondaries_id= ['none...'];
		$id_dropdown = "0";
		$id_dropdown2 = "0";
		$unit_admin_id = $id;

		return View::make('unit_admins.unit')
		->with('unit_admin_id', $unit_admin_id)
		->with('id_dropdown', $id_dropdown)
		->with('id_dropdown2', $id_dropdown2)
		->with('unit_offices',$unit_offices)
		->with('unit_offices_id',$unit_offices_id)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id);
	}

	public function postunit()
	{
		$unit_admin_id = Input::get('UnitAdminID');
		$id_dropdown = Input::get('UnitOfficeID');

		$unit_offices = DB::table('unit_offices')->get();
		$unit_offices_id= DB::table('unit_offices')->where('id', '=', $id_dropdown)->orderBy('UnitOfficeName','asc')
		->lists('UnitOfficeName','id');
		
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id= ['Select Secondary...'] + DB::table('unit_office_secondaries')
		->where('UnitOfficeID', '=', $id_dropdown)
		->orderBy('UnitOfficeSecondaryName','asc')
		->lists('UnitOfficeSecondaryName','id');
		$id_dropdown2='0';

		return View::make('unit_admins.unit')
		->with('unit_admin_id', $unit_admin_id)
		->with('id_dropdown', $id_dropdown)
		->with('id_dropdown2', $id_dropdown2)
		->with('unit_offices',$unit_offices)
		->with('unit_offices_id',$unit_offices_id)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id);
	}

	public function ajaxpostunit()
	{
		$unit_admin_id = $_REQUEST['unitAdminID'];
		$unit_office_id = $_REQUEST['unitOfficeID'];

		$unit_offices_secondaries_id = DB::table('unit_office_secondaries')
										->where('UnitOfficeID', '=', $unit_office_id)
										->orderBy('UnitOfficeSecondaryName','asc')
										->get();

		return Response::json($unit_offices_secondaries_id);
	}

	public function postunit2()
	{
		$unit_admin_id = Input::get('UnitAdminID');
		$id_dropdown = Input::get('UnitOfficeID');	
		$id_dropdown2 = Input::get('UnitOfficeSecondaryID');	

		$unit_offices = DB::table('unit_offices')->get();
		$unit_offices_id= DB::table('unit_offices')->where('id', '=', $id_dropdown)->orderBy('UnitOfficeName','asc')
		->lists('UnitOfficeName','id');
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id= DB::table('unit_office_secondaries')->where('id', '=', $id_dropdown2)->orderBy('UnitOfficeSecondaryName','asc')
		->lists('UnitOfficeSecondaryName','id');

		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();
		$unit_offices_quaternaries_id= ['none...'];

		return View::make('unit_admins.unit')
		->with('unit_admin_id', $unit_admin_id)
		->with('id_dropdown', $id_dropdown)
		->with('id_dropdown2', $id_dropdown2)
		->with('unit_offices',$unit_offices)
		->with('unit_offices_id',$unit_offices_id)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id);
	}

	public function saveunit()
	{
		$unit_admin_id = Input::get('UnitAdminID');
		$id_dropdown = Input::get('UnitOfficeID');	
		$id_dropdown2 = Input::get('UnitOfficeSecondaryID');	
        DB::statement('UPDATE unit_admins SET UnitOfficeID=:a, UnitOfficeSecondaryID=:b		
        				WHERE id=:res' ,
               array('res' => $unit_admin_id, 'a' => $id_dropdown, 'b' =>$id_dropdown2) );
		$unit_offices = DB::table('unit_offices')->get();
		$unit_offices_id= DB::table('unit_offices')->where('id', '=', $id_dropdown)->orderBy('UnitOfficeName','asc')
		->lists('UnitOfficeName','id');
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();

		$unit_offices_secondaries_id= DB::table('unit_office_secondaries')->where('id', '=', $id_dropdown2)->orderBy('UnitOfficeSecondaryName','asc')
		->lists('UnitOfficeSecondaryName','id');
		Session::flash('message', 'Saved Successfully');
		/*
		return View::make('unit_admins.unit')
		->with('unit_admin_id', $unit_admin_id)
		->with('id_dropdown', $id_dropdown)
		->with('id_dropdown2', $id_dropdown2)
		->with('unit_offices',$unit_offices)
		->with('unit_offices_id',$unit_offices_id)
		->with('unit_offices_secondaries',$unit_offices_secondaries)
		->with('unit_offices_secondaries_id',$unit_offices_secondaries_id);
		*/
		return Redirect::route('unit_admins.show', $unit_admin_id);
	}

/* THIS IS FOR UNIT ADMIN OTHER ACTIVITIES* -kwell*/
	
	public function showSUOtherActivities($id)

	{
		
				$empid = Session::put('UA_empID', $id);

			$other_activities = DB::table('other_activities')
					->where('other_activities.EmpID', '=', $id)
					->get();

			$employsname = DB::table('employs')	
					->join('ranks', 'ranks.id', '=', 'employs.RankID')
					->where('employs.id', '=', $id)
					->get();

				return View::make('SUotheractivities')

					->with('other_activities', $other_activities)

					->with('employsname', $employsname);

	}

	public function editSUOtherMeasures($sub_act)
	{
			
				$empid = Session::get('UA_empID', 'default');

				$employsname = DB::table('employs')	
					->join('ranks', 'ranks.id', '=', 'employs.RankID')
					->where('employs.id', '=', $empid)
					->get();

			$other_activities = DB::table('other_measures')->where('OtherActivitiesID', '=', $sub_act)->get();
			$subs = DB::table('other_activities')->where('id', '=', $sub_act)->first();



				return View::make('SUothermeasure')

					->with('other_activities', $other_activities)
					
					->with('subs', $subs)

					->with('employsname', $employsname)

					->with('empid', $empid);

	}

public function postAddSUOther()
	{
			//$id = Session::get('empid', 'default');
			$id = Session::get('UA_empID', 'default');
			$sub_activity = Input::get('sub_activity');
			$unit = Session::get('unitoffice' , 'default');
			$secon = Session::get('secondaryoffice','default');
			$tertia = Session::get('tertiaryoffice','default');
			$quater = Session::get('quaternaryoffice','default');


				if($sub_activity == null)

					{

						return Redirect::to('SUotheractivity/otheractivities');

					}

			$measure = Input::get('measure');
			$other = DB::table('other_activities')->where('EmpID', '=', $id)->where('OtherActivitiesName', '=', $sub_activity)->first();

			if($sub_activity != "")
			{
				if($other == null)
				{
					DB::insert('insert into other_activities (OtherActivitiesName, EmpID, UnitOfficeID, SecondaryUnitOfficeID, TertiaryUnitOfficeID, QuaternaryUnitOfficeID) values (?,?,?,?,?,?)', array($sub_activity, $id, $unit, $secon, $tertia,$quater));
				}
			}

			$other_id = DB::table('other_activities')->max('id');

			foreach ($measure as $measures) 

			{

				if($measures != "")

				{
						if($other == null)
						{
								DB::insert('insert into other_measures (OtherActivitiesMeasureName, OtherActivitiesID, EmpID) values (?,?,?)', array($measures, $other_id, $id));
						}
				}



			}


			Session::flash('mes', 'Sub-activity successfully added!');

			return Redirect::to('SUotheractivity/otheractivities/'.$id);


	}



	public function postAddSUMeasures()
	{
			$id = Input::get('empid');
			$other_id = Input::get('sub_id');
			$measure = Input::get('measure');
			
				if($measure == null)

					{

						return Redirect::to('SUeditOtherMeasures/'.$other_id);

					}

			
			foreach ($measure as $measures) 

			{



			$other = DB::table('other_measures')->where('EmpID', '=', $id)->where('OtherActivitiesMeasureName', '=', $measures)->first();

				if($measures != "")

				{
						if($other == null)
						{
								DB::insert('insert into other_measures (OtherActivitiesMeasureName, OtherActivitiesID, EmpID) values (?,?,?)', array($measures, $other_id, $id));
						}
				}



			}


			Session::flash('mes', 'Measure successfully added!');

			return Redirect::to('SUeditOtherMeasures/'.$other_id);


	}


	




	public function postEditSUOther()
	{

		$id = Session::get('UA_empID', 'default');
		$sub_id = Input::get('mainactivity');
		$subs = Input::get('main_activity');
		//$asd = Input::get('asd');
		
             $i = 0;   

            if ($subs != null)

            {


                foreach($subs as $sub)

                {



                        DB::statement('UPDATE other_activities SET OtherActivitiesName=:sur WHERE EmpID=:res AND id=:res2' ,

                             array('sur' => $sub, 'res' => $id, 'res2' =>$sub_id[$i]) );

                        $i++;

                }

            }


			Session::flash('mes', 'Sub-activity successfully edited!');

			return Redirect::to('SUotheractivity/otheractivities/'.$id);




	}



	public function postEditSUMeasure()
	{

		$id = Input::get('empid');
		$other_id = Input::get('sub_id');
		$sub_id = Input::get('mainactivity');
		$subs = Input::get('main_activity');

	
             $i = 0;   

            if ($subs != null)

            {

                foreach($subs as $sub)

                {



                        DB::statement('UPDATE other_measures SET OtherActivitiesMeasureName=:sur WHERE EmpID=:res AND id=:res2' ,

                             array('sur' => $sub, 'res' => $id, 'res2' =>$sub_id[$i]) );

                        $i++;

                }

            }


			Session::flash('mes', 'Measures successfully edited!');

			return Redirect::to('SUeditOtherMeasures/'.$other_id);




	}




	public function postSaveSUOther()
	{

		$id = Session::get('UA_empID', 'default');
		$subs = Input::get('check_id');
		$today = new DateTime("now");
		$temp = null;
        $dt_min = new DateTime("monday");



        DB::statement('UPDATE other_activities SET OtherDate=:sur WHERE EmpID=:res' ,

                             array('sur' => $temp, 'res' => $id) );

       	

        if ($dt_min > $today)

        {

            $dt_min = new DateTime("last monday");

        }


 if ($subs != null)

            {
		 foreach($subs as $sub)
                {

                        DB::statement('UPDATE other_activities SET OtherDate=:sur WHERE EmpID=:res AND id=:res2' ,

                             array('sur' => $dt_min, 'res' => $id, 'res2' =>$sub) );

                }



		Session::flash('mes', 'Sub-activity successfully added to scorecard!');
		return Redirect::to('SUotheractivity/otheractivities/'.$id);
}


		Session::flash('mes', 'Sub-activity successfully removed to scorecard!');
		return Redirect::to('SUotheractivity/otheractivities/'.$id);




	}




		public function postSaveSUMeasure()
	{

		$id = Input::get('empid');
		$subs = Input::get('check_id');
		$today = new DateTime("now");
		$temp = null;
        $dt_min = new DateTime("monday");
        $other_id = Input::get('sub_id');
        

        if ($dt_min > $today)

        {

            $dt_min = new DateTime("last monday");

        }

        DB::statement('UPDATE other_measures SET MeasureDate=:sur WHERE EmpID=:res AND OtherActivitiesID=:res2' ,

                array('sur' => $dt_min, 'res' => $id, 'res2' => $other_id) );



       	


 if ($subs != null)

            {
		 foreach($subs as $sub)
                {

      			  DB::statement('UPDATE other_measures SET MeasureDate=:sur WHERE EmpID=:res AND id=:res2' ,

                             array('sur' => $temp, 'res' => $id, 'res2' => $sub) );
                 
                }



		Session::flash('mes', 'Measures successfully added to sub-activity!');
		return Redirect::to('SUeditOtherMeasures/'.$other_id);
}


		Session::flash('mes', 'Measures successfully removed to sub-activity!');
		return Redirect::to('SUeditOtherMeasures/'.$other_id);




	}


	public function primary()
	{
		$officeID = $_REQUEST['officeID'];

		$queries= DB::table('unit_office_secondaries')
					->where('UnitOfficeID', '=', $officeID)
					->select('UnitOfficeSecondaryName','id')
					->orderBy('UnitOfficeSecondaryName','asc')
					->get();
		

		return Response::json($queries);



	}

	public function secondary()
	{
		$officeID = $_REQUEST['officeID2'];

		$queries= DB::table('unit_office_tertiaries')
					->where('UnitOfficeSecondaryID', '=', $officeID)
					->select('UnitOfficeTertiaryName','id')
					->orderBy('UnitOfficeTertiaryName','asc')
					->get();
		

		

		return Response::json($queries);

	}

	public function tertiary()
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
