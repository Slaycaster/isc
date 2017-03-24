<?php
    $StartDate = Session::get('StartDate', 'default');	        

	$SelectedDate = date("d", strtotime($StartDate.'-'. '1' . 'days'));

	$Month = date("m", strtotime($StartDate));
	$MonthName = date("F", strtotime($StartDate));
	$Year = date("Y", strtotime($StartDate));

	        
	$id = Session::get('emp_id', 'default'); 

    $Employees = DB::table('employs')
		        ->join('positions', 'positions.id', '=', 'employs.PositionID')
		        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
		        ->where('employs.id', '=', $id)
		        ->first();

	$PersonnelSupervisor = DB::table('employs')
			        ->join('positions', 'positions.id', '=', 'employs.PositionID')
			        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
			        ->where('employs.id', '=', $Employees->SupervisorID)
			        ->first();


    $NumofDays = 0;
    $EAwidth = 0;
	if($Month == 1 || $Month == 3 || $Month == 5 || $Month == 7 || $Month == 8 || $Month == 10 || $Month == 12)
	{
	   	$NumofDays = 31;
	   	$EAwidth = 110;
    }
	elseif ($Month == 4 || $Month == 6 || $Month == 9 || $Month == 11) 
	{
	 	$NumofDays = 30;
	 	$EAwidth = 117;
	}
	else
	{
	  	if($Month = 2 && $Year%4==0)
		{
	 		$NumofDays = 29;
	 		$EAwidth = 125;
		}
		else
		{
		    $NumofDays = 28;
		    $EAwidth = 132;
		}
	}
    $tempSubId = 0;
    $tempMainActivity = '';
    $tempSubActivity = '';
    $tempMeasure = '';
    $tempOtherActivities = '';
    $mainColSpan = 6 + $NumofDays;

		    
	$DateValidate = Session::get('DateValidate', 'default');          
    $DateCovered = null;
    if($DateValidate == null)
    {
        $DateCovered = 'No Date Selected, Please Select a Date';
    }
    else
    {
        if(date("d", strtotime($StartDate)) == 1)
	    {
	    	$DateCovered = date("F Y", strtotime($StartDate));
	    }
	    else
	    {
	    	$DateCovered = date("F Y", strtotime($StartDate.'-'. $SelectedDate . 'days'));
	    }
    }
    $mainActivityCounter = 0;   


    if(date("d", strtotime($StartDate)) == 1)
    {
    	$MonthStartDate = date("Y/m/d", strtotime($StartDate));
    }
    else
    {
    	$MonthStartDate = date("Y/m/d", strtotime($StartDate.'-'. $SelectedDate . 'days'));
    }
    $MonthEndDate = date("Y/m/d", strtotime($MonthStartDate.'+'. ($NumofDays - 1) . 'days'));

    //dd($SelectedDate);

    $FirstWeekofMonthDateFormatter = "";
	if(date("w",strtotime($MonthStartDate)) == 0)
	{
		$FirstWeekofMonthDateFormatter = 6;
	}
	else
	{
		$FirstWeekofMonthDateFormatter = date("w",strtotime($MonthStartDate.'-'. '1' .'days'));
	}

	$LastWeekofMonthDateFormatter = "";
	if(date("w",strtotime($MonthEndDate)) == 0)
	{
		$LastWeekofMonthDateFormatter = 6;
	}
	else
	{
		$LastWeekofMonthDateFormatter = date("w",strtotime($MonthEndDate.'-'. '1' .'days'));
	}

	$FirstWeekofMonthDate = date("Y/m/d", strtotime($MonthStartDate.'-'. $FirstWeekofMonthDateFormatter .'days'));
	$LastWeekofMonthDate = date("Y/m/d", strtotime($MonthEndDate.'-'. $LastWeekofMonthDateFormatter .'days'));

    //dd($FirstWeekofMonthDate );
    //dd($LastWeekofMonthDate);


    $emp_activities = DB::table('main_activities')
                ->join('employs', 'employs.id', '=', 'main_activities.EmpID')
                ->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')
                ->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')
                ->join('measure_variants', 'measures.id', '=', 'measure_variants.MeasureID')
                ->join('daily_accomplishments', 'measure_variants.id', '=', 'daily_accomplishments.MeasureVariantID')
                ->where('main_activities.EmpID', '=', $id)
                ->where('sub_activities.EmpID', '=', $id)
                ->whereBetween('daily_accomplishments.Date', array($FirstWeekofMonthDate, $LastWeekofMonthDate))
                ->whereBetween('measure_variants.MeasureVariantDate', array($FirstWeekofMonthDate, $LastWeekofMonthDate))
                ->select(DB::raw('DISTINCT(MainActivityName)'))
                ->orderBy('main_activities.id','asc')
                ->orderBy('sub_activities.id', 'asc')
                ->get();

    $other_activities  = DB::table('other_activities')
	                ->join('employs', 'employs.id', '=', 'other_activities.EmpID')
	                ->join('other_measures', 'other_activities.id', '=', 'other_measures.OtherActivitiesID')
	                ->join('othermeasure_variants', 'other_measures.id', '=', 'othermeasure_variants.OtherMeasureID')
	                ->join('otherdaily_accomplishment', 'othermeasure_variants.id', '=', 'otherdaily_accomplishment.OtherMeasureVariantID')
	                ->where('other_activities.EmpID', '=', $id)
	                ->whereBetween('otherdaily_accomplishment.Date', array($FirstWeekofMonthDate, $LastWeekofMonthDate))
	                ->orderBy('other_activities.id', 'asc')
	                ->get();

?>

<!DOCTYPE html>

<head>
    <title></title>
    <style type="text/css">
    table
    {
    	font-size: 8;
    	text-align: center;
    	width: 875;
    	border-collapse: collapse;
    	page-break-inside: auto;
    }
    tr
    { 
    	page-break-inside: avoid;
    	page-break-after: auto; 
    }
    strong
    {
    	font-family: helvetica;
    }
    </style>
</head>

<body>

	<img src="{{URL::asset($Employees->EmpPicturePath)}}" style="height:100px; width:100px;">
	
	<p style="margin-top: -95px;margin-left: 120px;">Rank and Name : <strong>{{ $Employees->RankCode }} {{ $Employees->EmpFirstName }} {{ $Employees->EmpMidInit }} {{ $Employees->EmpLastName }} {{$Employees->EmpQualifier}}</strong><br><br>Position : <strong>{{ $Employees->PositionName }}</strong><br><br>Period Covered: <strong>{{$DateCovered}}</strong> </p>
	<hr width="875">
	@if($emp_activities != null)
	    @foreach($emp_activities as $emp_mainActivity)
		    <?php	$mainActivityCounter = $mainActivityCounter + 1; ?>
		    <span style="font-size: 8;font-family: helvetica;font-weight: 600;text-align: left;">Main Activity {{$mainActivityCounter}}: {{$emp_mainActivity->MainActivityName}}</span>
		    <table border="1">
			    <thead style="font-family:helvetica">
			    	<tr>
				    	<td rowspan="3" width="{{ $EAwidth }}">Enabling Actions<br />(Sub-activity)</td>
				    	<td rowspan="3" width="80">MEASURES</td>
				    	<td rowspan="3" width="40">MONTHLY<br />TARGET</td>
				    	<td colspan="{{ $NumofDays }}" rowspan="1" height="15">DAILY ACCOMPLISHMENTS</td>
				    	<td rowspan="3" width="25">Total</td>
				    	<td rowspan="3" width="25">Cost</td>
				    	<td rowspan="3" width="35">Remarks</td>
				    </tr>
				    <tr style="font-size: 6">
				    	@for ($i = 0; $i < $NumofDays; $i++)
				    		<?php
				    			$Date = date("D", strtotime(($StartDate.'-'. $SelectedDate . 'days'). '+'. $i . 'days'));
				    		?>
				    		<td rowspan="1" width="15" >{{ $Date }}</td> 
						@endfor		
				    </tr>	
				    <tr style="font-size: 7">
					   	@for ($i = 0; $i < $NumofDays; $i++)
				    		<?php
				    			$Date = date("d", strtotime(($StartDate.'-'. $SelectedDate . 'days'). '+'. $i . 'days'));
				    		?>
				    		<td rowspan="1">{{ $Date }}</td> 
						@endfor	
				    </tr>
			    </thead>
			    <tbody>
			    	<?php
				    	$emp_subActivities = DB::table('main_activities')
		                ->join('employs', 'employs.id', '=', 'main_activities.EmpID')
		                ->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')
		                ->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')
		                ->join('measure_variants', 'measures.id', '=', 'measure_variants.MeasureID')
		                ->join('daily_accomplishments', 'measure_variants.id', '=', 'daily_accomplishments.MeasureVariantID')
		                ->where('main_activities.EmpID', '=', $id)
		                ->where('sub_activities.EmpID', '=', $id)
		                ->whereBetween('daily_accomplishments.Date', array($FirstWeekofMonthDate, $LastWeekofMonthDate))
		                ->whereBetween('measure_variants.MeasureVariantDate', array($FirstWeekofMonthDate, $LastWeekofMonthDate))
		                ->where('MainActivityName', '=', $emp_mainActivity->MainActivityName)
		                ->select(array('SubActivityName','MeasureName'))
		                ->distinct()
		                ->orderBy('main_activities.id','asc')
		                ->orderBy('sub_activities.id', 'asc')
		                ->get();
		                //dd($emp_subActivities);
		                
				    ?>
			    	@foreach($emp_subActivities as $emp_activity)

						    @if($tempSubActivity != $emp_activity->SubActivityName)
						    	<?php
						    		$tempSubActivity = $emp_activity->SubActivityName;
						    	?>
								    <tr>
								    	<td style="vertical-align: top;text-align: left;padding-left: 1px;padding-top: 4px;padding-bottom: 4px;font-size: 6;">{{ $emp_activity->SubActivityName }}</td>
										<td style="text-align: left;font-size: 6;">{{ $emp_activity->MeasureName }}</td>
										<td></td>
										@include('PDFMonthlyAccomplishments')
								   	</tr>
							@else
								    <tr> 
								    	<td></td>  	
										<td style="text-align: left;font-size: 6;">{{ $emp_activity->MeasureName }}</td>
										<td></td>
										@include('PDFMonthlyAccomplishments')
								   	</tr>
					    	@endif
			    	@endforeach	
			    </tbody>
		    </table>	
	    @endforeach
	@else
	    <p>No activities yet for this period.</p>
	@endif

{{--Other Activities--}}

	@if($other_activities != null)
		    <span style="font-size: 8;font-family: helvetica;font-weight: 600;text-align: left;">Other Activities (Other duties as directed)</span>
		    <table border="1">
			    <thead style="font-family:helvetica">
			    	<tr>
				    	<td rowspan="3" width="{{ $EAwidth }}">Enabling Actions<br />(Sub-activity)</td>
				    	<td rowspan="3" width="80">MEASURES</td>
				    	<td rowspan="3" width="40">MONTHLY<br />TARGET</td>
				    	<td colspan="{{ $NumofDays }}" rowspan="1" height="15">DAILY ACCOMPLISHMENTS</td>
				    	<td rowspan="3" width="25">Total</td>
				    	<td rowspan="3" width="25">Cost</td>
				    	<td rowspan="3" width="35">Remarks</td>
				    </tr>
				    <tr style="font-size: 6">
				    	@for ($i = 0; $i < $NumofDays; $i++)
				    		<?php
				    			$Date = date("D", strtotime(($StartDate.'-'. $SelectedDate . 'days'). '+'. $i . 'days'));
				    		?>
				    		<td rowspan="1" width="15" >{{ $Date }}</td> 
						@endfor		
				    </tr>	
				    <tr style="font-size: 7">
					   	@for ($i = 0; $i < $NumofDays; $i++)
				    		<?php
				    			$Date = date("d", strtotime(($StartDate.'-'. $SelectedDate . 'days'). '+'. $i . 'days'));
				    		?>
				    		<td rowspan="1">{{ $Date }}</td> 
						@endfor	
				    </tr>
			    </thead>
			    <tbody>
			    	@foreach($other_activities as $other_activity)

						    @if($tempOtherActivities != $other_activity->OtherActivitiesName)
						    	<?php
						    		$tempOtherActivities = $other_activity->OtherActivitiesName;
						    	?>
								    <tr>
								    	<td style="vertical-align: top;text-align: left;padding-left: 1px;padding-top: 4px;padding-bottom: 4px;font-size: 7;">{{ $other_activity->OtherActivitiesName }}</td>
										<td style="text-align: left;font-size: 7;padding-left: 1px;">{{ $other_activity->OtherActivitiesMeasureName }}</td>
										<td></td>
										@include('PDFMonthlyOtherAccomplishments')
								   	</tr>
							@else
								    <tr> 
								    	<td></td>  	
										<td style="text-align: left;font-size: 7;padding-left: 1px;">{{ $other_activity->OtherActivitiesMeasureName }}</td>
										<td></td>
										@include('PDFMonthlyOtherAccomplishments')
								   	</tr>
					    	@endif
			    	@endforeach	
			    </tbody>
		    </table>	
	@else
	    <p></p>
	@endif
	<br>
	<center>
		<table border="1" width="875" style="font-family: helvetica;page-break-inside: avoid;">
			<tr>
				<td width="15%" style="font-weight: bold;text-align: left;padding-left: 5px;">SUB-TOTAL</td>
				<td width="59.5%"></td>
				<td width="8.5%"></td>
				<td width="8.5%"></td>
				<td width="8.5%"></td>

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
	</center>
</body>