<?php
require('../fpdf.php');

class PDF extends FPDF
{
/**
* Renders the page header: a centered, colored title box using the global $title variable.
* @example
* $title = 'Monthly Sales Report';
* $pdf = new PDF(); // PDF extends FPDF and implements Header()
* $pdf->AddPage(); // Header() is invoked automatically and draws the title box
* $pdf->Output(); // outputs the PDF with header showing "Monthly Sales Report"
* @param {string} $title - Global title string used for the header (must be set before AddPage()).
* @returns {void} No return value; draws directly onto the PDF page.
*/
function Header()
{
	global $title;

	// Arial bold 15
	$this->SetFont('Arial','B',15);
	// Calculate width of title and position
	$w = $this->GetStringWidth($title)+6;
	$this->SetX((210-$w)/2);
	// Colors of frame, background and text
	$this->SetDrawColor(0,80,180);
	$this->SetFillColor(230,230,0);
	$this->SetTextColor(220,50,50);
	// Thickness of frame (1 mm)
	$this->SetLineWidth(1);
	// Title
	$this->Cell($w,9,$title,1,1,'C',true);
	// Line break
	$this->Ln(10);
}

function Footer()
{
	// Position at 1.5 cm from bottom
	$this->SetY(-15);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	// Text color in gray
	$this->SetTextColor(128);
	// Page number
	$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
}

function ChapterTitle($num, $label)
{
	// Arial 12
	$this->SetFont('Arial','',12);
	// Background color
	$this->SetFillColor(200,220,255);
	// Title
	$this->Cell(0,6,"Chapter $num : $label",0,1,'L',true);
	// Line break
	$this->Ln(4);
}

/**
* Outputs the contents of a text file into the current PDF page as a chapter body using Times 12, then appends an italicized "(end of excerpt)".
* @example
* $pdf = new PDF(); // instance of FPDF subclass
* $pdf->AddPage();
* $pdf->ChapterBody('application/third_party/fpdf/tutorial/chapter1.txt'); // sample file path
* // Result: the file text is written on the PDF page in Times 12 and "(end of excerpt)" is added in italics.
* @param {string} $file - Path to the text file to read and render into the PDF.
* @returns {void} No return value; outputs directly to the PDF document.
*/
function ChapterBody($file)
{
	// Read text file
	$txt = file_get_contents($file);
	// Times 12
	$this->SetFont('Times','',12);
	// Output justified text
	$this->MultiCell(0,5,$txt);
	// Line break
	$this->Ln();
	// Mention in italics
	$this->SetFont('','I');
	$this->Cell(0,5,'(end of excerpt)');
}

function PrintChapter($num, $title, $file)
{
	$this->AddPage();
	$this->ChapterTitle($num,$title);
	$this->ChapterBody($file);
}
}

$pdf = new PDF();
$title = '20000 Leagues Under the Seas';
$pdf->SetTitle($title);
$pdf->SetAuthor('Jules Verne');
$pdf->PrintChapter(1,'A RUNAWAY REEF','20k_c1.txt');
$pdf->PrintChapter(2,'THE PROS AND CONS','20k_c2.txt');
$pdf->Output();
?>
