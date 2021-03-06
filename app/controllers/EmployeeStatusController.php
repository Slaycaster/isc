<?php

class EmployeeStatusController extends BaseController 

{

	public function doLogin()
		{
	    	$rules = array(
			'username'   => 'required', 
			'password'=> 'required|alphaNum|min:4'

			);

		$validator = Validator::make(Input::all(), $rules);

		if($validator -> fails()){
			Session::flash('message', 'Sorry! Incorrect username/password. Please try again.');
			return Redirect::to('dashboard')
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
					return Redirect::to('employeestatusindex');
				}
				else
				{
					Session::flash('message', 'Sorry! Incorrect username/password. Please try again.');
					return Redirect::to('employeestatus');
				}
				
			}
	    	//return Redirect::to('employeestatusindex');
		}

	public function doLoginAgain()
	{
		$rules = array(
			'username'   => 'required', 
			'password'=> 'required|alphaNum|min:4'

			);

		$validator = Validator::make(Input::all(), $rules);

		if($validator -> fails()){
			Session::flash('message2', 'Sorry! Incorrect username/password. Please try again.');
			return Redirect::to('employeestatus')
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
					//return Redirect::to('employeestatusindex');
					if(Input::get('unsuspend'))
					{
						return $this->unsuspend();
					}
					elseif(Input::get('suspend'))
					{
						return $this->suspend();
					}
					elseif(Input::get('remove'))
					{
						return $this->delete();
					}
				}
				else
				{
					Session::flash('message2', 'Sorry! Incorrect username/password. Please try again.');
					return Redirect::to('employeestatusindex');
				}
				
			}
	}
	
	public function index()
	{
		$employees = DB::table('employs')
						->join('employs as supervisor', 'employs.SupervisorID', '=', 'supervisor.id')
						->join('unit_offices', 'employs.UnitOfficeID', '=', 'unit_offices.id')
						->join('positions', 'positions.id', '=', 'employs.PositionID')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->select('employs.id as id', 'employs.isActive as isActive', 'ranks.RankCode as RankCode', 'employs.EmpPicturePath as EmpPicturePath', 'employs.EmpLastName as EmpLastName', 'employs.EmpFirstName as EmpFirstName', 'ranks.RankName as RankName', 'positions.PositionName as PositionName', 'unit_offices.UnitOfficeName as UnitOffice', DB::raw('CONCAT(supervisor.EmpLastName, ", ",supervisor.EmpFirstName) as Supervisor'))
						->orderBy('ranks.Hierarchy')
						->get();

		$ranks = DB::table('ranks')->get();
		$positions= DB::table('positions')->get();
		$unit_offices = DB::table('unit_offices')->get();
		$unit_offices_secondaries = DB::table('unit_office_secondaries')->get();
		$unit_offices_tertiaries = DB::table('unit_office_tertiaries')->get();
		$unit_offices_quaternaries = DB::table('unit_office_quaternaries')->get();


		return View::make('employeestatus')
			->with('employees',$employees)
			->with('ranks',$ranks)
			->with('positions',$positions)
			->with('unit_offices',$unit_offices)
			->with('unit_offices_secondaries',$unit_offices_secondaries)
			->with('unit_offices_tertiaries',$unit_offices_tertiaries)
			->with('unit_offices_quaternaries',$unit_offices_quaternaries);
	}

	public function indexdatatable()
	{
		$employees = DB::table('employs')
						->join('employs as supervisor', 'employs.SupervisorID', '=', 'supervisor.id')
						->join('unit_offices', 'employs.UnitOfficeID', '=', 'unit_offices.id')
						->join('positions', 'positions.id', '=', 'employs.PositionID')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->select('employs.id as id', 'employs.isActive as isActive', 'ranks.RankCode as RankCode', 'employs.EmpPicturePath as EmpPicturePath', 'employs.EmpLastName as EmpLastName', 'employs.EmpFirstName as EmpFirstName', 'ranks.RankName as RankName', 'positions.PositionName as PositionName', 'unit_offices.UnitOfficeName as UnitOffice', DB::raw('CONCAT(supervisor.EmpLastName, ", ",supervisor.EmpFirstName) as Supervisor'))
						->orderBy('ranks.Hierarchy');

		return Datatables::of($employees)
			->add_column('Picture', '
	        				<img style = "height:60px; width:60px;" src="{{URL::asset($EmpPicturePath)}}">
	                    	')
			->add_column('Actions', '
	        				<a class = \'btn btn-info\' style = "margin-bottom:5px" href="{{ URL::to(\'employs/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'employs/\' . $id) }}\', \'newwindow\', \'width=380, height=620\'); return false;">View</a>
                                      <br>
                                      {{ Form::open(array(\'url\' => \'adminloginagain\', \'method\' => \'post\')) }}
                                                @if($isActive == \'1\')
                                                    <button type="button" class="btn btn-warning" style=\'font-size:15px;\' data-toggle="modal" data-target="#suspendemployee{{$id}}" >Suspend</button>
                                                
                                                @elseif($isActive == \'0\')
                                                     <button type="button" class="btn btn-success" stlye=\'font-size:15px;\' data-toggle="modal" data-target="#unsuspendemployee{{$id}}" >Unsuspend</button>
                                                @endif
                                          
                                          <!-- Modal Suspend-->
                                          <div id="suspendemployee{{$id}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">

                                              <!-- Modal content Suspend-->
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  <h4 class="modal-title">Are you sure?</h4>
                                                </div>
                                                <div class="modal-body">
                                                	<div class="col-md-12">
                                                   		<div class="col-md-4"> 
                                                  			<img style = "height:150px; width:150px;" src="{{URL::asset($EmpPicturePath)}}">
                                                  		</div>
                                                  		<div class="col-md-8">
                                                    		<p>{{ $RankCode }} {{$EmpLastName}}, {{$EmpFirstName}}</p>
                                                    		<p>{{ $PositionName }}</p>                                                     
                                                  		</div>
                                                	</div>
    
    	                                            <p>This will <strong>SUSPEND</strong> the personnel from accessing its account at PNP Individual Scorecard. This means the personnel will revoke access from his/her own PNP Individual Scorecard account. You can still track its past records even if the personnel is suspended. </p>
                                                  	<br>
                                                   	<p>Please confirm by entering credentials below:</p>
                                                    <div class="input-group">
                                                        <div class="alert alert-danger" id="fdk" style="display:none">
                                                            <span id="error"></span>
                                                        </div>
                                                    </div>
                                                
                                                  <div class="form-group">
                                                      <div class="input-group">

                                                           <span class="input-group-addon">

                                                              <i class="glyphicon glyphicon-user"></i>

                                                            </span> 

                                                            <strong>{{ Form::text(\'username\', Input::get(\'username\'), array(\'placeholder\' => \'Username\',\'autocomplete\' => \'off\', \'class\' => \'form-control\')) }}</strong>

                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                              <div class="input-group">

                                                            <span class="input-group-addon">

                                                              <i class="glyphicon glyphicon-lock"></i>

                                                            </span>

                                                            <strong>{{ Form::password(\'password\', array(\'placeholder\' => \'Password\', \'autocomplete\' => \'off\', \'class\' => \'form-control\')) }}</strong>

                                                        </div>
                                                      </div>
                                                 
                                                    
                                                  
                                                </div>

                                                <div class="modal-footer">
                                                    {{Form::hidden(\'empid\',$id)}}
                                                    {{Form::hidden(\'suspend\',\'Suspend\')}}
                                                   <input class = \'btn btn-danger\' type="submit" value="Suspend">
                                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                </div>
                                              </div>

                                            </div>
                                          </div>
                                       
                                           	{{Form::close()}}
                                            {{ Form::open(array(\'url\' => \'adminloginagain\', \'method\' => \'post\')) }}
                                        <div id="unsuspendemployee{{$id}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">

                                              <!-- Modal content Unsuspend-->
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  <h4 class="modal-title">Are you sure?</h4>
                                                </div>
                                                <div class="modal-body">

                                                  <div class="col-md-12">
                                                   <div class="col-md-4"> 

                                                  <img style = "height:150px; width:150px;" src="{{URL::asset($EmpPicturePath)}}">

                                                  </div>
                                                  <div class="col-md-8">
                                                    <p>{{ $RankCode }} {{ $EmpLastName }}, {{ $EmpFirstName }}</p>
                                                    <p>{{ $PositionName }}</p>
                                                  </div>
                                                </div>
                                                
                                                  <p>This will <strong>UNSUSPEND</strong> the personnel from accessing its account at PNP Individual Scorecard. This means the personnel will grant access again from his/her own PNP Individual Scorecard account. </p>
                                                  <br>
                                                   <p>Please confirm by entering credentials below:</p>
                                                      <div class="input-group">
                                                        <div class="alert alert-danger" id="fdk" style="display:none">
                                                            <span id="error"></span>
                                                        </div>
                                                      </div>
                                                
                                                  <div class="form-group">
                                                      <div class="input-group">

                                                           <span class="input-group-addon">

                                                              <i class="glyphicon glyphicon-user"></i>

                                                            </span> 

                                                             <strong>{{ Form::text(\'username\', Input::get(\'username\'), array(\'placeholder\' => \'Username\',\'autocomplete\' => \'off\', \'class\' => \'form-control\')) }}</strong>

                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                              <div class="input-group">

                                                            <span class="input-group-addon">

                                                              <i class="glyphicon glyphicon-lock"></i>

                                                            </span>

                                                            <strong>{{ Form::password(\'password\', array(\'placeholder\' => \'Password\', \'autocomplete\' => \'off\', \'class\' => \'form-control\')) }}</strong>

                                                        </div>
                                                      </div>
                                                 
                                                    
                                                  
                                                </div>

                                                <div class="modal-footer">
                                                     {{Form::hidden(\'empid\',$id)}}
                                                    {{Form::hidden(\'unsuspend\',\'Unsuspend\')}}
                                                   <input class = \'btn btn-success\' type="submit" value="Unsuspend">
                                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                </div>
                                              </div>

                                            </div>
                                          </div> 
                                           {{Form::close()}}
                                         {{--<a class = \'btn btn-danger\' style = "margin-bottom:5px" href="{{ URL::to(\'employee/unit/\' . $id) }}" onclick="window.open(\'{{ URL::to(\'employee/unit/\' . $id) }}\', \'newwindow\', \'width=500, height=500\'); return false;">Remove</a>--}}
                                         {{ Form::open(array(\'url\' => \'adminloginagain\', \'method\' => \'post\')) }}
                                           <button type="button" class="btn btn-danger"  style=\'font-size:15px;\' data-toggle="modal" data-target="#removeemployee{{$id}}">Remove</button>

                                          <!-- Modal Remove-->
                                          <div id="removeemployee{{$id}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">

                                              <!-- Modal content Remove-->
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  <h4 class="modal-title">Are you sure?</h4>
                                                </div>
                                                <div class="modal-body">
                                                	<div class="col-md-12">
                                                   		<div class="col-md-4"> 
                                                			<img style = "height:150px; width:150px;" src="{{URL::asset($EmpPicturePath)}}">
                                                  		</div>  
                                                  		<div class="col-md-8">
                                                    		<p>{{ $RankCode }} {{ $EmpLastName }}, {{ $EmpFirstName }}</p>
                                                    		<p>{{ $PositionName }}</p>
                                                  		</div>
                                                	</div>
                                                	<br>
                                                  	<p>This will <strong>PERMANENTLY DELETE</strong> all of its scorecard records, information and such. It means you cannot backtrack its past records anymore if you do this. If this personnel will not be active at a time being, please use the "Suspend" feature instead. <strong>THIS CANNOT BE UNDONE</strong>. </p>
                                                  	<br>
                                                   	<p>Please confirm by entering credentials below:</p>
                                                      	<div class="input-group">
                                                        	<div class="alert alert-danger" id="fdk" style="display:none">
                                                            	<span id="error"></span>
                                                        	</div>
                                                      	</div>
                                                  		<div class="form-group">
	                                                      	<div class="input-group">
	                                                           	<span class="input-group-addon">
	                                                              <i class="glyphicon glyphicon-user"></i>
	                                                            </span> 
	                                                             <strong>{{ Form::text(\'username\', Input::get(\'username\'), array(\'placeholder\' => \'Username\',\'autocomplete\' => \'off\', \'class\' => \'form-control\')) }}</strong>
	                                                      	</div>
                                                  		</div>
                                                  	<div class="form-group">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                              	<i class="glyphicon glyphicon-lock"></i>
                                                            </span>
                                                            <strong>{{ Form::password(\'password\', array(\'placeholder\' => \'Password\', \'autocomplete\' => \'off\', \'class\' => \'form-control\')) }}</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                 {{Form::hidden(\'empid\',$id)}}
                                                 {{Form::hidden(\'remove\',\'Remove\')}}
                                                  <input class = \'btn btn-danger\' type="submit" value="Remove">
                                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                </div>
                                              </div>
                                                  {{Form::close()}} 
                                            </div>
                                          </div>

	                    ')
	        ->remove_column('id')
	        ->remove_column('isActive')
	        ->remove_column('RankCode')
	        ->make(true);


	}

	public function delete()
	{
		$id = Input::get('empid');

		$empAccomplishments = DB::table('daily_accomplishments')
		->join('measure_variants', 'daily_accomplishments.MeasureVariantID', '=', 'measure_variants.id')
		->where('measure_variants.EmpID', '=', $id)
		->get();

		$otherAccomplishments = DB::table('otherdaily_accomplishment')
		->join('othermeasure_variants', 'otherdaily_accomplishment.OtherMeasureVariantID', '=', 'othermeasure_variants.id')
		->where('othermeasure_variants.EmpID', '=', $id)
		->get();

		foreach($empAccomplishments as $empAccomplishment)
		{
			DB::table('daily_accomplishments')
			->where('MeasureVariantID', '=', $empAccomplishment->MeasureVariantID)
			->delete();
		}

		foreach($otherAccomplishments as $otherAccomplishment)
		{
			DB::table('otherdaily_accomplishment')
			->where('OtherMeasureVariantID', '=', $otherAccomplishment->OtherMeasureVariantID)
			->delete();
		}

		DB::table('main_activities')->where('EmpID', '=', $id)->delete();
		DB::table('sub_activities')->where('EmpID', '=', $id)->delete();
		DB::table('measures')->where('EmpID', '=', $id)->delete();
		DB::table('activity_variants')->where('EmpID', '=', $id)->delete();
		DB::table('measure_variants')->where('EmpID', '=', $id)->delete();
		DB::table('other_variants')->where('EmpID', '=', $id)->delete();
		DB::table('other_activities')->where('EmpID', '=', $id)->delete();
		DB::table('other_measures')->where('EmpID', '=', $id)->delete();
		DB::table('othermeasure_variants')->where('EmpID', '=', $id)->delete();

		DB::table('employs')->where('employs.id', '=', $id)->delete();


		Session::flash('message', 'Personnel Deleted!');

		return Redirect::to('employeestatusindex');
	}

	public function suspend()
	{
		$id = Input::get('empid');


		DB::table('employs')
			->where('employs.id','=',$id)
			->update(array('isActive' => '0','SupervisorID' => $id));

		Session::flash('message', 'Personnel Suspended!');

		return Redirect::to('employeestatusindex');
	}

	public function unsuspend()
	{
		$id = Input::get('empid');

		DB::table('employs')
			->where('employs.id','=',$id)
			->update(array('isActive' => '1'));


		Session::flash('message', 'Personnel Unsuspended!');

		return Redirect::to('employeestatusindex');
	}

}
