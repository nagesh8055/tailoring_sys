 
 <?php
 
 ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
 	require('html-pdf.php');
	$pdf=new PDF('P','mm',array(100,120), false, 'UTF-8', true);
	$pdf->AddFont('mangal','mangal.ttf',true);
            $pdf->SetFont('mangal','',14);  
			// Logo
           // $this->Image('logo.png',10,6,30);
            // Title
            // Line break
			$pdf->Text(13,13,"लक्ष्मी  कृषी विकास प्रोडूसर कंपनी ली.");
			
			echo base64_encode ($pdf->output("I"));
			
?>			