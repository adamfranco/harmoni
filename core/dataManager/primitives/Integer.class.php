<?

/**
 * A simple Integer data type.
 *
 * @package harmoni.datamanager.primitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Integer.class.php,v 1.5 2005/07/13 20:16:31 adamfranco Exp $
 */
class Integer extends Primitive /* = implements Primitive */ {
	
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
	
	/**
	 * "Adopts" the value of the given {@link Primitive} into this one, assuming it is of the same class.
	 * @param ref object $object The {@link Primitive} to take values from.
	 * @access public
	 * @return void
	 */
	function adoptValue(&$object)
	{
		$this->_int = $object->getIntegerValue();
	}	
}