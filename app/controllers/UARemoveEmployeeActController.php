<?php

class UARemoveEmployeeActController extends BaseController 

{

    public function showRemoveEmpAct($id)
    {
        if (Session::has('unitadminid') && Session::has('unitadminname')) 
            {
                $unit_admin_id = Session::get('unitadminid', 'default');
                $name = Session::get('unitadminname', 'default');
               
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
                return View::make('UAremoveEmpAct')
                ->with('main_activities', $main_activities)
                ->with('emp_id', $emp_id)
                ->with('emp', $emp)
                ->with('name', $name)
                ->with('id',$unit_admin_id); 
            }
        else
            {

                Session::flash('message', 'Please login first!');

                return Redirect::to('login/unitadmin');
            }

    }


     public function showRemoveEmpSub($id)
    {
        if (Session::has('unitadminid') && Session::has('unitadminname')) 
            {
                $unit_admin_id = Session::get('unitadminid', 'default');
                $name = Session::get('unitadminname', 'default');
            
            	$sub_activities = DB::table('sub_activities')
            	->where('MainActivityID', '=', $id)
            	->whereNotIn('sub_activities.id', function($q2)
        		{		
        				$q2->select('SubActivityID')->from('activity_variants');
        		})		
            	->get();
            	 $main_id = $id;
            	 $main = DB::table('main_activities')->where('main_activities.id', '=', $id)->first();
                return View::make('UAremoveEmpSub')
                ->with('sub_activities', $sub_activities)
                ->with('main_id', $main_id)
                ->with('main', $main) 
                ->with('name', $name)
                ->with('id',$unit_admin_id); 
            }
        else
            {

                Session::flash('message', 'Please login first!');

                return Redirect::to('login/unitadmin');
            }  
    }


      public function showRemoveEmpMeasure($id)
    {
        if (Session::has('unitadminid') && Session::has('unitadminname')) 
        {
            $unit_admin_id = Session::get('unitadminid', 'default');
            $name = Session::get('unitadminname', 'default');
           
        	$measures = DB::table('measures')
        	->where('SubActivityID', '=', $id)
        	->whereNotIn('measures.id', function($q2)
    		{		
    				$q2->select('MeasureID')->from('measure_variants');
    		})		
        	->get();
        	 $sub_id = $id;
        	 $sub = DB::table('sub_activities')->where('sub_activities.id', '=', $id)->first();
            return View::make('UAremoveEmpMeasure')
            ->with('measures', $measures)
            ->with('sub', $sub)
            ->with('name', $name)
            ->with('sub_id', $sub_id)
            ->with('id',$unit_admin_id); 
            }
        else
            {

                Session::flash('message', 'Please login first!');

                return Redirect::to('login/unitadmin');
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

    			return Redirect::to('uaremoveempact/'.$emp_id);

    		}


    		Session::flash('message', 'Please click the checkbox to delete activity');
    		return Redirect::to('uaremoveempact/'.$emp_id);
    }



      public function postDeleteSub()
    {
    	$main_id = Input::get('main_id');
    	
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

    			return Redirect::to('UAremoveEmpSub/'.$main_id);

    		}


    		Session::flash('message', 'Please click the checkbox to delete activity');
    		return Redirect::to('UAremoveEmpSub/'.$main_id);
    }



          public function postDeleteMeasure()
    {
    	$sub_id = Input::get('sub_id');
    	$measures = Input::get('measure_id');
    	
    		if ($measures != null)
    		{
    					foreach($measures as $measure)
    					{
    						DB::table('measures')->where('id', '=', $measure)->delete();
    					}

    			Session::flash('message', 'Measures Successfully Deleted');

    			return Redirect::to('UAremoveEmpMeasure/'.$sub_id);

    		}


    		Session::flash('message', 'Please click the checkbox to delete activity');
    		return Redirect::to('UAremoveEmpSub/'.$sub_id);
    }


}	

