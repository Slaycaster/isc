<?php
            $StartDate = Session::get('StartDate', 'default');	        
	        $add_days = 6;
	        $EndDate = $StartDate;
	        $EndDate = date("Y/m/d", strtotime($StartDate.'+'. $add_days . 'days'));
	        $MonDate = date("d", strtotime($StartDate));
	        $TueDate = date("d", strtotime($StartDate.'+'. '1' . 'days'));
	        $WedDate = date("d", strtotime($StartDate.'+'. '2' . 'days'));
	        $ThuDate = date("d", strtotime($StartDate.'+'. '3' . 'days'));
	        $FriDate = date("d", strtotime($StartDate.'+'. '4' . 'days'));
	        $SatDate = date("d", strtotime($StartDate.'+'. '5' . 'days'));
	        $SunDate = date("d", strtotime($StartDate.'+'. '6' . 'days')); 
			$id = Session::get('yung_id', 'default');
			$emp_activities  = DB::table('main_activities')
                ->join('employs', 'employs.id', '=', 'main_activities.EmpID')
                ->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')
                ->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')
                ->join('measure_variants', 'measures.id', '=', 'measure_variants.MeasureID')
                ->join('daily_accomplishments', 'measure_variants.id', '=', 'daily_accomplishments.MeasureVariantID')
                ->where('main_activities.EmpID', '=', $id)
                ->whereBetween('daily_accomplishments.Date', array($StartDate, $EndDate))
                ->where('sub_activities.EmpID', '=', $id)
                ->orderBy('main_activities.id','asc')
                ->orderBy('sub_activities.id', 'asc')
                ->get();

            $Employees = DB::table('employs')
		        ->join('positions', 'positions.id', '=', 'employs.PositionID')
		        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
		        ->where('employs.id', '=', $id)
		        ->first();


            $tempSubId = 0;
            $tempMainActivity = '';
            $tempSubActivity = '';
            $tempMeasure = '';

?>
<!DOCTYPE html>
<head>
    <title>Scorecard Report | PNP Scorecard System</title>
    <style type="text/css">
    table
    {
    	font-size: 8;
    	text-align: center;
    	width: 100%;
    	border: 1px solid black;
    	border-collapse: collapse;
    	page-break-inside:auto;
    }
    tr
    { 
    	page-break-inside:avoid;
    	page-break-after:auto; 
    }
    </style>
</head>
<body>
	
	<img src="{{URL::asset($Employees->EmpPicturePath)}}" style="height:100px; width:100px;">
	
	<p style="margin-top:-95px; margin-left:120px">Rank and Name : <strong>{{ $Employees->RankCode }} {{ $Employees->EmpFirstName }} {{ $Employees->EmpMidInit }} {{ $Employees->EmpLastName }}</strong><br><br>Position : <strong>{{ $Employees->PositionName }}</strong><br><br>Period Covered: <strong>{{$StartDate}}</strong> to <strong>{{$EndDate}}</strong> </p>

	<hr>
    <table border="1">
    @foreach($emp_activities as $emp_activity)

    	@if($emp_activity->MainActivityName != $tempMainActivity)
	    <thead style="font-family:helvetica">
	    	<tr>
	    		<td colspan="13" style="text-align:left;padding-left:5px;font-weight:600">Main Activity: {{$emp_activity->MainActivityName}}</td>
	    	</tr>
	    	<tr>
		    	<td rowspan="3">Enabling Actions<br />(Sub-activity)</td>
		    	<td rowspan="3">MEASURE</td>
		    	<td rowspan="3">TARGET</td>
		    	<td colspan="7" rowspan="1" style="">ACCOMPLISHMENTS</td>
		    	<td rowspan="3">Total</td>
		    	<td rowspan="3">Cost</td>
		    	<td rowspan="3">Remarks</td>
		    </tr>
		    <tr>
		    	<td rowspan="1">{{ $MonDate }}</td>
		    	<td rowspan="1">{{ $TueDate }}</td>
		    	<td rowspan="1">{{ $WedDate }}</td>
		    	<td rowspan="1">{{ $ThuDate }}</td>
		    	<td rowspan="1">{{ $FriDate }}</td>
		    	<td rowspan="1">{{ $SatDate }}</td>
		    	<td rowspan="1">{{ $SunDate }}</td>		
		    </tr>
		    <tr>
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
	    		$tempMainActivity = $emp_activity->MainActivityName;
	    	?>
	    @endif
	    <tbody>
	    	@if($tempSubActivity != $emp_activity->SubActivityName)

	    		<?php
	    			$total = $emp_activity->MondayValue + $emp_activity->TuesdayValue + $emp_activity->WednesdayValue + $emp_activity->ThursdayValue + $emp_activity->FridayValue + $emp_activity->SaturdayValue + $emp_activity->SundayValue;
	    			$tempSubActivity = $emp_activity->SubActivityName;
	    		?>
	    		 
			    		<tr>
			    			<td style="text-align:left;padding-left: 5px;">{{ $emp_activity->SubActivityName }}</td>
			    			<td style="text-align:left;padding-left: 5px;">{{ $emp_activity->MeasureName }}</td>
			    			<td>{{ $emp_activity->Target }}</td>
			    			<td>{{ $emp_activity->MondayValue }}</td>
			    			<td>{{ $emp_activity->TuesdayValue }}</td>
			    			<td>{{ $emp_activity->WednesdayValue }}</td>
			    			<td>{{ $emp_activity->ThursdayValue }}</td>
			    			<td>{{ $emp_activity->FridayValue }}</td>
			    			<td>{{ $emp_activity->SaturdayValue }}</td>
			    			<td>{{ $emp_activity->SundayValue }}</td>
			    			<td>{{$total}}</td>
			    			<td>{{ $emp_activity->Cost }}</td>
			    			<td>{{ $emp_activity->Remarks }}</td>
			    		</tr>
			@else
				<?php
	    			$total = $emp_activity->MondayValue + $emp_activity->TuesdayValue + $emp_activity->WednesdayValue + $emp_activity->ThursdayValue + $emp_activity->FridayValue + $emp_activity->SaturdayValue + $emp_activity->SundayValue;
	    			
	    		?>
			    		<tr>
			    			<td></td>
			    			<td style="text-align:left;padding-left: 5px;">{{ $emp_activity->MeasureName }}</td>
			    			<td>{{ $emp_activity->Target }}</td>
			    			<td>{{ $emp_activity->MondayValue }}</td>
			    			<td>{{ $emp_activity->TuesdayValue }}</td>
			    			<td>{{ $emp_activity->WednesdayValue }}</td>
			    			<td>{{ $emp_activity->ThursdayValue }}</td>
			    			<td>{{ $emp_activity->FridayValue }}</td>
			    			<td>{{ $emp_activity->SaturdayValue }}</td>
			    			<td>{{ $emp_activity->SundayValue }}</td>
			    			<td>{{$total}}</td>
			    			<td>{{ $emp_activity->Cost }}</td>
			    			<td>{{ $emp_activity->Remarks }}</td>
			    		</tr>
	    	@endif
	    	</tbody>
    @endforeach	
    </table>
    <script>
		function extendRowSpan() {
		    document.getElementById("myTd").rowSpan = "4";
		}
		window.onload = extendRowSpan;
	</script>
</body>


