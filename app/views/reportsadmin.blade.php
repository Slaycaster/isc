@extends("layout")
@section("content")

<?php
require('html_table.php');


$EmpID = Session::get('Emp_id', 'default');
$Employees = DB::table('employs')
        ->join('positions', 'positions.id', '=', 'employs.PositionID')
        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
        ->where('employs.id', '=', $EmpID)
        ->first();
//dd($Employees); 
$emp_activities = DB::table('main_activities')
        ->join('employs', 'employs.id', '=', 'main_activities.EmpID')
        ->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')
        ->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')
        ->join('measure_variants', 'measures.id', '=', 'measure_variants.MeasureID')
        ->join('daily_accomplishments', 'measure_variants.id', '=', 'daily_accomplishments.MeasureVariantID')
        ->where('main_activities.EmpID', '=', $EmpID)
        
        ->get();

$tempMainActivity = '';
$tempSubActivity = '';
$tempMeasure = '';
$count = 0;
$mainActivity = '';

/*foreach ($emp_activities as $emp_activity) 
{ 
    if($emp_activity->MainActivityName != $tempMainActivity)
       {
                        
        	echo'<br>';
            $count++;
            'Main Activity '. $count . ': ' . $emp_activity->MainActivityName,1);
            foreach ($header as $col) {
                        
                echo'<table>
                	<thead>
                		<tr>
                			<td>Enabling Actions</td>
                			<td>Measure</td>
                			<td>Target</td>
                			<td>Accomplishments</td>
                			<td>Total</td>
                			<td>Cost</td>
                			<td>Remarks</td>
                		</tr>
                	<thead>';
                 

        }
}*/

$html=
	'

	
	<img src="'.$Employees->EmpPicturePath.'" width="100" height="100">	
	</div>
	
	<p><strong>                                 Rank and Name: '. $Employees->RankCode . ' ' . $Employees->EmpLastName . ', ' . $Employees->EmpFirstName . ' '. $Employees->EmpQualifier .' ' . $Employees->EmpMidInit .' 
			</strong>
		</p>

	<p><strong>                                 Position: '. $Employees->PositionName . '
 			</strong>
 	</p>
 	<br><br><br><br>
 	
 	<table border="1">   
<tr><td width="150" height="30">Objectives</td><td width="150" height="30">Enabling Actions</td><td width="150" height="30">Measure</td><td width="150" height="30">Target</td><td width="150" height="30">Accomplishments</td>
</tr>
        <tr>
        <td width="50" height="40">Mon</td><td width="50" height="40">Tue</td><td width="50" height="40">Wed</td><td width="50" height="40">Thu</td><td width="50" height="40">Fri</td><td width="50" height="40">Sat</td><td width="50" height="40">Sun</td><td width="50" height="40">Total</td><td width="50" height="40">Cost</td><td width="50" height="40">Remarks</td>
       	</tr>
    </table>
	';

$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->WriteHTML($html);
$pdf->Output('reportsadmin.pdf');
?>

<br><br><iframe src="reportsadmin.pdf" title="downloads"  height= "450" width="100%"  frameborder="0" margin-left= "100px" target="Message"></iframe>

@stop