<?

/**
 * A simple String data type.
 *
 * @package harmoni.datamanager.primitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: String.class.php,v 1.6 2005/07/13 20:44:09 adamfranco Exp $
 */
class String extends Primitive /* = implements Primitive */ {
	
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
 		if (!method_exists($anObject, 'asString'))
 			return false;
 			
		return strcmp($object->asString(), $this->asString())==0?true:false;
	}
	
	/**
	 * "Adopts" the value of the given {@link Primitive} into this one, assuming it is of the same class.
	 * @param ref object $object The {@link Primitive} to take values from.
	 * @access public
	 * @return void
	 */
	function adoptValue(&$object)
	{
		$this->_string = $object->asString();
	}	
}