<?php

class ScorecardController extends BaseController 

{	
	public function postReset()
	{
		$id = Session::get('empid', 'default');
			$today = new DateTime("now");

			 $dt_min = new DateTime("monday");

            if ($dt_min > $today)

            {

                $dt_min = new DateTime("last monday");

            }

		DB::table('target_approval')->where('EmpID', '=', $id)->where('date', '=', $dt_min)->delete();

		return Redirect::to('employee/accomplishment-final');


	}

	public function showFinalAccomplishment()

    {

    	if (Session::has('empid') && Session::has('empname')) {

			$id = Session::get('empid', 'default');

			$pic = Session::get('emppic', 'default');

			$name = Session::get('empname', 'default');


			
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




			$employee = DB::table('employs')

			->where('id','=',$id)

			->get();

			$rank = DB::table('ranks')

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

			$position = DB::table('positions')

			->get();			

			date_default_timezone_set('Asia/Singapore');

 			 $today = new DateTime("now");

            $dt_min = new DateTime("monday");

           $users = DB::table('users')->get();

            

            if ($dt_min > $today)

            {

                $dt_min = new DateTime("last monday");

            }





 			$dt_max = clone($dt_min);

 			$dt_max->modify('+6 days');

 			$datenow = date('Y-m-d');

 			$monthnow = date('M');

 			$yearnow = date('Y');

 			$month = date("F", strtotime($monthnow));

 			$mainactivity = DB::table('main_activities')->where('EmpID', '=', $id)->get();

			$subactivity = DB::table('sub_activities')->where('EmpID', '=', $id)->get();

			$measure = DB::table('measures')->where('EmpID', '=', $id)->get();



			$targetstat = DB::table('target_approval')
    		->where('target_approval.date', '=', $dt_min)

    		->where('target_approval.empID', '=', $id)


    		->get();



    		$targetstatus=null;



    		foreach($targetstat as $tar)

    		{

    			$targetstatus = $tar->status;

    		}


    		if($targetstatus == null)

    		{

    			$emp_activities = DB::table('main_activities')

				->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')

				->join('objectives', 'objectives.id', '=', 'sub_activities.ObjectiveID')

				->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')

				->join('employs', 'main_activities.EmpID', '=', 'employs.id')

    			->where('main_activities.EmpID', '=', $id)

    			->where('sub_activities.EmpID', '=', $id)

    			->where('main_activities.TDate', '=', NULL )
    			->where('sub_activities.TerminationDate', '=', NULL )
    			->where('measures.TerminationDate', '=', NULL )

    				->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    				AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
		    				AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
		    				AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")


                ->select('main_activities.id as MainActivityID' , 'sub_activities.id as SubActivityID', 'measures.id as MeasureID', 'MainActivityName', 

                    'SubActivityName', 'MeasureName' , 'ObjectiveName', 'employs.UnitOfficeID', 'employs.UnitOfficeSecondaryID', 'employs.UnitOfficeTertiaryID', 'employs.UnitOfficeQuaternaryID')
    			->orderBy('main_activities.Main_ID', 'asc')
                ->orderBy('objectives.id','asc')

                ->orderBy('sub_activities.id', 'asc')


    			->get();

    		$other_activities = DB::table('other_activities')

				->join('other_measures', 'other_activities.id', '=', 'other_measures.OtherActivitiesID')

    			->where('other_activities.EmpID', '=', $id)

    			->where('other_activities.OtherDate', '!=', 'NULL' )

    			->where('other_measures.MeasureDate', '=', NULL)
   
    			->orderBy('other_activities.id', 'asc')

    			->orderBy('other_measures.id', 'asc')

    			->select('other_activities.id as OtherActivitiesID', 'other_measures.id as OtherMeasureID', 'OtherActivitiesName', 

    				'OtherActivitiesMeasureName')

    			->get();

    			/*
    			$emp_activities = DB::raw('
    				SELECT ma.id as MainActivityID, sa.id as SubActivityID, m.id as MeasureID, ma.MainActivityName, ma.SubActivityName, ma.MeasureName, ma.ObjectiveName
    				FROM main_activities ma
    				INNER JOIN sub_activities sa ON ma.id = sa.id
    				INNER JOIN objectives sa')
    				->get();
				*/
    		}


    		elseif($targetstatus == 'pending')

    		{

    			$emp_activities = DB::table('main_activities')

				->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')

				->join('objectives', 'objectives.id', '=', 'sub_activities.ObjectiveID')

				->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')

				->join('target_approval', 'measures.id' , '=', 'target_approval.measureID')

				->join('employs', 'main_activities.EmpID', '=', 'employs.id')

				->where('target_approval.empID', '=', $id)

    			->where('main_activities.EmpID', '=', $id)

    			->where('sub_activities.EmpID', '=', $id)

    			->where('main_activities.TDate', '=', NULL )


    			->where('sub_activities.TerminationDate', '=', NULL )
    			->where('measures.TerminationDate', '=', NULL )

				->where('target_approval.date', '=', $dt_min)
				->where('target_approval.status', '=', $targetstatus)

				->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    				AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
		    				AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
		    				AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
    			
    			->orderBy('main_activities.Main_ID', 'asc')

    			->orderBy('objectives.id','asc')

                ->orderBy('sub_activities.id', 'asc')

    			->select('main_activities.id as MainActivityID' , 'sub_activities.id as SubActivityID', 'measures.id as MeasureID', 'MainActivityName', 

    				'SubActivityName', 'MeasureName' , 'ObjectiveName', 'target_approval.status', 'target_approval.value as targetvalue', 'target_approval.id as targetID', 
    				'employs.UnitOfficeID', 'employs.UnitOfficeSecondaryID', 'employs.UnitOfficeTertiaryID', 'employs.UnitOfficeQuaternaryID')

    			->get();



    		$other_activities = DB::table('other_activities')

				->join('other_measures', 'other_activities.id', '=', 'other_measures.OtherActivitiesID')

    			->where('other_activities.EmpID', '=', $id)

    			->where('other_activities.OtherDate', '!=', 'NULL' )

    			->where('other_measures.MeasureDate', '=', NULL)
   
    			->orderBy('other_activities.id', 'asc')

    			->orderBy('other_measures.id', 'asc')

    			->select('other_activities.id as OtherActivitiesID', 'other_measures.id as OtherMeasureID', 'OtherActivitiesName', 

    				'OtherActivitiesMeasureName')

    			->get();

    		}


    		elseif($targetstatus == 'rejected')

    		{

    			$emp_activities = DB::table('main_activities')

				->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')

				->join('objectives', 'objectives.id', '=', 'sub_activities.ObjectiveID')

				->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')

				->join('target_approval', 'measures.id' , '=', 'target_approval.measureID')

				->join('employs', 'main_activities.EmpID', '=', 'employs.id')

				->where('target_approval.empID', '=', $id)

    			->where('main_activities.EmpID', '=', $id)
    			->where('sub_activities.EmpID', '=', $id)

    			->where('main_activities.TDate', '=', NULL )

    			->where('sub_activities.TerminationDate', '=', NULL )
    			->where('measures.TerminationDate', '=', NULL )

				->where('target_approval.date', '=', $dt_min)

				->where('target_approval.status', '=', $targetstatus)

					->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    				AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
		    				AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
		    				AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
				
    			->orderBy('main_activities.Main_ID', 'asc')

    			->orderBy('objectives.id','asc')

                ->orderBy('sub_activities.id', 'asc')

    			->select('main_activities.id as MainActivityID' , 'sub_activities.id as SubActivityID', 'measures.id as MeasureID', 'MainActivityName', 

    				'SubActivityName', 'MeasureName' , 'ObjectiveName', 'target_approval.status', 'target_approval.value as targetvalue', 'target_approval.id as targetID'
    				, 'employs.UnitOfficeID', 'employs.UnitOfficeSecondaryID', 'employs.UnitOfficeTertiaryID', 'employs.UnitOfficeQuaternaryID')

    			->get();



    		$other_activities = DB::table('other_activities')

				->join('other_measures', 'other_activities.id', '=', 'other_measures.OtherActivitiesID')

    			->where('other_activities.EmpID', '=', $id)

    			->where('other_activities.OtherDate', '!=', 'NULL' )

    			->where('other_measures.MeasureDate', '=', NULL)
   
    			->orderBy('other_activities.id', 'asc')

    			->orderBy('other_measures.id', 'asc')

    			->select('other_activities.id as OtherActivitiesID', 'other_measures.id as OtherMeasureID', 'OtherActivitiesName', 

    				'OtherActivitiesMeasureName')

    			->get();

    		}

    		elseif($targetstatus == 'approved')

    		{

    			$emp_activities = DB::table('main_activities')

				->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')

				->join('objectives', 'objectives.id', '=', 'sub_activities.ObjectiveID')

				->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')

				->join('target_approval', 'measures.id' , '=', 'target_approval.measureID')

				->join('employs', 'main_activities.EmpID', '=', 'employs.id')

				->where('target_approval.empID', '=', $id)

    			->where('main_activities.EmpID', '=', $id)
    			->where('sub_activities.EmpID', '=', $id)

    			->where('main_activities.TDate', '=', NULL )
    			->where('sub_activities.TerminationDate', '=', NULL)
    			->where('measures.TerminationDate', '=', NULL )

				->where('target_approval.date', '=', $dt_min)
				->where('target_approval.status', '=', $targetstatus)

				->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    				AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
		    				AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
		    				AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
    			->orderBy('main_activities.Main_ID', 'asc')

    			->orderBy('objectives.id','asc')

                ->orderBy('sub_activities.id', 'asc')

    			->select('main_activities.id as MainActivityID' , 'sub_activities.id as SubActivityID', 'measures.id as MeasureID', 'MainActivityName', 

    				'SubActivityName', 'MeasureName' , 'ObjectiveName', 'target_approval.status', 'target_approval.value as targetvalue', 'target_approval.id as targetID'
    				, 'employs.UnitOfficeID', 'employs.UnitOfficeSecondaryID', 'employs.UnitOfficeTertiaryID', 'employs.UnitOfficeQuaternaryID')

    			->get();



    		$other_activities = DB::table('other_activities')

				->join('other_measures', 'other_activities.id', '=', 'other_measures.OtherActivitiesID')

    			->where('other_activities.EmpID', '=', $id)

    			->where('other_activities.OtherDate', '!=', 'NULL' )

    			->where('other_measures.MeasureDate', '=', NULL)
   
    			->orderBy('other_activities.id', 'asc')

    			->orderBy('other_measures.id', 'asc')

    			->select('other_activities.id as OtherActivitiesID', 'other_measures.id as OtherMeasureID', 'OtherActivitiesName', 

    				'OtherActivitiesMeasureName')

    			->get();

    		}



    		else

    		{

    			/*

    			$emp_activities = DB::table('main_activities')

				->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')

				->join('objectives', 'objectives.id', '=', 'sub_activities.ObjectiveID')

				->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')

				->join('target_approval', 'measures.id' , '=', 'target_approval.measureID')

				->join('measure_variants', 'measure_variants.MeasureID' , '=', 'measures.id')

				->join('daily_accomplishments' , 'measure_variants.id' , '=', 'daily_accomplishments.MeasureVariantID')

				->where('target_approval.empID', '=', $id)

				->where('target_approval.date', '=', $dt_min)

    			->where('main_activities.EmpID', '=', $id)

    			->where('sub_activities.TerminationDate', '>', $today)

    			->orWhere('sub_activities.TerminationDate', '=', NULL )

    			->orderBy('main_activities.Main_ID', 'asc')

    			->orderBy('sub_activities.id', 'asc')

    			->orderBy('objectives.id','asc')

    			->select('main_activities.id as MainActivityID' , 'sub_activities.id as SubActivityID', 'measures.id as MeasureID', 'MainActivityName', 

    				'SubActivityName', 'MeasureName' , 'ObjectiveName', 'target_approval.status as targetstatus', 'target_approval.value as targetvalue', 'target_approval.id as targetID', 'daily_accomplishments.MondayValue as monday',  'daily_accomplishments.TuesdayValue as tuesday',  'daily_accomplishments.WednesdayValue as wednesday',  'daily_accomplishments.ThursdayValue as thursday',  'daily_accomplishments.FridayValue as friday',  'daily_accomplishments.SaturdayValue as saturday',  'daily_accomplishments.SundayValue as sunday')

    			->get();

    			*/

    			$emp_activities  = DB::table('main_activities')

	                ->join('employs', 'employs.id', '=', 'main_activities.EmpID')

	                ->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')

	                ->join('objectives', 'objectives.id', '=', 'sub_activities.ObjectiveID')

	                ->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')

	                ->join('measure_variants', 'measures.id', '=', 'measure_variants.MeasureID')

	                ->join('daily_accomplishments', 'measure_variants.id', '=', 'daily_accomplishments.MeasureVariantID')

	                ->where('main_activities.EmpID', '=', $id)

	                ->where('sub_activities.EmpID', '=', $id)

	    			->where('main_activities.TDate', '=', NULL )
    				->where('sub_activities.TerminationDate', '=', NULL )
    				->where('measures.TerminationDate', '=', NULL )

    				->where('sub_activities.EmpID', '=', $id)

	                ->whereBetween('daily_accomplishments.Date', array($dt_min, $dt_max))

	                ->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
		    				AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
		    				AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
		    				AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")

	                ->orderBy('main_activities.Main_ID', 'asc')

	    			->orderBy('objectives.id','asc')

                ->orderBy('sub_activities.id', 'asc')

	                ->get();


    				$other_activities  = DB::table('other_activities')

	                ->join('employs', 'employs.id', '=', 'other_activities.EmpID')

	                ->join('other_measures', 'other_activities.id', '=', 'other_measures.OtherActivitiesID')

	                ->join('othermeasure_variants', 'other_measures.id', '=', 'othermeasure_variants.OtherMeasureID')

	                ->join('otherdaily_accomplishment', 'othermeasure_variants.id', '=', 'otherdaily_accomplishment.OtherMeasureVariantID')

	                ->where('other_activities.EmpID', '=', $id)

	    			->where('other_activities.OtherDate', '!=', 'NULL' )

	    			->where('other_measures.MeasureDate', '=', NULL)

	                ->whereBetween('otherdaily_accomplishment.Date', array($dt_min, $dt_max))
	            
	                ->orderBy('other_activities.id', 'asc')

	                ->get();

	                


    		}





    		$objectives = DB::table('objectives')->get();




    		if($targetstatus == null)

    		{

    			return View::make('accomplishment-request')

				->with('id', $id)

				->with('pic', $pic)

				->with('name', $name)

				->with('other_activities', $other_activities)

				->with('employee',$employee)

				->with('rank',$rank)

				->with('position',$position)

				->with('dt_min',$dt_min)

				->with('dt_max',$dt_max)

				->with('month',$month)

				->with('yearnow',$yearnow)

				->with('mainactivity',$mainactivity)

				->with('subactivity',$subactivity)

				->with('emp_activities', $emp_activities)

				->with('measure',$measure)

				->with('targetstatus',$targetstatus)

				->with('unitoffice',$unitoffice)

				->with('myrecord',$myrecord)

				->with('users',$users)
				->with('DateCovered', $DateCovered);

    		}

    		else if($targetstatus == 'pending')

    		{



    			return View::make('accomplishment-pending')

				->with('id', $id)

				->with('pic', $pic)

				->with('name', $name)

				->with('other_activities', $other_activities)

				->with('users',$users)

				->with('unitoffice',$unitoffice)

				->with('myrecord',$myrecord)

				->with('employee',$employee)

				->with('rank',$rank)

				->with('position',$position)

				->with('dt_min',$dt_min)

				->with('dt_max',$dt_max)

				->with('month',$month)

				->with('yearnow',$yearnow)

				->with('mainactivity',$mainactivity)

				->with('subactivity',$subactivity)

				->with('emp_activities', $emp_activities)

				->with('measure',$measure)

				->with('targetstatus',$targetstatus)

				->with('DateCovered', $DateCovered);

				



    		}

    		else if($targetstatus == 'rejected')

    		{



    			return View::make('accomplishment-rejected')

				->with('id', $id)

				->with('pic', $pic)

				->with('name', $name)

				->with('users',$users)

				->with('other_activities', $other_activities)

				->with('unitoffice',$unitoffice)

				->with('myrecord',$myrecord)

				->with('employee',$employee)

				->with('rank',$rank)

				->with('position',$position)

				->with('dt_min',$dt_min)

				->with('dt_max',$dt_max)

				->with('month',$month)

				->with('yearnow',$yearnow)

				->with('mainactivity',$mainactivity)

				->with('subactivity',$subactivity)

				->with('emp_activities', $emp_activities)

				->with('measure',$measure)

				->with('targetstatus',$targetstatus)
				->with('DateCovered', $DateCovered);

				



    		}

    		elseif($targetstatus == 'approved')

    		{

    			return View::make('accomplishment-approved')

				->with('id', $id)

				->with('pic', $pic)

				->with('name', $name)

				->with('users',$users)

				->with('employee',$employee)

				->with('other_activities', $other_activities)

				->with('unitoffice',$unitoffice)

				->with('myrecord',$myrecord)

				->with('rank',$rank)

				->with('position',$position)

				->with('dt_min',$dt_min)

				->with('dt_max',$dt_max)

				->with('month',$month)

				->with('yearnow',$yearnow)

				->with('mainactivity',$mainactivity)

				->with('subactivity',$subactivity)

				->with('emp_activities', $emp_activities)

				->with('measure',$measure)

				->with('targetstatus',$targetstatus)
				->with('DateCovered', $DateCovered);

    		}

    		else

    		{

    			return View::make('accomplishment-submitted')

				->with('id', $id)

				->with('pic', $pic)

				->with('name', $name)

				->with('users',$users)

				->with('unitoffice',$unitoffice)

				->with('other_activities', $other_activities)

				->with('myrecord',$myrecord)

				->with('employee',$employee)

				->with('rank',$rank)

				->with('position',$position)

				->with('dt_min',$dt_min)

				->with('dt_max',$dt_max)

				->with('month',$month)

				->with('yearnow',$yearnow)

				->with('mainactivity',$mainactivity)

				->with('subactivity',$subactivity)

				->with('emp_activities', $emp_activities)

				->with('measure',$measure)

				->with('targetstatus',$targetstatus)
				->with('DateCovered', $DateCovered);

    		}

    	

			



		

		}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/employee');

		}



	}

	





    public function postFinalAccomplishment()

    {

    	if (Session::has('empid') && Session::has('empname')) {

			
    	$Targets = Input::get('targets');
    	$TargetHasEmptyString = true;

    	if($Targets != null)
    	{
    		
	    	foreach ($Targets as $targ) 
	    	{
	    		if ($targ == "")
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
	    		# code...
	    	
    		$targetstatus = Input::get('targetstatus');

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



    		if($targetstatus == null)

    		{



    			

    			$id = Session::get('empid', 'default');

    			$pic = Session::get('emppic', 'default');

				$name = Session::get('empname', 'default');

				$employee = DB::table('employs')

				->where('id','=',$id)

				->get();

				$rank = DB::table('ranks')

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

	 			$datenow = date('Y-m-d');

	 			$monthnow = date('M');

	 			$yearnow = date('Y');

	 			$month = date("F", strtotime($monthnow));

	 			$mainactivity = DB::table('main_activities')->where('EmpID', '=', $id)->get();

				$subactivity = DB::table('sub_activities')->where('EmpID', '=', $id)->get();

				$measure = DB::table('measures')->where('EmpID', '=', $id)->get();



				$objectives = DB::table('objectives')->get();

	    	



	    		$measureID =  Input::get('measures');



	    		$counter = 0;



    			foreach($Targets as $Target)

    			{

    				DB::insert('insert into target_approval(value, status , date, empID, measureID) values (?,?,?,?,?)', array($Targets[$counter],'pending', $dt_min, $id, $measureID[$counter]));

    				$counter++;

    			}



	    		if($targetstatus == null)

	    		{

	    			$emp_activities = DB::table('main_activities')

					->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')

					->join('objectives', 'objectives.id', '=', 'sub_activities.ObjectiveID')

					->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')

					->join('target_approval', 'measures.id' , '=', 'target_approval.measureID')

					->where('target_approval.empID', '=', $id)

					->where('target_approval.date', '=', $dt_min)

	    			->where('main_activities.EmpID', '=', $id)

	    			->where('measures.TerminationDate', '>', $today)

    				->orWhere('measures.TerminationDate', '=', NULL )

	    			->where('sub_activities.TerminationDate', '>', $today)

	    			->orWhere('sub_activities.TerminationDate', '=', NULL )

	    			->where('main_activities.TDate', '>', $today)

	    			->orWhere('main_activities.TDate', '=', NULL )

    				->where('sub_activities.EmpID', '=', $id)

	    			->orderBy('main_activities.Main_ID', 'asc')

	    		->orderBy('objectives.id','asc')

                ->orderBy('sub_activities.id', 'asc')

	    			->select('main_activities.id as MainActivityID' , 'sub_activities.id as SubActivityID', 'measures.id as MeasureID', 'MainActivityName', 

	    				'SubActivityName', 'MeasureName' , 'ObjectiveName','target_approval.status as targetstatus', 'target_approval.value as targetvalue', 'target_approval.id as targetID')

	    			->get();

	    		}

	    		else

	    		{

	    			$emp_activities = DB::table('main_activities')

					->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')

					->join('objectives', 'objectives.id', '=', 'sub_activities.ObjectiveID')

					->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')

					->join('target_approval', 'measures.id' , '=', 'target_approval.measureID')

					->where('target_approval.empID', '=', $id)


	    			->where('main_activities.EmpID', '=', $id)


	    			->where('measures.TerminationDate', '>', $today)

    				->orWhere('measures.TerminationDate', '=', NULL )
	    			->where('sub_activities.TerminationDate', '>', $today)

	    			->orWhere('sub_activities.TerminationDate', '=', NULL )

	    			->where('main_activities.TDate', '>', $today)

	    			->orWhere('main_activities.TDate', '=', NULL )

    				->where('sub_activities.EmpID', '=', $id)
					->where('target_approval.date', '=', $dt_min)
					->where('target_approval.status', '=', $targetstatus)

	    			->orderBy('main_activities.Main_ID', 'asc')

	    		->orderBy('objectives.id','asc')

                ->orderBy('sub_activities.id', 'asc')

	    			->select('main_activities.id as MainActivityID' , 'sub_activities.id as SubActivityID', 'measures.id as MeasureID', 'MainActivityName', 

	    				'SubActivityName', 'MeasureName' , 'ObjectiveName', 'target_approval.status as targetstatus', 'target_approval.value as targetvalue', 'target_approval.id as targetID')

	    			->get();


	    			//dd($emp_activities);

	    		}

				return Redirect::to('employee/accomplishment-final');

    		}







    		elseif($targetstatus == 'pending' || $targetstatus == 'rejected')

    		{

    			

    			

    			$targetID = Input::get('targetID');



    			$id = Session::get('empid', 'default');

    			$pic = Session::get('emppic', 'default');

				$name = Session::get('empname', 'default');

				$employee = DB::table('employs')

				->where('id','=',$id)

				->get();

				$rank = DB::table('ranks')

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

	 			$datenow = date('Y-m-d');

	 			$monthnow = date('M');

	 			$yearnow = date('Y');

	 			$month = date("F", strtotime($monthnow));

	 			$mainactivity = DB::table('main_activities')->where('EmpID', '=', $id)->get();

				$subactivity = DB::table('sub_activities')->where('EmpID', '=', $id)->get();

				$measure = DB::table('measures')->where('EmpID', '=', $id)->get();



				$objectives = DB::table('objectives')->get();

	    		$Targets = Input::get('targets');

	    		

	    		



	    		$measureID =  Input::get('measures');



	    		$counter = 0;



	    		//dd($targetID[$counter]);



    			foreach($Targets as $Target)

    			{

    				DB::table('target_approval')

						->where('id', '=' , $targetID[$counter])

						->update(array('value' => $Targets[$counter], 'status' => $targetstatus));

    				$counter++;



    			}

				



	    		if($targetstatus == null)

	    		{

	    			$emp_activities = DB::table('main_activities')

					->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')

					->join('objectives', 'objectives.id', '=', 'sub_activities.ObjectiveID')

					->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')

	    			->where('main_activities.EmpID', '=', $id)


	    			->where('measures.TerminationDate', '>', $today)

    				->orWhere('measures.TerminationDate', '=', NULL )
	    			->where('sub_activities.TerminationDate', '>', $today)

	    			->orWhere('sub_activities.TerminationDate', '=', NULL )

	    			->where('main_activities.TDate', '>', $today)

	    			->orWhere('main_activities.TDate', '=', NULL )

    				->where('sub_activities.EmpID', '=', $id)

	    			->orderBy('main_activities.Main_ID', 'asc')

	    			//->orderBy('sub_activities.id', 'asc')

	    			->orderBy('objectives.id','asc')

	    			->select('main_activities.id as MainActivityID' , 'sub_activities.id as SubActivityID', 'measures.id as MeasureID', 'MainActivityName', 

	    				'SubActivityName', 'MeasureName' , 'ObjectiveName')

	    			->get();

	    		}

	    		else

	    		{

	    			$emp_activities = DB::table('main_activities')

					->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')

					->join('objectives', 'objectives.id', '=', 'sub_activities.ObjectiveID')

					->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')

					->join('target_approval', 'measures.id' , '=', 'target_approval.measureID')

					->where('target_approval.empID', '=', $id)


	    			->where('main_activities.EmpID', '=', $id)


	    			->where('measures.TerminationDate', '>', $today)

    				->orWhere('measures.TerminationDate', '=', NULL )

	    			->where('sub_activities.TerminationDate', '>', $today)

	    			->orWhere('sub_activities.TerminationDate', '=', NULL )


	    			->where('main_activities.TDate', '>', $today)

	    			->orWhere('main_activities.TDate', '=', NULL )
    				->where('sub_activities.EmpID', '=', $id)
					->where('target_approval.date', '=', $dt_min)

	    			->orderBy('main_activities.Main_ID', 'asc')

	    			//->orderBy('sub_activities.id', 'asc')

	    			->orderBy('objectives.id','asc')

	    			->select('main_activities.id as MainActivityID' , 'sub_activities.id as SubActivityID', 'measures.id as MeasureID', 'MainActivityName', 

	    				'SubActivityName', 'MeasureName' , 'ObjectiveName', 'target_approval.status as targetstatus', 'target_approval.value as targetvalue','target_approval.id as targetID')

	    			->get();

	    			//dd($emp_activities);

	    		}







	    		/*

				return View::make('accomplishment-pending')

				->with('id', $id)

				->with('pic', $pic)

				->with('name', $name)

				->with('users',$users)

				->with('employee',$employee)

				->with('rank',$rank)

				->with('position',$position)

				->with('dt_min',$dt_min)

				->with('dt_max',$dt_max)

				->with('month',$month)

				->with('yearnow',$yearnow)

				->with('mainactivity',$mainactivity)

				->with('subactivity',$subactivity)

				->with('emp_activities', $emp_activities)

				->with('measure',$measure)

				->with('unitoffice',$unitoffice)

				->with('myrecord',$myrecord)

				->with('targetstatus',$targetstatus)
				->with('DateCovered', $DateCovered);

				*/
				return Redirect::to('employee/accomplishment-final');



    		}







    		elseif($targetstatus == 'approved')

    		{

	    		$SubActivities = Input::get('subactivities');

	    		$OtherActivities = Input::get('otheractivities');

	    		$MainActivities = Input::get('mainactivities');

	    		$targetID = Input::get('targetID');



				$id = Session::get('empid', 'default');

				$pic = Session::get('emppic', 'default');

				

				$counter = 0;

				$activity = DB::table('activity_variants')

				->where('EmpID', '=', $id)

				->get();

				$other = DB::table('other_variants')

				->where('EmpID', '=', $id)

				->get();

				$measure_activity = DB::table('measure_variants')

				->where('EmpID', '=', $id)

				->get();


				$othermeasure_activity = DB::table('othermeasure_variants')

				->where('EmpID', '=', $id)

				->get();

				 $today = new DateTime("now");

	            $dt_min = new DateTime("monday");

	           

	            

	            if ($dt_min > $today)

	            {

	                $dt_min = new DateTime("last monday");

	            }

	 			$dt_max = clone($dt_min);

	 			$dt_max->modify('+6 days');
				//Delete Activity Variants before adding again...
				//DB::table('activity_variants')->where('EmpID', '=', $id)->delete();


						foreach($SubActivities as $SubActivity)

						{

						DB::insert('insert into activity_variants(MainActivityID,SubActivityID ,EmpID, ActivityVariantDate) values (?,?,?,?)', array($MainActivities[$counter],$SubActivity, $id, $dt_min));

							$counter++;

						}


                if($OtherActivities != null)
                {
						foreach($OtherActivities as $OtherActivity)

						{

						DB::insert('insert into other_variants(OtherActivityID ,EmpID, OtherVariantDate) values (?,?,?)', array($OtherActivity, $id, $dt_min));

							$counter++;

						}
                }

				$Measures = Input::get('measures');

				$Targets = Input::get('targets');

				$Mondays = Input::get('day1');

				$Tuesdays = Input::get('day2');

				$Wednesdays = Input::get('day3');

				$Thursdays = Input::get('day4');

				$Fridays = Input::get('day5');

				$Saturdays = Input::get('day6');

				$Sundays = Input::get('day7');

				$Cost = Input::get('cost');

				$Remarks = Input::get('remarks');

/*---------------------------------------------------------------*/
				$OtherMeasures = Input::get('othermeasures');

				$OtherTargets = Input::get('othertargets');

				$OtherMondays = Input::get('otherday1');

				$OtherTuesdays = Input::get('otherday2');

				$OtherWednesdays = Input::get('otherday3');

				$OtherThursdays = Input::get('otherday4');

				$OtherFridays = Input::get('otherday5');

				$OtherSaturdays = Input::get('otherday6');

				$OtherSundays = Input::get('otherday7');

				$OtherCost = Input::get('othercost');

				$OtherRemarks = Input::get('otherremarks');
/*--------------------------------------------------------------*/
				date_default_timezone_set('Asia/Singapore');

	 			$today = new DateTime("now");

	            $dt_min = new DateTime("monday");

	           





	            if ($dt_min > $today)

	            {

	                $dt_min = new DateTime("last monday");

	            }

				



				$counter1 = 0;

				//if($measure_activity == null)

				//{
				//Delete Measure Variants before adding again...
				//DB::table('measure_variants')->where('EmpID', '=', $id)->delete();
                if($OtherMeasures != null)
                {
    				foreach($OtherMeasures as $othermeasure)
    				{

    					 $OtherVariants = DB::table('other_variants')

    					->join('other_measures','other_measures.OtherActivitiesID','=','other_variants.OtherActivityID')

    					->select('other_variants.id')

    					->where('other_variants.EmpID', '=', $id)

    					->where('other_variants.OtherVariantDate', '=', $dt_min)

    					->get();

    				
    					DB::insert('insert into othermeasure_variants(OtherVariantsID ,OtherMeasureID, EmpID, OtherMeasureVariantDate) values (?,?,?,?)', array($OtherVariants[$counter1]->id,$othermeasure, $id, $dt_min));

    					$counter1++;

    				}
                }


				$counter1 = 0;


				foreach($Measures as $measure)

				{

					 $ActivityVariants = DB::table('activity_variants')

					->join('measures','measures.SubActivityID','=','activity_variants.SubActivityID')

					->select('activity_variants.id')

					->where('activity_variants.EmpID', '=', $id)

					->where('activity_variants.ActivityVariantDate', '=', $dt_min)

					->get();

					

					DB::insert('insert into measure_variants(ActivityVariantID, MeasureID, EmpID, MeasureVariantDate) values (?,?,?,?)', array($ActivityVariants[$counter1]->id, $measure, $id,$dt_min));

					$counter1++;

			

				}

				//}



				$counter2= 0;



				foreach($Measures as $measure)

				{

					$MeasureVariants = DB::table('measure_variants')

					->join('measures','measures.id','=','measure_variants.MeasureID')

					->select('measure_variants.id')

					->where('measure_variants.EmpID', '=', $id)

					->where('measure_variants.MeasureVariantDate', '=', $dt_min)

					->get();



					

					DB::insert('insert into daily_accomplishments(MeasureVariantID ,Target, MondayValue, TuesdayValue, WednesdayValue, ThursdayValue, FridayValue, SaturdayValue, SundayValue, Cost, Remarks, Date) values (?,?,?,?,?,?,?,?,?,?,?,?)', array($MeasureVariants[$counter2]->id, $Targets[$counter2], $Mondays[$counter2], $Tuesdays[$counter2], $Wednesdays[$counter2], $Thursdays[$counter2], $Fridays[$counter2], $Saturdays[$counter2], $Sundays[$counter2], 

						$Cost[$counter2], $Remarks[$counter2], 	$dt_min));

					$counter2++;



				}


				$counter2= 0;


                if($OtherMeasures != null)
                {
    				foreach($OtherMeasures as $othermeasure)
    				{

    					$OtherMeasureVariants = DB::table('othermeasure_variants')

    					->join('other_measures','other_measures.id','=','othermeasure_variants.OtherMeasureID')

    					->select('othermeasure_variants.id')

    					->where('othermeasure_variants.EmpID', '=', $id)

    					->where('othermeasure_variants.OtherMeasureVariantDate', '=', $dt_min)

    					->get();



    					

    					DB::insert('insert into otherdaily_accomplishment(OtherMeasureVariantID ,Target, MondayValue, TuesdayValue, WednesdayValue, ThursdayValue, FridayValue, SaturdayValue, SundayValue, Cost, Remarks, Date) values (?,?,?,?,?,?,?,?,?,?,?,?)', array($OtherMeasureVariants[$counter2]->id, $OtherTargets[$counter2], $OtherMondays[$counter2], $OtherTuesdays[$counter2], $OtherWednesdays[$counter2], $OtherThursdays[$counter2], $OtherFridays[$counter2], $OtherSaturdays[$counter2], $OtherSundays[$counter2], 

    						$OtherCost[$counter2], $OtherRemarks[$counter2], 	$dt_min));

    					$counter2++;

    				}
                }


				$name = Session::get('empname', 'default');

				$employee = DB::table('employs')

				->where('id','=',$id)

				->get();

				foreach($employee as $employs)
				{
					DB::insert('insert into employee_info(EmpID ,RankID, PositionID, StartDate) values (?,?,?,?)', array($employs->id, $employs->RankID, $employs->PositionID, $dt_min));
				}

				$rank = DB::table('ranks')

				->get();

				$position = DB::table('positions')

				->get();			

	 			$dt_max = clone($dt_min);

	 			$dt_max->modify('+6 days');

	 			$monthnow = date('M');

	 			$yearnow = date('Y');

	 			$month = date("F", strtotime($monthnow));

	 			$mainactivity = DB::table('main_activities')->where('EmpID', '=', $id)->get();

				$subactivity = DB::table('sub_activities')->where('EmpID', '=', $id)->get();

				$measure = DB::table('measures')->where('EmpID', '=', $id)->get();

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



				/*$emp_activities = DB::table('main_activities')

					->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')

					->join('objectives', 'objectives.id', '=', 'sub_activities.ObjectiveID')

					->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')

	    			->where('main_activities.EmpID', '=', $id)

	    			->where('sub_activities.TerminationDate', '>', $today)

	    			->orWhere('sub_activities.TerminationDate', '=', NULL )

	    			->select('main_activities.id as MainActivityID' , 'sub_activities.id as SubActivityID', 'measures.id as MeasureID', 'MainActivityName', 

	    				'SubActivityName', 'MeasureName', 'ObjectiveName')

	    			->get();*/



	    		$emp_activities  = DB::table('main_activities')

	                ->join('employs', 'employs.id', '=', 'main_activities.EmpID')

	                ->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')

	                ->join('objectives', 'objectives.id', '=', 'sub_activities.ObjectiveID')

	                ->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')

	                ->join('measure_variants', 'measures.id', '=', 'measure_variants.MeasureID')

	                ->join('daily_accomplishments', 'measure_variants.id', '=', 'daily_accomplishments.MeasureVariantID')

	                ->where('main_activities.EmpID', '=', $id)

	    			->where('main_activities.TDate', '>', $today)

	    			->orWhere('main_activities.TDate', '=', NULL )


	                ->where('measures.TerminationDate', '>', $today)

    				->orWhere('measures.TerminationDate', '=', NULL )

    				->where('sub_activities.TerminationDate', '>', $today)

	    			->orWhere('sub_activities.TerminationDate', '=', NULL )

    				->where('sub_activities.EmpID', '=', $id)
	                ->whereBetween('daily_accomplishments.Date', array($dt_min, $dt_max))

	                ->orderBy('main_activities.Main_ID', 'asc')

	    			->orderBy('sub_activities.id', 'asc')

	    			->orderBy('objectives.id','asc')

	                ->get();



	            $counter = 0;

	    		foreach($Targets as $Target)

    			{

    				DB::table('target_approval')

						->where('id', '=' , $targetID[$counter])

						->update(array('status' => 'submitted'));

    				$counter++;



    			}

				



	    		Session::flash('message', 'Scorecard was successfuly saved');

				/*	    		

				return View::make('accomplishment-submitted')

				->with('id', $id)

				->with('pic', $pic)

				->with('name', $name)

				->with('users',$users)

				->with('unitoffice',$unitoffice)

				->with('myrecord',$myrecord)

				->with('employee',$employee)

				->with('rank',$rank)

				->with('position',$position)

				->with('dt_min',$dt_min)

				->with('dt_max',$dt_max)

				->with('month',$month)

				->with('yearnow',$yearnow)

				->with('mainactivity',$mainactivity)

				->with('subactivity',$subactivity)

				->with('emp_activities', $emp_activities)

				->with('measure',$measure)

				->with('targetstatus',$targetstatus)
				->with('DateCovered', $DateCovered);
				*/

				return Redirect::to('employee/accomplishment-final');

			}

		}//if(TargetHasEmptyString)
		else
		{
			Session::flash('message3', 'Target Values not correctly set. Check your entry again.');

				return Redirect::to('employee/accomplishment-final');
		}
	}
		else
		{
			Session::flash('message3', 'Activities not correctly set. Check Activities and Set Objectives');

				return Redirect::to('employee/accomplishment-final'); 

		}

		}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/employee');

		}



    }

}

