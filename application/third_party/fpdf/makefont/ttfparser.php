<?php
/*******************************************************************************
* Utility to parse TTF font files                                              *
*                                                                              *
* Version: 1.0                                                                 *
* Date:    2011-06-18                                                          *
* Author:  Olivier PLATHEY                                                     *
*******************************************************************************/

class TTFParser
{
	var $f;
	var $tables;
	var $unitsPerEm;
	var $xMin, $yMin, $xMax, $yMax;
	var $numberOfHMetrics;
	var $numGlyphs;
	var $widths;
	var $chars;
	var $postScriptName;
	var $Embeddable;
	var $Bold;
	var $typoAscender;
	var $typoDescender;
	var $capHeight;
	var $italicAngle;
	var $underlinePosition;
	var $underlineThickness;
	var $isFixedPitch;

 /**
 * Parse a TrueType (.ttf) font file and populate the parser object's tables and font metrics.
 * @example
 * $parser = new TTFParser(); // instance from application/third_party/fpdf/makefont/ttfparser.php
 * $parser->Parse('/path/to/font.ttf');
 * echo count($parser->tables); // e.g. "9" — number of top-level tables parsed
 * @param {string} $file - Path to the TrueType font file to open and parse.
 * @returns {void} No return value; populates the object's properties (tables, hhea, maxp, hmtx, cmap, name, OS/2, post, etc.).
 */
	function Parse($file)
	{
		$this->f = fopen($file, 'rb');
		if(!$this->f)
			$this->Error('Can\'t open file: '.$file);

		$version = $this->Read(4);
		if($version=='OTTO')
			$this->Error('OpenType fonts based on PostScript outlines are not supported');
		if($version!="\x00\x01\x00\x00")
			$this->Error('Unrecognized file format');
		$numTables = $this->ReadUShort();
		$this->Skip(3*2); // searchRange, entrySelector, rangeShift
		$this->tables = array();
		for($i=0;$i<$numTables;$i++)
		{
			$tag = $this->Read(4);
			$this->Skip(4); // checkSum
			$offset = $this->ReadULong();
			$this->Skip(4); // length
			$this->tables[$tag] = $offset;
		}

		$this->ParseHead();
		$this->ParseHhea();
		$this->ParseMaxp();
		$this->ParseHmtx();
		$this->ParseCmap();
		$this->ParseName();
		$this->ParseOS2();
		$this->ParsePost();

		fclose($this->f);
	}

 /**
 * Parse the 'head' table of a TrueType font stream and populate related parser properties.
 * @example
 * $parser = new TtfParser('/path/to/font.ttf');
 * $parser->ParseHead();
 * // example populated properties:
 * echo $parser->unitsPerEm; // 2048
 * echo $parser->xMin; // -50
 * echo $parser->yMin; // 0
 * echo $parser->xMax; // 1200
 * echo $parser->yMax; // 1400
 * @returns {void} Void - Does not return a value; updates the parser instance properties (unitsPerEm, xMin, yMin, xMax, yMax).
 */
	function ParseHead()
	{
		$this->Seek('head');
		$this->Skip(3*4); // version, fontRevision, checkSumAdjustment
		$magicNumber = $this->ReadULong();
		if($magicNumber!=0x5F0F3CF5)
			$this->Error('Incorrect magic number');
		$this->Skip(2); // flags
		$this->unitsPerEm = $this->ReadUShort();
		$this->Skip(2*8); // created, modified
		$this->xMin = $this->ReadShort();
		$this->yMin = $this->ReadShort();
		$this->xMax = $this->ReadShort();
		$this->yMax = $this->ReadShort();
	}

	function ParseHhea()
	{
		$this->Seek('hhea');
		$this->Skip(4+15*2);
		$this->numberOfHMetrics = $this->ReadUShort();
	}

	function ParseMaxp()
	{
		$this->Seek('maxp');
		$this->Skip(4);
		$this->numGlyphs = $this->ReadUShort();
	}

 /**
 * Parse the 'hmtx' (horizontal metrics) table from the open TrueType file and populate $this->widths with advance widths for all glyphs.
 * @example
 * $parser = new TTFParser('Arial.ttf');
 * // assume $parser->numberOfHMetrics and $parser->numGlyphs were initialized by parsing other tables (e.g., hhea, maxp)
 * $parser->ParseHmtx();
 * print_r($parser->widths);
 * // Example output:
 * // Array ( [0] => 600 [1] => 600 [2] => 500 [3] => 500 [4] => 700 ... )
 * @returns {void} No return value; the method fills $this->widths on the parser instance with advance widths for each glyph.
 */
	function ParseHmtx()
	{
		$this->Seek('hmtx');
		$this->widths = array();
		for($i=0;$i<$this->numberOfHMetrics;$i++)
		{
			$advanceWidth = $this->ReadUShort();
			$this->Skip(2); // lsb
			$this->widths[$i] = $advanceWidth;
		}
		if($this->numberOfHMetrics<$this->numGlyphs)
		{
			$lastWidth = $this->widths[$this->numberOfHMetrics-1];
			$this->widths = array_pad($this->widths, $this->numGlyphs, $lastWidth);
		}
	}

 /**
 * Parse the 'cmap' table of a TrueType font and populate $this->chars with Unicode codepoint => glyph id mappings.
 * @example
 * $parser = new TTFParser('Arial.ttf'); // example constructor
 * $parser->ParseCmap();
 * var_export($parser->chars); // sample output: array ( 65 => 3, 66 => 4, 67 => 5 )
 * @param void $none - No parameters.
 * @returns void Populates $this->chars with mappings and does not return a value.
 */
	function ParseCmap()
	{
		$this->Seek('cmap');
		$this->Skip(2); // version
		$numTables = $this->ReadUShort();
		$offset31 = 0;
		for($i=0;$i<$numTables;$i++)
		{
			$platformID = $this->ReadUShort();
			$encodingID = $this->ReadUShort();
			$offset = $this->ReadULong();
			if($platformID==3 && $encodingID==1)
				$offset31 = $offset;
		}
		if($offset31==0)
			$this->Error('No Unicode encoding found');

		$startCount = array();
		$endCount = array();
		$idDelta = array();
		$idRangeOffset = array();
		$this->chars = array();
		fseek($this->f, $this->tables['cmap']+$offset31, SEEK_SET);
		$format = $this->ReadUShort();
		if($format!=4)
			$this->Error('Unexpected subtable format: '.$format);
		$this->Skip(2*2); // length, language
		$segCount = $this->ReadUShort()/2;
		$this->Skip(3*2); // searchRange, entrySelector, rangeShift
		for($i=0;$i<$segCount;$i++)
			$endCount[$i] = $this->ReadUShort();
		$this->Skip(2); // reservedPad
		for($i=0;$i<$segCount;$i++)
			$startCount[$i] = $this->ReadUShort();
		for($i=0;$i<$segCount;$i++)
			$idDelta[$i] = $this->ReadShort();
		$offset = ftell($this->f);
		for($i=0;$i<$segCount;$i++)
			$idRangeOffset[$i] = $this->ReadUShort();

		for($i=0;$i<$segCount;$i++)
		{
			$c1 = $startCount[$i];
			$c2 = $endCount[$i];
			$d = $idDelta[$i];
			$ro = $idRangeOffset[$i];
			if($ro>0)
				fseek($this->f, $offset+2*$i+$ro, SEEK_SET);
			for($c=$c1;$c<=$c2;$c++)
			{
				if($c==0xFFFF)
					break;
				if($ro>0)
				{
					$gid = $this->ReadUShort();
					if($gid>0)
						$gid += $d;
				}
				else
					$gid = $c+$d;
				if($gid>=65536)
					$gid -= 65536;
				if($gid>0)
					$this->chars[$c] = $gid;
			}
		}
	}

 /**
 * Parse the 'name' table of a TTF/OTF font file and extract the PostScript name into $this->postScriptName.
 * @example
 * $parser = new TTFParser(); // instance with an open file handle to a .ttf/.otf file
 * $parser->ParseName();
 * echo $parser->postScriptName; // e.g. "MyFont-Bold"
 * @param {void} $none - No arguments.
 * @returns {void} Sets $this->postScriptName to the PostScript name or triggers an error if not found.
 */
	function ParseName()
	{
		$this->Seek('name');
		$tableOffset = ftell($this->f);
		$this->postScriptName = '';
		$this->Skip(2); // format
		$count = $this->ReadUShort();
		$stringOffset = $this->ReadUShort();
		for($i=0;$i<$count;$i++)
		{
			$this->Skip(3*2); // platformID, encodingID, languageID
			$nameID = $this->ReadUShort();
			$length = $this->ReadUShort();
			$offset = $this->ReadUShort();
			if($nameID==6)
			{
				// PostScript name
				fseek($this->f, $tableOffset+$stringOffset+$offset, SEEK_SET);
				$s = $this->Read($length);
				$s = str_replace(chr(0), '', $s);
				$s = preg_replace('|[ \[\](){}<>/%]|', '', $s);
				$this->postScriptName = $s;
				break;
			}
		}
		if($this->postScriptName=='')
			$this->Error('PostScript name not found');
	}

 /**
  * Parse the OS/2 table from the currently loaded TTF/OTF font stream and populate parser properties.
  * This reads fields such as version, fsType, fsSelection, typoAscender, typoDescender and capHeight
  * and sets $this->Embeddable, $this->Bold, $this->typoAscender, $this->typoDescender and $this->capHeight.
  * @example
  * // Assuming $parser is an instance of the TTF parser and font data has been loaded:
  * $parser->ParseOS2();
  * var_dump($parser->Embeddable);   // bool(true)
  * var_dump($parser->Bold);         // bool(false)
  * echo $parser->typoAscender;      // e.g. 1854
  * echo $parser->typoDescender;     // e.g. -434
  * echo $parser->capHeight;         // e.g. 1456 (0 if not available for older OS/2 versions)
  * @returns {void} Parses the OS/2 table and sets related parser properties.
  */
	function ParseOS2()
	{
		$this->Seek('OS/2');
		$version = $this->ReadUShort();
		$this->Skip(3*2); // xAvgCharWidth, usWeightClass, usWidthClass
		$fsType = $this->ReadUShort();
		$this->Embeddable = ($fsType!=2) && ($fsType & 0x200)==0;
		$this->Skip(11*2+10+4*4+4);
		$fsSelection = $this->ReadUShort();
		$this->Bold = ($fsSelection & 32)!=0;
		$this->Skip(2*2); // usFirstCharIndex, usLastCharIndex
		$this->typoAscender = $this->ReadShort();
		$this->typoDescender = $this->ReadShort();
		if($version>=2)
		{
			$this->Skip(3*2+2*4+2);
			$this->capHeight = $this->ReadShort();
		}
		else
			$this->capHeight = 0;
	}

	function ParsePost()
	{
		$this->Seek('post');
		$this->Skip(4); // version
		$this->italicAngle = $this->ReadShort();
		$this->Skip(2); // Skip decimal part
		$this->underlinePosition = $this->ReadShort();
		$this->underlineThickness = $this->ReadShort();
		$this->isFixedPitch = ($this->ReadULong()!=0);
	}

	function Error($msg)
	{
		if(PHP_SAPI=='cli')
			die("Error: $msg\n");
		else
			die("<b>Error</b>: $msg");
	}

	function Seek($tag)
	{
		if(!isset($this->tables[$tag]))
			$this->Error('Table not found: '.$tag);
		fseek($this->f, $this->tables[$tag], SEEK_SET);
	}

	function Skip($n)
	{
		fseek($this->f, $n, SEEK_CUR);
	}

	function Read($n)
	{
		return fread($this->f, $n);
	}

	function ReadUShort()
	{
		$a = unpack('nn', fread($this->f,2));
		return $a['n'];
	}

	function ReadShort()
	{
		$a = unpack('nn', fread($this->f,2));
		$v = $a['n'];
		if($v>=0x8000)
			$v -= 65536;
		return $v;
	}

	function ReadULong()
	{
		$a = unpack('NN', fread($this->f,4));
		return $a['N'];
	}
}
?>
