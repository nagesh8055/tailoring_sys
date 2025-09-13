<?php

header('Content-Type: text/html; charset=utf-8');
require('code128.php');







//$pdf=new PDF_Code128('P','mm',array(457.2,304.8),'ISO10646-1',true);
$pdf=new PDF_Code128('P','mm',array(457.2,304.8), false, 'UTF-8', true);

//$pdf->AddPage();
$pdf->SetFont('Arial','',10);
//$pdf->$result;

//mysql_close();


$xaxis=5;
	$yaxis=5;
	$cardWidth=95;
	$cardHeight=108;
	
	$str= " नाव :";
$str1=" नागेश नंदकुमार हरीदास ";
$str2="दायित्त्व  :";
$str3="शाखा मुख्य - शिक्षक";
$str4="तालुका :";
$str5="पंढरपूर ";
$codeC=1;

for($k=0;$k<2;$k++)
{
	
	$pdf->AddPage();
	for($i=0;$i<5;$i++)
	{
		
		for($j=0;$j<4;$j++)
		{
			
			
			$pdf->Image('images/abhyagat.jpg',($xaxis+($j*100)),$yaxis+($i*113),$cardWidth,$cardHeight,'JPG');
			//$pdf->Cell(($xaxis+($j*100)),$yaxis+($i*113),"Education");
					$pdf->SetTextColor(249,247,247);
				
					 //$pdf->AddFont('gargi','','gargi.ttf',true);
					 $pdf->SetFont('Arial','',14);
					
					$pdf->AddFont('gargi','','gargi.ttf',true);
					$pdf->SetFont('gargi','',14);  
					
					
					//$str2=mb_convert_encoding($str2,'utf-8');
					//$str2 = mb_convert_encoding($str2, 'HTML-ENTITIES',"UTF-8");
					//$str2=html_entity_decode($str2,ENT_NOQUOTES, "ISO-8859-1");
					
					//$pdf->Text((($xaxis+16)+($j*100)),($yaxis+47)+($i*113),($str ));
					//$pdf->Text((($xaxis+29)+($j*100)),($yaxis+47)+($i*113),($str1));
					//$pdf->Text((($xaxis+8)+($j*100)),($yaxis+57)+($i*113),($str2 ));
					//$pdf->Text((($xaxis+31)+($j*100)),($yaxis+57)+($i*113),($str3 ));
					//$pdf->Text((($xaxis+13)+($j*100)),($yaxis+67)+($i*113),($str4 ));
					//$pdf->Text((($xaxis+31)+($j*100)),($yaxis+67)+($i*113),($str5 ));
					//$pdf->Image('images/Text.png',(($xaxis+12)+($j*100)),($yaxis+47)+($i*113),65,30,'PNG');//img,x,y,h,w
					//$pdf->SetFont('Arial','',14);
					//$pdf->Code128('x''y''nagesh''w''h')
					//$pdf->Code128('$xaxis+40','$yaxis+77','12345','100','50');
					//$pdf->SetFont('Arial','',10);
					
					 

	//A set+

	//$code='Code 128';
	//$pdf->Code128(50,70,$code,80,20);
	//$pdf->SetXY(50,95);
	//$pdf->Write(5,'B set: "'.$code.'"');
					//$pdf->cell(50,12," नाव  : नागेश नंदकुमार हरिदास");
					$pdf->SetFont('Arial','',14);
					$pdf->SetTextColor(000,000,000);
				//A set
				
				$tmpIndex=($k*12)+($i*3)+$j;
			$code='G00000000'.($tmpIndex+1);
			$pdf->Code128((($xaxis+5)+($j*100)),($yaxis+94)+($i*113),$code,85,10);
			//$pdf->SetXY((($xaxis+31)+($j*100)),($yaxis+67)+($i*153));//this is for after barcode print
			//$pdf->Write(5,'Code: "'.$code.'"');	
					
				
			
			
		}
		
			
	}
	
}	









/*
//B set
$code='Code 128';
$pdf->Code128(50,70,$code,80,20);
$pdf->SetXY(50,95);
$pdf->Write(5,'B set: "'.$code.'"');

//C set
$code='12345678901234567890';
$pdf->Code128(50,120,$code,110,20);
$pdf->SetXY(50,145);
$pdf->Write(5,'C set: "'.$code.'"');


//A,C,B sets
$code='ABCDEFG1234567890AbCdEf';
$pdf->Code128(50,170,$code,125,20);
$pdf->SetXY(50,195);
$pdf->Write(5,'ABC sets combined: "'.$code.'"');
*/
$pdf->Output();
?>