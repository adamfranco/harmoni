<?php

require_once(dirname(__FILE__)."/../Objects/SObject.class.php");


/**
 * A simple String data type.
 *
 * @package harmoni.primitives.collections-text
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: String.class.php,v 1.7 2007/10/10 22:58:33 adamfranco Exp $
 */
class String 
	extends SObject 
{
	
	var $_string;

	function String($string="") {
		$this->_string = (string) $string;
	}
	
	/**
 	 * Answer a String whose characters are a description of the receiver.
 	 * Override this method as needed to provide a better representation
 	 * 
 	 * @return string
 	 * @access public
 	 * @since 7/11/05
 	 */
 	function printableString () {
		return $this->_string;
	}
	
	/**
	 * Instantiates a new String object with the passed value.
	 * @param string $value
	 * @return ref object
	 * @access public
	 * @static
	 */
	static function withValue($value) {
		$string = new String($value);
		return $string;
	}
	
	/**
	 * Instantiates a new String object with the passed value.
	 *
	 * allowing 'fromString' for string values
	 * @param string $aString
	 * @return ref object
	 * @access public
	 * @static
	 */
	static function fromString($aString) {
		$string = new String($aString);
		return $string;
	}

	
	/**
 	 * Answer whether the receiver and the argument are the same.
 	 * If = is redefined in any subclass, consider also redefining the 
	 * message hash.
 	 * 
 	 * @param object $anObject
 	 * @return boolean
 	 * @access public
 	 * @since 7/11/05
 	 */
 	function isEqualTo ( $anObject ) {
 		if (!method_exists($anObject, 'asString'))
 			return false;
 			
		return strcmp($anObject->asString(), $this->asString())==0?true:false;
	}
}