@extends("layout")
@section("content")

<head>
    <title>Accomplishment Report | PNP Scorecard System</title>
</head>

<?php

require('fpdf.php');

class PDF extends FPDF
{
private function MultiAlignCell($w,$h,$text,$border=0,$ln=0,$align='L',$fill=false)
{
    // Store reset values for (x,y) positions
    $x = $this->GetX() + $w;
    $y = $this->GetY();

    // Make a call to FPDF's MultiCell
    $this->MultiCell($w,$h,$text,$border,$align,$fill);

    // Reset the line position to the right, like in Cell
    if( $ln==0 )
    {
        $this->SetXY($x,$y);
    }
}
function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
    {
        //Get string width
        $str_width=$this->GetStringWidth($txt);

        //Calculate ratio to fit cell
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $ratio = ($w-$this->cMargin*2)/$str_width;

        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit)
        {
            if ($scale)
            {
                //Calculate horizontal scaling
                $horiz_scale=$ratio*100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
            }
            else
            {
                //Calculate character spacing in points
                $char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET',$char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align='';
        }

        //Pass on to Cell method
        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
    }


function CellFitScale($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,false);
    }
// Page header
function Header()
{
   $StartDate = Session::get('StartDate', 'default');
   $add_days = 6;
   $EmpID = Session::get('Emp_id', 'default');
   $EndDate = $StartDate;
   $EndDate = date("Y/m/d", strtotime($StartDate.'+'. $add_days . 'days'));

   $Employees = DB::table('employs')
        ->join('positions', 'positions.id', '=', 'employs.PositionID')
        ->join('ranks', 'ranks.id', '=', 'employs.RankID')
        ->where('employs.id', '=', $EmpID)
        ->get();


    // Logo 
    foreach($Employees as $Employee)
    {
        
    // Arial bold 15
    // Move to the right

    $this->Image($Employee->EmpPicturePath,10,10,30,0,'','');

    $this->Cell(30);
    $this->SetFont('Arial','B',15);
    
    // Title
    $this->Cell(10,10,' Rank And Name: ');
    $this->Cell(35);
    $this->SetFont('Arial','',15);
    $this->Cell(10,10, $Employee->RankCode . ' ' . $Employee->EmpLastName . ', ' . $Employee->EmpFirstName . ' ' . $Employee->EmpMidInit,'');

    $this->Ln(14);
    $this->Cell(30);
    $this->SetFont('Arial','B',15);
    $this->Cell(10,10,' Position: ');
    $this->Cell(35);
    $this->SetFont('Arial','',15);
    $this->Cell(10,10, $Employee->PositionName,'');

    $this->Ln(14);
    $this->Cell(30);
    $this->SetFont('Arial','B',15);
    $this->Cell(10,10,' Period Covered: ');
    $this->Cell(35);
    $this->SetFont('Arial','',15);
    $this->Cell(10,10, $StartDate . ' to ' . $EndDate,'');

    $this->Ln(4);
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(5);
    $this->Ln(8);
    // Title
       // Line break

    $this->SetFont('Arial','',15);
    $this->Ln(8);
    } 
}

                
function BasicTable($header)
    {      
      
        $StartDate = Session::get('StartDate', 'default');
        $EmpID = Session::get('Emp_id', 'default');
        
       $add_days = 6;
       $EndDate = $StartDate;
       $EndDate = date("Y/m/d", strtotime($StartDate.'+'. $add_days . 'days')); 

           $emp_activities = DB::table('main_activities')
                ->join('employs', 'employs.id', '=', 'main_activities.EmpID')
                ->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')
                ->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')
                ->join('measure_variants', 'measures.id', '=', 'measure_variants.MeasureID')
                ->join('daily_accomplishments', 'measure_variants.id', '=', 'daily_accomplishments.MeasureVariantID')
                ->where('main_activities.EmpID', '=', $EmpID)
                ->whereBetween('daily_accomplishments.Date', array($StartDate, $EndDate))
                ->get();
                //dd($emp_activities);
            /*$emp_accomplishments = DB::table('daily_accomplishments')
                ->join('measure_variants', 'measure_variants.id', '=', 'daily_accomplishments.MeasureVariantID')
                ->join('activity_variants', 'measure_variants.ActivityVariantID', '=', 'activity_variants.id')
                ->where('measure_variants.EmpID', '=', $EmpID)
                ->whereBetween('daily_accomplishments.Date', array($StartDate, $EndDate))
                ->get();*/



        $this->SetFont('Arial','',9);
        $tempSubId = 0;
        $tempMainActivity = '';
              $tempSubActivity = '';
              $tempMeasure = '';
                $count = 0;


                        
                   
               
                
                foreach($emp_activities as $emp_activity)
                {   
                    if($emp_activity->MainActivityName != $tempMainActivity)
                    {
                        
                    $this->Ln();
                    $count++;
                    $this->MultiCell(193,5, 'Main Activity '. $count . ': ' . $emp_activity->MainActivityName,1);
                    foreach ($header as $col) {
                        
                    if($col == 'Enabling Actions')   
                        $this->Cell(40,5,$col,1,0,'C');
                    else if ($col == 'Measure')
                        $this->Cell(35,5,$col,1,0,'C');
                    else if ($col == 'Target')
                        $this->Cell(10,5,$col,1,0,'C');
                    else if ($col == 'Accomplishments')
                        $this->Cell(70,5,$col,1,0,'C');
                    else if ($col == 'Total')
                        $this->Cell(8,5,$col,1,0,'C');
                    else if ($col == 'Cost')
                        $this->Cell(10,5,$col,1,0,'C');
                    else if ($col == 'Remarks')
                        $this->Cell(20,5,$col,1,0,'C');  

                    }
                
                $this->Ln();           
                $this->Cell(40,5,'',1,0,'L');
                $this->Cell(35,5,'',1,0,'L');
                $this->Cell(10,5,'',1,0,'L');
                $this->Cell(10,5,'Mon',1,0,'C');
                $this->Cell(10,5,'Tue',1,0,'C');
                $this->Cell(10,5,'Wed',1,0,'C');
                $this->Cell(10,5,'Thu',1,0,'C');
                $this->Cell(10,5,'Fri',1,0,'C');
                $this->Cell(10,5,'Sat',1,0,'C');
                $this->Cell(10,5,'Sun',1,0,'L');
                $this->Cell(8,5,'',1,0,'L');
                $this->Cell(10,5,'',1,0,'L');
                $this->Cell(20,5,'',1,0,'L');
                $this->Ln();
                        $tempMainActivity = $emp_activity->MainActivityName;
                    }
                

                $Total = 0;
                    if ($tempSubActivity != $emp_activity->SubActivityName) 
                    {
                        $this->SetFont('Arial','',8);
                        
                        $this->CellFitScale(40,5,$emp_activity->SubActivityName,1);
                        $x = $this->GetX();
                        $tempSubActivity = $emp_activity->SubActivityName;
                        $this->CellFitScale(35,5,$emp_activity->MeasureName,1);
                        $y = $this->GetY();
                        $this->MultiCell(10,5,$emp_activity->Target,1);
                        $this->SetXY($x + 45, $y);

                        $Total = $emp_activity->MondayValue + $emp_activity->TuesdayValue + $emp_activity->WednesdayValue + $emp_activity->ThursdayValue + $emp_activity->FridayValue + $emp_activity->SaturdayValue + $emp_activity->SundayValue;
                        $this->Cell(10,5,$emp_activity->MondayValue,1);
                        $this->Cell(10,5,$emp_activity->TuesdayValue,1);
                        $this->Cell(10,5,$emp_activity->WednesdayValue,1);
                        $this->Cell(10,5,$emp_activity->ThursdayValue,1);
                        $this->Cell(10,5,$emp_activity->FridayValue,1);
                        $this->Cell(10,5,$emp_activity->SaturdayValue,1);
                        $this->Cell(10,5,$emp_activity->SundayValue,1);
                        $this->Cell(8,5,$Total,1);
                        $this->Cell(10,5,$emp_activity->Cost,1);
                        $this->Cell(20,5,$emp_activity->Remarks,1); 
                        $this->Ln();
                    }
                    else
                    {   
                        $x = $this->GetX();
                        $y = $this->GetY();
                        $this->Cell(40);
                        $this->CellFitScale(35,5,$emp_activity->MeasureName,1);
                        $this->SetXY($x + 75, $y);
                        $this->MultiCell(10,5,$emp_activity->Target,1);
                        $this->SetXY($x + 85, $y);
                        $Total = $emp_activity->MondayValue + $emp_activity->TuesdayValue + $emp_activity->WednesdayValue + $emp_activity->ThursdayValue + $emp_activity->FridayValue + $emp_activity->SaturdayValue + $emp_activity->SundayValue;
                        $this->Cell(10,5,$emp_activity->MondayValue,1);
                        $this->Cell(10,5,$emp_activity->TuesdayValue,1);
                        $this->Cell(10,5,$emp_activity->WednesdayValue,1);
                        $this->Cell(10,5,$emp_activity->ThursdayValue,1);
                        $this->Cell(10,5,$emp_activity->FridayValue,1);
                        $this->Cell(10,5,$emp_activity->SaturdayValue,1);
                        $this->Cell(10,5,$emp_activity->SundayValue,1);
                        $this->Cell(8,5,$Total,1);
                        $this->Cell(10,5,$emp_activity->Cost,1);
                        $this->Cell(20,5,$emp_activity->Remarks,1);
                        $this->Ln();
                    }
                }

                          
                        
                        
                /*
                $x = $this->GetX();
                $y = $this->GetY();
                    
                foreach($emp_activities as $emp_activity)
                {
                
                $this->MultiCell(40,5,$emp_activity->SubActivityName,1);
                $y = $this->GetY() - 10;
                $this->SetXY($x + 40, $y);
                $this->MultiCell(30,5,$emp_activity->MeasureName,1);
                $this->Ln(); 
                        
                }*/
                  
    }
// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

}
// Instanciation of inherited class
$pdf = new PDF();

$header = array('Enabling Actions', 'Measure', 'Target', 'Accomplishments', 'Total', 'Cost', 'Remarks');
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',12);
$pdf->AddPage();
$pdf->BasicTable($header);
$pdf->Output('accomplishmentreport.pdf');
?>

<br><br><iframe src="accomplishmentreport.pdf" title="downloads"  height= "450" width="100%"  frameborder="0" margin-left= "100px" target="Message"></iframe>

@stop