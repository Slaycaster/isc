<?php
	$supervisorID = Session::get('supervisorID', 'default');
    $StartDate = Session::get('mondayDateSelected', 'default');
    $EndDate = date("Y/m/d", strtotime($StartDate.'+'. '6' . 'days'));
    //dd($supervisorID);

	$NotSubmitted =	DB::table('employs')
						->join('ranks', 'ranks.id', '=', 'employs.RankID')
						->where('employs.SupervisorID', '=', $supervisorID)
						->whereNotIn('employs.id', function($q2)
							{
								$StartDate = Session::get('mondayDateSelected', 'default');

								$q2->select('empID')->from('target_approval')
									->where('target_approval.status', '=', 'submitted')
									->where('target_approval.date', '=', $StartDate);
							})
						->groupBy('employs.id')
						->orderBy('Hierarchy', 'asc')
						->get();

	$SupervisorInfo = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $supervisorID)
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
            $DateCovered = $StartDateCovered.$EndDateCovered;
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
		<normal style="font-size: 10px">isc.pulis.net</normal>
		<br><br>
		<normal style="font-size: 15px">
			<strong>List of personnel who didn't submit scorecard</strong>
			<br>{{ $DateCovered }}
		</normal>
	</p>
	<br>
		<p>Name of Supervisor: {{ $SupervisorInfo->RankCode }} {{ $SupervisorInfo->EmpFirstName }} {{ $SupervisorInfo->EmpMidInit }} {{ $SupervisorInfo->EmpLastName }} {{ $SupervisorInfo->EmpQualifier }}</p>
		<p>
		Unit/Office: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;__________________________<br>
		<hr size="5">
		</p>
		<br>
	@if($NotSubmitted != null)
	    <table border="1">
		    <thead style="font-family: helvetica; font-weight: bold;">
		    	<tr style="text-align: left;" height="15">
		    		<td width="1%">#</td>
			    	<td width="15%">Rank</td>
			    	<td width="39%">Name</td>
			    	<td width="45%">Office <i style="font-weight: normal; font-size:12px;">(Primary, Secondary, Tertiary, Quaternary)</i></td>
			    </tr>	
		    </thead>
			<tbody>
			@foreach($NotSubmitted as $employee)
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
					$Counter = $Counter + 1;
				?>
				<tr>
					<td style="text-align: left">{{ $Counter }}.</td>
					<td style="left;padding-left: 3px;">{{ $employee->RankCode }}</td>
					<td style="left;padding-left: 3px;">{{ $employee->EmpFirstName }} {{ $employee->EmpMidInit }} {{ $employee->EmpLastName }} {{ $employee->EmpQualifier }}</td>
					<td style="left;padding-left: 3px;">{{ $UnitOfficesName }}</td>
				</tr>
			@endforeach
			</tbody>
	    </table>
	@else
		<p>No Personnel Found for the Date and Unit Office Selected.</p>
	@endif
</body>