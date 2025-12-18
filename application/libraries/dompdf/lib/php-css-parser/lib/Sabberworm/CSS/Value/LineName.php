<?php

namespace Sabberworm\CSS\Value;

use Sabberworm\CSS\Parsing\ParserState;
use Sabberworm\CSS\Parsing\UnexpectedTokenException;

class LineName extends ValueList {
	public function __construct($aComponents = array(), $iLineNo = 0) {
		parent::__construct($aComponents, ' ', $iLineNo);
	}

 /**
 * Parse a CSS line-name value from the given parser state (identifiers enclosed in square brackets).
 * @example
 * $oParserState = new ParserState('[foo bar]');
 * $result = LineName::parse($oParserState);
 * print_r($result); // LineName object representing array('foo', 'bar') and its source line number
 * @param {ParserState} $oParserState - The parser state positioned at the opening '[' of a line-name.
 * @returns {LineName} The constructed LineName instance containing parsed identifiers and the originating line number.
 */
	public static function parse(ParserState $oParserState) {
		$oParserState->consume('[');
		$oParserState->consumeWhiteSpace();
		$aNames = array();
		do {
			if($oParserState->getSettings()->bLenientParsing) {
				try {
					$aNames[] = $oParserState->parseIdentifier();
				} catch(UnexpectedTokenException $e) {}
			} else {
				$aNames[] = $oParserState->parseIdentifier();
			}
			$oParserState->consumeWhiteSpace();
		} while (!$oParserState->comes(']'));
		$oParserState->consume(']');
		return new LineName($aNames, $oParserState->currentLine());
	}



	public function __toString() {
		return $this->render(new \Sabberworm\CSS\OutputFormat());
	}

	public function render(\Sabberworm\CSS\OutputFormat $oOutputFormat) {
		return '[' . parent::render(\Sabberworm\CSS\OutputFormat::createCompact()) . ']';
	}

}
