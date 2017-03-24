<?php

class SetActivitiesController extends BaseController 

{

	  public function showSetActivity()

    {
         if (Session::has('empid') && Session::has('empname')) {

                    $id = Session::get('empid', 'default');

                    $name = Session::get('empname', 'default');

                    $pic = Session::get('emppic', 'default');

                    $main = Input::get('main_id');

                    $main_activities = DB::table('main_activities')->get();

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
                                  //$main_id= DB::table('main_activities')->where('EmpID', '=', $id)->where('Main_ID', '=', 3)->lists('MainActivityName','id');
                                  //$mains= DB::table('main_activities')->where('EmpID', '=', $id)->where('Main_ID', '=', 3)->get();
                                  $main_id = ['Select Main Activity...'] + DB::table('main_activities')
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

                  $mains= DB::table('main_activities')
                  ->join('employs','main_activities.EmpID','=','employs.id')
                  ->where('employs.id','=',$id)
                  ->where('main_activities.EmpID','=',$id)
                  ->where('main_activities.Main_ID','=','3')
                  ->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
                    AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
                    AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
                    AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
                  ->get();

                                               
                                  if($mains != null)
                                  {
                                    foreach($mains as $main)
                                    {
                                    $sub_activities = DB::table('sub_activities')->join('main_activities', 'main_activities.id', '=', 

                                       'sub_activities.MainActivityID')->where('sub_activities.MainActivityID', '=', $main->id)->where('Main_ID', '=', 3)->select('main_activities.id as MainActivityID' ,'Main_ID', 'sub_activities.id as SubActivityID', 'MainActivityName', 

                                            'SubActivityName', 'TerminationDate')->get();
                                  
                                    }
                                }
                                else {

                                         $sub_activities = DB::table('sub_activities')->where('id', '=', 0)->get();
                                 
                                     }
                       
                             }
                            if($unitoffices->state == 'Enable')
                            {
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
                       }
                    
                                }
                            }
                            break;
                        }               
                    }
                 }
            }
                      $main = 0;


            return View::make('set_activities')
                    ->with('id', $id)

                    ->with('name', $name)

                    ->with('pic', $pic)

                    ->with('unitoffice',$unitoffice)

                    ->with('myrecord',$myrecord)

                    ->with('main_activities', $main_activities)

                    ->with('main_id', $main_id)

                    ->with('users',$users)

                    ->with('sub_activities', $sub_activities);

                    

                }

                else

                {

                    Session::flash('message', 'Please login first!');

                        return Redirect::to('login/employee');

                }

            }



 public function postSetActivity()

    {
         if (Session::has('empid') && Session::has('empname')) {

                    $id = Session::get('empid', 'default');

                    $name = Session::get('empname', 'default');

                    $pic = Session::get('emppic', 'default');

                    $main = Input::get('main_id');

                    $main_activities = DB::table('main_activities')->get();

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
                                  //$main_id= DB::table('main_activities')->where('EmpID', '=', $id)->where('Main_ID', '=', 3)->lists('MainActivityName','id');
                                  //$mains= DB::table('main_activities')->where('EmpID', '=', $id)->where('Main_ID', '=', 3)->get();
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

                  $mains= DB::table('main_activities')
                  ->join('employs','main_activities.EmpID','=','employs.id')
                  ->where('employs.id','=',$id)
                  ->where('main_activities.EmpID','=',$id)
                  ->where('main_activities.Main_ID','=','3')
                  ->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
                    AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
                    AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
                    AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
                  ->get();
                                               
                                  if($mains != null)
                                  {
                                    foreach($mains as $main)
                                    {
                                    $sub_activities = DB::table('sub_activities')->join('main_activities', 'main_activities.id', '=', 

                                       'sub_activities.MainActivityID')->where('sub_activities.MainActivityID', '=', $main->id)->where('Main_ID', '=', 3)->select('main_activities.id as MainActivityID' ,'Main_ID', 'sub_activities.id as SubActivityID', 'MainActivityName', 

                                            'SubActivityName', 'TerminationDate')->get();
                                  
                                    }
                                }
                                else {

                                         $sub_activities = DB::table('sub_activities')->where('id', '=', 0)->get();
                                 
                                     }
                       
                             }
                            if($unitoffices->state == 'Enable')
                            {     $main = Input::get('main_id');
                                    $main_activities = DB::table('main_activities')->get();
                                    $main = Input::get('main_id');
                                    //$main_id= ['Select Main Activity...'] + DB::table('main_activities')->orderBy('MainActivityName','asc')->where('EmpID', '=', $id)
                                    //->lists('MainActivityName','id');
                                      $main_id = DB::table('main_activities')
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
                            }
                    
                                }
                            }
                            break;
                        }               
                    }
                 }
            }
                  
                 

            return View::make('set_activities')
                    ->with('id', $id)

                    ->with('name', $name)

                    ->with('pic', $pic)

                    ->with('unitoffice',$unitoffice)

                    ->with('myrecord',$myrecord)

                    ->with('main_activities', $main_activities)

                    ->with('main_id', $main_id)
                     ->with('main', $main)

                    ->with('users',$users)

                    ->with('sub_activities', $sub_activities);

                    

                }

                else

                {

                    Session::flash('message', 'Please login first!');

                        return Redirect::to('login/employee');

                }

            }



     public function postEdit()

    {

        if (Session::has('empid') && Session::has('empname')) {

            $id = Session::get('empid', 'default');

            $name = Session::get('empname', 'default');

            $pic = Session::get('emppic', 'default');

            $users = DB::table('users')->get();

            $main = Input::get('main');

            $myrecord = DB::table('employs')
            ->where('id','=',$id)
            ->get();

            

            foreach($myrecord as $myrecords)
            {
                    $unitoffice = DB::table('unit_admins')
                    ->where('UnitOfficeID','=',$myrecords->UnitOfficeID)
                    ->get();
            }




            $main_activities = DB::table('main_activities')->get();


        

            $subs = Input::get('sub_activity');

            

            $sub_id = Input::get('subactivity');

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
                                 // $main_id= DB::table('main_activities')->where('EmpID', '=', $id)->where('Main_ID', '=', 3)->lists('MainActivityName','id');
                                  //$mains= DB::table('main_activities')->where('EmpID', '=', $id)->where('Main_ID', '=', 3)->get();
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

                  $mains= DB::table('main_activities')
                  ->join('employs','main_activities.EmpID','=','employs.id')
                  ->where('employs.id','=',$id)
                  ->where('main_activities.EmpID','=',$id)
                  ->where('main_activities.Main_ID','=','3')
                  ->whereRaw("main_activities.UnitOfficeID = employs.UnitOfficeID 
                    AND main_activities.UnitOfficeSecondaryID = employs.UnitOfficeSecondaryID
                    AND main_activities.UnitOfficeTertiaryID = employs.UnitOfficeTertiaryID
                    AND main_activities.UnitOfficeQuaternaryID = employs.UnitOfficeQuaternaryID")
                  ->get();
                                               
                                  if($mains != null)
                                  {
                                    foreach($mains as $main)
                                    {
                                    $sub_activities = DB::table('sub_activities')->join('main_activities', 'main_activities.id', '=', 

                                       'sub_activities.MainActivityID')->where('sub_activities.MainActivityID', '=', $main->id)->where('Main_ID', '=', 3)->select('main_activities.id as MainActivityID' ,'Main_ID', 'sub_activities.id as SubActivityID', 'MainActivityName', 

                                            'SubActivityName', 'TerminationDate')->get();
                                  
                                    }
                                }
                                else {

                                         $sub_activities = DB::table('sub_activities')->where('id', '=', 0)->get();
                                 
                                     }
                       
                             }
                            if($unitoffices->state == 'Enable')
                            {     $main = Input::get('main_id');
                                    $main_activities = DB::table('main_activities')->get();
                                    $main = Input::get('main_id');
                                   // $main_id= ['Select Main Activity...'] + DB::table('main_activities')->orderBy('MainActivityName','asc')->where('EmpID', '=', $id)
                                    //->lists('MainActivityName','id');
                                      $main_id = DB::table('main_activities')
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
                            }
                    
                                }
                            }
                            break;
                        }               
                    }
                 }
            }
                  
                 
           

           Session::flash('message', 'Changes Saved!');

            return View::make('set_activities')

            ->with('id', $id)

            ->with('name', $name)

             ->with('main', $main)

            ->with('pic', $pic)

            ->with('users',$users)

            ->with('unitoffice',$unitoffice)

            ->with('myrecord',$myrecord)

            ->with('main_activities', $main_activities)

            ->with('main_id', $main_id)


            ->with('sub_activities', $sub_activities);

            

        }

        else

        {

            Session::flash('message', 'Please login first!');

                return Redirect::to('login/employee');

        }

    }





}