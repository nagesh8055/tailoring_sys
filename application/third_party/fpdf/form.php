
<?php
//define('FPDF_FONTPATH','font');
require('fpdf.php');
require_once('tcpdf_include.php');


$xaxis=5;
$yaxis=5;
$cardWidth=95;
$cardHeight=108;

$pdf=new FPDF('P','mm',array(457.2,304.8));
$pdf->AddPage();


$str= " नाव  : नागेश नंदकुमार हरिदास ";
for($i=0;$i<5;$i++)
{
	
	for($j=0;$j<4;$j++)
	{
		$pdf->Image('images/icardBack.jpg',($xaxis+($j*100)),$yaxis+($i*113),$cardWidth,$cardHeight,'JPG');
		//$pdf->Cell(($xaxis+($j*100)),$yaxis+($i*113),"Education");
				$pdf->SetTextColor(249,247,247);
			
				$pdf->SetFont('Arial','',14);
				
				$pdf->Text((($xaxis+8)+($j*100)),($yaxis+47)+($i*113),utf8_encode());
				$pdf->cell(50,12," नाव  : नागेश नंदकुमार हरिदास");
				
				
				
		
		
	}
	
		
}




// Set font

// Move to 8 cm to the right

$pdf->Output();
?>