<?php
/*******************************************************************************
* Utility to generate font definition files                                    *
*                                                                              *
* Version: 1.2                                                                 *
* Date:    2011-06-18                                                          *
* Author:  Olivier PLATHEY                                                     *
*******************************************************************************/

require('ttfparser.php');

/**
* Outputs a message to either the CLI or a web browser, optionally prefixing it with a severity label.
* @example
* Message("Font file created successfully", "Notice");
* // CLI output: Notice: Font file created successfully
* // Browser output: <b>Notice</b>: Font file created successfully<br>
* @param {string} $txt - The message text to output.
* @param {string} $severity - Optional severity label (e.g. "Warning", "Notice"). If provided it is prefixed to the message.
* @returns {void} No return value; the function echoes the message directly.
*/
function Message($txt, $severity='')
{
	if(PHP_SAPI=='cli')
	{
		if($severity)
			echo "$severity: ";
		echo "$txt\n";
	}
	else
	{
		if($severity)
			echo "<b>$severity</b>: ";
		echo "$txt<br>";
	}
}

function Notice($txt)
{
	Message($txt, 'Notice');
}

function Warning($txt)
{
	Message($txt, 'Warning');
}

function Error($txt)
{
	Message($txt, 'Error');
	exit;
}

/**
* Load a 256-entry encoding map for the specified encoding and return a byte-to-Unicode/glyph-name mapping.
* @example
* $map = LoadMap('CP1252');
* echo $map[0x41]['name']; // outputs 'A'
* echo $map[0x41]['uv'];   // outputs 65
* @param {string} $enc - Encoding identifier (filename without extension), e.g. 'CP1252' or 'iso-8859-1'.
* @returns {array} Return an array of 256 elements where each element is an associative array with keys 'uv' (int Unicode value) and 'name' (string glyph name).
*/
function LoadMap($enc)
{
	$file = dirname(__FILE__).'/'.strtolower($enc).'.map';
	$a = file($file);
	if(empty($a))
		Error('Encoding not found: '.$enc);
	$map = array_fill(0, 256, array('uv'=>-1, 'name'=>'.notdef'));
	foreach($a as $line)
	{
		$e = explode(' ', rtrim($line));
		$c = hexdec(substr($e[0],1));
		$uv = hexdec(substr($e[1],2));
		$name = $e[2];
		$map[$c] = array('uv'=>$uv, 'name'=>$name);
	}
	return $map;
}

/**
* Extracts font metrics and metadata from a TrueType (.ttf) file and optionally embeds the raw font data.
* @example
* $map = array_fill(0,256,array('name'=>'.notdef','uv'=>0));
* $map[65] = array('name'=>'A','uv'=>65); // map ASCII code 65 to glyph UV 65
* $info = GetInfoFromTrueType('/path/to/font/DejaVuSans.ttf', true, $map);
* print_r($info); // Example output: Array ( [FontName] => DejaVuSans [Bold] => 0 [ItalicAngle] => 0 [IsFixedPitch] => 0 ... )
* @param string $file - Path to the TrueType font file (.ttf).
* @param bool $embed - Whether to embed the font data into the returned info (requires embedding permission in the font).
* @param array $map - 256-entry character map where each entry is an array with keys 'name' (glyph name) and 'uv' (unicode/glyph index).
* @returns array Associative array of font information (keys include FontName, Bold, ItalicAngle, IsFixedPitch, Ascender, Descender, UnderlineThickness, UnderlinePosition, FontBBox, CapHeight, MissingWidth, Widths, and optionally Data and OriginalSize when $embed is true).
*/
function GetInfoFromTrueType($file, $embed, $map)
{
	// Return informations from a TrueType font
	$ttf = new TTFParser();
	$ttf->Parse($file);
	if($embed)
	{
		if(!$ttf->Embeddable)
			Error('Font license does not allow embedding');
		$info['Data'] = file_get_contents($file);
		$info['OriginalSize'] = filesize($file);
	}
	$k = 1000/$ttf->unitsPerEm;
	$info['FontName'] = $ttf->postScriptName;
	$info['Bold'] = $ttf->Bold;
	$info['ItalicAngle'] = $ttf->italicAngle;
	$info['IsFixedPitch'] = $ttf->isFixedPitch;
	$info['Ascender'] = round($k*$ttf->typoAscender);
	$info['Descender'] = round($k*$ttf->typoDescender);
	$info['UnderlineThickness'] = round($k*$ttf->underlineThickness);
	$info['UnderlinePosition'] = round($k*$ttf->underlinePosition);
	$info['FontBBox'] = array(round($k*$ttf->xMin), round($k*$ttf->yMin), round($k*$ttf->xMax), round($k*$ttf->yMax));
	$info['CapHeight'] = round($k*$ttf->capHeight);
	$info['MissingWidth'] = round($k*$ttf->widths[0]);
	$widths = array_fill(0, 256, $info['MissingWidth']);
	for($c=0;$c<=255;$c++)
	{
		if($map[$c]['name']!='.notdef')
		{
			$uv = $map[$c]['uv'];
			if(isset($ttf->chars[$uv]))
			{
				$w = $ttf->widths[$ttf->chars[$uv]];
				$widths[$c] = round($k*$w);
			}
			else
				Warning('Character '.$map[$c]['name'].' is missing');
		}
	}
	$info['Widths'] = $widths;
	return $info;
}

/**
* Extract font metric information from a Type1 font (AFM) and optionally read binary font data for embedding.
* @example
* $map = array_fill(0,256,array('name'=>'.notdef'));
* $map[65]['name'] = 'A'; // sample mapping for character code 65
* $result = GetInfoFromType1('/path/to/font.pfb', true, $map);
* print_r($result);
* // Example output snippet:
* // Array(
* //   'FontName' => 'Helvetica',
* //   'Weight' => 'Medium',
* //   'Bold' => false,
* //   'ItalicAngle' => 0,
* //   'Ascender' => 718,
* //   'Descender' => -207,
* //   'UnderlineThickness' => 50,
* //   'UnderlinePosition' => -100,
* //   'IsFixedPitch' => false,
* //   'FontBBox' => array(-166,-225,1000,931),
* //   'CapHeight' => 718,
* //   'StdVW' => 84,
* //   'MissingWidth' => 250,
* //   'Widths' => array(0 => 250, 1 => 250, 65 => 667, ...),
* //   'Data' => '...binary data...' (only when $embed is true),
* //   'Size1' => 1234,
* //   'Size2' => 5678
* // )
* @param {string} $file - Path to the Type1 font file (usually .pfb or .pfa). The corresponding AFM is expected at the same path with the .afm extension.
* @param {bool} $embed - If true, the function will read and return the binary font segments (Data, Size1, Size2) for embedding.
* @param {array} $map - Character map indexed 0..255 where each entry is an array with a 'name' key (e.g. $map[65]['name'] == 'A') used to build the Widths array.
* @returns {array} Associative array of extracted font information (FontName, Weight, Bold, ItalicAngle, Ascender, Descender, UnderlineThickness, UnderlinePosition, IsFixedPitch, FontBBox, CapHeight, StdVW, MissingWidth, Widths and optionally Data, Size1, Size2).
*/
function GetInfoFromType1($file, $embed, $map)
{
	// Return informations from a Type1 font
	if($embed)
	{
		$f = fopen($file, 'rb');
		if(!$f)
			Error('Can\'t open font file');
		// Read first segment
		$a = unpack('Cmarker/Ctype/Vsize', fread($f,6));
		if($a['marker']!=128)
			Error('Font file is not a valid binary Type1');
		$size1 = $a['size'];
		$data = fread($f, $size1);
		// Read second segment
		$a = unpack('Cmarker/Ctype/Vsize', fread($f,6));
		if($a['marker']!=128)
			Error('Font file is not a valid binary Type1');
		$size2 = $a['size'];
		$data .= fread($f, $size2);
		fclose($f);
		$info['Data'] = $data;
		$info['Size1'] = $size1;
		$info['Size2'] = $size2;
	}

	$afm = substr($file, 0, -3).'afm';
	if(!file_exists($afm))
		Error('AFM font file not found: '.$afm);
	$a = file($afm);
	if(empty($a))
		Error('AFM file empty or not readable');
	foreach($a as $line)
	{
		$e = explode(' ', rtrim($line));
		if(count($e)<2)
			continue;
		$entry = $e[0];
		if($entry=='C')
		{
			$w = $e[4];
			$name = $e[7];
			$cw[$name] = $w;
		}
		elseif($entry=='FontName')
			$info['FontName'] = $e[1];
		elseif($entry=='Weight')
			$info['Weight'] = $e[1];
		elseif($entry=='ItalicAngle')
			$info['ItalicAngle'] = (int)$e[1];
		elseif($entry=='Ascender')
			$info['Ascender'] = (int)$e[1];
		elseif($entry=='Descender')
			$info['Descender'] = (int)$e[1];
		elseif($entry=='UnderlineThickness')
			$info['UnderlineThickness'] = (int)$e[1];
		elseif($entry=='UnderlinePosition')
			$info['UnderlinePosition'] = (int)$e[1];
		elseif($entry=='IsFixedPitch')
			$info['IsFixedPitch'] = ($e[1]=='true');
		elseif($entry=='FontBBox')
			$info['FontBBox'] = array((int)$e[1], (int)$e[2], (int)$e[3], (int)$e[4]);
		elseif($entry=='CapHeight')
			$info['CapHeight'] = (int)$e[1];
		elseif($entry=='StdVW')
			$info['StdVW'] = (int)$e[1];
	}

	if(!isset($info['FontName']))
		Error('FontName missing in AFM file');
	$info['Bold'] = isset($info['Weight']) && preg_match('/bold|black/i', $info['Weight']);
	if(isset($cw['.notdef']))
		$info['MissingWidth'] = $cw['.notdef'];
	else
		$info['MissingWidth'] = 0;
	$widths = array_fill(0, 256, $info['MissingWidth']);
	for($c=0;$c<=255;$c++)
	{
		$name = $map[$c]['name'];
		if($name!='.notdef')
		{
			if(isset($cw[$name]))
				$widths[$c] = $cw[$name];
			else
				Warning('Character '.$name.' is missing');
		}
	}
	$info['Widths'] = $widths;
	return $info;
}

/**
* Build a font descriptor array string from a font metrics/info array used by makefont.
* @example
* $info = array(
*   'Ascender'    => 800,
*   'Descender'   => -200,
*   'CapHeight'   => 700,
*   'IsFixedPitch'=> false,
*   'ItalicAngle' => 0,
*   'FontBBox'    => array(-50, -200, 1000, 900),
*   // 'StdVW' not set
*   'Bold'        => false,
*   'MissingWidth'=> 600
* );
* $result = MakeFontDescriptor($info);
* echo $result; // render some sample output value: array('Ascent'=>800,'Descent'=>-200,'CapHeight'=>700,'Flags'=>32,'FontBBox'=>'[-50 -200 1000 900]','ItalicAngle'=>0,'StemV'=>70,'MissingWidth'=>600)
* @param {array} $info - Associative array of font metrics and properties (keys: Ascender, Descender, CapHeight (optional), IsFixedPitch, ItalicAngle, FontBBox (array of 4 numbers), StdVW (optional), Bold, MissingWidth).
* @returns {string} Returns a string representing a PHP array literal describing the font descriptor for PDF embedding.
*/
function MakeFontDescriptor($info)
{
	// Ascent
	$fd = "array('Ascent'=>".$info['Ascender'];
	// Descent
	$fd .= ",'Descent'=>".$info['Descender'];
	// CapHeight
	if(!empty($info['CapHeight']))
		$fd .= ",'CapHeight'=>".$info['CapHeight'];
	else
		$fd .= ",'CapHeight'=>".$info['Ascender'];
	// Flags
	$flags = 0;
	if($info['IsFixedPitch'])
		$flags += 1<<0;
	$flags += 1<<5;
	if($info['ItalicAngle']!=0)
		$flags += 1<<6;
	$fd .= ",'Flags'=>".$flags;
	// FontBBox
	$fbb = $info['FontBBox'];
	$fd .= ",'FontBBox'=>'[".$fbb[0].' '.$fbb[1].' '.$fbb[2].' '.$fbb[3]."]'";
	// ItalicAngle
	$fd .= ",'ItalicAngle'=>".$info['ItalicAngle'];
	// StemV
	if(isset($info['StdVW']))
		$stemv = $info['StdVW'];
	elseif($info['Bold'])
		$stemv = 120;
	else
		$stemv = 70;
	$fd .= ",'StemV'=>".$stemv;
	// MissingWidth
	$fd .= ",'MissingWidth'=>".$info['MissingWidth'].')';
	return $fd;
}

/**
* Builds a PHP array literal string that maps every byte value (0-255) to a character key (printable characters quoted, single quote and backslash escaped, non-printables represented as chr(n)) with the corresponding width values.
* @example
* $widths = array_fill(0, 256, 600);
* $widths[32] = 250; // space
* $widths[65] = 600; // 'A'
* $result = MakeWidthArray($widths);
* echo $result // render a PHP array string like: array(' '=>250,'!'=>600, /* ... */
function MakeWidthArray($widths)
{
	$s = "array(\n\t";
	for($c=0;$c<=255;$c++)
	{
		if(chr($c)=="'")
			$s .= "'\\''";
		elseif(chr($c)=="\\")
			$s .= "'\\\\'";
		elseif($c>=32 && $c<=126)
			$s .= "'".chr($c)."'";
		else
			$s .= "chr($c)";
		$s .= '=>'.$widths[$c];
		if($c<255)
			$s .= ',';
		if(($c+1)%22==0)
			$s .= "\n\t";
	}
	$s .= ')';
	return $s;
}

/**
* Build a PDF font encoding "Differences" string by comparing a given map to the cp1252 reference.
* @example
* $sample_map = [
*   32  => ['name' => 'space'],
*   128 => ['name' => 'Euro'],
*   130 => ['name' => 'quotesinglbase']
* ];
* $result = MakeFontEncoding($sample_map);
* echo $result; // Example output: "128 /Euro 130 /quotesinglbase"
* @param array $map - Associative array indexed by codepoint (0-255) where each entry is an array containing at least a 'name' key with the glyph name.
* @returns string Returns a trimmed string listing differences in the PDF "Differences" format (codepoints and /glyphnames).
*/
function MakeFontEncoding($map)
{
	// Build differences from reference encoding
	$ref = LoadMap('cp1252');
	$s = '';
	$last = 0;
	for($c=32;$c<=255;$c++)
	{
		if($map[$c]['name']!=$ref[$c]['name'])
		{
			if($c!=$last+1)
				$s .= $c.' ';
			$last = $c;
			$s .= '/'.$map[$c]['name'].' ';
		}
	}
	return rtrim($s);
}

function SaveToFile($file, $s, $mode)
{
	$f = fopen($file, 'w'.$mode);
	if(!$f)
		Error('Can\'t write to file '.$file);
	fwrite($f, $s, strlen($s));
	fclose($f);
}

/**
* Generate and save a PHP font definition file containing font metadata (name, descriptor, widths, encoding, embed info, etc.) used by MakeFont.
* @example
* $info = array(
*     'FontName' => 'Helvetica',
*     'UnderlinePosition' => -100,
*     'UnderlineThickness' => 50,
*     'Widths' => array(32 => 250, 65 => 600),
*     'File' => 'helvetica.ttf',
*     'Size1' => 0,
*     'Size2' => 0,
*     'OriginalSize' => 12345
* );
* MakeDefinitionFile('helvetica.php', 'TrueType', 'cp1252', true, array(), $info);
* // Generates 'helvetica.php' containing PHP variables describing the font
* @param {string} $file - Destination filename for the generated PHP definition file.
* @param {string} $type - Font type (e.g. 'TrueType' or 'Type1').
* @param {string} $enc - Encoding name to write into the definition (e.g. 'cp1252').
* @param {bool} $embed - Whether the font file should be embedded (true) or not (false).
* @param {array} $map - Character mapping/encoding differences used to build the $diff entry.
* @param {array} $info - Associative array with font metadata (must include keys like 'FontName', 'UnderlinePosition', 'UnderlineThickness', 'Widths', 'File', and optionally 'Size1','Size2','OriginalSize').
* @returns {void} Writes the PHP definition file to disk and does not return a value.
*/
function MakeDefinitionFile($file, $type, $enc, $embed, $map, $info)
{
	$s = "<?php\n";
	$s .= '$type = \''.$type."';\n";
	$s .= '$name = \''.$info['FontName']."';\n";
	$s .= '$desc = '.MakeFontDescriptor($info).";\n";
	$s .= '$up = '.$info['UnderlinePosition'].";\n";
	$s .= '$ut = '.$info['UnderlineThickness'].";\n";
	$s .= '$cw = '.MakeWidthArray($info['Widths']).";\n";
	$s .= '$enc = \''.$enc."';\n";
	$diff = MakeFontEncoding($map);
	if($diff)
		$s .= '$diff = \''.$diff."';\n";
	if($embed)
	{
		$s .= '$file = \''.$info['File']."';\n";
		if($type=='Type1')
		{
			$s .= '$size1 = '.$info['Size1'].";\n";
			$s .= '$size2 = '.$info['Size2'].";\n";
		}
		else
			$s .= '$originalsize = '.$info['OriginalSize'].";\n";
	}
	$s .= "?>\n";
	SaveToFile($file, $s, 't');
}

/**
* Generate a font definition file (and optional compressed font data) from a TTF/OTF/PFB font.
* @example
* MakeFont('/var/www/fonts/DejaVuSans.ttf', 'cp1252', true);
* // Example output messages:
* // "Font file compressed: DejaVuSans.z"
* // "Font definition file generated: DejaVuSans.php"
* @param {string} $fontfile - Path to the font file to process (supported extensions: .ttf, .otf, .pfb).
* @param {string} $enc - Encoding/map to use for the font (default: 'cp1252').
* @param {bool} $embed - Whether to embed the font data in the generated files (default: true).
* @returns {void} Generates a .php font definition (and optionally a .z compressed font file); does not return a value.
*/
function MakeFont($fontfile, $enc='cp1252', $embed=true)
{
	// Generate a font definition file
	if(get_magic_quotes_runtime())
		@set_magic_quotes_runtime(0);
	ini_set('auto_detect_line_endings', '1');

	if(!file_exists($fontfile))
		Error('Font file not found: '.$fontfile);
	$ext = strtolower(substr($fontfile,-3));
	if($ext=='ttf' || $ext=='otf')
		$type = 'TrueType';
	elseif($ext=='pfb')
		$type = 'Type1';
	else
		Error('Unrecognized font file extension: '.$ext);

	$map = LoadMap($enc);

	if($type=='TrueType')
		$info = GetInfoFromTrueType($fontfile, $embed, $map);
	else
		$info = GetInfoFromType1($fontfile, $embed, $map);

	$basename = substr(basename($fontfile), 0, -4);
	if($embed)
	{
		if(function_exists('gzcompress'))
		{
			$file = $basename.'.z';
			SaveToFile($file, gzcompress($info['Data']), 'b');
			$info['File'] = $file;
			Message('Font file compressed: '.$file);
		}
		else
		{
			$info['File'] = basename($fontfile);
			Notice('Font file could not be compressed (zlib extension not available)');
		}
	}

	MakeDefinitionFile($basename.'.php', $type, $enc, $embed, $map, $info);
	Message('Font definition file generated: '.$basename.'.php');
}

if(PHP_SAPI=='cli')
{
	// Command-line interface
	if($argc==1)
		die("Usage: php makefont.php fontfile [enc] [embed]\n");
	$fontfile = $argv[1];
	if($argc>=3)
		$enc = $argv[2];
	else
		$enc = 'cp1252';
	if($argc>=4)
		$embed = ($argv[3]=='true' || $argv[3]=='1');
	else
		$embed = true;
	MakeFont($fontfile, $enc, $embed);
}
?>
