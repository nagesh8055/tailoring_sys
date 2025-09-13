<?php

// Optionally define the filesystem path to your system fonts
// otherwise tFPDF will use [path to tFPDF]/font/unifont/ directory
// define("_SYSTEM_TTFONTS", "C:/Windows/Fonts/");

require('tfpdf.php');

$pdf = new tFPDF();
$pdf->AddPage();

// Add a Unicode font (uses UTF-8)
$pdf->AddFont('gargi','','gargi.ttf',true);
$pdf->SetFont('gargi','',14);

// Load a UTF-8 string from a file and print it
$txt = file_get_contents('HelloWorld.txt');

$reportSubtitle= "लक्ष्मी  कृषी विकास प्रोडूसर कंपनी ली.";
//$pdf->text(8,20,iconv('UTF-8', 'cp1252', $reportSubtitle));
$pdf->text(8,20, $reportSubtitle);

// Select a standard font (uses windows-1252)
$pdf->SetFont('Arial','',14);
$pdf->Ln(10);
$pdf->Write(5,'The file size of this PDF is only 13 KB.');

$pdf->Output();
?>