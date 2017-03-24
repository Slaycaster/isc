<?php
    $Counter = 0;
    $logoPath = 'img/pnp_logo2.png';

    $title = '';
    if($Filter == 1)
    {
    	$position = DB::table('positions')->where('id', '=', $FilteredBy)->first();
    	$title = "Personnel with the Position of ".$position->PositionName;
    }
    elseif($Filter == 2)
    {
    	$rank = DB::table('ranks')->where('id', '=', $FilteredBy)->first();
    	$title = "Personnel with a Rank of ".$rank->RankName;
    }
    elseif($Filter == 3)
    {
    	if($FilteredBy == "Please Select on the Drop down List")
    	{
    		$title = $FilteredBy;
    	}
    	else
    	{
    		$title = "Personnel Under ".$FilteredBy;
    	}
    }
    else
    {
    	$title = "Please Select on the Drop down List";
    }
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
			{{ $title }}
		</normal>
	</p>
	<br>
	@if($employees != null)
	    <table border="1">
		    <thead style="font-family: helvetica; font-weight: bold;">
		    	@if($Filter == 3)
			    	<tr style="text-align: left;">
			    		<td width="1%"  height="20">#</td>
				    	<td width="10%">Rank</td>
				    	<td width="35%">Name</td>
				    	<td width="18%">Position</td>
				    	<td width="37%">Office <i style="font-weight: normal; font-size:12px;">(Primary, Secondary, Tertiary, Quaternary)</i></td>
				    </tr>
			    @else
			    	<tr style="text-align: left;">
			    		<td width="1%" height="20">#</td>
				    	<td width="10%">Rank</td>
				    	<td width="39%">Name</td>
				    	<td width="50%">Office <i style="font-weight: normal; font-size:12px;">(Primary, Secondary, Tertiary, Quaternary)</i></td>
				    </tr>
			    @endif	
		    </thead>
			<tbody>
			@foreach($employees as $employee)
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
					elseif($unit_office_secondaries == null && $unit_office_tertiaries == null && $unit_office_quaternaries == null)
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
					<td style="padding-left: 3px;">{{ $employee->RankCode }}</td>
					<td style="padding-left: 3px;">{{ $employee->EmpFirstName }} {{ $employee->EmpMidInit }} {{ $employee->EmpLastName }} {{ $employee->EmpQualifier }}</td>
					@if($Filter == 3)
						<td style="padding-left: 3px;">{{ $employee->PositionName }}</td>
					@endif
					<td style="padding-left: 3px;">{{ $UnitOfficesName }}</td>
				</tr>
			@endforeach
			</tbody>
	    </table>
	@else
		<p>No Personnel Found.</p>
	@endif
</body>