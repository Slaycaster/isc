<?php
require('html_table.php');

$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

/*
$html='<table border="1">
<tr>
<td width="200" height="30">cell 1</td><td width="200" height="30" bgcolor="#D0D0FF">cell 2</td>
</tr>
<tr>
'
.
foreach($vars as $var)
{
	echo '<td width="200" height="30">cell 3</td><td width="200" height="30">'.$var->id.'</td>';
}
.
'</tr> </table>';
*/

$date = 'November';
$year = $date . ' 2015';
$pdf->WriteHTML($html);
$pdf->Output();
?>
