<?php
            $StartDate = Session::get('StartDate', 'default');	        
	        $EndDate = date("Y/m/d", strtotime($StartDate.'+'. '6' . 'days'));

	        $StartDateCovered = "";
	        $EndDateCovered = "";

			$id = Session::get('emp_id', 'default');
			$summations = DB::table('measures')
							->join('measure_variants', 'measure_variants.MeasureID', '=', 'measures.id')
							->join('daily_accomplishments', 'daily_accomplishments.MeasureVariantID', '=', 'measure_variants.id')
							->where('measures.EmpID', '=', $id)
							->whereBetween('daily_accomplishments.Date',array($StartDate, $EndDate))		
							->get();
           

            if($summations != null)
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
            
            $DateCovered = $StartDateCovered.$EndDateCovered;
?>
<!DOCTYPE html>
<head>
    <title>Reports | PNP Scorecard</title>
    <style type="text/css">
    table
    {
    	font-size: 9;
    	text-align: center;
    	width: 100%;
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
	
	<img src="{{URL::asset($Employees->EmpPicturePath)}}" style="height: 100px;width: 100px;">
	
	<p style="margin-top: -95px;margin-left: 120px;">Rank and Name : <strong>{{ $Employees->RankCode }} {{ $Employees->EmpFirstName }} {{ $Employees->EmpMidInit }} {{ $Employees->EmpLastName }} {{$Employees->EmpQualifier}}</strong><br><br>Position : <strong>{{ $Employees->PositionName }}</strong><br><br>Period Covered: <strong>{{$DateCovered}}</strong> </p>
	<hr>
	<span style="font-size: 10;font-family: helvetica;font-weight: 600;text-align: left;">Key Performance Indicator(KPI) - Total/Summation</span>
	   
	<table border="1">
        <thead style="font-family: helvetica;font-size: 8">
            <tr>       
                <th width="120" height="20">Measure Name</th>
                <th width="35">Target</th>
                <th width="45">Measure Type</th>
                <th width="30">Accomplishment</th>
                <th width="40">Variance (Accomplishment<br>- Target)</th>
                <th width="147">Performance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($summations as $summation)
                <?php
                    $total = $summation->MondayValue + $summation->TuesdayValue + $summation->WednesdayValue + $summation->ThursdayValue + $summation->FridayValue + $summation->SaturdayValue + $summation->SundayValue;

                    $performance = 0;
                    $variance = 0;
                   	if($summation->MeasureType == 'Summation/Total')
                    {
                        $res = $summation->MondayValue + $summation->TuesdayValue + $summation->WednesdayValue + $summation->ThursdayValue + $summation->FridayValue + $summation->SaturdayValue + $summation->SundayValue;

                        	$variance = round(($res - $summation->Target), 2);
                            $performance = round(($res / $summation->Target) * 100, 2);
                    }
                    elseif($summation->MeasureType == 'Average')
                    {
                        $res2 = (($summation->MondayValue + $summation->TuesdayValue + $summation->WednesdayValue + $summation->ThursdayValue + $summation->FridayValue + $summation->SaturdayValue + $summation->SundayValue) / 7);

                            $variance = round(($res2 - $summation->Target), 2);
                            $performance = round(($res2 / $summation->Target) * 100, 2);
                    }
                    else{}


                    $barColor = "";
                    $barWidth = "";
                    if($performance >= 101)
                    	{
                    		$barColor = "#337ab7";
                    		$barWidth = 100;
                    	}           
		          	elseif($performance >= 50 && $performance <= 100)
		          		{
		          			$barColor = "#5cb85c";
		          			$barWidth = $performance;
		          		}
		          	elseif($performance <  50 && $performance >= 26)
		          		{
		          			$barColor = "#f0ad4e";
		          			$barWidth = $performance;
		          		}
		          	elseif($performance <= 25 && $performance >= 1)
		          		{
		          			$barColor = "#d9534f";
		          			$barWidth = $performance;
		          		}
		          	else{}
                ?>
                <tr>
                	<td style="text-align: left;padding-left: 4px;">{{$summation->MeasureName}}</td>
                    <td>{{$summation->Target}}</td>
                    <td>{{$summation->MeasureType}}</td>
                    <td>
                        @if($summation->MeasureType == 'Summation/Total')
                            {{$summation->MondayValue + $summation->TuesdayValue + $summation->WednesdayValue + $summation->ThursdayValue + $summation->FridayValue + $summation->SaturdayValue + $summation->SundayValue}}
                        @elseif($summation->MeasureType == 'Average')
                                {{round( (($summation->MondayValue + $summation->TuesdayValue + $summation->WednesdayValue + $summation->ThursdayValue + $summation->FridayValue + $summation->SaturdayValue + $summation->SundayValue) / 7), 2)}}
                        @endif
                    </td>
                    <td>{{ $variance }}</td>
                    <td>
					   	<table>
						    <tr>
						   		<td width="37" style="text-align: center;font-size: 10">{{ $performance }}%</td>
					     		<td>@if($performance != 0)<hr size="8" width="{{$barWidth}}" style="margin-left: 2px;color: {{$barColor}}">@endif</td>
					    	</tr>
					   	</table>
					</td> 
                              
                </tr>
            @endforeach
        </tbody>
    </table>
</body>