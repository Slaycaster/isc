<?php

class SetMeasuresController extends BaseController 

{

	  public function showSetMeasure()

    {

    	if (Session::has('empid') && Session::has('empname')) {

            $id = Session::get('empid', 'default');

            $pic = Session::get('emppic', 'default');

            $name = Session::get('empname', 'default');

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
                                   $main_activities = DB::table('main_activities')->get();

                                    $measures = DB::table('measures')->where('id', '=',  '0')->get();

                                    //$main_id= DB::table('main_activities')->where('EmpID', '=', $id)->where('Main_ID', '=', 3)->get();
                                     $main_id = DB::table('main_activities')
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
                                    if($main_id != null)
                                    {
                                        foreach($main_id as $main){
                                            $sub_activities = ['Select Sub Activity...'] + DB::table('sub_activities')->where('MainActivityID', '=', $main->id )->lists('SubActivityName','id');
                                      
                                    }

                                    }
                                    else 
                                    {
                                                 $sub_activities = DB::table('sub_activities')->where('id', '=', 0)->get();
                                    }
            
                       
                             }
                            if($unitoffices->state == 'Enable')
                            {
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
                    AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
                    AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
                    AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
                  ->lists('MainActivityName','id');
                               
                            }
                    
                                }
                            }
                            break;
                        }               
                    }
                 }
            }
                      $main = 0;

          
            

            return View::make('set_measures')

            ->with('id', $id)

            ->with('pic', $pic)

            ->with('users',$users)

            ->with('name', $name)

            ->with('myrecord',$myrecord)

            ->with('unitoffice',$unitoffice)

            ->with('main_activities', $main_activities)

            ->with('main_id', $main_id)

            ->with('main', $main)

            ->with('sub_activities', $sub_activities)

            ->with('measures',$measures);

            

        }

        else

        {

            Session::flash('message', 'Please login first!');

                return Redirect::to('login/employee');

        }

    }


     public function postSetMeasure()

    {

        if (Session::has('empid') && Session::has('empname')) {

            $id = Session::get('empid', 'default');

            $pic = Session::get('emppic', 'default');

            $name = Session::get('empname', 'default');

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
                                   $main_activities = DB::table('main_activities')->get();

                                    $measures = DB::table('measures')->where('id', '=',  '0')->get();

                                    //$main_id= DB::table('main_activities')->where('EmpID', '=', $id)->where('Main_ID', '=', 3)->get();
                                     $main_id = DB::table('main_activities')
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
                                    if($main_id != null)
                                    {
                                        foreach($main_id as $main){
                                            $sub_activities = ['Select Sub Activity...'] + DB::table('sub_activities')->where('MainActivityID', '=', $main->id )->lists('SubActivityName','id');
                                            $main = 0;
                                      

                                    }

                                    }
                                    else 
                                    {
                                                    $main = 0;
                                                 $sub_activities = DB::table('sub_activities')->where('id', '=', 0)->get();
                                    }
            
                       
                             }
                            if($unitoffices->state == 'Enable')
                            {
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
                    AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
                    AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
                    AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
                  ->lists('MainActivityName','id');
                                $sub_activities = ['Select Sub Activity...'] + DB::table('sub_activities')->where('EmpID', '=', $id)->where('MainActivityID', '=', $main)->lists('SubActivityName','id');
                               
                            }
                    
                                }
                            }
                            break;
                        }               
                    }
                 }
            }
                  

          
            

            return View::make('set_measures')

            ->with('id', $id)

            ->with('pic', $pic)

            ->with('users',$users)

            ->with('name', $name)

            ->with('myrecord',$myrecord)

            ->with('unitoffice',$unitoffice)

            ->with('main_activities', $main_activities)

            ->with('main_id', $main_id)

            ->with('main', $main)

            ->with('sub_activities', $sub_activities)

            ->with('measures',$measures);

            

        }

        else

        {

            Session::flash('message', 'Please login first!');

                return Redirect::to('login/employee');

        }

    }

    public function ajaxEditMeasure()
    {

         if (Session::has('empid') && Session::has('empname')) {

            $id = $_REQUEST['empID'];

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

            $name = Session::get('empname', 'default');

            $main = $_REQUEST['mainID'];

            $main_activities = DB::table('main_activities')->get();

             //$main_id= DB::table('main_activities')->where('EmpID', '=', $id)->where('Main_ID', '=', 3)->get();
            $main_id =  DB::table('main_activities')
                                     ->join('employs','main_activities.EmpID','=','employs.id')
                                     
                                      ->where('employs.id','=',$id)
                                      ->where('main_activities.EmpID','=',$id)
                                      ->where('main_activities.Main_ID','=','3')
                                     ->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
                    AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
                    AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
                    AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
                  ->get();

            $sub_id = Input::get('sub_activities');

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
                                    if($main_id != null)
                                    {
                                        foreach($main_id as $main)
                                        {
                                            $sub_activities = DB::table('sub_activities')->where('MainActivityID', '=', $main->id )->get();
                                        }
                                    }
                                    else 
                                    {
                                        $sub_activities = DB::table('sub_activities')->where('id', '=', 0)->get();
                                    }
                                    
                                    $measures = DB::table('measures')->join('sub_activities', 'sub_activities.id', '=', 

                                        'measures.SubActivityID')->join('main_activities', 'main_activities.id', '=', 

                                        'sub_activities.MainActivityID')->where('SubActivityID', '=', $sub_id)->select('sub_activities.id as SubActivityID' ,'Main_ID', 'measures.id as MeasureID', 'MeasureName', 

                                            'SubActivityName', 'measures.TerminationDate as TermDate','measures.MeasureType as MeasureType')->get();
                        
                             }
                            if($unitoffices->state == 'Enable')
                            {
                                $main = $_REQUEST['mainID'];
                                $main_activities = DB::table('main_activities')->get();
                                //$main_id= ['Select Main Activity...'] + DB::table('main_activities')->where('EmpID', '=', $id)->orderBy('MainActivityName','asc')
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
                  ->lists('MainActivityName','id');
                                $sub_id = Input::get('sub_activities');
                        
                                $sub_activities = DB::table('sub_activities')->where('EmpID', '=', $id)->where('MainActivityID', '=', $main)->get();
                                
                                $measure1 = Input::get('measures');
                                $measures_id = Input::get('measures_id');
                                $state_ids = Input::get('state_id');
                               
                               $measures = DB::table('measures')->join('sub_activities', 'sub_activities.id', '=', 
                                    'measures.SubActivityID')->join('main_activities', 'main_activities.id', '=', 
                                    'sub_activities.MainActivityID')->where('SubActivityID', '=', $sub_id)->select('sub_activities.id as SubActivityID' , 'Main_ID', 'measures.id as MeasureID', 'MeasureName', 
                                        'SubActivityName', 'measures.TerminationDate as TermDate','measures.MeasureType as MeasureType')->get();
            
                               }
                    
                                }
                            }
                            break;
                        }               
                    }
                 }
            }
            return Response::json($sub_activities);
        }
        else
        {
            Session::flash('message', 'Please login first!');
                return Redirect::to('login/employee');
        }

    }



    public function postSetMeasure2()
    {

         if (Session::has('empid') && Session::has('empname')) {

            $id = Session::get('empid', 'default');

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

            $name = Session::get('empname', 'default');

            $main = Input::get('main_id');

            $main_activities = DB::table('main_activities')->get();

             //$main_id= DB::table('main_activities')->where('EmpID', '=', $id)->where('Main_ID', '=', 3)->get();
            $main_id =  DB::table('main_activities')
                                     ->join('employs','main_activities.EmpID','=','employs.id')
                                     
                                      ->where('employs.id','=',$id)
                                      ->where('main_activities.EmpID','=',$id)
                                      ->where('main_activities.Main_ID','=','3')
                                     ->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
                    AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
                    AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
                    AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
                  ->get();

            $sub_id = Input::get('sub_activities');

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
                                    if($main_id != null)
                                    {
                                        foreach($main_id as $main){
                                            $sub_activities = ['Select Sub Activity...'] + DB::table('sub_activities')->where('MainActivityID', '=', $main->id )->lists('SubActivityName','id');
                                    
                                      

                                    }

                                    }
                                    else 
                                    {
                                                 $sub_activities = DB::table('sub_activities')->where('id', '=', 0)->get();
                                    }
                                    
                                    $measures = DB::table('measures')->join('sub_activities', 'sub_activities.id', '=', 

                                        'measures.SubActivityID')->join('main_activities', 'main_activities.id', '=', 

                                        'sub_activities.MainActivityID')->where('SubActivityID', '=', $sub_id)->select('sub_activities.id as SubActivityID' ,'Main_ID', 'measures.id as MeasureID', 'MeasureName', 

                                            'SubActivityName', 'measures.TerminationDate as TermDate','measures.MeasureType as MeasureType')->get();
                        
                             }
                            if($unitoffices->state == 'Enable')
                            {
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
                    AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
                    AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
                    AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
                  ->lists('MainActivityName','id');
                                $sub_id = Input::get('sub_activities');
                       	
                                $sub_activities = ['Select Sub-Activity...']+ DB::table('sub_activities')->where('EmpID', '=', $id)->where('MainActivityID', '=', $main)->lists('SubActivityName','id');
                                
                                $measure1 = Input::get('measures');
                                $measures_id = Input::get('measures_id');
                                $state_ids = Input::get('state_id');
                               
                               $measures = DB::table('measures')->join('sub_activities', 'sub_activities.id', '=', 
                                    'measures.SubActivityID')->join('main_activities', 'main_activities.id', '=', 
                                    'sub_activities.MainActivityID')->where('SubActivityID', '=', $sub_id)->select('sub_activities.id as SubActivityID' , 'Main_ID', 'measures.id as MeasureID', 'MeasureName', 
                                        'SubActivityName', 'measures.TerminationDate as TermDate','measures.MeasureType as MeasureType')->get();
            
                               }
                    
                                }
                            }
                            break;
                        }               
                    }
                 }
            }
                                  

         
           


            return View::make('set_measures')

            ->with('id', $id)

            ->with('pic', $pic)

            ->with('name', $name)

            ->with('users',$users)

            ->with('unitoffice',$unitoffice)

            ->with('myrecord',$myrecord)

            ->with('main_activities', $main_activities)

            ->with('main_id', $main_id)

            ->with('main', $main)

            ->with('sub_activities', $sub_activities)

            ->with('measures',$measures);

            

        }

        else

        {

            Session::flash('message', 'Please login first!');

                return Redirect::to('login/employee');

        }

    }





     public function postEditMeasure()

    {

        if (Session::has('empid') && Session::has('empname')) {

            $id = Session::get('empid', 'default');

            $pic = Session::get('emppic', 'default');

            $name = Session::get('empname', 'default');

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
                                 
                                
                                $main = Input::get('main_id');

                                $main_activities = DB::table('main_activities')->get();

                                 //$main_id= DB::table('main_activities')->where('EmpID', '=', $id)->where('Main_ID', '=', 3)->get();
                                  $main_id =  DB::table('main_activities')
                                     ->join('employs','main_activities.EmpID','=','employs.id')
                                      ->where('employs.id','=',$id)
                                      ->where('main_activities.EmpID','=',$id)
                                      ->where('main_activities.Main_ID','=','3')
                                     ->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
                    AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
                    AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
                    AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
                  ->get();

                                $sub_id = Input::get('sub_activities');

                                
                                if($main_id != null)
                                {
                                    foreach($main_id as $main){
                                        $sub_activities = ['Select Sub Activity...'] + DB::table('sub_activities')->where('MainActivityID', '=', $main->id )->lists('SubActivityName','id');
                                
                                  

                                }

                                }
                                else 
                                {
                                             $sub_activities = DB::table('sub_activities')->where('id', '=', 0)->get();
                                }
                             }
                            if($unitoffices->state == 'Enable')
                            {
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
                    AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
                    AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
                    AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
                  ->lists('MainActivityName','id');
                                $sub_id = Input::get('sub_activities');
                                $sub_activities = ['Select Sub Activity...'] + DB::table('sub_activities')->where('EmpID', '=', $id)->where('MainActivityID', '=', $main)->lists('SubActivityName','id');
                                
                                $measure1 = Input::get('measures');
                                $measures_id = Input::get('measures_id');
                                $state_ids = Input::get('state_id');
                               
                               $measures = DB::table('measures')->join('sub_activities', 'sub_activities.id', '=', 
                                    'measures.SubActivityID')->join('main_activities', 'main_activities.id', '=', 
                                    'sub_activities.MainActivityID')->where('SubActivityID', '=', $sub_id)->select('sub_activities.id as SubActivityID' , 'Main_ID', 'measures.id as MeasureID', 'MeasureName', 
                                        'SubActivityName', 'measures.TerminationDate as TermDate','measures.MeasureType as MeasureType')->get();
            
                             }
                    
                                }
                            }
                            break;
                        }               
                    }
                 }
            }
                      

            

            $measure1 = Input::get('measures');

            $measures_id = Input::get('measures_id');

            $state_ids = Input::get('state_id');

            $measuretype = Input::get('measure_types');



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

            if ($measure1 != null)

            {

                foreach($measure1 as $measure)

                {



                        DB::statement('UPDATE measures SET MeasureName=:sur, MeasureType=:sur2 WHERE EmpID=:res AND id=:res2' ,

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

                         array('sur' => NULL, 'res' => $id, 'res2' =>$state_id) );

                }    

                 $x++;

                }



            }



           $measures = DB::table('measures')->join('sub_activities', 'sub_activities.id', '=', 

                'measures.SubActivityID')->join('main_activities', 'main_activities.id', '=', 

                'sub_activities.MainActivityID')->where('SubActivityID', '=', $sub_id)->select('sub_activities.id as SubActivityID' , 'Main_ID', 'measures.id as MeasureID', 'MeasureName', 

                    'SubActivityName', 'measures.TerminationDate as TermDate','measures.MeasureType as MeasureType')->get();





           

           Session::flash('message', 'Changes Saved!');

            return View::make('set_measures')

            ->with('id', $id)

            ->with('pic', $pic)

            ->with('users',$users)

            ->with('myrecord',$myrecord)

            ->with('unitoffice',$unitoffice)

            ->with('name', $name)

            ->with('main_activities', $main_activities)

            ->with('main_id', $main_id)

            ->with('main', $main)

            ->with('sub_activities', $sub_activities)

            ->with('measures',$measures);

            

        }

        else

        {

            Session::flash('message', 'Please login first!');

                return Redirect::to('login/employee');

        }

    }





}