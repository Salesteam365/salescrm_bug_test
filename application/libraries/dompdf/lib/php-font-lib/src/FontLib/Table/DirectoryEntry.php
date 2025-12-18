<?php
/**
 * @package php-font-lib
 * @link    https://github.com/PhenX/php-font-lib
 * @author  Fabien Ménager <fabien.menager@gmail.com>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */
namespace FontLib\Table;

use FontLib\TrueType\File;
use FontLib\Font;
use FontLib\BinaryStream;

/**
 * Generic Font table directory entry.
 *
 * @package php-font-lib
 */
class DirectoryEntry extends BinaryStream {
  /**
   * @var File
   */
  protected $font;

  /**
   * @var Table
   */
  protected $font_table;

  public $entryLength = 4;

  public $tag;
  public $checksum;
  public $offset;
  public $length;

  protected $origF;

  /**
  * Compute a checksum for binary data (used for font table directory entries).
  * @example
  * $result = DirectoryEntry::computeChecksum(""); 
  * echo $result // 0;
  * @param {string} $data - Binary-safe input data to checksum; will be padded with NUL bytes to a 4-byte boundary if necessary.
  * @returns {int} Checksum value as an integer.
  */
  static function computeChecksum($data) {
    $len = strlen($data);
    $mod = $len % 4;

    if ($mod) {
      $data = str_pad($data, $len + (4 - $mod), "\0");
    }

    $len = strlen($data);

    $hi = 0x0000;
    $lo = 0x0000;

    for ($i = 0; $i < $len; $i += 4) {
      $hi += (ord($data[$i]) << 8) + ord($data[$i + 1]);
      $lo += (ord($data[$i + 2]) << 8) + ord($data[$i + 3]);
      $hi += $lo >> 16;
      $lo = $lo & 0xFFFF;
      $hi = $hi & 0xFFFF;
    }

    return ($hi << 8) + $lo;
  }

  function __construct(File $font) {
    $this->font = $font;
    $this->f    = $font->f;
  }

  function parse() {
    $this->tag = $this->font->read(4);
  }

  function open($filename, $mode = self::modeRead) {
    // void
  }

  function setTable(Table $font_table) {
    $this->font_table = $font_table;
  }

  /**
  * Encode and write this table's directory entry and its table data into the font stream at the specified entry offset.
  * @example
  * $directoryEntry = new FontLib\Table\DirectoryEntry($font, $tag, $table);
  * $result = $directoryEntry->encode(2048);
  * var_dump($result); // NULL; table data and directory entry are written directly into the font stream
  * @param int $entry_offset - Offset within the font file where the directory entry should be written.
  * @returns void No return value; the method writes bytes (tag, checksum, offset, length and table data) into the font stream.
  */
  function encode($entry_offset) {
    Font::d("\n==== $this->tag ====");
    //Font::d("Entry offset  = $entry_offset");

    $data = $this->font_table;
    $font = $this->font;

    $table_offset = $font->pos();
    $this->offset = $table_offset;
    $table_length = $data->encode();

    $font->seek($table_offset);
    $table_data = $font->read($table_length);

    $font->seek($entry_offset);

    $font->write($this->tag, 4);
    $font->writeUInt32(self::computeChecksum($table_data));
    $font->writeUInt32($table_offset);
    $font->writeUInt32($table_length);

    Font::d("Bytes written = $table_length");

    $font->seek($table_offset + $table_length);
  }

  /**
   * @return File
   */
  function getFont() {
    return $this->font;
  }

  function startRead() {
    $this->font->seek($this->offset);
  }

  function endRead() {
    //
  }

  function startWrite() {
    $this->font->seek($this->offset);
  }

  function endWrite() {
    //
  }
}

