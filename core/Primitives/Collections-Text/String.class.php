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
 * @version $Id: String.class.php,v 1.8 2008/02/14 20:20:24 adamfranco Exp $
 */
class String 
	extends SObject 
{
	
	protected $_string;

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
	
	/**
 	 * Convert 'smart quotes' and other non-UTF8 characters to the UTF8 equivalent.
 	 *
 	 * Method implementation from Chris Shiflett:
 	 *		http://shiflett.org/blog/2005/oct/convert-smart-quotes-with-php
 	 * 
 	 * @param string $inputString
 	 * @return string
 	 * @access public
 	 * @since 6/16/08
 	 */
 	public function convertNonUtf8 () {
		$search = array(	chr(145), 
							chr(146), 
							chr(147), 
							chr(148), 
							chr(151)); 
		
		$replace = array(	"'", 
							"'", 
							'"', 
							'"', 
							'-'); 
		
		// Convert any characters known
		$this->_string = str_replace($search, $replace, $this->asString());
		
		// Strip out any remaining non-UTF8 characters
		$this->_string = @ iconv("UTF-8", "UTF-8//IGNORE", $this->_string);
 	}
}