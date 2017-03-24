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
							->orderBy('measures.id', 'asc')				
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
	<span style="font-size: 10;font-family: helvetica;font-weight: 600;text-align: left;">Key Performance Indicator(KPI) - Weighted Average</span>
	   
	<table border="1">
        <thead style="font-family: helvetica;font-size: 8">
            <tr>       
                <th width="160" height="20">MEASURE NAME</th>
                <th width="120">MEASURE TYPE</th>
                <th width="60">TARGET</th>
                <th width="147">WEIGHTED AVERAGE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($summations as $summation)
                <?php
                	$ave = 0;
                    $count = 0;
                    if ($summation->MondayValue == 0) 
                    {
                        $count = $count + 1;
                    }
                    elseif ($summation->TuesdayValue == 0) 
                    {
                        $count = $count + 1;
                    }
                    elseif ($summation->WednesdayValue == 0) 
                    {
                        $count = $count + 1;
                    }
                    elseif ($summation->ThursdayValue == 0) 
                    {
                        $count = $count + 1;
                    }
                    elseif ($summation->FridayValue == 0) 
                    {
                        $count = $count + 1;
                    }
                    elseif ($summation->SaturdayValue == 0) 
                    {
                        $count = $count + 1;
                    }
                    elseif ($summation->SundayValue == 0) 
                    {
                        $count = $count + 1;
                    }

                    $ave = 7 - $count;

                    if ($count != 0)
                    {
		               	$mon = ($summation->MondayValue / $ave) * 100;
		                $tue = ($summation->TuesdayValue / $ave) * 100;
		                $wed = ($summation->WednesdayValue / $ave) * 100;
		                $thu = ($summation->ThursdayValue / $ave) * 100;
		                $fri = ($summation->FridayValue / $ave) * 100;
		                $sat = ($summation->SaturdayValue / $ave) * 100;
		                $sun = ($summation->SundayValue / $ave) * 100;
		                $total = $mon + $tue + $wed + $thu + $fri + $sat + $sun;
                    }
                    else
                    {
                    	$total = 0;
                    }


                    $performace = round(($total), 2);

                    $barColor = "";
                    $barWidth = "";
                    if($performace >= 101)
                    	{
                    		$barColor = "#337ab7";
                    		$barWidth = 100;
                    	}           
		          	elseif($performace >= 50 && $performace <= 100)
		          		{
		          			$barColor = "#5cb85c";
		          			$barWidth = $performace;
		          		}
		          	elseif($performace <  50 && $performace >= 26)
		          		{
		          			$barColor = "#f0ad4e";
		          			$barWidth = $performace;
		          		}
		          	elseif($performace <= 25 && $performace >= 1)
		          		{
		          			$barColor = "#d9534f";
		          			$barWidth = $performace;
		          		}
		          	else{}
                ?>
                <tr>
                    <td style="vertical-align: top;text-align: left;padding-left: 5px;padding-top: 4px;padding-right: 4px;padding-bottom: 4px;font-size: 8">{{ $summation->MeasureName }}</td>
                    <td>{{ $summation->MeasureType }}</td>
                    <td width="20" style="text-align: center;font-size: 10">{{ $summation->Target }}</td>
	                <td>
					   	<table>
						    <tr>
						   		<td width="37" style="text-align: center;font-size: 10">{{ $performace }}%</td>
					     		<td>@if($performace != 0)<hr size="8" width="{{$barWidth}}" style="margin-left: 2px;color: {{$barColor}}">@endif</td>
					    	</tr>
					   	</table>
					</td>                      
                </tr>
            @endforeach
        </tbody>
    </table>
</body>