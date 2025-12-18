<?php

namespace Sabberworm\CSS\Value;

use Sabberworm\CSS\Parsing\ParserState;

class URL extends PrimitiveValue {

	private $oURL;

	public function __construct(CSSString $oURL, $iLineNo = 0) {
		parent::__construct($iLineNo);
		$this->oURL = $oURL;
	}

 /**
 * Parse a CSS URL value from the given ParserState and return a URL object.
 * @example
 * $parser = new ParserState('url("http://example.com/image.png")');
 * $result = URL::parse($parser);
 * echo $result; // URL object representing "http://example.com/image.png"
 * @param ParserState $oParserState - ParserState positioned at the start of a URL token or string.
 * @returns URL URL object representing the parsed CSS URL value.
 */
	public static function parse(ParserState $oParserState) {
		$bUseUrl = $oParserState->comes('url', true);
		if ($bUseUrl) {
			$oParserState->consume('url');
			$oParserState->consumeWhiteSpace();
			$oParserState->consume('(');
		}
		$oParserState->consumeWhiteSpace();
		$oResult = new URL(CSSString::parse($oParserState), $oParserState->currentLine());
		if ($bUseUrl) {
			$oParserState->consumeWhiteSpace();
			$oParserState->consume(')');
		}
		return $oResult;
	}


	public function setURL(CSSString $oURL) {
		$this->oURL = $oURL;
	}

	public function getURL() {
		return $this->oURL;
	}

	public function __toString() {
		return $this->render(new \Sabberworm\CSS\OutputFormat());
	}

	public function render(\Sabberworm\CSS\OutputFormat $oOutputFormat) {
		return "url({$this->oURL->render($oOutputFormat)})";
	}

}