<?php
/**
 * @package php-font-lib
 * @link    https://github.com/PhenX/php-font-lib
 * @author  Fabien Ménager <fabien.menager@gmail.com>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */

namespace FontLib;

/**
 * Encoding map used to map a code point to a Unicode char.
 *
 * @package php-font-lib
 */
class EncodingMap {
  private $f;

  function __construct($file) {
    $this->f = fopen($file, "r");
  }

  /**
   * Parse the encoding map from the file handle ($this->f) and return a mapping of source bytes to [unicode codepoint, glyph name].
   * @example
   * $map = $encodingMap->parse();
   * print_r($map);
   * // Example output:
   * // Array (
   * //   [32] => Array ( [0] => 32, [1] => 'space' ),
   * //   [65] => Array ( [0] => 65, [1] => 'A' ),
   * // )
   * @param resource $f - Open file handle (stored as $this->f) containing encoding lines (e.g. "!20 U+00A0 nbsp").
   * @returns array Map where keys are source byte values (int) and values are arrays: [unicode_codepoint (int), glyph_name (string)].
   */
  function parse() {
    $map = array();

    while ($line = fgets($this->f)) {
      if (preg_match('/^[\!\=]([0-9A-F]{2,})\s+U\+([0-9A-F]{2})([0-9A-F]{2})\s+([^\s]+)/', $line, $matches)) {
        $unicode = (hexdec($matches[2]) << 8) + hexdec($matches[3]);
        $map[hexdec($matches[1])] = array($unicode, $matches[4]);
      }
    }

    ksort($map);

    return $map;
  }
}
