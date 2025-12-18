<?php

namespace Sabberworm\CSS\Parsing;

/**
* Thrown if the CSS parsers encounters a token it did not expect
*/
class UnexpectedTokenException extends SourceException {
	private $sExpected;
	private $sFound;
	// Possible values: literal, identifier, count, expression, search
	private $sMatchType;

 /**
  * Constructs an UnexpectedTokenException containing details about the expected token, the token actually found, the matching strategy, and the line number; prepares the exception message accordingly.
  * @example
  * $ex = new UnexpectedTokenException('div', '<span>', 'literal', 12);
  * echo $ex->getMessage(); // Token “{div}” (literal) not found. Got “<span>”.
  * @param {string} $sExpected - Expected token or pattern (e.g. 'div', '3', 'identifier', or a custom message).
  * @param {string} $sFound - The actual token or context found (e.g. '<span>', 'context text').
  * @param {string} $sMatchType - Match type: 'literal' (default), 'search', 'count', 'identifier', or 'custom'.
  * @param {int} $iLineNo - Line number where the unexpected token was encountered (default 0).
  * @returns {void} Constructor does not return a value; it initializes the exception message and state.
  */
	public function __construct($sExpected, $sFound, $sMatchType = 'literal', $iLineNo = 0) {
		$this->sExpected = $sExpected;
		$this->sFound = $sFound;
		$this->sMatchType = $sMatchType;
		$sMessage = "Token “{$sExpected}” ({$sMatchType}) not found. Got “{$sFound}”.";
		if($this->sMatchType === 'search') {
			$sMessage = "Search for “{$sExpected}” returned no results. Context: “{$sFound}”.";
		} else if($this->sMatchType === 'count') {
			$sMessage = "Next token was expected to have {$sExpected} chars. Context: “{$sFound}”.";
		} else if($this->sMatchType === 'identifier') {
			$sMessage = "Identifier expected. Got “{$sFound}”";
		} else if($this->sMatchType === 'custom') {
			$sMessage = trim("$sExpected $sFound");
		}

		parent::__construct($sMessage, $iLineNo);
	}
}