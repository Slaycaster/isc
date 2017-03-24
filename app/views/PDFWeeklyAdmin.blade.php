<?php
            $StartDate = Session::get('StartDate', 'default');	        
	        $EndDate = date("Y/m/d", strtotime($StartDate.'+'. '6' . 'days'));

	        $StartDateCovered = "";
	        $EndDateCovered = "";

	        $MonDate = date("d", strtotime($StartDate));
	        $TueDate = date("d", strtotime($StartDate.'+'. '1' . 'days'));
	        $WedDate = date("d", strtotime($StartDate.'+'. '2' . 'days'));
	        $ThuDate = date("d", strtotime($StartDate.'+'. '3' . 'days'));
	        $FriDate = date("d", strtotime($StartDate.'+'. '4' . 'days'));
	        $SatDate = date("d", strtotime($StartDate.'+'. '5' . 'days'));
	        $SunDate = date("d", strtotime($StartDate.'+'. '6' . 'days')); 

			$id = Session::get('emp_id', 'default');

			$emp_activities = DB::table('main_activities')
                ->join('employs', 'employs.id', '=', 'main_activities.EmpID')
                ->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')
                ->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')
                ->join('measure_variants', 'measures.id', '=', 'measure_variants.MeasureID')
                ->join('daily_accomplishments', 'measure_variants.id', '=', 'daily_accomplishments.MeasureVariantID')
                ->where('main_activities.EmpID', '=', $id)
                ->whereBetween('daily_accomplishments.Date', array($StartDate, $EndDate))
                ->where('sub_activities.EmpID', '=', $id)
                ->where('measure_variants.MeasureVariantDate', '=', $StartDate)
                ->select('main_activities.id as MainActivityID','MainActivityName')
                ->groupBy('main_activities.id')
                ->orderBy('main_activities.id','asc')
                ->get();


            $other_activities  = DB::table('other_activities')
	                ->join('employs', 'employs.id', '=', 'other_activities.EmpID')
	                ->join('other_measures', 'other_activities.id', '=', 'other_measures.OtherActivitiesID')
	                ->join('othermeasure_variants', 'other_measures.id', '=', 'othermeasure_variants.OtherMeasureID')
	                ->join('otherdaily_accomplishment', 'othermeasure_variants.id', '=', 'otherdaily_accomplishment.OtherMeasureVariantID')
	                ->where('other_activities.EmpID', '=', $id)
	                ->whereBetween('otherdaily_accomplishment.Date', array($StartDate, $EndDate))
	                ->orderBy('other_activities.id', 'asc')
	                ->get();
           

            if($emp_activities != null)
            {
	            $Employees = DB::table('employs')
	            	->join('employee_info', 'employee_info.Empid', '=', 'employs.id')
			        ->join('positions', 'positions.id', '=', 'employee_info.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employee_info.RankID')
			        ->where('employs.id', '=', $id)
			        ->where('employee_info.StartDate', '=', $StartDate)
			        ->first();
			}
			else
			{
	            $Employees = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $id)
			        ->first();
			}

			$PersonnelSupervisor = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $Employees->SupervisorID)
			        ->first();

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

		    $DateValidate = Session::get('DateValidate', 'default');          
            $DateCovered = null;
            if($DateValidate == null)
            {
                $DateCovered = 'No Date Selected, Please Select a Date';
            }
            else
            {
                $DateCovered = $StartDateCovered.$EndDateCovered;
            }

			
			$UnitOfficesName = '';
			$unit_offices = DB::table('unit_offices')->where('id', '=', $Employees->UnitOfficeID)->first();
			$unit_office_secondaries = DB::table('unit_office_secondaries')->where('id', '=', $Employees->UnitOfficeSecondaryID)->first();
			$unit_office_tertiaries = DB::table('unit_office_tertiaries')->where('id', '=', $Employees->UnitOfficeTertiaryID)->first();
			$unit_office_quaternaries = DB::table('unit_office_quaternaries')->where('id', '=', $Employees->UnitOfficeQuaternaryID)->first();
					
			if($unit_office_secondaries != null && $unit_office_tertiaries != null && $unit_office_quaternaries != null)
			{
				$UnitOfficesName = $unit_office_quaternaries->UnitOfficeQuaternaryName.', '.$unit_office_tertiaries->UnitOfficeTertiaryName.', '.$unit_office_secondaries->UnitOfficeSecondaryName.', '.$unit_offices->UnitOfficeName;
			}
			elseif(($unit_office_secondaries != null && $unit_office_tertiaries != null) && $unit_office_quaternaries == null)
			{
				$UnitOfficesName = $unit_office_tertiaries->UnitOfficeTertiaryName.', '.$unit_office_secondaries->UnitOfficeSecondaryName.', '.$unit_offices->UnitOfficeName;
			}
			elseif($unit_office_secondaries != null && $unit_office_tertiaries == null && $unit_office_quaternaries == null)
			{
				$UnitOfficesName = $unit_office_secondaries->UnitOfficeSecondaryName.', '.$unit_offices->UnitOfficeName;
			}
			elseif($unit_office_secondaries == null && $unit_office_tertiaries == null && $unit_office_quaternaries == null)
			{
				$UnitOfficesName = $unit_offices->UnitOfficeName;
			}
			else
			{
				$UnitOfficesName = "No Unit Office Assign";
			}
			//dd($UnitOfficesName);


            $tempSubId = 0;
            $tempMainActivity = '';
            $tempSubActivity = '';
            $tempMeasure = '';
            $tempOtherActivities = '';
            $mainActivityCounter = 0;
?>
<!DOCTYPE html>
<head>
    <title>Reports | PNP Scorecard</title>
    <style type="text/css">
    table
    {
    	font-size: 8;
    	text-align: center;
    	width: 100%;
    	border-collapse: collapse;
    	page-break-inside: auto;
    }
    tr
    { 
    	page-break-inside: avoid;
    	page-break-after: always; 
    }
    strong
    {
    	font-family: helvetica;
    }
    </style>
</head>
<body>
	
	<img src="{{URL::asset($Employees->EmpPicturePath)}}" style="height: 100px;width: 100px;">
	
	<p style="margin-top: -95px;margin-left: 120px;">
						Rank and Name : <strong>{{ $Employees->RankCode }} {{ $Employees->EmpFirstName }} {{ $Employees->EmpMidInit }} {{ $Employees->EmpLastName }} {{$Employees->EmpQualifier}}</strong>
						<br style="line-height: 100%;"/>
						Position : <strong>{{ $Employees->PositionName }}</strong>
						<br/>
						Unit Offices :
							@if($unit_office_tertiaries != null)
								<strong style="font-size: 10px">{{ $UnitOfficesName }}</strong>
							@else
								<strong style="font-size: 14px">{{ $UnitOfficesName }}</strong>
							@endif
						<br style="line-height: 250%;"/>
						Period Covered: <strong>{{$DateCovered}}</strong> 
	</p>
	<hr>
	@if($emp_activities != null)
    @foreach($emp_activities as $emp_mainActivity)
    <?php
    	$mainActivityCounter = $mainActivityCounter + 1;
    ?>
	<span style="font-size: 8;font-family: helvetica;font-weight: 600;text-align: left;">Main Activity {{$mainActivityCounter}}: {{$emp_mainActivity->MainActivityName}}</span>
	    <table border="1">
		    <thead style="font-family: helvetica">
		    	<tr>
		    		<td rowspan="3" width="86">OBJECTIVE</td>
			    	<td rowspan="3" width="95">Enabling Actions<br />(Sub-activity)</td>
			    	<td rowspan="3" >MEASURE</td>
			    	<td rowspan="3" width="37">TARGET</td>
			    	<td colspan="7" rowspan="1" height="12">ACCOMPLISHMENTS</td>
			    	<td rowspan="3" width="23">Total</td>
			    	<td rowspan="3" width="24">Cost</td>
			    	<td rowspan="3" width="42">Remarks</td>
			    </tr>
			    <tr style="font-size: 7">
			    	<td rowspan="1" width="15">{{ $MonDate }}</td>
			    	<td rowspan="1" width="15">{{ $TueDate }}</td>
			    	<td rowspan="1" width="15">{{ $WedDate }}</td>
			    	<td rowspan="1" width="15">{{ $ThuDate }}</td>
			    	<td rowspan="1" width="15">{{ $FriDate }}</td>
			    	<td rowspan="1" width="15">{{ $SatDate }}</td>
			    	<td rowspan="1" width="15">{{ $SunDate }}</td>		
			    </tr>
			    <tr style="font-size: 7">
			    	<td rowspan="1">Mon</td>
			    	<td rowspan="1">Tue</td>
			    	<td rowspan="1">Wed</td>
			    	<td rowspan="1">Thu</td>
			    	<td rowspan="1">Fri</td>
			    	<td rowspan="1">Sat</td>
			    	<td rowspan="1">Sun</td>		
			    </tr>	
		    </thead>

		    <?php
		    	$emp_subActivities = DB::table('sub_activities')
		    							->join('objectives', 'objectives.id', '=', 'sub_activities.ObjectiveID')
						                ->join('employs', 'employs.id', '=', 'sub_activities.EmpID')
						                ->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')
						                ->join('measure_variants', 'measures.id', '=', 'measure_variants.MeasureID')
						                ->join('daily_accomplishments', 'measure_variants.id', '=', 'daily_accomplishments.MeasureVariantID')
						                ->whereBetween('daily_accomplishments.Date', array($StartDate, $EndDate))
						                ->where('sub_activities.EmpID', '=', $id)
						                ->where('sub_activities.MainActivityID', '=', $emp_mainActivity->MainActivityID)
						                ->orderBy('objectives.id','asc')
						                ->orderBy('sub_activities.id', 'asc')
						                ->get();
				$tempObjective = '';
		    ?>

			<tbody>
			    @foreach($emp_subActivities as $emp_activity)
				    	@if($tempSubActivity != $emp_activity->SubActivityName)
				    		<?php
				    			$total = $emp_activity->MondayValue + $emp_activity->TuesdayValue + $emp_activity->WednesdayValue + $emp_activity->ThursdayValue + $emp_activity->FridayValue + $emp_activity->SaturdayValue + $emp_activity->SundayValue;
				    			$tempSubActivity = $emp_activity->SubActivityName;
				    		?>
						    <tr>
						    	@if($tempObjective != $emp_activity->ObjectiveName)
								    <?php
								    	$tempObjective = $emp_activity->ObjectiveName;
								    ?>
									<td style="font-size: 8;vertical-align: top;text-align: left;">{{ $emp_activity->ObjectiveName }}</td>
								@else
						    		<td></td>
								@endif
						    	<td style="vertical-align: top;text-align: left;">{{ $emp_activity->SubActivityName }}</td>
						    	<td style="text-align: left;">{{ $emp_activity->MeasureName }}</td>
						    	<td>{{ $emp_activity->Target }}</td>
						    	<td>{{ $emp_activity->MondayValue }}</td>
						    	<td>{{ $emp_activity->TuesdayValue }}</td>
						    	<td>{{ $emp_activity->WednesdayValue }}</td>
						    	<td>{{ $emp_activity->ThursdayValue }}</td>
						    	<td>{{ $emp_activity->FridayValue }}</td>
						    	<td>{{ $emp_activity->SaturdayValue }}</td>
						    	<td>{{ $emp_activity->SundayValue }}</td>
						    	<td>
			                        @if($emp_activity->MeasureType == 'Summation/Total')
			                            {{$emp_activity->MondayValue + $emp_activity->TuesdayValue + $emp_activity->WednesdayValue + $emp_activity->ThursdayValue + $emp_activity->FridayValue + $emp_activity->SaturdayValue + $emp_activity->SundayValue}}
			                        @elseif($emp_activity->MeasureType == 'Average')
			                                {{round( (($emp_activity->MondayValue + $emp_activity->TuesdayValue + $emp_activity->WednesdayValue + $emp_activity->ThursdayValue + $emp_activity->FridayValue + $emp_activity->SaturdayValue + $emp_activity->SundayValue) / 7), 2)}}
			                        @endif
			                    </td>
						    	<td>{{ $emp_activity->Cost }}</td>
						    	<td>{{ $emp_activity->Remarks }}</td>
						   	</tr>
						@else
							<?php
				    			$total = $emp_activity->MondayValue + $emp_activity->TuesdayValue + $emp_activity->WednesdayValue + $emp_activity->ThursdayValue + $emp_activity->FridayValue + $emp_activity->SaturdayValue + $emp_activity->SundayValue;
				    		?>
						    <tr>
						    	<td></td>
						    	<td></td>
						    	<td style="text-align: left;">{{ $emp_activity->MeasureName }}</td>
						    	<td>{{ $emp_activity->Target }}</td>
						    	<td>{{ $emp_activity->MondayValue }}</td>
						    	<td>{{ $emp_activity->TuesdayValue }}</td>
						    	<td>{{ $emp_activity->WednesdayValue }}</td>
						    	<td>{{ $emp_activity->ThursdayValue }}</td>
						    	<td>{{ $emp_activity->FridayValue }}</td>
						    	<td>{{ $emp_activity->SaturdayValue }}</td>
						    	<td>{{ $emp_activity->SundayValue }}</td>
						    	<td>
			                        @if($emp_activity->MeasureType == 'Summation/Total')
			                            {{$emp_activity->MondayValue + $emp_activity->TuesdayValue + $emp_activity->WednesdayValue + $emp_activity->ThursdayValue + $emp_activity->FridayValue + $emp_activity->SaturdayValue + $emp_activity->SundayValue}}
			                        @elseif($emp_activity->MeasureType == 'Average')
			                                {{round( (($emp_activity->MondayValue + $emp_activity->TuesdayValue + $emp_activity->WednesdayValue + $emp_activity->ThursdayValue + $emp_activity->FridayValue + $emp_activity->SaturdayValue + $emp_activity->SundayValue) / 7), 2)}}
			                        @endif
			                    </td>
						    	<td>{{ $emp_activity->Cost }}</td>
						    	<td>{{ $emp_activity->Remarks }}</td>
						    </tr>
				    	@endif
	    			@endforeach	
			    </tbody>
	    </table>
    @endforeach	
    @else
    	<?php
    		$targetvalue = DB::table('target_approval')
								->join('employs', 'target_approval.EmpID', '=', 'employs.id')
								->where('employs.id', '=', $id)
								->where('date', '=', $StartDate)
								->select('target_approval.status as Status')
								->first();
    	?>
    	@if($targetvalue == null)

    		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No activities yet for this period.</p>

    	@else

	    	@if($targetvalue->Status == 'approved')
		    	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Targets were approved by the supervisor but  he/she failed to submit accomplishments.</p>
	    	@endif

	    	@if($targetvalue->Status == 'pending')
		    	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Targets had been pending for approval but the supervisor hasn't approved/rejected the pending target values.</p>
	    	@endif

	    	@if($targetvalue->Status == 'rejected')
		    	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Targets had been rejected by the supervisor and he/she failed to resubmit his/her target values for approval.</p>
	    	@endif

    	@endif

    @endif

    <br>

    @if($other_activities != null)
	<span style="font-size: 8;font-family: helvetica;font-weight: 600;text-align: left;">Other Activities (Other duties as directed)</span>
	    <table border="1">
		    <thead style="font-family: helvetica">
		    	<tr>
			    	<td rowspan="3" width="115">Enabling Actions<br />(Sub-activity)</td>
			    	<td rowspan="3" width="87">MEASURE</td>
			    	<td rowspan="3" width="37">TARGET</td>
			    	<td colspan="7" rowspan="1" height="15">ACCOMPLISHMENTS</td>
			    	<td rowspan="3" width="23">Total</td>
			    	<td rowspan="3" width="24">Cost</td>
			    	<td rowspan="3" width="42">Remarks</td>
			    </tr>
			    <tr style="font-size: 7">
			    	<td rowspan="1" width="23">{{ $MonDate }}</td>
			    	<td rowspan="1" width="23">{{ $TueDate }}</td>
			    	<td rowspan="1" width="23">{{ $WedDate }}</td>
			    	<td rowspan="1" width="23">{{ $ThuDate }}</td>
			    	<td rowspan="1" width="23">{{ $FriDate }}</td>
			    	<td rowspan="1" width="23">{{ $SatDate }}</td>
			    	<td rowspan="1" width="23">{{ $SunDate }}</td>		
			    </tr>
			    <tr style="font-size: 7">
			    	<td rowspan="1">Mon</td>
			    	<td rowspan="1">Tue</td>
			    	<td rowspan="1">Wed</td>
			    	<td rowspan="1">Thu</td>
			    	<td rowspan="1">Fri</td>
			    	<td rowspan="1">Sat</td>
			    	<td rowspan="1">Sun</td>		
			    </tr>	
		    </thead>
			<tbody>
			    @foreach($other_activities as $other_activity)
				    	@if($tempOtherActivities != $other_activity->OtherActivitiesName)
				    		<?php
				    			$total = $other_activity->MondayValue + $other_activity->TuesdayValue + $other_activity->WednesdayValue + $other_activity->ThursdayValue + $other_activity->FridayValue + $other_activity->SaturdayValue + $other_activity->SundayValue;
				    			$tempOtherActivities = $other_activity->OtherActivitiesName;
				    		?>
						    <tr>
						    	<td style="vertical-align: top;text-align: left;">{{ $other_activity->OtherActivitiesName }}</td>
						    	<td style="text-align: left;">{{ $other_activity->OtherActivitiesMeasureName }}</td>
						    	<td>{{ $other_activity->Target }}</td>
						    	<td>{{ $other_activity->MondayValue }}</td>
						    	<td>{{ $other_activity->TuesdayValue }}</td>
						    	<td>{{ $other_activity->WednesdayValue }}</td>
						    	<td>{{ $other_activity->ThursdayValue }}</td>
						    	<td>{{ $other_activity->FridayValue }}</td>
						    	<td>{{ $other_activity->SaturdayValue }}</td>
						    	<td>{{ $other_activity->SundayValue }}</td>
						    	<td>{{$total}}</td>
						    	<td>{{ $other_activity->Cost }}</td>
						    	<td>{{ $other_activity->Remarks }}</td>
						   	</tr>
						@else
							<?php
				    			$total = $other_activity->MondayValue + $other_activity->TuesdayValue + $other_activity->WednesdayValue + $other_activity->ThursdayValue + $other_activity->FridayValue + $other_activity->SaturdayValue + $other_activity->SundayValue;
				    		?>
						    <tr>
						    	<td></td>
						    	<td style="text-align: left;">{{ $other_activity->OtherActivitiesMeasureName }}</td>
						    	<td>{{ $other_activity->Target }}</td>
						    	<td>{{ $other_activity->MondayValue }}</td>
						    	<td>{{ $other_activity->TuesdayValue }}</td>
						    	<td>{{ $other_activity->WednesdayValue }}</td>
						    	<td>{{ $other_activity->ThursdayValue }}</td>
						    	<td>{{ $other_activity->FridayValue }}</td>
						    	<td>{{ $other_activity->SaturdayValue }}</td>
						    	<td>{{ $other_activity->SundayValue }}</td>
						    	<td>{{$total}}</td>
						    	<td>{{ $other_activity->Cost }}</td>
						    	<td>{{ $other_activity->Remarks }}</td>
						    </tr>
				    	@endif
	    			@endforeach	
			    </tbody>
	    </table>
    @else
    	<p></p>
    @endif
    @if($emp_activities != null)
	    <table border="1" style="font-family: helvetica;page-break-inside: avoid;">
				<tr>
					<td width="16.2%" style="font-weight: bold;text-align: left;padding-left: 5px;">SUB-TOTAL</td>
					<td width="56%"></td>
					<td width="9.6%"></td>
					<td width="9.6%"></td>
					<td width="8.1%"></td>
				</tr>
				<tr>
					<td style="font-weight: bold;text-align: left;padding-left: 5px;">AMT. RECVD</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>

				</tr>
				<tr>
					<td style="font-weight: bold;text-align: left;padding-left: 5px;">GRND TOTAL</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="5">
						<table>
							<tr>
								<td colspan="2">
									<strong><p style="text-align: left">&nbsp;&nbsp;&nbsp;I hereby certify to the correctness and validity of all the entries which I personally made.</p></strong>
								</td>
							</tr>
							<tr>
								<td>
									<strong style="text-align: center;text-decoration: underline;">{{ $Employees->RankCode }} {{ $Employees->EmpFirstName }} {{ $Employees->EmpMidInit }} {{ $Employees->EmpLastName }} {{$Employees->EmpQualifier}}</strong>
									<br>
									<strong>(Signature over printed name of the personnel)</strong><br><br>
								</td>
								<td>
									Noted by: <strong style="text-align: center;text-decoration: underline;">{{ $PersonnelSupervisor->RankCode }} {{ $PersonnelSupervisor->EmpFirstName }} {{ $PersonnelSupervisor->EmpMidInit }} {{ $PersonnelSupervisor->EmpLastName }} {{$PersonnelSupervisor->EmpQualifier}}</strong>
									<br>
									<strong>(Supervising Officer)</strong><br><br>
								</td>
							</tr>
						</table>
					</td>
				</tr>	
		</table>
	@endif

</body>