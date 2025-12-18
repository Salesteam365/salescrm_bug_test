<?php

namespace Sabberworm\CSS\Value;

use Sabberworm\CSS\Parsing\ParserState;

class Color extends CSSFunction {

	public function __construct($aColor, $iLineNo = 0) {
		parent::__construct(implode('', array_keys($aColor)), $aColor, ',', $iLineNo);
	}

 /**
 * Parse a color from the given ParserState and return a Color object.
 * @example
 * $parserState = new ParserState('#ff000080'); // hex with alpha (rgba(255,0,0,0.5))
 * $result = Color::parse($parserState);
 * var_dump($result); // Color object representing r=255, g=0, b=0, a=0.5
 * @param {{ParserState}} {{$oParserState}} - The ParserState instance positioned at the color token to parse.
 * @returns {{Color}} The parsed Color instance containing r, g, b (and optional a) components.
 */
	public static function parse(ParserState $oParserState) {
		$aColor = array();
		if ($oParserState->comes('#')) {
			$oParserState->consume('#');
			$sValue = $oParserState->parseIdentifier(false);
			if ($oParserState->strlen($sValue) === 3) {
				$sValue = $sValue[0] . $sValue[0] . $sValue[1] . $sValue[1] . $sValue[2] . $sValue[2];
			} else if ($oParserState->strlen($sValue) === 4) {
				$sValue = $sValue[0] . $sValue[0] . $sValue[1] . $sValue[1] . $sValue[2] . $sValue[2] . $sValue[3] . $sValue[3];
			}

			if ($oParserState->strlen($sValue) === 8) {
				$aColor = array(
					'r' => new Size(intval($sValue[0] . $sValue[1], 16), null, true, $oParserState->currentLine()),
					'g' => new Size(intval($sValue[2] . $sValue[3], 16), null, true, $oParserState->currentLine()),
					'b' => new Size(intval($sValue[4] . $sValue[5], 16), null, true, $oParserState->currentLine()),
					'a' => new Size(round(self::mapRange(intval($sValue[6] . $sValue[7], 16), 0, 255, 0, 1), 2), null, true, $oParserState->currentLine())
				);
			} else {
				$aColor = array(
					'r' => new Size(intval($sValue[0] . $sValue[1], 16), null, true, $oParserState->currentLine()),
					'g' => new Size(intval($sValue[2] . $sValue[3], 16), null, true, $oParserState->currentLine()),
					'b' => new Size(intval($sValue[4] . $sValue[5], 16), null, true, $oParserState->currentLine())
				);
			}
		} else {
			$sColorMode = $oParserState->parseIdentifier(true);
			$oParserState->consumeWhiteSpace();
			$oParserState->consume('(');
			$iLength = $oParserState->strlen($sColorMode);
			for ($i = 0; $i < $iLength; ++$i) {
				$oParserState->consumeWhiteSpace();
				$aColor[$sColorMode[$i]] = Size::parse($oParserState, true);
				$oParserState->consumeWhiteSpace();
				if ($i < ($iLength - 1)) {
					$oParserState->consume(',');
				}
			}
			$oParserState->consume(')');
		}
		return new Color($aColor, $oParserState->currentLine());
	}

	private static function mapRange($fVal, $fFromMin, $fFromMax, $fToMin, $fToMax) {
		$fFromRange = $fFromMax - $fFromMin;
		$fToRange = $fToMax - $fToMin;
		$fMultiplier = $fToRange / $fFromRange;
		$fNewVal = $fVal - $fFromMin;
		$fNewVal *= $fMultiplier;
		return $fNewVal + $fToMin;
	}

	public function getColor() {
		return $this->aComponents;
	}

	public function setColor($aColor) {
		$this->setName(implode('', array_keys($aColor)));
		$this->aComponents = $aColor;
	}

	public function getColorDescription() {
		return $this->getName();
	}

	public function __toString() {
		return $this->render(new \Sabberworm\CSS\OutputFormat());
	}

 /**
 * Render the color as a CSS string, using 3-digit hexadecimal shorthand when the output format allows it and the color components permit.
 * @example
 * // Assume $color is an instance of Sabberworm\CSS\Value\Color with components r=255, g=204, b=0
 * $oOutputFormat = new \Sabberworm\CSS\OutputFormat();
 * // When RGB hash shorthand is allowed:
 * // (e.g. $oOutputFormat->getRGBHashNotation() === true)
 * echo $color->render($oOutputFormat); // '#fc0'
 * // When RGB hash shorthand is not allowed:
 * // (e.g. $oOutputFormat->getRGBHashNotation() === false)
 * echo $color->render($oOutputFormat); // '#ffcc00'
 * @param \Sabberworm\CSS\OutputFormat $oOutputFormat - Output format instance that controls rendering options (e.g. whether RGB hash shorthand is allowed).
 * @returns string Return the rendered CSS color string (e.g. '#fc0' or '#ffcc00').
 */
	public function render(\Sabberworm\CSS\OutputFormat $oOutputFormat) {
		// Shorthand RGB color values
		if($oOutputFormat->getRGBHashNotation() && implode('', array_keys($this->aComponents)) === 'rgb') {
			$sResult = sprintf(
				'%02x%02x%02x',
				$this->aComponents['r']->getSize(),
				$this->aComponents['g']->getSize(),
				$this->aComponents['b']->getSize()
			);
			return '#'.(($sResult[0] == $sResult[1]) && ($sResult[2] == $sResult[3]) && ($sResult[4] == $sResult[5]) ? "$sResult[0]$sResult[2]$sResult[4]" : $sResult);
		}
		return parent::render($oOutputFormat);
	}
}
