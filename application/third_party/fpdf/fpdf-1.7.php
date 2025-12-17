<?php
/*******************************************************************************
* FPDF                                                                         *
*                                                                              *
* Version: 1.81                                                                *
* Date:    2015-12-20                                                          *
* Author:  Olivier PLATHEY                                                     *
*******************************************************************************/

define('FPDF_VERSION','1.81');

class FPDFT
{
protected $page;               // current page number
protected $n;                  // current object number
protected $offsets;            // array of object offsets
protected $buffer;             // buffer holding in-memory PDF
protected $pages;              // array containing pages
protected $state;              // current document state
protected $compress;           // compression flag
protected $k;                  // scale factor (number of points in user unit)
protected $DefOrientation;     // default orientation
protected $CurOrientation;     // current orientation
protected $StdPageSizes;       // standard page sizes
protected $DefPageSize;        // default page size
protected $CurPageSize;        // current page size
protected $CurRotation;        // current page rotation
protected $PageInfo;           // page-related data
protected $wPt, $hPt;          // dimensions of current page in points
protected $w, $h;              // dimensions of current page in user unit
protected $lMargin;            // left margin
protected $tMargin;            // top margin
protected $rMargin;            // right margin
protected $bMargin;            // page break margin
protected $cMargin;            // cell margin
protected $x, $y;              // current position in user unit
protected $lasth;              // height of last printed cell
protected $LineWidth;          // line width in user unit
protected $fontpath;           // path containing fonts
protected $CoreFonts;          // array of core font names
protected $fonts;              // array of used fonts
protected $FontFiles;          // array of font files
protected $encodings;          // array of encodings
protected $cmaps;              // array of ToUnicode CMaps
protected $FontFamily;         // current font family
protected $FontStyle;          // current font style
protected $underline;          // underlining flag
protected $CurrentFont;        // current font info
protected $FontSizePt;         // current font size in points
protected $FontSize;           // current font size in user unit
protected $DrawColor;          // commands for drawing color
protected $FillColor;          // commands for filling color
protected $TextColor;          // commands for text color
protected $ColorFlag;          // indicates whether fill and text colors are different
protected $WithAlpha;          // indicates whether alpha channel is used
protected $ws;                 // word spacing
protected $images;             // array of used images
protected $PageLinks;          // array of links in pages
protected $links;              // array of internal links
protected $AutoPageBreak;      // automatic page breaking
protected $PageBreakTrigger;   // threshold used to trigger page breaks
protected $InHeader;           // flag set when processing header
protected $InFooter;           // flag set when processing footer
protected $AliasNbPages;       // alias for total number of pages
protected $ZoomMode;           // zoom display mode
protected $LayoutMode;         // layout display mode
protected $metadata;           // document properties
protected $PDFVersion;         // PDF version number

/*******************************************************************************
*                               Public methods                                 *
*******************************************************************************/

function __construct($orientation='P', $unit='mm', $size='A4')
{
	// Some checks
	$this->_dochecks();
	// Initialization of properties
	$this->state = 0;
	$this->page = 0;
	$this->n = 2;
	$this->buffer = '';
	$this->pages = array();
	$this->PageInfo = array();
	$this->fonts = array();
	$this->FontFiles = array();
	$this->encodings = array();
	$this->cmaps = array();
	$this->images = array();
	$this->links = array();
	$this->InHeader = false;
	$this->InFooter = false;
	$this->lasth = 0;
	$this->FontFamily = '';
	$this->FontStyle = '';
	$this->FontSizePt = 12;
	$this->underline = false;
	$this->DrawColor = '0 G';
	$this->FillColor = '0 g';
	$this->TextColor = '0 g';
	$this->ColorFlag = false;
	$this->WithAlpha = false;
	$this->ws = 0;
	// Font path
	if(defined('FPDF_FONTPATH'))
	{
		$this->fontpath = FPDF_FONTPATH;
		if(substr($this->fontpath,-1)!='/' && substr($this->fontpath,-1)!='\\')
			$this->fontpath .= '/';
	}
	elseif(is_dir(dirname(__FILE__).'/font'))
		$this->fontpath = dirname(__FILE__).'/font/';
	else
		$this->fontpath = '';
	// Core fonts
	$this->CoreFonts = array('courier', 'helvetica', 'times', 'symbol', 'zapfdingbats');
	// Scale factor
	if($unit=='pt')
		$this->k = 1;
	elseif($unit=='mm')
		$this->k = 72/25.4;
	elseif($unit=='cm')
		$this->k = 72/2.54;
	elseif($unit=='in')
		$this->k = 72;
	else
		$this->Error('Incorrect unit: '.$unit);
	// Page sizes
	$this->StdPageSizes = array('a3'=>array(841.89,1190.55), 'a4'=>array(595.28,841.89), 'a5'=>array(420.94,595.28),
		'letter'=>array(612,792), 'legal'=>array(612,1008));
	$size = $this->_getpagesize($size);
	$this->DefPageSize = $size;
	$this->CurPageSize = $size;
	// Page orientation
	$orientation = strtolower($orientation);
	if($orientation=='p' || $orientation=='portrait')
	{
		$this->DefOrientation = 'P';
		$this->w = $size[0];
		$this->h = $size[1];
	}
	elseif($orientation=='l' || $orientation=='landscape')
	{
		$this->DefOrientation = 'L';
		$this->w = $size[1];
		$this->h = $size[0];
	}
	else
		$this->Error('Incorrect orientation: '.$orientation);
	$this->CurOrientation = $this->DefOrientation;
	$this->wPt = $this->w*$this->k;
	$this->hPt = $this->h*$this->k;
	// Page rotation
	$this->CurRotation = 0;
	// Page margins (1 cm)
	$margin = 28.35/$this->k;
	$this->SetMargins($margin,$margin);
	// Interior cell margin (1 mm)
	$this->cMargin = $margin/10;
	// Line width (0.2 mm)
	$this->LineWidth = .567/$this->k;
	// Automatic page break
	$this->SetAutoPageBreak(true,2*$margin);
	// Default display mode
	$this->SetDisplayMode('default');
	// Enable compression
	$this->SetCompression(true);
	// Set default PDF version number
	$this->PDFVersion = '1.3';
}

function SetMargins($left, $top, $right=null)
{
	// Set left, top and right margins
	$this->lMargin = $left;
	$this->tMargin = $top;
	if($right===null)
		$right = $left;
	$this->rMargin = $right;
}

function SetLeftMargin($margin)
{
	// Set left margin
	$this->lMargin = $margin;
	if($this->page>0 && $this->x<$margin)
		$this->x = $margin;
}

function SetTopMargin($margin)
{
	// Set top margin
	$this->tMargin = $margin;
}

function SetRightMargin($margin)
{
	// Set right margin
	$this->rMargin = $margin;
}

function SetAutoPageBreak($auto, $margin=0)
{
	// Set auto page break mode and triggering margin
	$this->AutoPageBreak = $auto;
	$this->bMargin = $margin;
	$this->PageBreakTrigger = $this->h-$margin;
}

/**
* Set the viewer display mode for zoom and page layout.
* @example
* $pdf = new FPDF();
* $pdf->SetDisplayMode('fullpage', 'single');
* // Example: sets ZoomMode to 'fullpage' and LayoutMode to 'single' on the $pdf instance.
* @param {string|mixed} $zoom - Zoom mode to use: 'fullpage', 'fullwidth', 'real', 'default' or any non-string value (non-string values are accepted).
* @param {string} $layout - Layout mode to use: 'single', 'continuous', 'two' or 'default'.
* @returns {void} No return value; updates internal ZoomMode and LayoutMode or triggers an error if an invalid string value is provided.
*/
function SetDisplayMode($zoom, $layout='default')
{
	// Set display mode in viewer
	if($zoom=='fullpage' || $zoom=='fullwidth' || $zoom=='real' || $zoom=='default' || !is_string($zoom))
		$this->ZoomMode = $zoom;
	else
		$this->Error('Incorrect zoom display mode: '.$zoom);
	if($layout=='single' || $layout=='continuous' || $layout=='two' || $layout=='default')
		$this->LayoutMode = $layout;
	else
		$this->Error('Incorrect layout display mode: '.$layout);
}

function SetCompression($compress)
{
	// Set page compression
	if(function_exists('gzcompress'))
		$this->compress = $compress;
	else
		$this->compress = false;
}

function SetTitle($title, $isUTF8=false)
{
	// Title of document
	$this->metadata['Title'] = $isUTF8 ? $title : utf8_encode($title);
}

function SetAuthor($author, $isUTF8=false)
{
	// Author of document
	$this->metadata['Author'] = $isUTF8 ? $author : utf8_encode($author);
}

function SetSubject($subject, $isUTF8=false)
{
	// Subject of document
	$this->metadata['Subject'] = $isUTF8 ? $subject : utf8_encode($subject);
}

function SetKeywords($keywords, $isUTF8=false)
{
	// Keywords of document
	$this->metadata['Keywords'] = $isUTF8 ? $keywords : utf8_encode($keywords);
}

function SetCreator($creator, $isUTF8=false)
{
	// Creator of document
	$this->metadata['Creator'] = $isUTF8 ? $creator : utf8_encode($creator);
}

function AliasNbPages($alias='{nb}')
{
	// Define an alias for total number of pages
	$this->AliasNbPages = $alias;
}

function Error($msg)
{
	// Fatal error
	throw new Exception('FPDF error: '.$msg);
}

/**
* Close the PDF document: ensure at least one page, invoke the footer, finish the current page and finalize the document.
* @example
* $pdf = new FPDF();
* $pdf->AddPage();
* // ... add content ...
* $pdf->Close();
* echo $pdf->state; // sample output: 3 (document closed)
* @param {void} $none - No arguments.
* @returns {void} Document is finalized and no value is returned.
*/
function Close()
{
	// Terminate document
	if($this->state==3)
		return;
	if($this->page==0)
		$this->AddPage();
	// Page footer
	$this->InFooter = true;
	$this->Footer();
	$this->InFooter = false;
	// Close page
	$this->_endpage();
	// Close document
	$this->_enddoc();
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
function PrintChapter($num, $title, $file)
{
  
    $this->ChapterTitle($num,$title);
}

/**
* AddPage — Start a new page in the PDF document (handles header/footer and restores graphics state).
* @example
* $pdf = new FPDF();
* $pdf->AddPage('P', 'A4', 0);
* // Adds a portrait A4 page, triggers Header() and Footer() callbacks, and restores drawing/font/color state. No return value.
* @param {string} $orientation - Page orientation ('P' for portrait, 'L' for landscape). Empty string uses the current orientation.
* @param {string} $size - Page size (e.g. 'A4', 'Letter') or custom size identifier. Empty string uses the current size.
* @param {int} $rotation - Page rotation in degrees (0, 90, 180, 270). Default is 0.
* @returns {void} No return value; the method appends a new page to the PDF document.
*/
function AddPage($orientation='', $size='', $rotation=0)
{
	// Start a new page
	if($this->state==3)
		$this->Error('The document is closed');
	$family = $this->FontFamily;
	$style = $this->FontStyle.($this->underline ? 'U' : '');
	$fontsize = $this->FontSizePt;
	$lw = $this->LineWidth;
	$dc = $this->DrawColor;
	$fc = $this->FillColor;
	$tc = $this->TextColor;
	$cf = $this->ColorFlag;
	if($this->page>0)
	{
		// Page footer
		$this->InFooter = true;
		$this->Footer();
		$this->InFooter = false;
		// Close page
		$this->_endpage();
	}
	// Start new page
	$this->_beginpage($orientation,$size,$rotation);
	// Set line cap style to square
	$this->_out('2 J');
	// Set line width
	$this->LineWidth = $lw;
	$this->_out(sprintf('%.2F w',$lw*$this->k));
	// Set font
	if($family)
		$this->SetFont($family,$style,$fontsize);
	// Set colors
	$this->DrawColor = $dc;
	if($dc!='0 G')
		$this->_out($dc);
	$this->FillColor = $fc;
	if($fc!='0 g')
		$this->_out($fc);
	$this->TextColor = $tc;
	$this->ColorFlag = $cf;
	// Page header
	$this->InHeader = true;
	$this->Header();
	$this->InHeader = false;
	// Restore line width
	if($this->LineWidth!=$lw)
	{
		$this->LineWidth = $lw;
		$this->_out(sprintf('%.2F w',$lw*$this->k));
	}
	// Restore font
	if($family)
		$this->SetFont($family,$style,$fontsize);
	// Restore colors
	if($this->DrawColor!=$dc)
	{
		$this->DrawColor = $dc;
		$this->_out($dc);
	}
	if($this->FillColor!=$fc)
	{
		$this->FillColor = $fc;
		$this->_out($fc);
	}
	$this->TextColor = $tc;
	$this->ColorFlag = $cf;
}

/**
* Render the page header for a proforma invoice (adds title, colors and a horizontal rule).
* @example
* $pdf = new PDF(); // PDF is a class that extends FPDF and includes this Header() override
* $pdf->AddPage(); // Header() is invoked automatically when a new page is added
* $pdf->Output('I', 'proforma-invoice.pdf'); // sends the generated PDF inline to the browser
* @param void $none - No parameters.
* @returns void Header is drawn directly onto the current PDF page; nothing is returned.
*/
function Header()
{
	// Logo
    // Arial bold 15
    $this->SetFont('Arial','B',11);
    // Move to the right
    $this->Cell(80);
    // Title
	$this->SetDrawColor(0, 0, 127);
	$this->SetFillColor(0, 0, 255);
	$this->SetTextColor(0, 0, 255);
    $this->Cell(30,10,'PROFORMA INVOICE',0,0,'C');
   $this->SetDrawColor(188,188,188);
	$this->Line(10,20,200,20);
    $this->Ln(20);
}

function Footer()
{
	$this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
	$this->SetDrawColor(188,188,188);
	
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	$this->Line(20,280,190,280);
}

function PageNo()
{
	// Get current page number
	return $this->page;
}

function SetDrawColor($r, $g=null, $b=null)
{
	// Set color for all stroking operations
	if(($r==0 && $g==0 && $b==0) || $g===null)
		$this->DrawColor = sprintf('%.3F G',$r/255);
	else
		$this->DrawColor = sprintf('%.3F %.3F %.3F RG',$r/255,$g/255,$b/255);
	if($this->page>0)
		$this->_out($this->DrawColor);
}

function SetFillColor($r, $g=null, $b=null)
{
	// Set color for all filling operations
	if(($r==0 && $g==0 && $b==0) || $g===null)
		$this->FillColor = sprintf('%.3F g',$r/255);
	else
		$this->FillColor = sprintf('%.3F %.3F %.3F rg',$r/255,$g/255,$b/255);
	$this->ColorFlag = ($this->FillColor!=$this->TextColor);
	if($this->page>0)
		$this->_out($this->FillColor);
}

function SetTextColor($r, $g=null, $b=null)
{
	// Set color for text
	if(($r==0 && $g==0 && $b==0) || $g===null)
		$this->TextColor = sprintf('%.3F g',$r/255);
	else
		$this->TextColor = sprintf('%.3F %.3F %.3F rg',$r/255,$g/255,$b/255);
	$this->ColorFlag = ($this->FillColor!=$this->TextColor);
}

function GetStringWidth($s)
{
	// Get width of a string in the current font
	$s = (string)$s;
	$cw = &$this->CurrentFont['cw'];
	$w = 0;
	$l = strlen($s);
	for($i=0;$i<$l;$i++)
		$w += $cw[$s[$i]];
	return $w*$this->FontSize/1000;
}

function SetLineWidth($width)
{
	// Set line width
	$this->LineWidth = $width;
	if($this->page>0)
		$this->_out(sprintf('%.2F w',$width*$this->k));
}

function Line($x1, $y1, $x2, $y2)
{
	// Draw a line
	$this->_out(sprintf('%.2F %.2F m %.2F %.2F l S',$x1*$this->k,($this->h-$y1)*$this->k,$x2*$this->k,($this->h-$y2)*$this->k));
}

function Rect($x, $y, $w, $h, $style='')
{
	// Draw a rectangle
	if($style=='F')
		$op = 'f';
	elseif($style=='FD' || $style=='DF')
		$op = 'B';
	else
		$op = 'S';
	$this->_out(sprintf('%.2F %.2F %.2F %.2F re %s',$x*$this->k,($this->h-$y)*$this->k,$w*$this->k,-$h*$this->k,$op));
}

/**
* Add a TrueType, OpenType or Type1 font to the PDF instance.
* @example
* $pdf = new FPDF();
* $result = $pdf->AddFont('DejaVu Sans', 'B');
* echo $result // null (no return; the font is registered in the PDF instance)
* @param {string} $family - Font family name (case-insensitive), e.g. 'Arial' or 'DejaVu Sans'.
* @param {string} $style - Optional font style ('' | 'B' | 'I' | 'U' | 'BI'); 'IB' will be normalized to 'BI'. Default: ''.
* @param {string} $file - Optional font definition PHP filename relative to the font directory; if omitted it's derived from the family and style (e.g. 'dejavusansb.php').
* @returns {void} Registers the font in $this->fonts and, if embedded, adds file info to $this->FontFiles; no value is returned.
*/
function AddFont($family, $style='', $file='')
{
	// Add a TrueType, OpenType or Type1 font
	$family = strtolower($family);
	if($file=='')
		$file = str_replace(' ','',$family).strtolower($style).'.php';
	$style = strtoupper($style);
	if($style=='IB')
		$style = 'BI';
	$fontkey = $family.$style;
	if(isset($this->fonts[$fontkey]))
		return;
	$info = $this->_loadfont($file);
	$info['i'] = count($this->fonts)+1;
	if(!empty($info['file']))
	{
		// Embedded font
		if($info['type']=='TrueType')
			$this->FontFiles[$info['file']] = array('length1'=>$info['originalsize']);
		else
			$this->FontFiles[$info['file']] = array('length1'=>$info['size1'], 'length2'=>$info['size2']);
	}
	$this->fonts[$fontkey] = $info;
}

/**
* Select and set the current font for PDF output; size is given in points.
* @example
* $pdf = new FPDF();
* $pdf->AddPage();
* $pdf->SetFont('Arial','B',12);
* $pdf->Cell(40,10,'Hello World!');
* $pdf->Output(); // outputs a PDF with "Hello World!" in Helvetica Bold 12pt
* @param string $family - Font family name (e.g. 'Arial', 'Times', 'Symbol'). If empty, the current family is kept.
* @param string $style - Font style flags: combination of 'B' (bold), 'I' (italic), 'U' (underline). 'IB' is normalized to 'BI'. Default is ''.
* @param float|int $size - Font size in points. If 0, the current font size is used.
* @returns void Sets the font on the FPDF instance; no return value.
*/
function SetFont($family, $style='', $size=0)
{
	// Select a font; size given in points
	if($family=='')
		$family = $this->FontFamily;
	else
		$family = strtolower($family);
	$style = strtoupper($style);
	if(strpos($style,'U')!==false)
	{
		$this->underline = true;
		$style = str_replace('U','',$style);
	}
	else
		$this->underline = false;
	if($style=='IB')
		$style = 'BI';
	if($size==0)
		$size = $this->FontSizePt;
	// Test if font is already selected
	if($this->FontFamily==$family && $this->FontStyle==$style && $this->FontSizePt==$size)
		return;
	// Test if font is already loaded
	$fontkey = $family.$style;
	if(!isset($this->fonts[$fontkey]))
	{
		// Test if one of the core fonts
		if($family=='arial')
			$family = 'helvetica';
		if(in_array($family,$this->CoreFonts))
		{
			if($family=='symbol' || $family=='zapfdingbats')
				$style = '';
			$fontkey = $family.$style;
			if(!isset($this->fonts[$fontkey]))
				$this->AddFont($family,$style);
		}
		else
			$this->Error('Undefined font: '.$family.' '.$style);
	}
	// Select it
	$this->FontFamily = $family;
	$this->FontStyle = $style;
	$this->FontSizePt = $size;
	$this->FontSize = $size/$this->k;
	$this->CurrentFont = &$this->fonts[$fontkey];
	if($this->page>0)
		$this->_out(sprintf('BT /F%d %.2F Tf ET',$this->CurrentFont['i'],$this->FontSizePt));
}

function SetFontSize($size)
{
	// Set font size in points
	if($this->FontSizePt==$size)
		return;
	$this->FontSizePt = $size;
	$this->FontSize = $size/$this->k;
	if($this->page>0)
		$this->_out(sprintf('BT /F%d %.2F Tf ET',$this->CurrentFont['i'],$this->FontSizePt));
}

function AddLink()
{
	// Create a new internal link
	$n = count($this->links)+1;
	$this->links[$n] = array(0, 0);
	return $n;
}

function SetLink($link, $y=0, $page=-1)
{
	// Set destination of internal link
	if($y==-1)
		$y = $this->y;
	if($page==-1)
		$page = $this->page;
	$this->links[$link] = array($page, $y);
}

function Link($x, $y, $w, $h, $link)
{
	// Put a link on the page
	$this->PageLinks[$this->page][] = array($x*$this->k, $this->hPt-$y*$this->k, $w*$this->k, $h*$this->k, $link);
}

/**
* Print a text string at a specified position on the current PDF page using the currently selected font and text settings (supports underline and text color).
* @example
* $pdf = new FPDF();
* $pdf->AddPage();
* $pdf->SetFont('Arial','',12);
* // Place the text "Hello World" at X=10, Y=20 (user units, typically mm)
* $pdf->Text(10.0, 20.0, 'Hello World');
* @param float $x - X coordinate (in user units, typically mm) where the text will start.
* @param float $y - Y coordinate (in user units, typically mm) where the text baseline will be placed.
* @param string $txt - The text string to output; special characters are escaped automatically.
* @returns void Returns nothing; the text is written directly to the PDF output buffer.
*/
function Text($x, $y, $txt)
{
	// Output a string
	if(!isset($this->CurrentFont))
		$this->Error('No font has been set');
	$s = sprintf('BT %.2F %.2F Td (%s) Tj ET',$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
	if($this->underline && $txt!='')
		$s .= ' '.$this->_dounderline($x,$y,$txt);
	if($this->ColorFlag)
		$s = 'q '.$this->TextColor.' '.$s.' Q';
	$this->_out($s);
}

function AcceptPageBreak()
{
	// Accept automatic page break or not
	return $this->AutoPageBreak;
}

/**/ **
* Output a rectangular cell (optionally with text, border, fill and link) and advance the current position; handles automatic page breaks.
* @example
* // Add a 40x10 cell with centered text, a border, move to next line and add a link
* $this->Cell(40, 10, 'Hello World', 1, 1, 'C', false, 'https://example.com');
* // No direct return; the PDF content is modified (cell rendered on current page)
* @param float $w - Cell width in user units. If 0 the cell extends up to the right margin.
* @param float $h - Cell height in user units (default 0).
* @param string $txt - String to print inside the cell (default empty).
* @param int|string $border - 0 (no border), 1 (frame), or string containing any of 'L', 'T', 'R', 'B' to draw specific borders (default 0).
* @param int $ln - Indicates where the current position should go after the call: 0 to the right, 1 to the beginning of the next line, >1 below (default 0).
* @param string $align - Text alignment inside the cell: 'L', 'C', 'R' or '' for left (default '').
* @param bool $fill - Whether to draw a background fill (true) or not (false) (default false).
* @param string $link - URL or internal link identifier to attach to the cell text (default empty).
* @returns void Return description: Modifies the internal PDF buffer (no direct return value).
*/*/
function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
{
	// Output a cell
	$k = $this->k;
	if($this->y+$h>$this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak())
	{
		// Automatic page break
		$x = $this->x;
		$ws = $this->ws;
		if($ws>0)
		{
			$this->ws = 0;
			$this->_out('0 Tw');
		}
		$this->AddPage($this->CurOrientation,$this->CurPageSize,$this->CurRotation);
		$this->x = $x;
		if($ws>0)
		{
			$this->ws = $ws;
			$this->_out(sprintf('%.3F Tw',$ws*$k));
		}
	}
	if($w==0)
		$w = $this->w-$this->rMargin-$this->x;
	$s = '';
	if($fill || $border==1)
	{
		if($fill)
			$op = ($border==1) ? 'B' : 'f';
		else
			$op = 'S';
		$s = sprintf('%.2F %.2F %.2F %.2F re %s ',$this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
	}
	if(is_string($border))
	{
		$x = $this->x;
		$y = $this->y;
		if(strpos($border,'L')!==false)
			$s .= sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
		if(strpos($border,'T')!==false)
			$s .= sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
		if(strpos($border,'R')!==false)
			$s .= sprintf('%.2F %.2F m %.2F %.2F l S ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
		if(strpos($border,'B')!==false)
			$s .= sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
	}
	if($txt!=='')
	{
		if(!isset($this->CurrentFont))
			$this->Error('No font has been set');
		if($align=='R')
			$dx = $w-$this->cMargin-$this->GetStringWidth($txt);
		elseif($align=='C')
			$dx = ($w-$this->GetStringWidth($txt))/2;
		else
			$dx = $this->cMargin;
		if($this->ColorFlag)
			$s .= 'q '.$this->TextColor.' ';
		$s .= sprintf('BT %.2F %.2F Td (%s) Tj ET',($this->x+$dx)*$k,($this->h-($this->y+.5*$h+.3*$this->FontSize))*$k,$this->_escape($txt));
		if($this->underline)
			$s .= ' '.$this->_dounderline($this->x+$dx,$this->y+.5*$h+.3*$this->FontSize,$txt);
		if($this->ColorFlag)
			$s .= ' Q';
		if($link)
			$this->Link($this->x+$dx,$this->y+.5*$h-.5*$this->FontSize,$this->GetStringWidth($txt),$this->FontSize,$link);
	}
	if($s)
		$this->_out($s);
	$this->lasth = $h;
	if($ln>0)
	{
		// Go to next line
		$this->y += $h;
		if($ln==1)
			$this->x = $this->lMargin;
	}
	else
		$this->x += $w;
}

/**
* Outputs a multi-line cell into the PDF with automatic or explicit line breaks and advances to the next line.
* @example
* $pdf->MultiCell(80,6,"This is a long example text that will be wrapped automatically across lines.",1,'J',false);
* // Renders wrapped text into the PDF and advances to the next line.
* @param {float} $w - Cell width. If 0, the cell extends to the right margin.
* @param {float} $h - Minimum cell height for each line.
* @param {string} $txt - Text to be printed; may contain "\n" for explicit line breaks.
* @param {int|string|bool} $border - Border specification: 0 (no border), 1 (full border), or a string containing any of 'L','R','T','B' to specify sides.
* @param {string} $align - Text alignment: 'L' (left), 'C' (center), 'R' (right), 'J' (justified). Default 'J'.
* @param {bool} $fill - Indicates whether to fill the cell background. Default false.
* @returns {void} Does not return a value; writes output directly to the PDF document.
*/
function MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false)
{
	// Output text with automatic or explicit line breaks
	if(!isset($this->CurrentFont))
		$this->Error('No font has been set');
	$cw = &$this->CurrentFont['cw'];
	if($w==0)
		$w = $this->w-$this->rMargin-$this->x;
	$wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
	$s = str_replace("\r",'',$txt);
	$nb = strlen($s);
	if($nb>0 && $s[$nb-1]=="\n")
		$nb--;
	$b = 0;
	if($border)
	{
		if($border==1)
		{
			$border = 'LTRB';
			$b = 'LRT';
			$b2 = 'LR';
		}
		else
		{
			$b2 = '';
			if(strpos($border,'L')!==false)
				$b2 .= 'L';
			if(strpos($border,'R')!==false)
				$b2 .= 'R';
			$b = (strpos($border,'T')!==false) ? $b2.'T' : $b2;
		}
	}
	$sep = -1;
	$i = 0;
	$j = 0;
	$l = 0;
	$ns = 0;
	$nl = 1;
	while($i<$nb)
	{
		// Get next character
		$c = $s[$i];
		if($c=="\n")
		{
			// Explicit line break
			if($this->ws>0)
			{
				$this->ws = 0;
				$this->_out('0 Tw');
			}
			$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
			$i++;
			$sep = -1;
			$j = $i;
			$l = 0;
			$ns = 0;
			$nl++;
			if($border && $nl==2)
				$b = $b2;
			continue;
		}
		if($c==' ')
		{
			$sep = $i;
			$ls = $l;
			$ns++;
		}
		$l += $cw[$c];
		if($l>$wmax)
		{
			// Automatic line break
			if($sep==-1)
			{
				if($i==$j)
					$i++;
				if($this->ws>0)
				{
					$this->ws = 0;
					$this->_out('0 Tw');
				}
				$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
			}
			else
			{
				if($align=='J')
				{
					$this->ws = ($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
					$this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
				}
				$this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
				$i = $sep+1;
			}
			$sep = -1;
			$j = $i;
			$l = 0;
			$ns = 0;
			$nl++;
			if($border && $nl==2)
				$b = $b2;
		}
		else
			$i++;
	}
	// Last chunk
	if($this->ws>0)
	{
		$this->ws = 0;
		$this->_out('0 Tw');
	}
	if($border && strpos($border,'B')!==false)
		$b .= 'B';
	$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
	$this->x = $this->lMargin;
}

/**
* Write text in flowing mode: outputs the given text into the PDF, performing automatic line wrapping and handling explicit newlines; an optional link can be attached to the text.
* @example
* $pdf = new FPDF();
* $pdf->AddPage();
* $pdf->SetFont('Arial','',12);
* $pdf->Write(5, "This is a long text that will wrap automatically across lines.", "http://example.com");
* // Writes the text to the current position in the PDF (no return value).
* @param float $h - Line height (height of each line in user units).
* @param string $txt - Text string to output; supports newline characters and automatic wrapping.
* @param string $link - Optional URL or internal link identifier to apply to the written text (default: '').
* @returns void No return value; content is written directly to the PDF document.
*/
function Write($h, $txt, $link='')
{
	// Output text in flowing mode
	if(!isset($this->CurrentFont))
		$this->Error('No font has been set');
	$cw = &$this->CurrentFont['cw'];
	$w = $this->w-$this->rMargin-$this->x;
	$wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
	$s = str_replace("\r",'',$txt);
	$nb = strlen($s);
	$sep = -1;
	$i = 0;
	$j = 0;
	$l = 0;
	$nl = 1;
	while($i<$nb)
	{
		// Get next character
		$c = $s[$i];
		if($c=="\n")
		{
			// Explicit line break
			$this->Cell($w,$h,substr($s,$j,$i-$j),0,2,'',false,$link);
			$i++;
			$sep = -1;
			$j = $i;
			$l = 0;
			if($nl==1)
			{
				$this->x = $this->lMargin;
				$w = $this->w-$this->rMargin-$this->x;
				$wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
			}
			$nl++;
			continue;
		}
		if($c==' ')
			$sep = $i;
		$l += $cw[$c];
		if($l>$wmax)
		{
			// Automatic line break
			if($sep==-1)
			{
				if($this->x>$this->lMargin)
				{
					// Move to next line
					$this->x = $this->lMargin;
					$this->y += $h;
					$w = $this->w-$this->rMargin-$this->x;
					$wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
					$i++;
					$nl++;
					continue;
				}
				if($i==$j)
					$i++;
				$this->Cell($w,$h,substr($s,$j,$i-$j),0,2,'',false,$link);
			}
			else
			{
				$this->Cell($w,$h,substr($s,$j,$sep-$j),0,2,'',false,$link);
				$i = $sep+1;
			}
			$sep = -1;
			$j = $i;
			$l = 0;
			if($nl==1)
			{
				$this->x = $this->lMargin;
				$w = $this->w-$this->rMargin-$this->x;
				$wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
			}
			$nl++;
		}
		else
			$i++;
	}
	// Last chunk
	if($i!=$j)
		$this->Cell($l/1000*$this->FontSize,$h,substr($s,$j),0,0,'',false,$link);
}

function Ln($h=null)
{
	// Line feed; default value is the last cell height
	$this->x = $this->lMargin;
	if($h===null)
		$this->y += $this->lasth;
	else
		$this->y += $h;
}

/**
 * Place an image on the current PDF page.
 * Supports automatic sizing, DPI-based negative sizes, automatic page breaks in flowing mode, and optional clickable links.
 * @example
 * $pdf = new FPDF();
 * $pdf->AddPage();
 * // Place 'logo.png' at x=10mm, y=20mm, width=50mm (height auto), PNG type inferred, clickable to example.com
 * $pdf->Image('images/logo.png', 10, 20, 50, 0, 'png', 'https://example.com');
 * @param string $file - Path to the image file. Required. Example: 'images/logo.png'
 * @param float|null $x - X position in user units. If null uses current x. Example: 10
 * @param float|null $y - Y position in user units. If null uses current y and enables flowing mode (may trigger automatic page break). Example: 20
 * @param float $w - Width in user units. 0 = auto-calculate, negative = treat as DPI (e.g. -96 for 96 DPI). Example: 50
 * @param float $h - Height in user units. 0 = auto-calculate, negative = treat as DPI. Example: 0
 * @param string $type - Image type/extension (e.g. 'jpg', 'png', 'gif'). If empty, inferred from filename. Example: 'png'
 * @param string $link - Optional URL or internal link target to make the image clickable. Example: 'https://example.com'
 * @returns void Does not return a value; writes image drawing operations into the PDF output.
 */
function Image($file, $x=null, $y=null, $w=0, $h=0, $type='', $link='')
{
	// Put an image on the page
	if($file=='')
		$this->Error('Image file name is empty');
	if(!isset($this->images[$file]))
	{
		// First use of this image, get info
		if($type=='')
		{
			$pos = strrpos($file,'.');
			if(!$pos)
				$this->Error('Image file has no extension and no type was specified: '.$file);
			$type = substr($file,$pos+1);
		}
		$type = strtolower($type);
		if($type=='jpeg')
			$type = 'jpg';
		$mtd = '_parse'.$type;
		if(!method_exists($this,$mtd))
			$this->Error('Unsupported image type: '.$type);
		$info = $this->$mtd($file);
		$info['i'] = count($this->images)+1;
		$this->images[$file] = $info;
	}
	else
		$info = $this->images[$file];

	// Automatic width and height calculation if needed
	if($w==0 && $h==0)
	{
		// Put image at 96 dpi
		$w = -96;
		$h = -96;
	}
	if($w<0)
		$w = -$info['w']*72/$w/$this->k;
	if($h<0)
		$h = -$info['h']*72/$h/$this->k;
	if($w==0)
		$w = $h*$info['w']/$info['h'];
	if($h==0)
		$h = $w*$info['h']/$info['w'];

	// Flowing mode
	if($y===null)
	{
		if($this->y+$h>$this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak())
		{
			// Automatic page break
			$x2 = $this->x;
			$this->AddPage($this->CurOrientation,$this->CurPageSize,$this->CurRotation);
			$this->x = $x2;
		}
		$y = $this->y;
		$this->y += $h;
	}

	if($x===null)
		$x = $this->x;
	$this->_out(sprintf('q %.2F 0 0 %.2F %.2F %.2F cm /I%d Do Q',$w*$this->k,$h*$this->k,$x*$this->k,($this->h-($y+$h))*$this->k,$info['i']));
	if($link)
		$this->Link($x,$y,$w,$h,$link);
}

function GetPageWidth()
{
	// Get current page width
	return $this->w;
}

function GetPageHeight()
{
	// Get current page height
	return $this->h;
}

function GetX()
{
	// Get x position
	return $this->x;
}

function SetX($x)
{
	// Set x position
	if($x>=0)
		$this->x = $x;
	else
		$this->x = $this->w+$x;
}

function GetY()
{
	// Get y position
	return $this->y;
}

function SetY($y, $resetX=true)
{
	// Set y position and optionally reset x
	if($y>=0)
		$this->y = $y;
	else
		$this->y = $this->h+$y;
	if($resetX)
		$this->x = $this->lMargin;
}

function SetXY($x, $y)
{
	// Set x and y positions
	$this->SetX($x);
	$this->SetY($y,false);
}

/**
* Output the generated PDF to a destination: inline to browser, force download, save to local file, or return as a string.
* @example
* // Inline to browser:
* $pdf->Output('I', 'report.pdf');
* // Force download:
* $pdf->Output('D', 'document.pdf');
* // Save to local file:
* $pdf->Output('F', '/path/to/output.pdf');
* // Return PDF as string:
* $content = $pdf->Output('S');
* echo substr($content, 0, 8); // "%PDF-1.4"
* @param string $dest - Destination: 'I' (inline), 'D' (download), 'F' (save to file), 'S' (return as string). Default 'I'.
* @param string $name - Filename for inline/download or path when saving to file. Default 'doc.pdf'.
* @param bool $isUTF8 - Whether $name is UTF-8 encoded (affects header encoding). Default false.
* @returns string Return PDF content when $dest == 'S', otherwise an empty string after output.
*/
function Output($dest='', $name='', $isUTF8=false)
{
	// Output PDF to some destination
	$this->Close();
	if(strlen($name)==1 && strlen($dest)!=1)
	{
		// Fix parameter order
		$tmp = $dest;
		$dest = $name;
		$name = $tmp;
	}
	if($dest=='')
		$dest = 'I';
	if($name=='')
		$name = 'doc.pdf';
	switch(strtoupper($dest))
	{
		case 'I':
			// Send to standard output
			$this->_checkoutput();
			if(PHP_SAPI!='cli')
			{
				// We send to a browser
				header('Content-Type: application/pdf');
				header('Content-Disposition: inline; '.$this->_httpencode('filename',$name,$isUTF8));
				header('Cache-Control: private, max-age=0, must-revalidate');
				header('Pragma: public');
			}
			echo $this->buffer;
			break;
		case 'D':
			// Download file
			$this->_checkoutput();
			header('Content-Type: application/x-download');
			header('Content-Disposition: attachment; '.$this->_httpencode('filename',$name,$isUTF8));
			header('Cache-Control: private, max-age=0, must-revalidate');
			header('Pragma: public');
			echo $this->buffer;
			break;
		case 'F':
			// Save to local file
			if(!file_put_contents($name,$this->buffer))
				$this->Error('Unable to create output file: '.$name);
			break;
		case 'S':
			// Return as a string
			return $this->buffer;
		default:
			$this->Error('Incorrect output destination: '.$dest);
	}
	return '';
}

/*******************************************************************************
*                              Protected methods                               *
*******************************************************************************/

protected function _dochecks()
{
	// Check mbstring overloading
	if(ini_get('mbstring.func_overload') & 2)
		$this->Error('mbstring overloading must be disabled');
	// Ensure runtime magic quotes are disabled
	if(get_magic_quotes_runtime())
		@set_magic_quotes_runtime(0);
}

/**
* Check whether any output or headers have already been sent before delivering a PDF, and clean a BOM/whitespace-only output buffer if safe.
* @example
* $this->_checkoutput();
* // No output: method returns silently and PDF can be sent.
* // If headers were already sent or unexpected output exists, $this->Error(...) will be invoked.
* @returns {void} Does not return a value; may call $this->Error() when headers or unexpected output exist.
*/
protected function _checkoutput()
{
	if(PHP_SAPI!='cli')
	{
		if(headers_sent($file,$line))
			$this->Error("Some data has already been output, can't send PDF file (output started at $file:$line)");
	}
	if(ob_get_length())
	{
		// The output buffer is not empty
		if(preg_match('/^(\xEF\xBB\xBF)?\s*$/',ob_get_contents()))
		{
			// It contains only a UTF-8 BOM and/or whitespace, let's clean it
			ob_clean();
		}
		else
			$this->Error("Some data has already been output, can't send PDF file");
	}
}

/**
* Get canonical page size as a two-element array [width, height].
* @example
* $result = $this->_getpagesize('A4');
* print_r($result); // render some sample output e.g. Array ( [0] => 210 [1] => 297 )
* @param {string|array} $size - Page size name (string, e.g. 'A4') or numeric array [width, height] in the current unit.
* @returns {array} Return width and height as an array [width, height], with width <= height.
*/
protected function _getpagesize($size)
{
	if(is_string($size))
	{
		$size = strtolower($size);
		if(!isset($this->StdPageSizes[$size]))
			$this->Error('Unknown page size: '.$size);
		$a = $this->StdPageSizes[$size];
		return array($a[0]/$this->k, $a[1]/$this->k);
	}
	else
	{
		if($size[0]>$size[1])
			return array($size[1], $size[0]);
		else
			return $size;
	}
}

/**
* Begin a new PDF page: increments the internal page counter, initializes page content and state,
* resets the current position to margins, sets or updates page orientation, size and rotation,
* and records page information (size in points and rotation) when different from defaults.
* @example
* $pdf->_beginpage('P', 'A4', 0);
* // Starts a new portrait A4 page with no rotation
* @param string $orientation - Page orientation. Accepts '' to use the default, or values like 'P' (portrait) or 'L' (landscape); case-insensitive.
* @param string|array $size - Page size. Can be a standard size name (e.g. 'A4') or an array(width, height) in user units; use '' to apply the default page size.
* @param int $rotation - Page rotation in degrees. Must be a multiple of 90 (for example 0, 90, 180, 270). An error is raised for invalid rotation values.
* @returns void No return value; the method updates the object's internal page-related state.
*/
protected function _beginpage($orientation, $size, $rotation)
{
	$this->page++;
	$this->pages[$this->page] = '';
	$this->state = 2;
	$this->x = $this->lMargin;
	$this->y = $this->tMargin;
	$this->FontFamily = '';
	// Check page size and orientation
	if($orientation=='')
		$orientation = $this->DefOrientation;
	else
		$orientation = strtoupper($orientation[0]);
	if($size=='')
		$size = $this->DefPageSize;
	else
		$size = $this->_getpagesize($size);
	if($orientation!=$this->CurOrientation || $size[0]!=$this->CurPageSize[0] || $size[1]!=$this->CurPageSize[1])
	{
		// New size or orientation
		if($orientation=='P')
		{
			$this->w = $size[0];
			$this->h = $size[1];
		}
		else
		{
			$this->w = $size[1];
			$this->h = $size[0];
		}
		$this->wPt = $this->w*$this->k;
		$this->hPt = $this->h*$this->k;
		$this->PageBreakTrigger = $this->h-$this->bMargin;
		$this->CurOrientation = $orientation;
		$this->CurPageSize = $size;
	}
	if($orientation!=$this->DefOrientation || $size[0]!=$this->DefPageSize[0] || $size[1]!=$this->DefPageSize[1])
		$this->PageInfo[$this->page]['size'] = array($this->wPt, $this->hPt);
	if($rotation!=0)
	{
		if($rotation%90!=0)
			$this->Error('Incorrect rotation value: '.$rotation);
		$this->CurRotation = $rotation;
		$this->PageInfo[$this->page]['rotation'] = $rotation;
	}
}

protected function _endpage()
{
	$this->state = 1;
}

/**
 * Load a font definition file from the configured font directory and return its defined variables.
 * @example
 * $result = $this->_loadfont('arial.php');
 * echo $result['name']; // render some sample output value; e.g. "Arial"
 * @param string $font - Font definition file name (e.g. 'arial.php'). Must not contain '/' or '\' characters.
 * @returns array Return associative array of font definition variables (for example: 'name', 'type', 'file', 'size', 'up', 'ut', 'cw', 'enc', 'subsetted').
 */
protected function _loadfont($font)
{
	// Load a font definition file from the font directory
	if(strpos($font,'/')!==false || strpos($font,"\\")!==false)
		$this->Error('Incorrect font definition file name: '.$font);
	include($this->fontpath.$font);
	if(!isset($name))
		$this->Error('Could not include font definition file');
	if(isset($enc))
		$enc = strtolower($enc);
	if(!isset($subsetted))
		$subsetted = false;
	return get_defined_vars();
}

protected function _isascii($s)
{
	// Test if string is ASCII
	$nb = strlen($s);
	for($i=0;$i<$nb;$i++)
	{
		if(ord($s[$i])>127)
			return false;
	}
	return true;
}

/**
* Encode an HTTP header field parameter, returning either a quoted ASCII value or an RFC5987-style UTF-8 percent-encoded value, with special handling for older MSIE user agents.
* @example
* $result = $this->_httpencode('filename', 'résumé.pdf', true);
* echo $result // e.g. filename*=UTF-8''r%C3%A9sum%C3%A9.pdf
* @param {{string}} {$param} - Header parameter name (e.g., 'filename').
* @param {{string}} {$value} - Parameter value to encode.
* @param {{bool}} {$isUTF8} - Whether $value is already UTF-8 encoded (true) or needs conversion (false).
* @returns {{string}} Encoded header parameter string ready to append to an HTTP header.
*/
protected function _httpencode($param, $value, $isUTF8)
{
	// Encode HTTP header field parameter
	if($this->_isascii($value))
		return $param.'="'.$value.'"';
	if(!$isUTF8)
		$value = utf8_encode($value);
	if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE')!==false)
		return $param.'="'.rawurlencode($value).'"';
	else
		return $param."*=UTF-8''".rawurlencode($value);
}

/**
* Convert a UTF-8 encoded string to UTF-16BE encoded string with a BOM.
* @example
* $sample = "Hello €"; // contains ASCII characters and a 3-byte Euro sign
* $result = $this->_UTF8toUTF16($sample);
* echo bin2hex($result); // render some sample output value: "feff00480065006c006c006f20ac"
* @param string $s - UTF-8 encoded input string to convert.
* @returns string UTF-16BE encoded string prefixed with BOM ("\xFE\xFF").
*/
protected function _UTF8toUTF16($s)
{
	// Convert UTF-8 to UTF-16BE with BOM
	$res = "\xFE\xFF";
	$nb = strlen($s);
	$i = 0;
	while($i<$nb)
	{
		$c1 = ord($s[$i++]);
		if($c1>=224)
		{
			// 3-byte character
			$c2 = ord($s[$i++]);
			$c3 = ord($s[$i++]);
			$res .= chr((($c1 & 0x0F)<<4) + (($c2 & 0x3C)>>2));
			$res .= chr((($c2 & 0x03)<<6) + ($c3 & 0x3F));
		}
		elseif($c1>=192)
		{
			// 2-byte character
			$c2 = ord($s[$i++]);
			$res .= chr(($c1 & 0x1C)>>2);
			$res .= chr((($c1 & 0x03)<<6) + ($c2 & 0x3F));
		}
		else
		{
			// Single-byte character
			$res .= "\0".chr($c1);
		}
	}
	return $res;
}

protected function _escape($s)
{
	// Escape special characters
	if(strpos($s,'(')!==false || strpos($s,')')!==false || strpos($s,'\\')!==false || strpos($s,"\r")!==false)
		return str_replace(array('\\','(',')',"\r"), array('\\\\','\\(','\\)','\\r'), $s);
	else
		return $s;
}

protected function _textstring($s)
{
	// Format a text string
	if(!$this->_isascii($s))
		$s = $this->_UTF8toUTF16($s);
	return '('.$this->_escape($s).')';
}

protected function _dounderline($x, $y, $txt)
{
	// Underline text
	$up = $this->CurrentFont['up'];
	$ut = $this->CurrentFont['ut'];
	$w = $this->GetStringWidth($txt)+$this->ws*substr_count($txt,' ');
	return sprintf('%.2F %.2F %.2F %.2F re f',$x*$this->k,($this->h-($y-$up/1000*$this->FontSize))*$this->k,$w*$this->k,-$ut/1000*$this->FontSizePt);
}

/**
* Parse a JPEG file and return its width, height, color space, bits-per-component, filter and raw image data. Calls $this->Error() on missing/invalid files.
* @example
* $result = $this->_parsejpg('/var/www/html/images/photo.jpg');
* echo $result['w'].'x'.$result['h']; // render some sample output value; e.g. "800x600"
* @param {string} $file - Path to the JPEG file to parse.
* @returns {array} Return associative array with keys: 'w' (width), 'h' (height), 'cs' (color space, e.g. 'DeviceRGB'), 'bpc' (bits per component), 'f' (filter, e.g. 'DCTDecode'), 'data' (raw JPEG file contents).
*/
protected function _parsejpg($file)
{
	// Extract info from a JPEG file
	$a = getimagesize($file);
	if(!$a)
		$this->Error('Missing or incorrect image file: '.$file);
	if($a[2]!=2)
		$this->Error('Not a JPEG file: '.$file);
	if(!isset($a['channels']) || $a['channels']==3)
		$colspace = 'DeviceRGB';
	elseif($a['channels']==4)
		$colspace = 'DeviceCMYK';
	else
		$colspace = 'DeviceGray';
	$bpc = isset($a['bits']) ? $a['bits'] : 8;
	$data = file_get_contents($file);
	return array('w'=>$a[0], 'h'=>$a[1], 'cs'=>$colspace, 'bpc'=>$bpc, 'f'=>'DCTDecode', 'data'=>$data);
}

protected function _parsepng($file)
{
	// Extract info from a PNG file
	$f = fopen($file,'rb');
	if(!$f)
		$this->Error('Can\'t open image file: '.$file);
	$info = $this->_parsepngstream($f,$file);
	fclose($f);
	return $info;
}

/**
* Parse a PNG image stream and return an associative array with image parameters and image data suitable for embedding in a PDF.
* @example
* $f = fopen('path/to/image.png', 'rb');
* $info = $this->_parsepngstream($f, 'image.png');
* fclose($f);
* print_r($info); // sample output: Array ( [w] => 800 [h] => 600 [cs] => 'DeviceRGB' [bpc] => 8 [f] => 'FlateDecode' [dp] => '/Predictor 15 /Colors 3 /BitsPerComponent 8 /Columns 800' [pal] => '' [trns] => '' [data] => '(binary compressed string)' [smask] => '(binary compressed string)' )
* @param resource $f - Open file handle or stream resource containing PNG data.
* @param string $file - Original filename (used for error messages).
* @returns array Return associative array with keys: w (int width), h (int height), cs (string color space: DeviceGray/DeviceRGB/Indexed), bpc (int bits per component), f (string filter, e.g. 'FlateDecode'), dp (string decode parameters), pal (string palette data or ''), trns (mixed transparency info or ''), data (string compressed image data), smask (string compressed alpha mask, if present).
*/
protected function _parsepngstream($f, $file)
{
	// Check signature
	if($this->_readstream($f,8)!=chr(137).'PNG'.chr(13).chr(10).chr(26).chr(10))
		$this->Error('Not a PNG file: '.$file);

	// Read header chunk
	$this->_readstream($f,4);
	if($this->_readstream($f,4)!='IHDR')
		$this->Error('Incorrect PNG file: '.$file);
	$w = $this->_readint($f);
	$h = $this->_readint($f);
	$bpc = ord($this->_readstream($f,1));
	if($bpc>8)
		$this->Error('16-bit depth not supported: '.$file);
	$ct = ord($this->_readstream($f,1));
	if($ct==0 || $ct==4)
		$colspace = 'DeviceGray';
	elseif($ct==2 || $ct==6)
		$colspace = 'DeviceRGB';
	elseif($ct==3)
		$colspace = 'Indexed';
	else
		$this->Error('Unknown color type: '.$file);
	if(ord($this->_readstream($f,1))!=0)
		$this->Error('Unknown compression method: '.$file);
	if(ord($this->_readstream($f,1))!=0)
		$this->Error('Unknown filter method: '.$file);
	if(ord($this->_readstream($f,1))!=0)
		$this->Error('Interlacing not supported: '.$file);
	$this->_readstream($f,4);
	$dp = '/Predictor 15 /Colors '.($colspace=='DeviceRGB' ? 3 : 1).' /BitsPerComponent '.$bpc.' /Columns '.$w;

	// Scan chunks looking for palette, transparency and image data
	$pal = '';
	$trns = '';
	$data = '';
	do
	{
		$n = $this->_readint($f);
		$type = $this->_readstream($f,4);
		if($type=='PLTE')
		{
			// Read palette
			$pal = $this->_readstream($f,$n);
			$this->_readstream($f,4);
		}
		elseif($type=='tRNS')
		{
			// Read transparency info
			$t = $this->_readstream($f,$n);
			if($ct==0)
				$trns = array(ord(substr($t,1,1)));
			elseif($ct==2)
				$trns = array(ord(substr($t,1,1)), ord(substr($t,3,1)), ord(substr($t,5,1)));
			else
			{
				$pos = strpos($t,chr(0));
				if($pos!==false)
					$trns = array($pos);
			}
			$this->_readstream($f,4);
		}
		elseif($type=='IDAT')
		{
			// Read image data block
			$data .= $this->_readstream($f,$n);
			$this->_readstream($f,4);
		}
		elseif($type=='IEND')
			break;
		else
			$this->_readstream($f,$n+4);
	}
	while($n);

	if($colspace=='Indexed' && empty($pal))
		$this->Error('Missing palette in '.$file);
	$info = array('w'=>$w, 'h'=>$h, 'cs'=>$colspace, 'bpc'=>$bpc, 'f'=>'FlateDecode', 'dp'=>$dp, 'pal'=>$pal, 'trns'=>$trns);
	if($ct>=4)
	{
		// Extract alpha channel
		if(!function_exists('gzuncompress'))
			$this->Error('Zlib not available, can\'t handle alpha channel: '.$file);
		$data = gzuncompress($data);
		$color = '';
		$alpha = '';
		if($ct==4)
		{
			// Gray image
			$len = 2*$w;
			for($i=0;$i<$h;$i++)
			{
				$pos = (1+$len)*$i;
				$color .= $data[$pos];
				$alpha .= $data[$pos];
				$line = substr($data,$pos+1,$len);
				$color .= preg_replace('/(.)./s','$1',$line);
				$alpha .= preg_replace('/.(.)/s','$1',$line);
			}
		}
		else
		{
			// RGB image
			$len = 4*$w;
			for($i=0;$i<$h;$i++)
			{
				$pos = (1+$len)*$i;
				$color .= $data[$pos];
				$alpha .= $data[$pos];
				$line = substr($data,$pos+1,$len);
				$color .= preg_replace('/(.{3})./s','$1',$line);
				$alpha .= preg_replace('/.{3}(.)/s','$1',$line);
			}
		}
		unset($data);
		$data = gzcompress($color);
		$info['smask'] = gzcompress($alpha);
		$this->WithAlpha = true;
		if($this->PDFVersion<'1.4')
			$this->PDFVersion = '1.4';
	}
	$info['data'] = $data;
	return $info;
}

/**
* Read exactly $n bytes from a stream resource or raise an error if reading fails or EOF is reached early.
* @example
* $f = fopen('php://temp', 'r+');
* fwrite($f, "HelloWorld");
* rewind($f);
* $result = $this->_readstream($f, 10);
* echo $result; // HelloWorld
* @param {{resource}} {$f} - Stream resource to read from.
* @param {{int}} {$n} - Number of bytes to read from the stream.
* @returns {{string}} Return the bytes read as a string.
*/
protected function _readstream($f, $n)
{
	// Read n bytes from stream
	$res = '';
	while($n>0 && !feof($f))
	{
		$s = fread($f,$n);
		if($s===false)
			$this->Error('Error while reading stream');
		$n -= strlen($s);
		$res .= $s;
	}
	if($n>0)
		$this->Error('Unexpected end of stream');
	return $res;
}

protected function _readint($f)
{
	// Read a 4-byte integer from stream
	$a = unpack('Ni',$this->_readstream($f,4));
	return $a['i'];
}

/**
* Extract image information from a GIF file by converting it to PNG in-memory and parsing the PNG stream.
* @example
* $info = $this->_parsegif('/path/to/sample.gif');
* var_export($info); // e.g. array('w' => 200, 'h' => 100, 'cs' => 'RGB', 'bpc' => 8, 'f' => 'png');
* @param {string} $file - Path to the GIF file to parse.
* @returns {array} Parsed image information array (width, height, color space, bits per channel, format, etc.).
*/
protected function _parsegif($file)
{
	// Extract info from a GIF file (via PNG conversion)
	if(!function_exists('imagepng'))
		$this->Error('GD extension is required for GIF support');
	if(!function_exists('imagecreatefromgif'))
		$this->Error('GD has no GIF read support');
	$im = imagecreatefromgif($file);
	if(!$im)
		$this->Error('Missing or incorrect image file: '.$file);
	imageinterlace($im,0);
	ob_start();
	imagepng($im);
	$data = ob_get_clean();
	imagedestroy($im);
	$f = fopen('php://temp','rb+');
	if(!$f)
		$this->Error('Unable to create memory stream');
	fwrite($f,$data);
	rewind($f);
	$info = $this->_parsepngstream($f,$file);
	fclose($f);
	return $info;
}

/**
* Append a line to the PDF document output according to the current internal state.
* @example
* // ensure state is set to 2 (page buffer mode) to see direct page append
* $pdf->state = 2;
* $pdf->page = 1;
* $pdf->pages[$pdf->page] = '';
* $pdf->_out('Hello, world!');
* echo $pdf->pages[$pdf->page]; // outputs: Hello, world!\n
* @param {string} $s - The string content to add to the document (a newline will be appended when writing to the page buffer).
* @returns {void} No return value; modifies internal document buffers or raises an error if state is invalid.
*/
protected function _out($s)
{
	// Add a line to the document
	if($this->state==2)
		$this->pages[$this->page] .= $s."\n";
	elseif($this->state==1)
		$this->_put($s);
	elseif($this->state==0)
		$this->Error('No page has been added yet');
	elseif($this->state==3)
		$this->Error('The document is closed');
}

protected function _put($s)
{
	$this->buffer .= $s."\n";
}

protected function _getoffset()
{
	return strlen($this->buffer);
}

protected function _newobj($n=null)
{
	// Begin a new object
	if($n===null)
		$n = ++$this->n;
	$this->offsets[$n] = $this->_getoffset();
	$this->_put($n.' 0 obj');
}

protected function _putstream($data)
{
	$this->_put('stream');
	$this->_put($data);
	$this->_put('endstream');
}

/**
* Writes a PDF stream object into the document buffer, optionally compressing the stream using FlateDecode when $this->compress is true.
* @example
* // Example usage from inside an FPDF subclass (protected method)
* $stream = "BT /F1 12 Tf (Hello, PDF!) Tj ET\n";
* $pdf->_putstreamobject($stream);
* // After calling, the stream has been appended as a new PDF object in the internal buffer.
* @param string $data - Stream data (binary-safe) to be written into the PDF object.
* @returns void Writes a PDF object containing the stream with /Length and optional /Filter /FlateDecode entries to the output buffer.
*/
protected function _putstreamobject($data)
{
	if($this->compress)
	{
		$entries = '/Filter /FlateDecode ';
		$data = gzcompress($data);
	}
	else
		$entries = '';
	$entries .= '/Length '.strlen($data);
	$this->_newobj();
	$this->_put('<<'.$entries.'>>');
	$this->_putstream($data);
	$this->_put('endobj');
}

/**
* Write a single PDF page object (internal use) including MediaBox, rotation, resources, links/annotations, transparency group and content stream.
* @example
* // Typical internal usage after pages are created; page index is zero-based
* $pdf = new FPDF(); // FPDF instance with pages prepared
* $pdf->_putpage(0); // writes page 0 objects/streams into the PDF output buffer
* @param {int} $n - Zero-based page index identifying which page to write into the PDF file.
* @returns {void} No return value; the function emits PDF objects and a content stream to the internal output buffer.
*/
protected function _putpage($n)
{
	$this->_newobj();
	$this->_put('<</Type /Page');
	$this->_put('/Parent 1 0 R');
	if(isset($this->PageInfo[$n]['size']))
		$this->_put(sprintf('/MediaBox [0 0 %.2F %.2F]',$this->PageInfo[$n]['size'][0],$this->PageInfo[$n]['size'][1]));
	if(isset($this->PageInfo[$n]['rotation']))
		$this->_put('/Rotate '.$this->PageInfo[$n]['rotation']);
	$this->_put('/Resources 2 0 R');
	if(isset($this->PageLinks[$n]))
	{
		// Links
		$annots = '/Annots [';
		foreach($this->PageLinks[$n] as $pl)
		{
			$rect = sprintf('%.2F %.2F %.2F %.2F',$pl[0],$pl[1],$pl[0]+$pl[2],$pl[1]-$pl[3]);
			$annots .= '<</Type /Annot /Subtype /Link /Rect ['.$rect.'] /Border [0 0 0] ';
			if(is_string($pl[4]))
				$annots .= '/A <</S /URI /URI '.$this->_textstring($pl[4]).'>>>>';
			else
			{
				$l = $this->links[$pl[4]];
				if(isset($this->PageInfo[$l[0]]['size']))
					$h = $this->PageInfo[$l[0]]['size'][1];
				else
					$h = ($this->DefOrientation=='P') ? $this->DefPageSize[1]*$this->k : $this->DefPageSize[0]*$this->k;
				$annots .= sprintf('/Dest [%d 0 R /XYZ 0 %.2F null]>>',$this->PageInfo[$l[0]]['n'],$h-$l[1]*$this->k);
			}
		}
		$this->_put($annots.']');
	}
	if($this->WithAlpha)
		$this->_put('/Group <</Type /Group /S /Transparency /CS /DeviceRGB>>');
	$this->_put('/Contents '.($this->n+1).' 0 R>>');
	$this->_put('endobj');
	// Page content
	if(!empty($this->AliasNbPages))
		$this->pages[$n] = str_replace($this->AliasNbPages,$this->page,$this->pages[$n]);
	$this->_putstreamobject($this->pages[$n]);
}

/**
 * Assemble and write all page objects and the Pages root into the PDF object buffer.
 * @example
 * $pdf = new FPDF();
 * // simulate that two pages were created internally
 * $pdf->page = 2;
 * // protected method; typically called internally when finalizing the document
 * $pdf->_putpages();
 * // no direct return; internal PDF objects for pages and the /Pages root have been written
 * @param void $none - No arguments.
 * @returns void Writes page objects and the Pages root into the PDF buffer (no return value).
 */
protected function _putpages()
{
	$nb = $this->page;
	for($n=1;$n<=$nb;$n++)
		$this->PageInfo[$n]['n'] = $this->n+1+2*($n-1);
	for($n=1;$n<=$nb;$n++)
		$this->_putpage($n);
	// Pages root
	$this->_newobj(1);
	$this->_put('<</Type /Pages');
	$kids = '/Kids [';
	for($n=1;$n<=$nb;$n++)
		$kids .= $this->PageInfo[$n]['n'].' 0 R ';
	$this->_put($kids.']');
	$this->_put('/Count '.$nb);
	if($this->DefOrientation=='P')
	{
		$w = $this->DefPageSize[0];
		$h = $this->DefPageSize[1];
	}
	else
	{
		$w = $this->DefPageSize[1];
		$h = $this->DefPageSize[0];
	}
	$this->_put(sprintf('/MediaBox [0 0 %.2F %.2F]',$w*$this->k,$h*$this->k));
	$this->_put('>>');
	$this->_put('endobj');
}

/**
* Embed and write all font-related PDF objects (font files, encodings, ToUnicode CMaps, font dictionaries, widths and descriptors) into the PDF document.
* @example
* $this->_putfonts();
* // No direct output; updates the internal PDF object stream with embedded fonts.
* @param void $none - No parameters.
* @returns void No return value; writes objects to the internal PDF buffer.
*/
protected function _putfonts()
{
	foreach($this->FontFiles as $file=>$info)
	{
		// Font file embedding
		$this->_newobj();
		$this->FontFiles[$file]['n'] = $this->n;
		$font = file_get_contents($this->fontpath.$file,true);
		if(!$font)
			$this->Error('Font file not found: '.$file);
		$compressed = (substr($file,-2)=='.z');
		if(!$compressed && isset($info['length2']))
			$font = substr($font,6,$info['length1']).substr($font,6+$info['length1']+6,$info['length2']);
		$this->_put('<</Length '.strlen($font));
		if($compressed)
			$this->_put('/Filter /FlateDecode');
		$this->_put('/Length1 '.$info['length1']);
		if(isset($info['length2']))
			$this->_put('/Length2 '.$info['length2'].' /Length3 0');
		$this->_put('>>');
		$this->_putstream($font);
		$this->_put('endobj');
	}
	foreach($this->fonts as $k=>$font)
	{
		// Encoding
		if(isset($font['diff']))
		{
			if(!isset($this->encodings[$font['enc']]))
			{
				$this->_newobj();
				$this->_put('<</Type /Encoding /BaseEncoding /WinAnsiEncoding /Differences ['.$font['diff'].']>>');
				$this->_put('endobj');
				$this->encodings[$font['enc']] = $this->n;
			}
		}
		// ToUnicode CMap
		if(isset($font['uv']))
		{
			if(isset($font['enc']))
				$cmapkey = $font['enc'];
			else
				$cmapkey = $font['name'];
			if(!isset($this->cmaps[$cmapkey]))
			{
				$cmap = $this->_tounicodecmap($font['uv']);
				$this->_putstreamobject($cmap);
				$this->cmaps[$cmapkey] = $this->n;
			}
		}
		// Font object
		$this->fonts[$k]['n'] = $this->n+1;
		$type = $font['type'];
		$name = $font['name'];
		if($font['subsetted'])
			$name = 'AAAAAA+'.$name;
		if($type=='Core')
		{
			// Core font
			$this->_newobj();
			$this->_put('<</Type /Font');
			$this->_put('/BaseFont /'.$name);
			$this->_put('/Subtype /Type1');
			if($name!='Symbol' && $name!='ZapfDingbats')
				$this->_put('/Encoding /WinAnsiEncoding');
			if(isset($font['uv']))
				$this->_put('/ToUnicode '.$this->cmaps[$cmapkey].' 0 R');
			$this->_put('>>');
			$this->_put('endobj');
		}
		elseif($type=='Type1' || $type=='TrueType')
		{
			// Additional Type1 or TrueType/OpenType font
			$this->_newobj();
			$this->_put('<</Type /Font');
			$this->_put('/BaseFont /'.$name);
			$this->_put('/Subtype /'.$type);
			$this->_put('/FirstChar 32 /LastChar 255');
			$this->_put('/Widths '.($this->n+1).' 0 R');
			$this->_put('/FontDescriptor '.($this->n+2).' 0 R');
			if(isset($font['diff']))
				$this->_put('/Encoding '.$this->encodings[$font['enc']].' 0 R');
			else
				$this->_put('/Encoding /WinAnsiEncoding');
			if(isset($font['uv']))
				$this->_put('/ToUnicode '.$this->cmaps[$cmapkey].' 0 R');
			$this->_put('>>');
			$this->_put('endobj');
			// Widths
			$this->_newobj();
			$cw = &$font['cw'];
			$s = '[';
			for($i=32;$i<=255;$i++)
				$s .= $cw[chr($i)].' ';
			$this->_put($s.']');
			$this->_put('endobj');
			// Descriptor
			$this->_newobj();
			$s = '<</Type /FontDescriptor /FontName /'.$name;
			foreach($font['desc'] as $k=>$v)
				$s .= ' /'.$k.' '.$v;
			if(!empty($font['file']))
				$s .= ' /FontFile'.($type=='Type1' ? '' : '2').' '.$this->FontFiles[$font['file']]['n'].' 0 R';
			$this->_put($s.'>>');
			$this->_put('endobj');
		}
		else
		{
			// Allow for additional types
			$mtd = '_put'.strtolower($type);
			if(!method_exists($this,$mtd))
				$this->Error('Unsupported font type: '.$type);
			$this->$mtd($font);
		}
	}
}

/**
* Generate a ToUnicode CMap string from a mapping of single-byte character codes to Unicode code points or ranges.
* @example
* $uv = [
*     0x20 => 0x0020,           // space
*     0x41 => [0x0041, 26],     // map 0x41..0x5A to U+0041..U+005A ('A'..'Z')
* ];
* $cmap = $this->_tounicodecmap($uv);
* echo substr($cmap, 0, 120); // render some sample output, e.g. "/CIDInit /ProcSet findresource begin\n12 dict begin\nbegincmap\n"
* @param array $uv - Mapping of byte values (ints 0x00..0xFF) to either a single Unicode code point (int) or an array [startUnicode(int), length(int)] describing a consecutive range.
* @returns string Return the generated CMap content (ToUnicode CMap) as a string ready to be embedded in a PDF.
*/
protected function _tounicodecmap($uv)
{
	$ranges = '';
	$nbr = 0;
	$chars = '';
	$nbc = 0;
	foreach($uv as $c=>$v)
	{
		if(is_array($v))
		{
			$ranges .= sprintf("<%02X> <%02X> <%04X>\n",$c,$c+$v[1]-1,$v[0]);
			$nbr++;
		}
		else
		{
			$chars .= sprintf("<%02X> <%04X>\n",$c,$v);
			$nbc++;
		}
	}
	$s = "/CIDInit /ProcSet findresource begin\n";
	$s .= "12 dict begin\n";
	$s .= "begincmap\n";
	$s .= "/CIDSystemInfo\n";
	$s .= "<</Registry (Adobe)\n";
	$s .= "/Ordering (UCS)\n";
	$s .= "/Supplement 0\n";
	$s .= ">> def\n";
	$s .= "/CMapName /Adobe-Identity-UCS def\n";
	$s .= "/CMapType 2 def\n";
	$s .= "1 begincodespacerange\n";
	$s .= "<00> <FF>\n";
	$s .= "endcodespacerange\n";
	if($nbr>0)
	{
		$s .= "$nbr beginbfrange\n";
		$s .= $ranges;
		$s .= "endbfrange\n";
	}
	if($nbc>0)
	{
		$s .= "$nbc beginbfchar\n";
		$s .= $chars;
		$s .= "endbfchar\n";
	}
	$s .= "endcmap\n";
	$s .= "CMapName currentdict /CMap defineresource pop\n";
	$s .= "end\n";
	$s .= "end";
	return $s;
}

protected function _putimages()
{
	foreach(array_keys($this->images) as $file)
	{
		$this->_putimage($this->images[$file]);
		unset($this->images[$file]['data']);
		unset($this->images[$file]['smask']);
	}
}

/**
* Write an image XObject into the PDF stream (and any associated soft mask or palette objects).
* @example
* // Example usage from within the FPDF class or a subclass (protected method)
* $info = array(
*   'w'   => 100,                       // width in pixels
*   'h'   => 50,                        // height in pixels
*   'cs'  => 'DeviceRGB',               // colorspace: DeviceRGB | DeviceGray | DeviceCMYK | Indexed
*   'bpc' => 8,                         // bits per component
*   'f'   => 'FlateDecode',             // optional filter name
*   'data'=> gzcompress('...raw image bytes...') // image stream data (possibly compressed)
* );
* $this->_putimage($info); // writes the image object(s) into the PDF document stream
* @param array &$info - Associative array describing the image (keys: w,h,cs,bpc,data; optional: pal, f, dp, trns, smask).
* @returns void Writes image objects (and optional soft mask/palette) to the PDF output stream.
*/
protected function _putimage(&$info)
{
	$this->_newobj();
	$info['n'] = $this->n;
	$this->_put('<</Type /XObject');
	$this->_put('/Subtype /Image');
	$this->_put('/Width '.$info['w']);
	$this->_put('/Height '.$info['h']);
	if($info['cs']=='Indexed')
		$this->_put('/ColorSpace [/Indexed /DeviceRGB '.(strlen($info['pal'])/3-1).' '.($this->n+1).' 0 R]');
	else
	{
		$this->_put('/ColorSpace /'.$info['cs']);
		if($info['cs']=='DeviceCMYK')
			$this->_put('/Decode [1 0 1 0 1 0 1 0]');
	}
	$this->_put('/BitsPerComponent '.$info['bpc']);
	if(isset($info['f']))
		$this->_put('/Filter /'.$info['f']);
	if(isset($info['dp']))
		$this->_put('/DecodeParms <<'.$info['dp'].'>>');
	if(isset($info['trns']) && is_array($info['trns']))
	{
		$trns = '';
		for($i=0;$i<count($info['trns']);$i++)
			$trns .= $info['trns'][$i].' '.$info['trns'][$i].' ';
		$this->_put('/Mask ['.$trns.']');
	}
	if(isset($info['smask']))
		$this->_put('/SMask '.($this->n+1).' 0 R');
	$this->_put('/Length '.strlen($info['data']).'>>');
	$this->_putstream($info['data']);
	$this->_put('endobj');
	// Soft mask
	if(isset($info['smask']))
	{
		$dp = '/Predictor 15 /Colors 1 /BitsPerComponent 8 /Columns '.$info['w'];
		$smask = array('w'=>$info['w'], 'h'=>$info['h'], 'cs'=>'DeviceGray', 'bpc'=>8, 'f'=>$info['f'], 'dp'=>$dp, 'data'=>$info['smask']);
		$this->_putimage($smask);
	}
	// Palette
	if($info['cs']=='Indexed')
		$this->_putstreamobject($info['pal']);
}

protected function _putxobjectdict()
{
	foreach($this->images as $image)
		$this->_put('/I'.$image['i'].' '.$image['n'].' 0 R');
}

protected function _putresourcedict()
{
	$this->_put('/ProcSet [/PDF /Text /ImageB /ImageC /ImageI]');
	$this->_put('/Font <<');
	foreach($this->fonts as $font)
		$this->_put('/F'.$font['i'].' '.$font['n'].' 0 R');
	$this->_put('>>');
	$this->_put('/XObject <<');
	$this->_putxobjectdict();
	$this->_put('>>');
}

protected function _putresources()
{
	$this->_putfonts();
	$this->_putimages();
	// Resource dictionary
	$this->_newobj(2);
	$this->_put('<<');
	$this->_putresourcedict();
	$this->_put('>>');
	$this->_put('endobj');
}

protected function _putinfo()
{
	$this->metadata['Producer'] = 'FPDF '.FPDF_VERSION;
	$this->metadata['CreationDate'] = 'D:'.@date('YmdHis');
	foreach($this->metadata as $key=>$value)
		$this->_put('/'.$key.' '.$this->_textstring($value));
}

/**
 * Write the PDF Catalog (root) object into the document buffer.
 * Determines the /OpenAction entry based on $this->ZoomMode (fullpage, fullwidth, real, or numeric zoom)
 * and the /PageLayout entry based on $this->LayoutMode (single, continuous, two).
 * Uses $this->PageInfo[1]['n'] to reference the first page object.
 * @example
 * $pdf = new FPDF();
 * $pdf->ZoomMode = 'fullpage';    // other examples: 'fullwidth', 'real', 150 (numeric zoom)
 * $pdf->LayoutMode = 'single';    // other examples: 'continuous', 'two'
 * // This protected method is normally invoked internally when generating output:
 * // $pdf->_putcatalog(); // (called by the class; protected)
 * // Example lines written to the PDF buffer when ZoomMode='fullpage' and LayoutMode='single':
 * // /Type /Catalog
 * // /Pages 1 0 R
 * // /OpenAction [2 0 R /Fit]
 * // /PageLayout /SinglePage
 * @returns void Writes the catalog entries to the PDF internal buffer (no return value).
 */
protected function _putcatalog()
{
	$n = $this->PageInfo[1]['n'];
	$this->_put('/Type /Catalog');
	$this->_put('/Pages 1 0 R');
	if($this->ZoomMode=='fullpage')
		$this->_put('/OpenAction ['.$n.' 0 R /Fit]');
	elseif($this->ZoomMode=='fullwidth')
		$this->_put('/OpenAction ['.$n.' 0 R /FitH null]');
	elseif($this->ZoomMode=='real')
		$this->_put('/OpenAction ['.$n.' 0 R /XYZ null null 1]');
	elseif(!is_string($this->ZoomMode))
		$this->_put('/OpenAction ['.$n.' 0 R /XYZ null null '.sprintf('%.2F',$this->ZoomMode/100).']');
	if($this->LayoutMode=='single')
		$this->_put('/PageLayout /SinglePage');
	elseif($this->LayoutMode=='continuous')
		$this->_put('/PageLayout /OneColumn');
	elseif($this->LayoutMode=='two')
		$this->_put('/PageLayout /TwoColumnLeft');
}

protected function _putheader()
{
	$this->_put('%PDF-'.$this->PDFVersion);
}

protected function _puttrailer()
{
	$this->_put('/Size '.($this->n+1));
	$this->_put('/Root '.$this->n.' 0 R');
	$this->_put('/Info '.($this->n-1).' 0 R');
}

/**
* Finalize the PDF document by writing header, pages, resources, info, catalog, cross-reference table and trailer into the internal buffer.
* @example
* // Typically called internally; after this the PDF is complete and ready to be output.
* $pdf->_enddoc();
* // Afterwards use $pdf->Output() to send or save the finalized PDF (e.g. sends "%PDF-..." stream ending with "%%EOF").
* @param void $none - This method does not accept parameters.
* @returns void Finalizes the internal PDF structure; does not return a value.
*/
protected function _enddoc()
{
	$this->_putheader();
	$this->_putpages();
	$this->_putresources();
	// Info
	$this->_newobj();
	$this->_put('<<');
	$this->_putinfo();
	$this->_put('>>');
	$this->_put('endobj');
	// Catalog
	$this->_newobj();
	$this->_put('<<');
	$this->_putcatalog();
	$this->_put('>>');
	$this->_put('endobj');
	// Cross-ref
	$offset = $this->_getoffset();
	$this->_put('xref');
	$this->_put('0 '.($this->n+1));
	$this->_put('0000000000 65535 f ');
	for($i=1;$i<=$this->n;$i++)
		$this->_put(sprintf('%010d 00000 n ',$this->offsets[$i]));
	// Trailer
	$this->_put('trailer');
	$this->_put('<<');
	$this->_puttrailer();
	$this->_put('>>');
	$this->_put('startxref');
	$this->_put($offset);
	$this->_put('%%EOF');
	$this->state = 3;
}

#######################
// Adding Function 
########################

var $widths;
var $aligns;

function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

/**
* Draws a single table row using the current column widths and alignments, handling text wrapping (MultiCell) and automatic page breaks.
* @example
* $pdf = new FPDF();
* $pdf->AddPage();
* $pdf->SetFont('Arial','',10);
* // Define column widths and optional alignments before calling Row:
* $pdf->SetWidths(array(40, 80, 60)); // widths in user units
* $pdf->SetAligns(array('L', 'C', 'R')); // optional: left, center, right
* // Render a row with three cells; long text in the second cell will wrap across lines
* $pdf->Row(array('001', 'Very long product description that will wrap into multiple lines', '$9.99'));
* // The call writes the row into the PDF at the current position (no return value).
* @param array $data - Array of cell text values (strings) for each column in the row.
* @returns void Does not return a value; outputs the rendered row to the PDF.
*/
function Row($data)
{
	
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

/**
* Compute how many lines a MultiCell of the given width will occupy for a given text.
* @example
* $pdf = new FPDF(); // previously created FPDF instance with current font set
* $result = $pdf->NbLines(50, "Lorem ipsum dolor sit amet, consectetur adipiscing elit.");
* echo $result; // e.g. 2
* @param float|int $w - Cell width in current unit. If 0 the function uses the remaining width ($this->w - $this->rMargin - $this->x).
* @param string $txt - The text to be measured (carriage returns are normalized).
* @returns int Number of lines the text will be split into when rendered in a MultiCell of width $w.
*/
function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}

function GenerateWord()
{
    //Get a random word
    $nb=rand(3,10);
    $w='';
    for($i=1;$i<=$nb;$i++)
        $w.=chr(rand(ord('a'),ord('z')));
    return $w;
}

function GenerateSentence()
{
    //Get a random sentence
    $nb=rand(1,10);
    $s='';
    for($i=1;$i<=$nb;$i++)
        $s.=$this->GenerateWord().' ';
    return substr($s,0,-1);
}




}
?>
