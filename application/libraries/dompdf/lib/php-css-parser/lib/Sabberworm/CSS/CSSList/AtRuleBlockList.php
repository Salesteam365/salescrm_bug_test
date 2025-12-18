<?php

namespace Sabberworm\CSS\CSSList;

use Sabberworm\CSS\Property\AtRule;

/**
 * A BlockList constructed by an unknown @-rule. @media rules are rendered into AtRuleBlockList objects.
 */
class AtRuleBlockList extends CSSBlockList implements AtRule {

	private $sType;
	private $sArgs;

	public function __construct($sType, $sArgs = '', $iLineNo = 0) {
		parent::__construct($iLineNo);
		$this->sType = $sType;
		$this->sArgs = $sArgs;
	}

	public function atRuleName() {
		return $this->sType;
	}

	public function atRuleArgs() {
		return $this->sArgs;
	}

	public function __toString() {
		return $this->render(new \Sabberworm\CSS\OutputFormat());
	}

 /**
 * Render the at-rule block list as a CSS string using the provided output format.
 * @example
 * $format = new \Sabberworm\CSS\OutputFormat(); // formatting helper (example instance)
 * $atRuleBlockList = new \Sabberworm\CSS\CSSList\AtRuleBlockList('media', 'screen and (max-width: 600px)'); // example instance
 * $result = $atRuleBlockList->render($format);
 * echo $result; // outputs something like "@media screen and (max-width: 600px) { /* rules... */
	public function render(\Sabberworm\CSS\OutputFormat $oOutputFormat) {
		$sArgs = $this->sArgs;
		if($sArgs) {
			$sArgs = ' ' . $sArgs;
		}
		$sResult  = $oOutputFormat->sBeforeAtRuleBlock;
		$sResult .= "@{$this->sType}$sArgs{$oOutputFormat->spaceBeforeOpeningBrace()}{";
		$sResult .= parent::render($oOutputFormat);
		$sResult .= '}';
		$sResult .= $oOutputFormat->sAfterAtRuleBlock;
		return $sResult;
	}

	public function isRootList() {
		return false;
	}

}