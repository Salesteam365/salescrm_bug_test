<?php
/**
 * @package php-svg-lib
 * @link    http://github.com/PhenX/php-svg-lib
 * @author  Fabien M�nager <fabien.menager@gmail.com>
 * @license GNU LGPLv3+ http://www.gnu.org/copyleft/lesser.html
 */

namespace Svg\Surface;

use Svg\Style;

class SurfaceGmagick implements SurfaceInterface
{
    const DEBUG = false;

    /** @var \GmagickDraw */
    private $canvas;

    private $width;
    private $height;

    /** @var Style */
    private $style;

    /**
     * Construct a SurfaceGmagick instance with the specified width and height and initialize the Gmagick drawing canvas.
     * @example
     * $surface = new \Svg\Surface\SurfaceGmagick(800, 600);
     * echo get_class($surface->canvas); // GmagickDraw
     * @param {int} $w - Width of the surface in pixels.
     * @param {int} $h - Height of the surface in pixels.
     * @returns {void} Constructor does not return a value; it initializes internal properties.
     */
    public function __construct($w, $h)
    {
        if (self::DEBUG) {
            echo __FUNCTION__ . "\n";
        }
        $this->width = $w;
        $this->height = $h;

        $canvas = new \GmagickDraw();

        $this->canvas = $canvas;
    }

    /**
    * Render the SVG surface to an image and return the raw image data.
    * @example
    * $result = $this->out();
    * // $result contains raw image bytes (e.g. PNG/GIF/etc.) or false on failure
    * echo strlen($result); // render some sample output value; e.g. 10234
    * @returns {string|false} Raw image data as a string on success, or false on failure.
    */
    function out()
    {
        if (self::DEBUG) {
            echo __FUNCTION__ . "\n";
        }

        $image = new \Gmagick();
        $image->newimage($this->width, $this->height);
        $image->drawimage($this->canvas);

        $tmp = tempnam("", "gm");

        $image->write($tmp);

        return file_get_contents($tmp);
    }

    public function save()
    {
        if (self::DEBUG) {
            echo __FUNCTION__ . "\n";
        }
        $this->canvas->save();
    }

    public function restore()
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $this->canvas->restore();
    }

    public function scale($x, $y)
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $this->canvas->scale($x, $y);
    }

    public function rotate($angle)
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $this->canvas->rotate($angle);
    }

    public function translate($x, $y)
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $this->canvas->translate($x, $y);
    }

    public function transform($a, $b, $c, $d, $e, $f)
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $this->canvas->concat($a, $b, $c, $d, $e, $f);
    }

    public function beginPath()
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        // TODO: Implement beginPath() method.
    }

    public function closePath()
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $this->canvas->closepath();
    }

    public function fillStroke()
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $this->canvas->fill_stroke();
    }

    public function clip()
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $this->canvas->clip();
    }

    public function fillText($text, $x, $y, $maxWidth = null)
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $this->canvas->set_text_pos($x, $y);
        $this->canvas->show($text);
    }

    public function strokeText($text, $x, $y, $maxWidth = null)
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        // TODO: Implement drawImage() method.
    }

    /**
    * Draws an image onto the Gmagick surface, handling data URIs (including base64) and fitting the image into the specified box.
    * @example
    * $this->drawImage('data:image/svg+xml;base64,PHN2ZyB4bWxucz0i...', 10, 150, 100, 50);
    * // Draws the decoded SVG onto the canvas at x=10 and adjusted y position; no return value.
    * @param {string} $image - Path to an image file or a data URI (e.g. "data:image/png;base64,...").
    * @param {float|int} $sx - X coordinate where the image should be placed on the surface.
    * @param {float|int} $sy - Y coordinate where the image should be placed on the surface (internally adjusted by subtracting $sh).
    * @param {float|int|null} $sw - Width of the source/box to fit the image into (optional).
    * @param {float|int|null} $sh - Height of the source/box to fit the image into (optional).
    * @param {float|int|null} $dx - Destination X coordinate (not used by this implementation, optional).
    * @param {float|int|null} $dy - Destination Y coordinate (not used by this implementation, optional).
    * @param {float|int|null} $dw - Destination width (not used by this implementation, optional).
    * @param {float|int|null} $dh - Destination height (not used by this implementation, optional).
    * @returns {void} Void; the image is rendered directly onto the surface and nothing is returned.
    */
    public function drawImage($image, $sx, $sy, $sw = null, $sh = null, $dx = null, $dy = null, $dw = null, $dh = null)
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";

        if (strpos($image, "data:") === 0) {
            $data = substr($image, strpos($image, ";") + 1);
            if (strpos($data, "base64") === 0) {
                $data = base64_decode(substr($data, 7));
            }

            $image = tempnam("", "svg");
            file_put_contents($image, $data);
        }

        $img = $this->canvas->load_image("auto", $image, "");

        $sy = $sy - $sh;
        $this->canvas->fit_image($img, $sx, $sy, 'boxsize={' . "$sw $sh" . '} fitmethod=entire');
    }

    public function lineTo($x, $y)
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $this->canvas->lineto($x, $y);
    }

    public function moveTo($x, $y)
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $this->canvas->moveto($x, $y);
    }

    public function quadraticCurveTo($cpx, $cpy, $x, $y)
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        // TODO: Implement quadraticCurveTo() method.
    }

    public function bezierCurveTo($cp1x, $cp1y, $cp2x, $cp2y, $x, $y)
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $this->canvas->curveto($cp1x, $cp1y, $cp2x, $cp2y, $x, $y);
    }

    public function arcTo($x1, $y1, $x2, $y2, $radius)
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
    }

    public function arc($x, $y, $radius, $startAngle, $endAngle, $anticlockwise = false)
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $this->canvas->arc($x, $y, $radius, $startAngle, $endAngle);
    }

    public function circle($x, $y, $radius)
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $this->canvas->circle($x, $y, $radius);
    }

    public function ellipse($x, $y, $radiusX, $radiusY, $rotation, $startAngle, $endAngle, $anticlockwise)
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $this->canvas->ellipse($x, $y, $radiusX, $radiusY);
    }

    public function fillRect($x, $y, $w, $h)
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $this->rect($x, $y, $w, $h);
        $this->fill();
    }

    public function rect($x, $y, $w, $h, $rx = 0, $ry = 0)
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $this->canvas->rect($x, $y, $w, $h);
    }

    public function fill()
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $this->canvas->fill();
    }

    public function strokeRect($x, $y, $w, $h)
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $this->rect($x, $y, $w, $h);
        $this->stroke();
    }

    public function stroke()
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $this->canvas->stroke();
    }

    public function endPath()
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        //$this->canvas->endPath();
    }

    public function measureText($text)
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";
        $style = $this->getStyle();
        $font = $this->getFont($style->fontFamily, $style->fontStyle);

        return $this->canvas->stringwidth($text, $font, $this->getStyle()->fontSize);
    }

    public function getStyle()
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";

        return $this->style;
    }

    /**
    * Apply the given Style to the Gmagick drawing surface (sets stroke color, stroke width, linecap, linejoin, and font).
    * @example
    * $style = new Style();
    * $style->stroke = [255, 0, 0]; // red stroke RGB
    * $style->fill = [0, 255, 0]; // green fill RGB (fill application commented out in this implementation)
    * $style->strokeWidth = 2;
    * $style->strokeLinecap = 'round';
    * $style->strokeLinejoin = 'miter';
    * $style->fontFamily = 'Arial';
    * $style->fontStyle = 'normal';
    * $style->fontSize = 12;
    * $surface->setStyle($style);
    * // No return value; the canvas graphics options and font are updated.
    * @param Style $style - Style object containing stroke, fill, strokeWidth, strokeLinecap, strokeLinejoin, fontFamily, fontStyle and fontSize.
    * @returns void No return value; updates the internal canvas (graphics options and font) based on the provided style.
    */
    public function setStyle(Style $style)
    {
        if (self::DEBUG) echo __FUNCTION__ . "\n";

        $this->style = $style;
        $canvas = $this->canvas;

        if (is_array($style->stroke) && $stroke = $style->stroke) {
            $canvas->setcolor("stroke", "rgb", $stroke[0] / 255, $stroke[1] / 255, $stroke[2] / 255, null);
        }

        if (is_array($style->fill) && $fill = $style->fill) {
           // $canvas->setcolor("fill", "rgb", $fill[0] / 255, $fill[1] / 255, $fill[2] / 255, null);
        }

        $opts = array();
        if ($style->strokeWidth > 0.000001) {
            $opts[] = "linewidth=$style->strokeWidth";
        }

        if (in_array($style->strokeLinecap, array("butt", "round", "projecting"))) {
            $opts[] = "linecap=$style->strokeLinecap";
        }

        if (in_array($style->strokeLinejoin, array("miter", "round", "bevel"))) {
            $opts[] = "linejoin=$style->strokeLinejoin";
        }

        $canvas->set_graphics_option(implode(" ", $opts));

        $font = $this->getFont($style->fontFamily, $style->fontStyle);
        $canvas->setfont($font, $style->fontSize);
    }

    /****
    * Map a CSS font-family (including generic keywords) to a concrete font name and load it from the canvas.
    * @example
    * $font = $this->getFont('sans-serif', 'normal');
    * var_dump($font); // e.g. resource|object returned by canvas->load_font (font handle)
    * @param {string} $family - Font family name or CSS generic family (e.g. 'serif', 'sans-serif', 'fantasy', 'cursive', 'monospance').
    * @param {string} $style - Font style/options string passed to the canvas loader (e.g. 'normal', 'bold', 'italic').
    * @returns {mixed} The font resource/object returned by canvas->load_font, or null on failure.
    */
    private function getFont($family, $style)
    {
        $map = array(
            "serif"      => "Times",
            "sans-serif" => "Helvetica",
            "fantasy"    => "Symbol",
            "cursive"    => "serif",
            "monospance" => "Courier",
        );

        $family = strtolower($family);
        if (isset($map[$family])) {
            $family = $map[$family];
        }

        return $this->canvas->load_font($family, "unicode", "fontstyle=$style");
    }

    public function setFont($family, $style, $weight)
    {
        // TODO: Implement setFont() method.
    }
}