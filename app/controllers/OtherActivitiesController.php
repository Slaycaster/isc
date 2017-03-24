<?php



class OtherActivitiesController extends BaseController
{
public function showOtherActivities()

	{

		if (Session::has('empid') && Session::has('empname')) {

			$id = Session::get('empid', 'default');

			$name = Session::get('empname', 'default');

			$pic = Session::get('emppic', 'default');

			$users = DB::table('users')->get();

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

			$other_activities = DB::table('other_activities')->where('EmpID', '=', $id)->get();

			$employsname = DB::table('employs')	
					->join('ranks', 'ranks.id', '=', 'employs.RankID')
					->where('employs.id', '=', $id)
					->get();

				return View::make('otheractivitiesemp')

					->with('id', $id)

					->with('name', $name)

					->with('pic', $pic)

					->with('users',$users)

					->with('employsname', $employsname)

					->with('other_activities', $other_activities)

					->with('myrecord',$myrecord)

					->with('unitoffice',$unitoffice);

		}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/employee');

		}



	}

	public function editOtherMeasures($sub_act)
	{

			if (Session::has('empid') && Session::has('empname')) {

			$id = Session::get('empid', 'default');

			$name = Session::get('empname', 'default');

			$pic = Session::get('emppic', 'default');

			$users = DB::table('users')->get();

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
		
			$other_activities = DB::table('other_measures')->where('OtherActivitiesID', '=', $sub_act)->get();
			$subs = DB::table('other_activities')->where('id', '=', $sub_act)->first();
			$employsname = DB::table('employs')	
					->join('ranks', 'ranks.id', '=', 'employs.RankID')
					->where('employs.id', '=', $id)
					->get();

				return View::make('othermeasure')

					->with('id', $id)

					->with('name', $name)

					->with('pic', $pic)

					->with('users',$users)

					->with('other_activities', $other_activities)

					->with('employsname', $employsname)
					
					->with('subs', $subs)

					->with('myrecord',$myrecord)

					->with('unitoffice',$unitoffice);

		}

		else

		{

			Session::flash('message', 'Please login first!');

				return Redirect::to('login/employee');

		}


	}

public function postAddOther()
	{
			$id = Session::get('empid', 'default');
			$sub_activity = Input::get('sub_activity');
			$unit = Session::get('unitoffice' , 'default');
			$secon = Session::get('secondaryoffice','default');
			$tertia = Session::get('tertiaryoffice','default');
			$quater = Session::get('quaternaryoffice','default');


				if($sub_activity == null)

					{

						return Redirect::to('employee/otheractivities');

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

			return Redirect::to('employee/otheractivities');


	}



	public function postAddMeasures()
	{
			$id = Session::get('empid', 'default');
			$other_id = Input::get('sub_id');
			$measure = Input::get('measure');

				if($measure == null)

					{

						return Redirect::to('editOtherMeasures/'.$other_id);

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

			return Redirect::to('editOtherMeasures/'.$other_id);


	}


	




	public function postEditOther()
	{

		$id = Session::get('empid', 'default');
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

			return Redirect::to('employee/otheractivities');




	}



	public function postEditMeasure()
	{

		$id = Session::get('empid', 'default');
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

			return Redirect::to('editOtherMeasures/'.$other_id);




	}




	public function postSaveOther()
	{

		$id = Session::get('empid', 'default');
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
		return Redirect::to('employee/otheractivities');
}


		Session::flash('mes', 'Sub-activity successfully removed to scorecard!');
		return Redirect::to('employee/otheractivities');




	}




		public function postSaveMeasure()
	{

		$id = Session::get('empid', 'default');
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
		return Redirect::to('editOtherMeasures/'.$other_id);
}


		Session::flash('mes', 'Measures successfully removed to sub-activity!');
		return Redirect::to('editOtherMeasures/'.$other_id);




	}

/* THIS IS FOR UNIT ADMIN OTHER ACTIVITIES* -kwell*/
	
	public function showUAEOtherActivities($id)

	{
		if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');
				$empid = Session::put('UA_empID', $id);

			$other_activities = DB::table('other_activities')
					->where('other_activities.EmpID', '=', $id)
					->get();

			$employsname = DB::table('employs')	
					->join('ranks', 'ranks.id', '=', 'employs.RankID')
					->where('employs.id', '=', $id)
					->get();

				return View::make('UAEotheractivities')

					->with('other_activities', $other_activities)

					->with('name', $name)

					->with('employsname', $employsname)

					->with('id',$unit_admin_id);
			}
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}


	}

	public function editUAEOtherMeasures($sub_act)
	{
			if (Session::has('unitadminid') && Session::has('unitadminname')) 
			{
				$unit_admin_id = Session::get('unitadminid', 'default');
				$name = Session::get('unitadminname', 'default');
				$empid = Session::get('UA_empID', 'default');

				$employsname = DB::table('employs')	
					->join('ranks', 'ranks.id', '=', 'employs.RankID')
					->where('employs.id', '=', $empid)
					->get();

			$other_activities = DB::table('other_measures')->where('OtherActivitiesID', '=', $sub_act)->get();
			$subs = DB::table('other_activities')->where('id', '=', $sub_act)->first();



				return View::make('UAEothermeasure')

					->with('other_activities', $other_activities)
					
					->with('subs', $subs)

					->with('employsname', $employsname)

					->with('name', $name)
					
					->with('empid', $empid)

					->with('id',$unit_admin_id)
					;
			}
			else
			{

				Session::flash('message', 'Please login first!');

				return Redirect::to('login/unitadmin');
			}



	}

public function postAddUAEOther()
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

						return Redirect::to('UAEotheractivity/otheractivities');

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

			return Redirect::to('UAEotheractivity/otheractivities/'.$id);


	}



	public function postAddUAEMeasures()
	{
			$id = Input::get('empid');
			$other_id = Input::get('sub_id');
			$measure = Input::get('measure');
			
				if($measure == null)

					{

						return Redirect::to('UAEeditOtherMeasures/'.$other_id);

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

			return Redirect::to('UAEeditOtherMeasures/'.$other_id);


	}


	




	public function postEditUAEOther()
	{

		$id = Input::get('empid');
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

			return Redirect::to('UAEotheractivity/otheractivities/'.$id);




	}



	public function postEditUAEMeasure()
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

			return Redirect::to('UAEeditOtherMeasures/'.$other_id);




	}




	public function postSaveUAEOther()
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
		return Redirect::to('UAEotheractivity/otheractivities/'.$id);
}


		Session::flash('mes', 'Sub-activity successfully removed to scorecard!');
		return Redirect::to('UAEotheractivity/otheractivities/'.$id);




	}




		public function postSaveUAEMeasure()
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
		return Redirect::to('UAEeditOtherMeasures/'.$other_id);
}


		Session::flash('mes', 'Measures successfully removed to sub-activity!');
		return Redirect::to('UAEeditOtherMeasures/'.$other_id);




	}


}

	



?>
