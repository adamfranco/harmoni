<?

/**
 * A simple Boolean data type.
 *
 * @package harmoni.datamanager.primitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Boolean.class.php,v 1.5 2005/07/13 20:16:31 adamfranco Exp $
 */
class Boolean extends Primitive /* = implements Primitive */ {
	
	var $_bool;

	function Boolean($value=true) {
		$this->_bool = (bool) $value;
	}
	
	/**
	 * Returns the boolean value.
	 * @access public
	 * @return boolean
	 */
	function getBooleanValue()
	{
		return $this->_bool;
	}
	
	/**
	 * "Adopts" the value of the given {@link Primitive} into this one, assuming it is of the same class.
	 * @param ref object $object The {@link Primitive} to take values from.
	 * @access public
	 * @return void
	 */
	function adoptValue(&$object)
	{
		$this->_bool = $object->getBooleanValue();
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
		return $this->_bool?"true":"false";
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
 		if (!method_exists($anObject, 'getBooleanValue'))
 			return false;
 			
		return ($this->_bool===$object->getBooleanValue())?true:false;
	}	
}