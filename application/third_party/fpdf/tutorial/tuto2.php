<?php
require('../fpdf.php');

class PDF extends FPDF
{
// Page header
/**
* Renders the PDF header: places the logo image at the top-left, sets a bold Arial 15 font, centers a titled cell and adds a line break.
* @example
* $pdf = new FPDF();
* $pdf->AddPage(); // Header() will be invoked automatically and will render the logo and title
* // Or call directly (if needed):
* $pdf->Header();
* @param {void} none - No arguments are required.
* @returns {void} Outputs header content directly to the PDF; does not return a value.
*/
function Header()
{
	// Logo
	$this->Image('logo.png',10,6,30);
	// Arial bold 15
	$this->SetFont('Arial','B',15);
	// Move to the right
	$this->Cell(80);
	// Title
	$this->Cell(30,10,'Title',1,0,'C');
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
	// Page number
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
for($i=1;$i<=40;$i++)
	$pdf->Cell(0,10,'Printing line number '.$i,0,1);
$pdf->Output();
?>
