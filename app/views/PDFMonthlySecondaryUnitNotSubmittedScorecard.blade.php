<?php
	$UnitOfficeID = Session::get('unitOfficeSelected', 'default');
	$UnitOfficeSecondaryID = Session::get('UnitOfficeSecondaryID', 'default');
    $StartDate = Session::get('mondayDateSelected', 'default');

	$SelectedDate = date("d", strtotime($StartDate.'-'. '1' . 'days'));
	if(date("d", strtotime($StartDate)) == 1)
	{
		$MonthStartDate = date("Y/m/d", strtotime($StartDate));
	}
	else
	{
		$MonthStartDate = date("Y/m/d", strtotime($StartDate.'-'. $SelectedDate . 'days'));
	}
    $DateCovered = date("F Y", strtotime($MonthStartDate));
    

    if(date("d", strtotime($StartDate)) == 1)
    {
    	$MonthStartDate = date("Y/m/d", strtotime($StartDate));
    }
    else
    {
    	$MonthStartDate = date("Y/m/d", strtotime($StartDate.'-'. $SelectedDate . 'days'));
    }

    $FirstWeekofMonthDateFormatter = "";
	if(date("w",strtotime($MonthStartDate)) == 0)
	{
		$FirstWeekofMonthDateFormatter = 6;
	}
	else
	{
		$FirstWeekofMonthDateFormatter = date("w",strtotime($MonthStartDate.'-'. '1' .'days'));
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
    $CurrentWeekMonDate = date("Y/m/d", strtotime($CurrentDate.'-'. $CurrentDateFormat. 'days'));

	$weekDates = array();

	$FirstWeekofMonthDate = date("Y/m/d", strtotime($MonthStartDate.'-'. $FirstWeekofMonthDateFormatter .'days'));
	$SecondWeekofMonthDate = date("Y/m/d", strtotime($FirstWeekofMonthDate.'+'. '7' . 'days'));
	$ThirdWeekofMonthDate = date("Y/m/d", strtotime($SecondWeekofMonthDate.'+'. '7' . 'days'));
	$FourthWeekofMonthDate = date("Y/m/d", strtotime($ThirdWeekofMonthDate .'+'. '7' . 'days'));
	$FifthWeekofMonthDate = date("Y/m/d", strtotime($FourthWeekofMonthDate .'+'. '7' . 'days'));
	$SixthWeekofMonthDate = date("Y/m/d", strtotime($FifthWeekofMonthDate .'+'. '7' . 'days'));
	array_push($weekDates, $FirstWeekofMonthDate);
	if(strtotime($SecondWeekofMonthDate) < strtotime($CurrentWeekMonDate))
	{
		array_push($weekDates, $SecondWeekofMonthDate);
	}
	if(strtotime($ThirdWeekofMonthDate) < strtotime($CurrentWeekMonDate))
	{
		array_push($weekDates, $ThirdWeekofMonthDate);
	}
	if(strtotime($FourthWeekofMonthDate) < strtotime($CurrentWeekMonDate))
	{
		array_push($weekDates, $FourthWeekofMonthDate);
	}
	if(date("m", strtotime($FifthWeekofMonthDate )) == date("m", strtotime($StartDate)) && 
		strtotime($FifthWeekofMonthDate) < strtotime($CurrentWeekMonDate))
	{
		array_push($weekDates, $FifthWeekofMonthDate);
	}
	if(date("m", strtotime($SixthWeekofMonthDate)) == date("m", strtotime($StartDate)) &&
		strtotime($SixthWeekofMonthDate) < strtotime($CurrentWeekMonDate))
	{
		array_push($weekDates, $SixthWeekofMonthDate);
	}


    $employees = DB::table('employs')
					->join('positions', 'positions.id', '=', 'employs.PositionID')
					->join('ranks', 'ranks.id', '=', 'employs.RankID')
					->where('UnitOfficeID', '=', $UnitOfficeID)
					->where('UnitOfficeSecondaryID', '=', $UnitOfficeSecondaryID)
					->select('employs.id as id', 'employs.EmpLastName as EmpLastName', 'employs.EmpFirstName as EmpFirstName', 'employs.EmpQualifier as EmpQualifier', 'positions.PositionName as PositionName', 'ranks.RankCode as RankCode', 'employs.UnitOfficeID as UnitOfficeID', 'employs.UnitOfficeSecondaryID as UnitOfficeSecondaryID', 'employs.UnitOfficeTertiaryID as UnitOfficeTertiaryID', 'employs.UnitOfficeQuaternaryID as UnitOfficeQuaternaryID', 'employs.EmpMidInit as EmpMidInit')
					->orderBy('ranks.Hierarchy', 'asc')
					->get();

	$unit_office = DB::table('unit_offices')
						->where('id', '=', $UnitOfficeID)
						->first();
	$secondary_unit_office = DB::table('unit_office_secondaries')
								->where('id', '=', $UnitOfficeSecondaryID)
								->first();

    $Counter = 0;
    $logoPath = 'img/pnp_logo2.png';
?>
<!DOCTYPE html>
<head>
    <title>Reports | PNP Scorecard</title>
    <style type="text/css">
    table
    {
    	font-size: 10;
    	width: 100%;
    	border: 1px solid black;
    	border-collapse: collapse;
    	page-break-inside: auto;
    }
    tr
    { 
    	text-align: left;
    	page-break-inside: avoid;
    	page-break-after: auto; 
    }
    p, strong
    {
    	font-family: helvetica;
    }
    hr 
    { 
	    display: block;
	    margin-top: 0.2em;
	    margin-bottom: 0.5em;
	} 
    img 
    {
    	position: absolute;
    	left: 0px;
    	top: 15px;
	}
    </style>
</head>
<body>
	
	<img src="{{URL::asset($logoPath)}}" style="height: 135px;width: 105px;">
	<p style="text-align: center;">
		<normal style="font-size: 15px">Republic of the Philippines</normal>
		<br>
		<strong>NATIONAL POLICE COMMISSION<br>PHILIPPINE NATIONAL POLICE</strong>
		<br>
		<normal style="font-size: 15px">{{ $unit_office->UnitOfficeName }}<br>{{ $secondary_unit_office->UnitOfficeSecondaryName }}</normal>
		<br>
		<normal style="font-size: 10px">isc.pulis.net</normal>
		<br><br>
		<normal style="font-size: 15px">
			<strong>List of Personnel with Incomplete Submission of Scorecard</strong>
			<br>as of {{ $DateCovered }}
		</normal>
	</p>
	<br>
	<br>
	@if($employees != null)
	    <table border="1">
		    <thead style="font-family: helvetica; font-weight: bold;">
		    	<tr style="text-align: center;" height="15">
		    		<td width="1%">#</td>
			    	<td width="29%" height="15">Name</td>
			    	<td width="20%">Position</td>
			    	<td width="25%">Office <i style="font-weight: normal; font-size:12px;">(Primary, Secondary, Tertiary, Quaternary)</i></td>
			    	<td width="25%">Week Date</td>
			    </tr>	
		    </thead>
			<tbody>
			@foreach($employees as $employee)
				<?php
					$completeSubmission = 1;
					$weeksDidNotSubmit = array();
					foreach ($weekDates as $week) 
					{
						$submitted = DB::table('measure_variants')
		                				->where('EmpID', '=', $employee->id)
		                				->where('MeasureVariantDate','=', $week)   			
		                				->get();

						if(!$submitted)
						{
							$completeSubmission = 0;

							$weekCovered = null;
							$StartDateFormatter = date("m", strtotime($week));
						    $EndDateFormatter = date("m", strtotime($week . '+' . '6' . 'days'));
						    if($StartDateFormatter==$EndDateFormatter)
						    {
						    	$StartDateCovered = date("F d-", strtotime($week));
					        	$EndDateCovered = date("d, Y", strtotime($week . '+' . '6' . 'days'));
						    }
						    else
						    {
						    	$StartDateCovered = date("M d, Y - ", strtotime($week));
					        	$EndDateCovered = date("M d, Y", strtotime($week . '+' . '6' . 'days'));
						    }
						    $weekCovered = $StartDateCovered.$EndDateCovered;
						    array_push($weeksDidNotSubmit, $weekCovered);
						}
					}
					
				?>
{{-------------------------------------------------------------------------------------------------------------------------------}}

				<?php
					$UnitOfficesName = '';

					$unit_offices = DB::table('unit_offices')->where('id', '=', $employee->UnitOfficeID)->first();
					$unit_office_secondaries = DB::table('unit_office_secondaries')->where('id', '=', $employee->UnitOfficeSecondaryID)->first();
					$unit_office_tertiaries = DB::table('unit_office_tertiaries')->where('id', '=', $employee->UnitOfficeTertiaryID)->first();
					$unit_office_quaternaries = DB::table('unit_office_quaternaries')->where('id', '=', $employee->UnitOfficeQuaternaryID)->first();
					
					if($unit_office_secondaries != null && $unit_office_tertiaries != null && $unit_office_quaternaries != null)
					{
						$UnitOfficesName = $unit_offices->UnitOfficeName.', '.$unit_office_secondaries->UnitOfficeSecondaryName.', '.$unit_office_tertiaries->UnitOfficeTertiaryName.', '.$unit_office_quaternaries->UnitOfficeQuaternaryName;
					}
					elseif(($unit_office_secondaries != null && $unit_office_tertiaries != null) && $unit_office_quaternaries == null)
					{
						$UnitOfficesName = $unit_offices->UnitOfficeName.', '.$unit_office_secondaries->UnitOfficeSecondaryName.', '.$unit_office_tertiaries->UnitOfficeTertiaryName;
					}
					elseif($unit_office_secondaries != null && $unit_office_tertiaries == null && $unit_office_quaternaries == null)
					{
						$UnitOfficesName = $unit_offices->UnitOfficeName.', '.$unit_office_secondaries->UnitOfficeSecondaryName;
					}
					elseif($unit_offices != null && $unit_office_secondaries == null && $unit_office_tertiaries == null && $unit_office_quaternaries == null)
					{
						$UnitOfficesName = $unit_offices->UnitOfficeName;
					}
					else
					{
						$UnitOfficesName = "No Unit Office Assign";
					}

					//dd($unit_offices);
				?>
				@if($completeSubmission == 0)
					<?php
						$Counter = $Counter + 1;
					?>
					<tr>
						<td style="text-align: right">{{ $Counter }}.</td>
						<td style="left;padding-left: 3px;">{{ $employee->RankCode }} {{ $employee->EmpFirstName }} {{ $employee->EmpMidInit }} {{ $employee->EmpLastName }} {{ $employee->EmpQualifier }}</td>
						<td style="left;padding-left: 3px;">{{ $employee->PositionName }}</td>
						<td style="left;padding-left: 3px;">{{ $UnitOfficesName }}</td>
						<td>@foreach($weeksDidNotSubmit as $weeks){{ $weeks }}<br>@endforeach</td>
					</tr>
				@endif
			@endforeach
			</tbody>
	    </table>
	@else
		<p>No Personnel Found for the Date and Unit Office Selected.</p>
	@endif
</body>
</body>