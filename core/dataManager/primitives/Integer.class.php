<?

require_once(HARMONI."utilities/Magnitude.class.php");

/**
 * A simple Integer data type.
 *
 * @package harmoni.datamanager.primitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Integer.class.php,v 1.6 2005/07/13 21:00:29 adamfranco Exp $
 */
class Integer 
	extends Magnitude
{
	
	var $_int;

	function Integer($value=0) {
		$this->_int = (int) $value;
	}
	
	/**
	 * Returns the integer value.
	 * @access public
	 * @return int
	 */
	function getIntegerValue()
	{
		return $this->_int;
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
		return (string) $this->_int;
	}
	
	/**
	 * Test if this is less than aMagnitude.
	 * 
	 * @param object Magnitude $aMagnitude
	 * @return boolean
	 * @access public
	 * @since 5/4/05
	 */
	function isLessThan ( &$aMagnitude ) {
		if (!method_exists($anObject, 'getFloatValue'))
 			return false;
 		
 		return ($this->_int < $object->getFloatValue())?true:false;
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
 	function isEqualTo ( &$anObject ) {
 		if (!method_exists($anObject, 'getIntegerValue'))
 			return false;
 			
		return $this->_int==$object->getIntegerValue()?true:false;
	}	
}