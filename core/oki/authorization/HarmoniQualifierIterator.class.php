<?php


require_once(OKI."/authorization.interface.php");

// public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

/**
 *
 *
 * @package harmoni.osid.authorization
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniQualifierIterator.class.php,v 1.5 2005/01/19 21:10:03 adamfranco Exp $
 */

class HarmoniQualifierIterator
	extends QualifierIterator
{ // begin QualifierIterator

	/**
	 * @var array $_qualifiers The stored qualifiers.
	 * @access private
	 */
	var $_qualifiers = array();
	 
	/**
	 * @var int $_i The current posititon.
	 * @access private
	 */
	var $_i = -1;
	
	/**
	 * Constructor
	 */
	function HarmoniQualifierIterator (& $qualifierArray) {
		// make sure that we get an array of Qualifier objects
		ArgumentValidator::validate($qualifierArray, new ArrayValidatorRuleWithRule(new ExtendsValidatorRule("Qualifier")));
		
		// load the types into our private array
		foreach (array_keys($qualifierArray) as $i => $key) {
			$this->_qualifiers[] =& $qualifierArray[$key];
		}
	}

	// public boolean hasNext();
	function hasNext() {
		return ($this->_i < count($this->_qualifiers)-1);
	}

	// public Type & next();
	function &next() {
		if ($this->hasNext()) {
			$this->_i++;
			return $this->_qualifiers[$this->_i];
		} else {
			throwError(new Error(NO_MORE_ITERATOR_ELEMENTS, "QualifierIterator", 1));
		}
	}

} // end QualifierIterator


?>