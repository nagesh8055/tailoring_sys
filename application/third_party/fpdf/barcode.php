<?php

header('Content-Type: text/html; charset=utf-8');
require('code128.php');
require('control\control.php');



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

//creating connection
$obj=new connection();
$conn=$obj->get_conn();

$query="select mid from v1_member_m where mid > 437 order by mid asc";
$data=$obj->getData($query,$conn);

$id=array();

foreach($data as $row)
{
	array_push($id,$row['mid']);
	
}

$noOfPages=0;
if(sizeof($id)%12==0)
{
		$noOfPages=sizeof($id)/12;
}
else
{
	 $noOfPages=((int)sizeof($id)/12);
}



$count=0;

for($k=0;$k<$noOfPages;$k++)
{
	
	$pdf->AddPage();	
	for($i=0;$i<5;$i++)//rows
	{
		
		for($j=0;$j<4;$j++)//cols
		{
			
			
			$pdf->Image('images/icardBack.jpg',($xaxis+($j*100)),$yaxis+($i*113),$cardWidth,$cardHeight,'JPG');
			//$pdf->Cell(($xaxis+($j*100)),$yaxis+($i*113),"Education");
					$pdf->SetTextColor(249,247,247);
				
					 //$pdf->AddFont('gargi','','gargi.ttf',true);
					$pdf->SetFont('Arial','',14);
					$pdf->AddFont('gargi','','gargi.ttf',true);
					$pdf->SetFont('gargi','',14);

					$tmpIndex=($k*12)+($i*3)+$j;
					
					try
					{
						
						if($tmpIndex < sizeof($id))
						{
							$pdf->Image('images/data/'.$id[$tmpIndex].'.png',(($xaxis+12)+($j*100)),($yaxis+47)+($i*113),65,30,'PNG');//img,x,y,h,w	
						}
					}
					catch(Exception $e)
					{
						
					}	
					
			
					$pdf->SetFont('Arial','',14);
					$pdf->SetTextColor(000,000,000);
				//A set
				if($tmpIndex < sizeof($id))
				{
					$code='00000000'.$id[$tmpIndex];
					$pdf->Code128((($xaxis+5)+($j*100)),($yaxis+94)+($i*113),$code,85,10);	
				}
				
				
			
			//$pdf->SetXY((($xaxis+31)+($j*100)),($yaxis+67)+($i*153));//this is for after barcode print
			//$pdf->Write(5,'Code: "'.$code.'"');	
			//$count=$count+1;		
					
			
			
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