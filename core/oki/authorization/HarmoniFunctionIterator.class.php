<?php


require_once(OKI."/authorization.interface.php");

// public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

/**
 *
 *
 * @package harmoni.osid_v1.authorization
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniFunctionIterator.class.php,v 1.7 2005/03/29 19:44:15 adamfranco Exp $ */

class HarmoniFunctionIterator
	extends FunctionIterator
{ // begin FunctionIterator

	/**
	 * @var array $_functions The stored functions.
	 * @access private
	 */
	var $_functions = array();
	 
	/**
	 * @var int $_i The current posititon.
	 * @access private
	 */
	var $_i = -1;
	
	/**
	 * Constructor
	 */
	function HarmoniFunctionIterator (& $functionArray) {
		// make sure that we get an array of Function objects
		ArgumentValidator::validate($functionArray, ArrayValidatorRuleWithRule::getRule(ExtendsValidatorRule::getRule("FunctionInterface")));
		
		// load the types into our private array
		foreach (array_keys($functionArray) as $i => $key) {
			$this->_functions[] =& $functionArray[$key];
		}
	}

	// public boolean hasNext();
	function hasNext() {
		return ($this->_i < count($this->_functions)-1);
	}

	// public Type & next();
	function &next() {
		if ($this->hasNext()) {
			$this->_i++;
			return $this->_functions[$this->_i];
		} else {
			throwError(new Error(NO_MORE_ITERATOR_ELEMENTS, "FunctionIterator", 1));
		}
	}

} // end FunctionIterator


?>