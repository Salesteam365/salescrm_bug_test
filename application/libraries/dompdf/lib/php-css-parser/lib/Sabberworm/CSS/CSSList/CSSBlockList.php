<?php

namespace Sabberworm\CSS\CSSList;

use Sabberworm\CSS\RuleSet\DeclarationBlock;
use Sabberworm\CSS\RuleSet\RuleSet;
use Sabberworm\CSS\Property\Selector;
use Sabberworm\CSS\Rule\Rule;
use Sabberworm\CSS\Value\ValueList;
use Sabberworm\CSS\Value\CSSFunction;

/**
 * A CSSBlockList is a CSSList whose DeclarationBlocks are guaranteed to contain valid declaration blocks or at-rules.
 * Most CSSLists conform to this category but some at-rules (such as @keyframes) do not.
 */
abstract class CSSBlockList extends CSSList {
	public function __construct($iLineNo = 0) {
		parent::__construct($iLineNo);
	}

	protected function allDeclarationBlocks(&$aResult) {
		foreach ($this->aContents as $mContent) {
			if ($mContent instanceof DeclarationBlock) {
				$aResult[] = $mContent;
			} else if ($mContent instanceof CSSBlockList) {
				$mContent->allDeclarationBlocks($aResult);
			}
		}
	}

	protected function allRuleSets(&$aResult) {
		foreach ($this->aContents as $mContent) {
			if ($mContent instanceof RuleSet) {
				$aResult[] = $mContent;
			} else if ($mContent instanceof CSSBlockList) {
				$mContent->allRuleSets($aResult);
			}
		}
	}

 /**
 * Collects all non-list values (or nested list components) from a CSS element into the provided accumulator.
 * @example
 * $result = [];
 * // $oElement can be a CSSBlockList, RuleSet, Rule, ValueList, CSSFunction or a single value element
 * $this->allValues($oElement, $result, 'color', true);
 * var_export($result); // array('red', '#ffffff')
 * @param mixed $oElement - The CSS element to traverse (e.g. CSSBlockList, RuleSet, Rule, ValueList, CSSFunction or a value object).
 * @param array &$aResult - Accumulator (passed by reference) that will be populated with found value objects.
 * @param string|null $sSearchString - Optional search string used to filter rules (default null).
 * @param bool $bSearchInFunctionArguments - Whether to search inside function arguments (default false).
 * @returns void Void; results are appended to $aResult by reference.
 */
	protected function allValues($oElement, &$aResult, $sSearchString = null, $bSearchInFunctionArguments = false) {
		if ($oElement instanceof CSSBlockList) {
			foreach ($oElement->getContents() as $oContent) {
				$this->allValues($oContent, $aResult, $sSearchString, $bSearchInFunctionArguments);
			}
		} else if ($oElement instanceof RuleSet) {
			foreach ($oElement->getRules($sSearchString) as $oRule) {
				$this->allValues($oRule, $aResult, $sSearchString, $bSearchInFunctionArguments);
			}
		} else if ($oElement instanceof Rule) {
			$this->allValues($oElement->getValue(), $aResult, $sSearchString, $bSearchInFunctionArguments);
		} else if ($oElement instanceof ValueList) {
			if ($bSearchInFunctionArguments || !($oElement instanceof CSSFunction)) {
				foreach ($oElement->getListComponents() as $mComponent) {
					$this->allValues($mComponent, $aResult, $sSearchString, $bSearchInFunctionArguments);
				}
			}
		} else {
			//Non-List Value or CSSString (CSS identifier)
			$aResult[] = $oElement;
		}
	}

 /**
 * Collects selectors from all declaration blocks into the provided array, optionally filtering them by a specificity comparison expression.
 * @example
 * $selectors = array();
 * // Collect all selectors
 * $blockList->allSelectors($selectors);
 * echo count($selectors); // render some sample output value, e.g. 10
 *
 * // Collect only selectors matching a specificity comparison (example expression)
 * $filtered = array();
 * $blockList->allSelectors($filtered, '>= 1');
 * echo count($filtered); // render some sample output value, e.g. 3
 * @param array &$aResult - Array passed by reference which will be appended with found selector objects.
 * @param string|null $sSpecificitySearch - Optional comparison string used to filter selectors by specificity (e.g. '>= 1', '== 0'); when null all selectors are added.
 * @returns void No return value; selectors are appended into the provided array by reference.
 */
	protected function allSelectors(&$aResult, $sSpecificitySearch = null) {
		$aDeclarationBlocks = array();
		$this->allDeclarationBlocks($aDeclarationBlocks);
		foreach ($aDeclarationBlocks as $oBlock) {
			foreach ($oBlock->getSelectors() as $oSelector) {
				if ($sSpecificitySearch === null) {
					$aResult[] = $oSelector;
				} else {
					$sComparison = "\$bRes = {$oSelector->getSpecificity()} $sSpecificitySearch;";
					eval($sComparison);
					if ($bRes) {
						$aResult[] = $oSelector;
					}
				}
			}
		}
	}

}
