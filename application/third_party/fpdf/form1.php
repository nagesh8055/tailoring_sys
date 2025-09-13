<?php
require('fpdf.php');
require_once('tcpdf_include.php');
	require('tfpdf.php');  
	//require('code128.php');
	//require('barcode.php');
      define("_SYSTEM_TTFONTS", "/font/unifont/");

    class PDF extends tFPDF
    {
 function Header()
            {
            $this->AddFont('mangal','','mangal.ttf',true);
            $this->SetFont('mangal','',14);  

           
            // Logo
           // $this->Image('logo.png',10,6,30);
            // Title
           
            // Line break
            $this->Ln(20);
        }

        // Page footer
            function Footer()
        {

            // Position at 1.5 cm from bottom
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',14);
            // Page number
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        }
		}
    //$pdf = new tFPDF();
	$xaxis=5;
	$yaxis=5;
	$cardWidth=95;
	$cardHeight=108;
    
	$pdf=new PDF('P','mm',array(457.2,304.8));
	//$pdf=new PDF_Code128()
    $pdf->AliasNbPages();
    $pdf->SetMargins(5,10,0);

    $pdf->AddPage();
    $pdf->AddFont('mangal','','mangal.ttf',true);
    $pdf->SetFont('mangal','',13);
$str= " नाव :";
$str1=" नागेश नंदकुमार हरीदास ";
$str2="दायित्त्व :";
$str3="शाखा मुख्य-शिक्षक";
$str4="तालुका :";
$str5="पंढरपूर ";
for($i=0;$i<5;$i++)
{
	
	for($j=0;$j<4;$j++)
	{
		$pdf->Image('images/icardBack.jpg',($xaxis+($j*100)),$yaxis+($i*113),$cardWidth,$cardHeight,'JPG');
		//$pdf->Cell(($xaxis+($j*100)),$yaxis+($i*113),"Education");
				$pdf->SetTextColor(249,247,247);
			
				 $pdf->AddFont('mangal','','mangal.ttf',true);
    
				
				$pdf->Text((($xaxis+16)+($j*100)),($yaxis+47)+($i*113),($str ));
				$pdf->Text((($xaxis+29)+($j*100)),($yaxis+47)+($i*113),($str1));
				$pdf->Text((($xaxis+8)+($j*100)),($yaxis+57)+($i*113),($str2 ));
				$pdf->Text((($xaxis+31)+($j*100)),($yaxis+57)+($i*113),($str3 ));
				$pdf->Text((($xaxis+13)+($j*100)),($yaxis+67)+($i*113),($str4 ));
				$pdf->Text((($xaxis+31)+($j*100)),($yaxis+67)+($i*113),($str5 ));
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
				
				
		
		
	}
	
		
}
   


   




    
    //$pdf->cell(50,12," नाव  : नागेश नंदकुमार हरिदास");
	$pdf->Write(10,'');
    $pdf->cell(50,12," ");

  
    $pdf->Output();
    

?>