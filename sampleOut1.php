<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
	// Logo
	$this->Image('logo.png',140,0,60);
	// Arial bold 15
	$this->SetFont('Arial','B',15);
	// Move to the right
	$this->Cell(80);
	// Title
	//$this->Cell(30,10,'Title',1,0,'C');
	// Line break
	$this->Ln(20);
}

// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	$this->SetY(-15);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	$this->Cell(0,5,'MN AL FALAH SDN BHD (88261-X)',0,1,'C');
	$this->Cell(0,5,'D-11-3A, Plaza Paragon Point II, Jalan Medan Pusat Bandar 5, Seksyen 9, 43650 Bandar Baru Bangim Selangor, Malaysia',0,1,'C');
	$this->Cell(0,5,'tel +6 03 8926 0044 mobile +6 012 2526 499 fax +6 03 8926 4873 www.mnalfalah.com.my',0,1,'C');
	// Page number
	//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

    $pdf->Cell(0,10,'For patient- Sa\'adiah Mohd Jani ; Attention- Ruzanna Mohamed',0,1);
    $pdf->Cell(0,10,'APPENDIX 1 (to be read with Quotation )',0,1,'C');
    $pdf->Cell(0,10,'Date:',0,1);
    $pdf->Cell(0,10,'Terms and Conditions- please refer to the attached Quotation ()',0,1);
    $pdf->Cell(0,10,'1. Above is the price schedule for our Company’s "NURSING & GENERAL HOME CARE SERVICES".',0,1);
    $pdf->Cell(0,10,'2. The above-said fees include direct consultation with medical specialist and/or Nursing Sister.',0,1);
    $pdf->MultiCell(0,10,'3. The above-said "Caregiver Service Fees” (*) do not include: additional use of items such as glucometer (bedside glucose); consumable items, disposable napkins, use of wound dressing sets and materials, catheters and NG tubes, drugs (medications), and/or any other special procedure which is beyond the scope of the basic general care; mileage; and extra charges during gazetted public holidays',0,1);
    $pdf->MultiCell(0,10,'4. Any other professional Home services such as Physiotherapy, Occupational or Speech Therapist or Doctor’s House Call, are not included in the above quotation. Separate charges apply.',0,1);
    
//for($i=1;$i<=40;$i++)
//	$pdf->Cell(0,10,'Printing line number '.$i,0,1);
$pdf->Output();
?>
