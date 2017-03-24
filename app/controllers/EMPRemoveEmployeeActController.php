<?php

class EMPRemoveEmployeeActController extends BaseController 

{

    public function showRemoveEmpAct()
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
            	$main_activities = DB::table('main_activities')
            	->where('EmpID', '=', $id)
            	->whereNotIn('main_activities.id', function($q2)
        		{		
        				$q2->select('MainActivityID')->from('activity_variants');
        		})		
            	->get();
                $emp_id = $id;
                $emp = DB::table('employs')
                ->join('ranks', 'ranks.id', '=', 'employs.RankID')
                ->where('employs.id', '=', $id)
                ->get();
                return View::make('EMPremoveEmpAct')
                ->with('main_activities', $main_activities)
                ->with('emp_id', $emp_id)
                ->with('emp', $emp)
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


     public function showRemoveEmpSub($id)
    {


        if (Session::has('empid') && Session::has('empname')) {

            $empid = Session::get('empid', 'default');

            $name = Session::get('empname', 'default');

            $pic = Session::get('emppic', 'default');

            $users = DB::table('users')->get();

            $myrecord = DB::table('employs')
            ->where('id','=',$empid)
            ->get();

            

            foreach($myrecord as $myrecords)
            {
                    $unitoffice = DB::table('unit_admins')
                    ->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
                    ->get();
            }

            	$sub_activities = DB::table('sub_activities')
            	->where('MainActivityID', '=', $id)
            	->whereNotIn('sub_activities.id', function($q2)
        		{		
        				$q2->select('SubActivityID')->from('activity_variants');
        		})		
            	->get();
            	 $main_id = $id;
            	 $main = DB::table('main_activities')->where('main_activities.id', '=', $id)->first();
                return View::make('EMPremoveEmpSub')
                ->with('sub_activities', $sub_activities)
                ->with('main_id', $main_id)
                ->with('main', $main)
                ->with('id', $empid)

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

////////////////////////////////////////////////////////////////////////////////
    public function showRemoveAllEmpSub()
    {#employee/EMPremoveAllEmpSub


        if (Session::has('empid') && Session::has('empname')) {

            $empid = Session::get('empid', 'default');

            $name = Session::get('empname', 'default');

            $pic = Session::get('emppic', 'default');

            $users = DB::table('users')->get();

            $myrecord = DB::table('employs')
            ->where('id','=',$empid)
            ->get();

            

            foreach($myrecord as $myrecords)
            {
                    $unitoffice = DB::table('unit_admins')
                    ->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
                    ->get();
            }

                $sub_activities = DB::table('main_activities')
                ->join('sub_activities','sub_activities.MainActivityID' , '=', 'main_activities.id')
                ->where('sub_activities.EmpID','=',$empid)
                ->whereNotIn('sub_activities.id', function($q2)
                {       
                        $q2->select('SubActivityID')->from('activity_variants');
                })      
                ->get();
                return View::make('EMPremoveAllEmpSub')
                ->with('sub_activities', $sub_activities)
                ->with('id', $empid)
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


    public function showRemoveEmpMeasure($id)
    {
        if (Session::has('empid') && Session::has('empname')) {

            $empid = Session::get('empid', 'default');

            $name = Session::get('empname', 'default');

            $pic = Session::get('emppic', 'default');

            $users = DB::table('users')->get();

            $myrecord = DB::table('employs')
            ->where('id','=',$empid)
            ->get();

            

            foreach($myrecord as $myrecords)
            {
                    $unitoffice = DB::table('unit_admins')
                    ->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
                    ->get();
            }
       
        	$measures = DB::table('measures')
        	->where('SubActivityID', '=', $id)
        	->whereNotIn('measures.id', function($q2)
    		{		
    				$q2->select('MeasureID')->from('measure_variants');
    		})		
        	->get();
        	 $sub_id = $id;
        	 $sub = DB::table('sub_activities')->where('sub_activities.id', '=', $id)->first();
            return View::make('EMPremoveEmpMeasure')
            ->with('measures', $measures)
            ->with('sub', $sub)
            ->with('sub_id', $sub_id)
            ->with('id', $empid)

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

    public function showRemoveAllEmpMeasure()
    {#employee/EMPremoveEmpMeasure
        if (Session::has('empid') && Session::has('empname')) {

            $empid = Session::get('empid', 'default');

            $name = Session::get('empname', 'default');

            $pic = Session::get('emppic', 'default');

            $users = DB::table('users')->get();

            $myrecord = DB::table('employs')
            ->where('id','=',$empid)
            ->get();

            

            foreach($myrecord as $myrecords)
            {
                    $unitoffice = DB::table('unit_admins')
                    ->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
                    ->get();
            }
       
            $measures = DB::table('sub_activities')
            ->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')
            ->where('measures.EmpID','=',$empid)
            ->whereNotIn('measures.id', function($q2)
            {       
                    $q2->select('MeasureID')->from('measure_variants');
            })      
            ->get();

            return View::make('EMPremoveAllEmpMeasure')
                ->with('measures', $measures)
                ->with('id', $empid)
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

     public function postDeleteMain()
    {
    	$emp_id = Input::get('emp_id');
    	
    	$mains = Input::get('main_id');
    	
    		if ($mains != null)
    		{
    			foreach($mains as $main)
    			{	
    				$subs = DB::table('sub_activities')->where('MainActivityID', '=', $main)->get();

    				foreach($subs as $sub)
    				{
    					$measures = DB::table('measures')->where('SubActivityID', '=', $sub->id)->get();

    					foreach($measures as $measure)
    					{
    						DB::table('measures')->where('EmpID', '=', $emp_id)->where('id', '=', $measure->id)->delete();
    					}

    					DB::table('sub_activities')->where('EmpID', '=', $emp_id)->where('id', '=', $sub->id)->delete();
    			
    				}



    				DB::table('main_activities')->where('EmpID', '=', $emp_id)->where('id', '=', $main)->delete();
    			}

    			Session::flash('message', 'Main Activity Successfully Deleted');

    			return Redirect::to('employee/EMPremoveEmpAct');

    		}


    		Session::flash('message', 'Please click the checkbox to delete activity');
    		return Redirect::to('employee/EMPremoveEmpAct');
    }



      public function postDeleteSub()
    {
    	$main_id = Input::get('main_id');
    	$counter = Input::get('counter');
    	
    	$subs = Input::get('sub_id');
    	
    		if ($subs != null)
    		{
    			foreach($subs as $sub)
    			{	
    					$measures = DB::table('measures')->where('SubActivityID', '=', $sub)->get();

    					foreach($measures as $measure)
    					{
    						DB::table('measures')->where('id', '=', $measure->id)->delete();
    					}


    				DB::table('sub_activities')->where('id', '=', $sub)->delete();
    			}

    			Session::flash('message', 'Sub Activity Successfully Deleted');
    			if ($counter == null)
    			{
    				return Redirect::to('EMPremoveEmpSub/'.$main_id);
    			}
    			else
    			{
    				return Redirect::to('employee/EMPremoveAllEmpSub');
    			}
    		}


    		Session::flash('message', 'Please click the checkbox to delete activity');
    		if ($counter == null)
    			{
    				return Redirect::to('EMPremoveEmpSub/'.$main_id);
    			}
    		else{
    				return Redirect::to('employee/EMPremoveAllEmpSub');
    			}
    }



          public function postDeleteMeasure()
    {
    	$sub_id = Input::get('sub_id');
    	$measures = Input::get('measure_id');
    	$counter = Input::get('counter');
    	
    		if ($measures != null)
    		{
    					foreach($measures as $measure)
    					{
    						DB::table('measures')->where('id', '=', $measure)->delete();
    					}

    			Session::flash('message', 'Measures Successfully Deleted');
    		if ($counter == null)
    			{
    				return Redirect::to('EMPremoveEmpMeasure/'.$sub_id);
    			}
    		else{
    				return Redirect::to('employee/EMPremoveEmpMeasure');
    			}

    		}


    		Session::flash('message', 'Please click the checkbox to delete activity');
    		if ($counter == null)
    			{
    				return Redirect::to('EMPremoveEmpMeasure/'.$sub_id);
    			}
    		else{
    				return Redirect::to('employee/EMPremoveEmpMeasure');
    			}
    }


}	

