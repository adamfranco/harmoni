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
 * @version $Id: HarmoniAuthorizationIterator.class.php,v 1.6 2005/01/19 22:27:48 adamfranco Exp $ */

class HarmoniAuthorizationIterator
	extends AuthorizationIterator
{ // begin AuthorizationIterator

	/**
	 * @var array $_authorizations The stored authorizations.
	 * @access private
	 */
	var $_authorizations = array();
	 
	/**
	 * @var int $_i The current posititon.
	 * @access private
	 */
	var $_i = -1;
	
	/**
	 * Constructor
	 */
	function HarmoniAuthorizationIterator (& $authorizationArray) {
		// make sure that we get an array of Authorization objects
		ArgumentValidator::validate($authorizationArray, new ArrayValidatorRuleWithRule(new ExtendsValidatorRule("Authorization")));
		
		// load the types into our private array
		foreach (array_keys($authorizationArray) as $i => $key) {
			$this->_authorizations[] =& $authorizationArray[$key];
		}
	}

	// public boolean hasNext();
	function hasNext() {
		return ($this->_i < count($this->_authorizations)-1);
	}

	// public Type & next();
	function &next() {
		if ($this->hasNext()) {
			$this->_i++;
			return $this->_authorizations[$this->_i];
		} else {
			throwError(new Error(NO_MORE_ITERATOR_ELEMENTS, "AuthorizationIterator", 1));
		}
	}

} // end AuthorizationIterator


?>