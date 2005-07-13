<?

require_once(HARMONI."utilities/Magnitude.class.php");

/**
 * A simple Float data type.
 *
 * @package harmoni.datamanager.primitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Float.class.php,v 1.6 2005/07/13 21:00:29 adamfranco Exp $
 */
class Float 
	extends Magnitude
{
	
	var $_float;

	function Float($value=0) {
		$this->_float = (float) $value;
	}
	
	/**
	 * Returns the float value.
	 * @access public
	 * @return float
	 */
	function getFloatValue()
	{
		return $this->_float;
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
		return (string) $this->_float;
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
 		
 		return ($this->_float < $object->getFloatValue())?true:false;
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
 		if (!method_exists($anObject, 'getFloatValue'))
 			return false;
 			
		return $this->_float==$object->getFloatValue()?true:false;
	}
	
	/**
	 * "Adopts" the value of the given {@link Primitive} into this one, assuming it is of the same class.
	 * @param ref object $object The {@link Primitive} to take values from.
	 * @access public
	 * @return void
	 */
	function adoptValue(&$object)
	{
		$this->_float = $object->getFloatValue();
	}	
}