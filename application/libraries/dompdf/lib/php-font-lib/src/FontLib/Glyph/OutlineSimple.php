<?php
/**
 * @package php-font-lib
 * @link    https://github.com/PhenX/php-font-lib
 * @author  Fabien Ménager <fabien.menager@gmail.com>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @version $Id: Font_Table_glyf.php 46 2012-04-02 20:22:38Z fabien.menager $
 */

namespace FontLib\Glyph;

/**
 * `glyf` font table.
 *
 * @package php-font-lib
 */
class OutlineSimple extends Outline {
  const ON_CURVE       = 0x01;
  const X_SHORT_VECTOR = 0x02;
  const Y_SHORT_VECTOR = 0x04;
  const REPEAT         = 0x08;
  const THIS_X_IS_SAME = 0x10;
  const THIS_Y_IS_SAME = 0x20;

  public $instructions;
  public $points;

  /**
  * Parse simple glyph outline data from the current font stream and populate the glyph's points and instructions.
  * It reads contour end points, instruction bytes, flag arrays (including repeated flags), and delta-encoded X/Y coordinates
  * according to the TrueType/OpenType "simple glyph" format, then builds $this->points and $this->instructions.
  * @example
  * $glyph = $font->getGlyph($gid); // obtain glyph instance from the font library
  * $glyph->parseData();
  * // After parsing:
  * echo json_encode($glyph->instructions); // e.g. "[10,21,0]"
  * echo json_encode($glyph->points); // e.g. '[{"onCurve":true,"endOfContour":false,"x":0,"y":0},{"onCurve":false,"endOfContour":true,"x":120,"y":-30}]'
  * @param void $none - This method accepts no parameters.
  * @returns void Populates $this->points (array of points with keys "x", "y", "onCurve", "endOfContour") and $this->instructions (byte array); does not return a value.
  */
  function parseData() {
    parent::parseData();

    if (!$this->size) {
      return;
    }

    $font = $this->getFont();

    $noc = $this->numberOfContours;

    if ($noc == 0) {
      return;
    }

    $endPtsOfContours = $font->r(array(self::uint16, $noc));

    $instructionLength  = $font->readUInt16();
    $this->instructions = $font->r(array(self::uint8, $instructionLength));

    $count = $endPtsOfContours[$noc - 1] + 1;

    // Flags
    $flags = array();
    for ($index = 0; $index < $count; $index++) {
      $flags[$index] = $font->readUInt8();

      if ($flags[$index] & self::REPEAT) {
        $repeats = $font->readUInt8();

        for ($i = 1; $i <= $repeats; $i++) {
          $flags[$index + $i] = $flags[$index];
        }

        $index += $repeats;
      }
    }

    $points = array();
    foreach ($flags as $i => $flag) {
      $points[$i]["onCurve"]      = $flag & self::ON_CURVE;
      $points[$i]["endOfContour"] = in_array($i, $endPtsOfContours);
    }

    // X Coords
    $x = 0;
    for ($i = 0; $i < $count; $i++) {
      $flag = $flags[$i];

      if ($flag & self::THIS_X_IS_SAME) {
        if ($flag & self::X_SHORT_VECTOR) {
          $x += $font->readUInt8();
        }
      }
      else {
        if ($flag & self::X_SHORT_VECTOR) {
          $x -= $font->readUInt8();
        }
        else {
          $x += $font->readInt16();
        }
      }

      $points[$i]["x"] = $x;
    }

    // Y Coords
    $y = 0;
    for ($i = 0; $i < $count; $i++) {
      $flag = $flags[$i];

      if ($flag & self::THIS_Y_IS_SAME) {
        if ($flag & self::Y_SHORT_VECTOR) {
          $y += $font->readUInt8();
        }
      }
      else {
        if ($flag & self::Y_SHORT_VECTOR) {
          $y -= $font->readUInt8();
        }
        else {
          $y += $font->readInt16();
        }
      }

      $points[$i]["y"] = $y;
    }

    $this->points = $points;
  }

  public function splitSVGPath($path) {
    preg_match_all('/([a-z])|(-?\d+(?:\.\d+)?)/i', $path, $matches, PREG_PATTERN_ORDER);

    return $matches[0];
  }

  /**
   * Convert an SVG path string (or token array) into an array of point descriptors for a glyph outline.
   * @example
   * $outline = new FontLib\Glyph\OutlineSimple();
   * $result = $outline->makePoints('M10 10 L20 20 Q15 15 25 25 z');
   * echo json_encode($result); // [{"onCurve":true,"x":10,"y":10,"endOfContour":false},{"onCurve":true,"x":20,"y":20,"endOfContour":false},{"onCurve":false,"x":15,"y":15,"endOfContour":false},{"onCurve":true,"x":25,"y":25,"endOfContour":true}]
   * @param string|array $path - SVG path data as a string or an already tokenized path array.
   * @returns array Array of points; each point is an associative array with keys 'onCurve' (bool), 'x' (number), 'y' (number), and 'endOfContour' (bool).
   */
  public function makePoints($path) {
    $path = $this->splitSVGPath($path);
    $l    = count($path);
    $i    = 0;

    $points = array();

    while ($i < $l) {
      switch ($path[$i]) {
        // moveTo
        case "M":
          $points[] = array(
            "onCurve"      => true,
            "x"            => $path[++$i],
            "y"            => $path[++$i],
            "endOfContour" => false,
          );
          break;

        // lineTo
        case "L":
          $points[] = array(
            "onCurve"      => true,
            "x"            => $path[++$i],
            "y"            => $path[++$i],
            "endOfContour" => false,
          );
          break;

        // quadraticCurveTo
        case "Q":
          $points[] = array(
            "onCurve"      => false,
            "x"            => $path[++$i],
            "y"            => $path[++$i],
            "endOfContour" => false,
          );
          $points[] = array(
            "onCurve"      => true,
            "x"            => $path[++$i],
            "y"            => $path[++$i],
            "endOfContour" => false,
          );
          break;

        // closePath
        /** @noinspection PhpMissingBreakStatementInspection */
        case "z":
          $points[count($points) - 1]["endOfContour"] = true;

        default:
          $i++;
          break;
      }
    }

    return $points;
  }

  function encode() {
    if (empty($this->points)) {
      return parent::encode();
    }

    return $this->size = $this->encodePoints($this->points);
  }

  /**
  * Encode an array of outline points into the font binary (glyf) structure and write contour end points, flags and coordinate deltas to the font buffer. Updates local bounds while encoding and returns the total number of bytes written.
  * @example
  * $points = [
  *   ['x' => 0,  'y' => 0,  'onCurve' => true,  'endOfContour' => false],
  *   ['x' => 50, 'y' => 0,  'onCurve' => false, 'endOfContour' => true],
  * ];
  * $bytes = $outline->encodePoints($points);
  * echo $bytes; // e.g. 34
  * @param {array} $points - Array of associative arrays describing points. Each point should have keys: 'x' (int), 'y' (int), 'onCurve' (bool), and 'endOfContour' (bool).
  * @returns {int} Total number of bytes written to the font buffer.
  */
  public function encodePoints($points) {
    $endPtsOfContours = array();
    $flags            = array();
    $coords_x         = array();
    $coords_y         = array();

    $last_x = 0;
    $last_y = 0;
    $xMin   = $yMin = 0xFFFF;
    $xMax   = $yMax = -0xFFFF;
    foreach ($points as $i => $point) {
      $flag = 0;
      if ($point["onCurve"]) {
        $flag |= self::ON_CURVE;
      }

      if ($point["endOfContour"]) {
        $endPtsOfContours[] = $i;
      }

      // Simplified, we could do some optimizations
      if ($point["x"] == $last_x) {
        $flag |= self::THIS_X_IS_SAME;
      }
      else {
        $x          = intval($point["x"]);
        $xMin       = min($x, $xMin);
        $xMax       = max($x, $xMax);
        $coords_x[] = $x - $last_x; // int16
      }

      // Simplified, we could do some optimizations
      if ($point["y"] == $last_y) {
        $flag |= self::THIS_Y_IS_SAME;
      }
      else {
        $y          = intval($point["y"]);
        $yMin       = min($y, $yMin);
        $yMax       = max($y, $yMax);
        $coords_y[] = $y - $last_y; // int16
      }

      $flags[] = $flag;
      $last_x  = $point["x"];
      $last_y  = $point["y"];
    }

    $font = $this->getFont();

    $l = 0;
    $l += $font->writeInt16(count($endPtsOfContours)); // endPtsOfContours
    $l += $font->writeFWord(isset($this->xMin) ? $this->xMin : $xMin); // xMin
    $l += $font->writeFWord(isset($this->yMin) ? $this->yMin : $yMin); // yMin
    $l += $font->writeFWord(isset($this->xMax) ? $this->xMax : $xMax); // xMax
    $l += $font->writeFWord(isset($this->yMax) ? $this->yMax : $yMax); // yMax

    // Simple glyf
    $l += $font->w(array(self::uint16, count($endPtsOfContours)), $endPtsOfContours); // endPtsOfContours
    $l += $font->writeUInt16(0); // instructionLength
    $l += $font->w(array(self::uint8, count($flags)), $flags); // flags
    $l += $font->w(array(self::int16, count($coords_x)), $coords_x); // xCoordinates
    $l += $font->w(array(self::int16, count($coords_y)), $coords_y); // yCoordinates
    return $l;
  }

  /**
  * Builds and returns an SVG path string describing the contours from the given glyph points.
  * @example
  * $points = [
  *   ['x' => 10, 'y' => 10, 'endOfContour' => false],
  *   ['x' => 20, 'y' => 10, 'endOfContour' => true]
  * ];
  * $svg = $glyph->getSVGContours($points);
  * echo $svg // "M10 10L20 10Z"
  * @param array|null $points - Array of associative point arrays with keys 'x', 'y' and 'endOfContour'. If null, uses the object's parsed points.
  * @returns string Return SVG path data string representing one or more contours.
  */
  public function getSVGContours($points = null) {
    $path = "";

    if (!$points) {
      if (empty($this->points)) {
        $this->parseData();
      }

      $points = $this->points;
    }

    $length     = count($points);
    $firstIndex = 0;
    $count      = 0;

    for ($i = 0; $i < $length; $i++) {
      $count++;

      if ($points[$i]["endOfContour"]) {
        $path .= $this->getSVGPath($points, $firstIndex, $count);
        $firstIndex = $i + 1;
        $count      = 0;
      }
    }

    return $path;
  }

  /**
  * Convert a sequence of glyph outline points into a closed SVG path string.
  * @example
  * $points = [
  *   ['x' => 0,   'y' => 0,   'onCurve' => true],
  *   ['x' => 50,  'y' => 0,   'onCurve' => false],
  *   ['x' => 100, 'y' => 0,   'onCurve' => true],
  * ];
  * $result = $this->getSVGPath($points, 0, 3);
  * echo $result // renders: "M0,0 Q50,0,100,0 z ";
  * @param array $points - Array of associative arrays describing points. Each point must contain keys 'x' (number), 'y' (number) and 'onCurve' (bool).
  * @param int $startIndex - Starting index in the $points array for the contour.
  * @param int $count - Number of points in the contour to process.
  * @returns string Return the generated SVG path commands (closed with 'z ').
  */
  protected function getSVGPath($points, $startIndex, $count) {
    $offset = 0;
    $path   = "";

    while ($offset < $count) {
      $point    = $points[$startIndex + $offset % $count];
      $point_p1 = $points[$startIndex + ($offset + 1) % $count];

      if ($offset == 0) {
        $path .= "M{$point['x']},{$point['y']} ";
      }

      if ($point["onCurve"]) {
        if ($point_p1["onCurve"]) {
          $path .= "L{$point_p1['x']},{$point_p1['y']} ";
          $offset++;
        }
        else {
          $point_p2 = $points[$startIndex + ($offset + 2) % $count];

          if ($point_p2["onCurve"]) {
            $path .= "Q{$point_p1['x']},{$point_p1['y']},{$point_p2['x']},{$point_p2['y']} ";
          }
          else {
            $path .= "Q{$point_p1['x']},{$point_p1['y']}," . $this->midValue($point_p1['x'], $point_p2['x']) . "," . $this->midValue($point_p1['y'], $point_p2['y']) . " ";
          }

          $offset += 2;
        }
      }
      else {
        if ($point_p1["onCurve"]) {
          $path .= "Q{$point['x']},{$point['y']},{$point_p1['x']},{$point_p1['y']} ";
        }
        else {
          $path .= "Q{$point['x']},{$point['y']}," . $this->midValue($point['x'], $point_p1['x']) . "," . $this->midValue($point['y'], $point_p1['y']) . " ";
        }

        $offset++;
      }
    }

    $path .= "z ";

    return $path;
  }

  function midValue($a, $b) {
    return $a + ($b - $a) / 2;
  }
}