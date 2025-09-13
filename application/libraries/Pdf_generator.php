<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'third_party/fpdf/fpdf.php');

class Pdf_generator extends FPDF {

    function __construct() {
        parent::__construct();
    }

    function generate_pdf($data,$mData = array()) {

        // Custom page size in millimeters (mm)
      $width = 148.5; // Width: 210mm (A4 size)
      $height = 210; // Height: 148mm (A5 size)

      // Create instance of FPDF
      $pdf = new FPDF('L','mm', array($width, $height));
      $pdf->AddPage();

      $image_path = APPPATH. 'logs/logo.JPG';
	  $qr_image_path = APPPATH.'logs/QR.jpeg';
		
      // Header Section
      $pdf->Image($image_path,10,4,-250);
		$pdf->Image($qr_image_path,170,2,23);
      $pdf->SetFont('Arial','B',16);
		$pdf->SetTextColor(156, 34, 93);
      $pdf->Cell(0,7,'BK Tailors',0,1,'C');
		$pdf->SetTextColor(93, 63, 211);
      $pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(93, 63, 211);
      $pdf->Cell(0,5,'Sangola Naka, Gurudev Nagar, Pandharpur - 413304',0,1,'C');
      $pdf->Cell(0,7,'Contact Number - 9421027826, 8888532373',0,1,'C');
	  $pdf->SetTextColor(00, 00, 00);	
      $pdf->SetFont('Arial','B',10);
      $pdf->Cell(0,7,'Bill No - '.$mData['billno'],1,0,'L');
      $pdf->Cell(0,7,'Bill Date -'.$mData['billDate'],0,1,'R');
      
      $pdf->Cell(0,7,'Customer - '.$mData['custname'],1,0);
      $pdf->Ln();

      $pdf->SetY(46);
        // Set font for table
        $pdf->SetFont('Arial', 'B', 10);

        $cellHeight = 6 ;
        $defaultCellBorder = 1 ;
        // Table header
        $pdf->Cell(15, $cellHeight, 'Sr', 1, 0, 'C');
        $pdf->Cell(75, $cellHeight, 'Item', 1, 0, 'C');
        $pdf->Cell(30, $cellHeight, 'Qty', 1, 0, 'C');
        $pdf->Cell(30, $cellHeight, 'Rate', 1, 0, 'C');
        $pdf->Cell(40, $cellHeight, 'Total', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        // Table content
        foreach($data as $row) {
            
            $pdf->Cell(15, $cellHeight, $row['sr'], 1, 0, 'C');
            $pdf->Cell(75, $cellHeight, $row['item'], $defaultCellBorder, 0, 'L');
            $pdf->Cell(30, $cellHeight, $row['qty'], $defaultCellBorder, 0, 'R');
            $pdf->Cell(30, $cellHeight, $row['rate'], $defaultCellBorder, 0, 'R');
            $pdf->Cell(40, $cellHeight, $row['total'], 1, 1, 'R');
            
            // Check if new page needed
            if($pdf->GetY() > 190) {
                $pdf->AddPage();
            }
        }

        // Footer Section
        $pdf->SetY(-35);
        $pdf->Cell(0,10,'Customer Signature: ________________________',0,0,'L');

        // Add bottom text
        $pdf->SetY(-37);
        $pdf->Cell(0,10,'Thanks you visit again',0,0,'R');
        
        // Output the PDF
        $pdf->Output();
    }
}
