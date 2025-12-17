<?php
require('../fpdf.php');

class PDF extends FPDF
{
// Load data
function LoadData($file)
{
	// Read file lines
	$lines = file($file);
	$data = array();
	foreach($lines as $line)
		$data[] = explode(';',trim($line));
	return $data;
}

// Simple table
/**
* Draws a simple table (header row then data rows) into the current FPDF document using fixed-width cells.
* @example
* $header = ['Country', 'Capital', 'Area', 'Population'];
* $data = [
*     ['Austria', 'Vienna', '83,859 km²', '8.9M'],
*     ['Germany', 'Berlin', '357,022 km²', '83M']
* ];
* $result = $pdf->BasicTable($header, $data);
* echo $result; // no direct output: table is rendered into the PDF document stream
* @param {{array}} {{$header}} - Numeric array of column header labels (e.g. ['Col1','Col2','Col3']).
* @param {{array}} {{$data}} - Two-dimensional numeric array of rows, each row being an array of cell values.
* @returns {{void}} No return value; outputs table cells directly to the active FPDF instance.
*/
function BasicTable($header, $data)
{
	// Header
	foreach($header as $col)
		$this->Cell(40,7,$col,1);
	$this->Ln();
	// Data
	foreach($data as $row)
	{
		foreach($row as $col)
			$this->Cell(40,6,$col,1);
		$this->Ln();
	}
}

// Better table
/**
* Render a four-column table into the current PDF using fixed column widths and number formatting.
* @example
* $pdf = new FPDF();
* $pdf->AddPage();
* $header = array('Country','Capital','Population','Area (km²)');
* $data = array(
*     array('Netherlands','Amsterdam',17000000,41543),
*     array('Belgium','Brussels',11500000,30528)
* );
* $pdf->ImprovedTable($header, $data); // outputs a table into the PDF
* @param {array} $header - Array of 4 header labels (strings) for each column.
* @param {array} $data - Array of rows; each row is an array of 4 values: [string, string, number, number].
* @returns {void} Outputs the table directly to the PDF; no value is returned.
*/
function ImprovedTable($header, $data)
{
	// Column widths
	$w = array(40, 35, 40, 45);
	// Header
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C');
	$this->Ln();
	// Data
	foreach($data as $row)
	{
		$this->Cell($w[0],6,$row[0],'LR');
		$this->Cell($w[1],6,$row[1],'LR');
		$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
		$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
		$this->Ln();
	}
	// Closing line
	$this->Cell(array_sum($w),0,'','T');
}

// Colored table
/**
* Output a styled table to the current PDF page using the given header labels and row data.
* @example
* $header = array('Country', 'Capital', 'Area (km2)', 'Population');
* $data = array(
*     array('Austria', 'Vienna', 83879, 8205),
*     array('Belgium', 'Brussels', 30528, 11556),
*     array('Canada', 'Ottawa', 9984670, 375900)
* );
* // Assuming $pdf is an instance of the FPDF subclass containing FancyTable and a page already added:
* $result = $pdf->FancyTable($header, $data);
* echo $result; // No direct return value; table is rendered into the PDF document.
* @param {array} $header - Array of header titles (strings) for each column (expects 4 headers).
* @param {array} $data - Array of rows, each row is an array with 4 values: [string, string, numeric, numeric].
* @returns {void} No return value; the function renders the table into the active PDF page.
*/
function FancyTable($header, $data)
{
	// Colors, line width and bold font
	$this->SetFillColor(255,0,0);
	$this->SetTextColor(255);
	$this->SetDrawColor(128,0,0);
	$this->SetLineWidth(.3);
	$this->SetFont('','B');
	// Header
	$w = array(40, 35, 40, 45);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
	$this->Ln();
	// Color and font restoration
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	$this->SetFont('');
	// Data
	$fill = false;
	foreach($data as $row)
	{
		$this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
		$this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
		$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
		$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
		$this->Ln();
		$fill = !$fill;
	}
	// Closing line
	$this->Cell(array_sum($w),0,'','T');
}
}

$pdf = new PDF();
// Column headings
$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
// Data loading
$data = $pdf->LoadData('countries.txt');
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->BasicTable($header,$data);
$pdf->AddPage();
$pdf->ImprovedTable($header,$data);
$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Output();
?>
