

<?php



use App\Http\Requests;
use App\User;
use Bllim\Datatables\Facade\Datatables;

class DatatablesController extends \BaseController {

	/**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        return view('employs.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
        
        $employs = DB::table('employs')

			->join('ranks', 'employs.RankID', '=', 'ranks.id')
			->join('positions', 'employs.PositionID', '=', 'positions.id')
			->join('unit_offices', 'employs.UnitOfficeID', '=', 'unit_offices.id')
			->join('employs AS employ_supervisor', 'employs.SupervisorID', '=', 'employ_supervisor.id')
			->select('employs.id as id', 'employs.EmpLastName as EmpLastName', 'employs.EmpFirstName as EmpFirstName', 'ranks.RankCode as rank', 'positions.PositionName as position', 'unit_offices.UnitOfficeName as UnitOfficeName', 'employs.EmpPicturePath as picpath')
			->orderBy('ranks.Hierarchy');


			

        return Datatables::of($employs)
        ->add_column('Pictures', '<img style = "height:60px; width:60px;" src="{{URL::asset($picpath)}}">')
        ->add_column('Actions', '<a class = \'btn btn-warning\' style = "margin-bottom:5px" href="{{ URL::to(\'employs/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'employs/\' . $id) }}\', \'newwindow\', \'width=380, height=620\'); return false;">View</a>

        	 <br>
  
              <a class = \'btn btn-info\' style = "margin-bottom:5px"  href="{{ URL::to(\'employs/\' . $id . \'/edit\') }}" onclick="window.open(\'{{ URL::to(\'employs/\' . $id . \'/edit\') }}\', \'newwindow\', \'width=500, height=500\'); return false;">Edit</a><br>

              <a class = \'btn btn-success\' style = "margin-bottom:5px" href="{{ URL::to(\'employee/unit/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'employee/unit/\' . $id) }}\', \'newwindow\', \'width=500, height=500\'); return false;">Unit</a>
                    
                ')
        
        ->make(true);
    }



   public function anyDash()
    {
        
        $employs = DB::table('employs')

			->join('ranks', 'employs.RankID', '=', 'ranks.id')
			->join('unit_offices', 'employs.UnitOfficeID', '=', 'unit_offices.id')
			->join('employs AS employ_supervisor', 'employs.SupervisorID', '=', 'employ_supervisor.id')
			->select('employs.id as id', 'employs.EmpLastName as EmpLastName', 'employs.EmpFirstName as EmpFirstName', 'ranks.RankCode as rank')
			->orderBy('ranks.Hierarchy');


			

        return Datatables::of($employs)
        ->add_column('Actions', '{{Form::radio(\'emp_id\', $id, false)}}')
        ->remove_column('id')
        ->make(true);
    }

	public function anyUnitSec()
	    {
	        
	        $unit_office_secondaries = DB::table('unit_office_secondaries')

				->join('unit_offices', 'unit_office_secondaries.UnitOfficeID', '=', 'unit_offices.id' )
				->select('unit_office_secondaries.id', 'unit_office_secondaries.UnitOfficeSecondaryName as UnitOfficeSecondaryName', 'unit_offices.UnitOfficeName as UnitOfficeName', 'unit_office_secondaries.UnitOfficeHasTertiary as UnitOfficeHasTertiary')
				;
				

	        return Datatables::of($unit_office_secondaries)
	        
	        ->add_column('Actions', '<a class = \'btn btn-warning\' href="{{ URL::to(\'unit_office_secondaries/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'unit_office_secondaries/\' . $id) }}\', \'newwindow\', \'width=450, height=500\'); return false;">View</a>

	        	<br><br>
                            		 <a class = \'btn btn-info\'  href="{{ URL::to(\'unit_office_secondaries/\' . $id . \'/edit\') }}" onclick="window.open(\'{{ URL::to(\'unit_office_secondaries/\' . $id . \'/edit\') }}\', \'newwindow\', \'width=450, height=450\'); return false;">Edit</a>

                            ')
	        ->remove_column('$unit_office_secondaries.id')
	        ->make(true);
	    }

	public function anyUnitTer()
	    {
	        
	        $unit_office_tertiaries = DB::table('unit_office_tertiaries')
				->join('unit_office_secondaries', 'unit_office_tertiaries.UnitOfficeSecondaryID', '=', 'unit_office_secondaries.id' )
				->select('unit_office_tertiaries.id', 'unit_office_tertiaries.UnitOfficeTertiaryName as UnitOfficeTertiaryName', 'unit_office_secondaries.UnitOfficeSecondaryName as UnitOfficeSecondaryName', 'unit_office_tertiaries.UnitOfficeHasQuaternary as UnitOfficeHasQuaternary')
				;
			

	        return Datatables::of($unit_office_tertiaries)
	        
	        ->add_column('Actions', '

	        	<a class = \'btn btn-warning\' href="{{ URL::to(\'unit_office_tertiaries/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'unit_office_tertiaries/\' . $id) }}\', \'newwindow\', \'width=450, height=500\'); return false;">View</a>

	        	<br>
	        	<br>

                <a class = \'btn btn-info\'  href="{{ URL::to(\'unit_office_tertiaries/\' . $id . \'/edit\') }}" onclick="window.open(\'{{ URL::to(\'unit_office_tertiaries/\' . $id . \'/edit\') }}\', \'newwindow\', \'width=450, height=450\'); return false;">Edit</a>
                            ')
	        ->remove_column('$unit_office_tertiaries.id')
	        ->make(true);
	    }

public function anyKpi()
    {
        
        $employs = DB::table('employs')
			->join('ranks', 'employs.RankID', '=', 'ranks.id')
			->select('employs.id as id', 'employs.EmpLastName as EmpLastName', 'employs.EmpFirstName as EmpFirstName', 'ranks.RankCode as rank')
			->orderBy('ranks.Hierarchy');

        return Datatables::of($employs)
        ->add_column('Actions', '{{Form::radio(\'emp_id\', $id, false)}}')
        ->remove_column('id')
        ->make(true);
    }

public function anyPriObj()
    {
        
        $unit_offices = DB::table('unit_offices')
			->select('unit_offices.id', 'unit_offices.UnitOfficeName as UnitOfficeName');
			
        return Datatables::of($unit_offices)
        ->add_column('Actions', '{{ Form::checkbox(\'primarycheckboxid[]\',$id) }}')
        ->remove_column('id')
        ->make(true);
    }
public function anySecObj()
    {
        
        $unit_office_secondaries = DB::table('unit_office_secondaries')
			->select('unit_office_secondaries.id', 'unit_office_secondaries.UnitOfficeSecondaryName as UnitOfficeSecondaryName');
			
        return Datatables::of($unit_office_secondaries)
        ->add_column('Actions', '{{ Form::checkbox(\'secondarycheckboxid[]\',$id) }}')
        ->remove_column('id')
        ->make(true);
    }

public function anyDashUnit()
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
					->join('ranks', 'employs.RankID', '=', 'ranks.id')
					->join('unit_offices', 'employs.UnitOfficeID', '=', 'unit_offices.id')
					->join('employs AS employ_supervisor', 'employs.SupervisorID', '=', 'employ_supervisor.id')
					->select('employs.id as id', 'employs.EmpLastName as EmpLastName', 'employs.EmpFirstName as EmpFirstName', 'ranks.RankCode as rank')
					->where('employs.UnitOfficeSecondaryID','=',$secondaryoffice_id)
					->where('employs.isActive', '!=', '0')
					->orderBy('ranks.Hierarchy');
				}

				if($unitadmin->UnitOfficeSecondaryID == '0')
				{
					 $employs = DB::table('employs')
					->join('ranks', 'employs.RankID', '=', 'ranks.id')
					->join('unit_offices', 'employs.UnitOfficeID', '=', 'unit_offices.id')
					->join('employs AS employ_supervisor', 'employs.SupervisorID', '=', 'employ_supervisor.id')
					->select('employs.id as id', 'employs.EmpLastName as EmpLastName', 'employs.EmpFirstName as EmpFirstName', 'ranks.RankCode as rank')
					->where('employs.UnitOfficeID','=',$unitoffice_id)
					->where('employs.isActive', '!=', '0')
					->orderBy('ranks.Hierarchy');
					
				}
				


			}
       

        return Datatables::of($employs)
        ->add_column('Actions', '{{Form::radio(\'emp_id\', $id, false)}}')
        ->remove_column('id')
        ->make(true);
    }

public function anyKpiUnitAdmin()
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
					->select('employs.id as id', 'employs.EmpLastName as EmpLastName', 'employs.EmpFirstName as EmpFirstName', 'ranks.RankCode as rank')
					->where('UnitOfficeID','=',$unitoffice_id)
					->where('employs.UnitOfficeSecondaryID','=',$secondaryoffice_id)
					->where('employs.isActive', '!=', '0')
					->orderBy('ranks.Hierarchy');
					
				}

				if($unitadmin->UnitOfficeSecondaryID == '0')
				{
					$employs = DB::table('ranks')
					->join('employs', 'ranks.id', '=', 'employs.RankID')
					->select('employs.id as id', 'employs.EmpLastName as EmpLastName', 'employs.EmpFirstName as EmpFirstName', 'ranks.RankCode as rank')
					->where('employs.UnitOfficeID','=',$unitoffice_id)
					->where('employs.isActive', '!=', '0')
					->orderBy('ranks.Hierarchy');
				}
				


			}

			
       

        return Datatables::of($employs)
        ->add_column('Actions', '{{Form::radio(\'emp_id\', $id, false)}}')
        ->remove_column('id')
        ->make(true);
    }



//Notification Submitted Last week

	public function notifSubmitted()
    {

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
						->join('unit_offices', 'unit_offices.id', '=', 'employs.UnitOfficeID')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('target_approval.status', '=', 'submitted')
						->where('date', '=', $LastWeekStartDate)
						->where('employs.isActive', '!=', '0')
						->groupBy('employs.id')
						->orderBy('ranks.Hierarchy')
						->select('employs.id as id', 'employs.EmpPicturePath as picpath', 'employs.EmpLastName as lastname', 'employs.EmpFirstName as firstname', 'ranks.RankCode as rank', 'unit_offices.UnitOfficeName as unit');
        
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
						->join('unit_offices', 'unit_offices.id', '=', 'employs.UnitOfficeID')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('target_approval.status', '=', 'submitted')
						->where('date', '=', $dt_min)
						->where('employs.isActive', '!=', '0')
						->groupBy('employs.id')
						->orderBy('ranks.Hierarchy')
						->select('employs.id as id', 'employs.EmpPicturePath as picpath', 'employs.EmpLastName as lastname', 'employs.EmpFirstName as firstname', 'ranks.RankCode as rank', 'unit_offices.UnitOfficeName as unit');
        

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
						->join('unit_offices', 'unit_offices.id', '=', 'employs.UnitOfficeID')
						
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
						
						->groupBy('employs.id')
						->orderBy('ranks.Hierarchy')
						->select('employs.id as id', 'employs.EmpPicturePath as picpath', 'employs.EmpLastName as lastname', 'employs.EmpFirstName as firstname', 'ranks.RankCode as rank', 'unit_offices.UnitOfficeName as unit');
        


      
        return Datatables::of($didNotSubmitted)
        ->add_column('Pictures', '<img style = "height:60px; width:60px;" src="{{URL::asset($picpath)}}">')
 
        ->remove_column('id')
        ->remove_column('picpath')
        ->make(true);

    }
          

//notif no scorecard

    public function notifNoScorecard()
    {

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

    
        	$noScorecardList = DB::table('employs')
				->join('ranks', 'ranks.id', '=', 'employs.RankID')
				->join('unit_offices', 'unit_offices.id', '=', 'employs.UnitOfficeID')
				->whereNotIn('employs.id', function($q)
					{
						$q->select('empID')->from('target_approval');
					})
				->where('employs.isActive', '!=', '0')
				->groupBy('employs.id')
				->orderBy('ranks.Hierarchy')
				->select('employs.id as id', 'employs.EmpPicturePath as picpath', 'employs.EmpLastName as lastname', 'employs.EmpFirstName as firstname', 'ranks.RankCode as rank', 'unit_offices.UnitOfficeName as unit');
      
        return Datatables::of($noScorecardList)
        ->add_column('Pictures', '<img style = "height:60px; width:60px;" src="{{URL::asset($picpath)}}">')
        ->remove_column('id')
        ->remove_column('picpath')
        ->make(true);

    }




//Unit admin submitted notif
    public function UANotifSubmitted()
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
						->orderBy('ranks.Hierarchy')
						->select('employs.id as id', 'employs.EmpPicturePath as picpath', 'employs.EmpLastName as lastname', 'employs.EmpFirstName as firstname', 'ranks.RankCode as rank' );
        

	
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
						->orderBy('ranks.Hierarchy')
						->select('employs.id as id', 'employs.EmpPicturePath as picpath', 'employs.EmpLastName as lastname', 'employs.EmpFirstName as firstname', 'ranks.RankCode as rank' );
        


        }


        return Datatables::of($submitted)
        ->add_column('Pictures', '<img style = "height:60px; width:60px;" src="{{URL::asset($picpath)}}">')
        ->add_column('Actions', '<a class = \'btn btn-primary\' href="{{ URL::to(\'SubmittedScorecardForThisWeek/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'SubmittedScorecardForThisWeek/\' . $id) }}\', \'newwindow\'); return false;">View</a>')
        ->remove_column('id')
        ->remove_column('picpath')
        ->make(true);



    }



    //Unit admin submitted last week notif
    public function UANotifLastWeekSubmitted()
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
        	

	$lastSubmitted = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('target_approval.status', '=', 'submitted')
						->where('date', '=', $LastWeekStartDate)
						->where('UnitOfficeID', '=', $officeId)
						->where('employs.isActive', '!=', '0')
						->groupBy('employs.id')
						->orderBy('ranks.Hierarchy')
						->select('employs.id as id', 'employs.EmpPicturePath as picpath', 'employs.EmpLastName as lastname', 'employs.EmpFirstName as firstname', 'ranks.RankCode as rank' );


        }

 
        else
        {

        	$lastSubmitted = DB::table('target_approval')
						->join('employs', 'target_approval.EmpID', '=', 'employs.id')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('target_approval.status', '=', 'submitted')
						->where('date', '=', $LastWeekStartDate)
						->where('UnitOfficeSecondaryID', '=', $officeId)
						->where('employs.isActive', '!=', '0')
						->groupBy('employs.id')
						->orderBy('ranks.Hierarchy')
						->select('employs.id as id', 'employs.EmpPicturePath as picpath', 'employs.EmpLastName as lastname', 'employs.EmpFirstName as firstname', 'ranks.RankCode as rank' );
        


        }


        return Datatables::of($lastSubmitted)
        ->add_column('Pictures', '<img style = "height:60px; width:60px;" src="{{URL::asset($picpath)}}">')
        ->add_column('Actions', '<a class = \'btn btn-primary\' href="{{ URL::to(\'SubmittedScorecardForLastWeek/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'SubmittedScorecardForLastWeek/\' . $id) }}\', \'newwindow\'); return false;">View</a>')
        ->remove_column('id')
        ->remove_column('picpath')
        ->make(true);



    }



        //Unit admin didnt submit notif
    public function UANotifDidntSubmit()
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
						->groupBy('employs.id')
						->orderBy('ranks.Hierarchy')
						->select('employs.id as id', 'employs.EmpPicturePath as picpath', 'employs.EmpLastName as lastname', 'employs.EmpFirstName as firstname', 'ranks.RankCode as rank' );
        
	

        }

 
        else
        {

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
						->groupBy('employs.id')
						->orderBy('ranks.Hierarchy')
						->select('employs.id as id', 'employs.EmpPicturePath as picpath', 'employs.EmpLastName as lastname', 'employs.EmpFirstName as firstname', 'ranks.RankCode as rank' );
        
        }


        return Datatables::of($didNotSubmitted)
        ->add_column('Pictures', '<img style = "height:60px; width:60px;" src="{{URL::asset($picpath)}}">')
        ->remove_column('id')
        ->remove_column('picpath')
        ->make(true);



    }




            //Unit admin no scorecard notif
    public function UANotifNoScorecard()
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
        	
        	$noScorecardList = DB::table('employs')
				->join('ranks', 'ranks.id', '=', 'employs.RankID')
				->whereNotIn('employs.id', function($q)
					{
						$q->select('empID')->from('target_approval');
					})
				->where('UnitOfficeID', '=', $officeId)
				->where('employs.isActive', '!=', '0')
				->groupBy('employs.id')
						->orderBy('ranks.Hierarchy')
						->select('employs.id as id', 'employs.EmpPicturePath as picpath', 'employs.EmpLastName as lastname', 'employs.EmpFirstName as firstname', 'ranks.RankCode as rank' );
        

        }

 
        else
        {

        	$noScorecardList = DB::table('employs')
				->join('ranks', 'ranks.id', '=', 'employs.RankID')
				->whereNotIn('employs.id', function($q)
					{
						$q->select('empID')->from('target_approval');
					})
				->where('UnitOfficeSecondaryID', '=', $officeId)
				->where('employs.isActive', '!=', '0')
				->groupBy('employs.id')
						->orderBy('ranks.Hierarchy')
						->select('employs.id as id', 'employs.EmpPicturePath as picpath', 'employs.EmpLastName as lastname', 'employs.EmpFirstName as firstname', 'ranks.RankCode as rank' );
        
        }


        return Datatables::of($noScorecardList)
        ->add_column('Pictures', '<img style = "height:60px; width:60px;" src="{{URL::asset($picpath)}}">')
        ->remove_column('id')
        ->remove_column('picpath')
        ->make(true);



    }
            
}
?>