<?php
/*
header('Content-Type: text/html; charset=utf-8');
require('code128.php');
require('control\control.php');*/

require('html-pdf.php');

$margin=10;
$paperWidth=210;
$paperHeight=297;

//$pdf=new PDF_Code128('P','mm',array(457.2,304.8),'ISO10646-1',true);
$pdf=new PDF('P','mm',array($paperWidth,$paperHeight), false, 'UTF-8', true);

//$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->SetMargins("10", "10", "10");
//$pdf->$result;

//mysql_close();

$pdf->AddPage();
$pdf->SetTextColor(249,247,247);
$pdf->Rect($margin, $margin, ($paperWidth-(2*$margin)), ($paperHeight-(2*$margin)),"D");

$pdf->SetTextColor(226,76,30);
$pdf->Image('logo.png',12,12,79.375,15.610416667,'PNG');//img,x,y,h,w
$pdf->SetFont('Arial','',17);
$pdf->Text(92,25,"Lodge");
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',11);
$pdf->Text(13,31,"Pandharpur-Mohol Road, Bhairavnathvadi, Dist- Solapur ");
$pdf->Text(13,37,"Phone : 9730006371, 7875289695");
$pdf->Text(13,43,"GST NO : GST0000TYHGBJ");
$pdf->SetFont('Arial','',8);
$pdf->Text(140,14,"SUBJECT TO PANDHARPUR JURISDICTION");
$pdf->SetFont('Arial','',12);
$pdf->Line($margin,45,($paperWidth-$margin),45);
$pdf->SetTextColor(203,71,31);
$pdf->SetFillColor(203,71,31);
$pdf->Rect(150, 25, 40, 7,"F");
$pdf->SetTextColor(255,255,255);
$pdf->Text(155,30,"TAX - INVOICE");
$pdf->SetTextColor(0,1,0);
$html='<table border="1">
<tr >
<td width="200" height="30">cell 1</td><td width="200" height="30" bgcolor="#D0D0FF">cell 2</td>
</tr>
<tr>
<td width="200" height="30">cell 3</td><td width="200" height="30">cell 4</td>
</tr>
</table>';
$yaxis=50;
$pdf->SetXY($margin+2,$yaxis);
$pdf->SetFont('Arial','',10);
//$pdf->WriteHTML($html,12);
//width height text,border,endline,align
$pdf->Cell(22,7,'Bill Date',1,0,'R');
$pdf->Cell(30,7,'18/04/2018',1,1,'R');
$pdf->SetX($margin+2);
$pdf->Cell(22,7,'Bill No.',1,0,'R');
$pdf->Cell(30,7,'01',1,1,'R');


$pdf->SetXY($margin+55,$yaxis);
$pdf->Cell(30,5,'Party Name :',0,0,'R');
$pdf->Cell(90,5,'Nagesh Nandkumar Haridas',0,1,'L');
$pdf->SetX($margin+55);
$pdf->Cell(30,6,'Address :',0,0,'R');
$pdf->Cell(90,6,'1883/B,Haridas Ves,Pandhsrpur',0,1,'L');
$pdf->SetX($margin+55);
$pdf->Cell(30,6,'GST/PAN :',0,0,'R');
$pdf->Cell(90,6,'XSdfr57478 / Pa34fgty',0,1,'L');

//Billing Table
//$pdf->SetXY($margin+55,$yaxis);
//Drawing billin Table

$yaxis=70;$xaxis=$margin+5;$tblW=($paperWidth-($margin*2)-10);$tblH=160;
$pdf->Rect($margin+5,70,$tblW,$tblH);
	//Drwing Table Cells;
$cols=array("srno"=>6,"particulars"=>34,"Rate"=>20,"Qty"=>15,"Amount"=>25);	
$colsW=array(10,35,20,15,20);

$count=0;
$pdf->SetXY($xaxis,$yaxis);
$tmpWidth=$xaxis;
$colx=array();
$colW=array();
foreach($cols as $col=>$val)
{  
	//width height text,border,endline,align
	$tmpWidth=$tmpWidth+getPerVal($val,$tblW);
	
	if(end($cols))
	{
			$pdf->Cell(getPerVal($val,$tblW),6,$col,1,0,'C');
	}
	array_push($colx,$tmpWidth);
	array_push($colW,getPerVal($val,$tblW));
	$pdf->Line($tmpWidth,$yaxis,$tmpWidth,$yaxis+$tblH);
	//;
}

//bottom Values
$pdf->SetXY($colx[2],$yaxis+$tblH);
$pdf->Cell($colW[3],7,"Gross Amt",1,0,"R");
$pdf->Cell($colW[4],7,"0.0",1,1,"R");

$pdf->SetX($colx[2]);
$pdf->Cell($colW[3],7,"SGST",1,0,"R");
$pdf->Cell($colW[4],7,"0.0",1,1,"R");

$pdf->SetX($colx[2]);
$pdf->Cell($colW[3],7,"CGST",1,0,"R");
$pdf->Cell($colW[4],7,"0.0",1,1,"R");

$pdf->SetX($colx[2]);
$pdf->Cell($colW[3],7,"IGST",1,0,"R");
$pdf->Cell($colW[4],7,"0.0",1,1,"R");

$pdf->SetX($colx[2]);
$pdf->Cell($colW[3],7,"NET AMOUNT",1,0,"R");
$pdf->Cell($colW[4],7,"0.0",1,1,"R");


function getPerVal($val,$width)
{
	return (($width*$val)/100);
}









$pdf->Output();
?>