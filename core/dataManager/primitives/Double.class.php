<?

require_once(HARMONI."dataManager/primitives/Float.class.php");

/**
 * A simple Double data type.
 *
 * @package harmoni.datamanager.primitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Double.class.php,v 1.5 2005/07/13 20:16:31 adamfranco Exp $
 */
class Double extends Float {

	function Double($value=0) {
		parent::Float($value);
	}
	
	/**
	 * Returns the Double value of this object.
	 * @access public
	 * @return double
	 */
	function getDoubleValue()
	{
		return $this->getFloatValue();
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
 		if (!method_exists($anObject, 'getDoubleValue'))
 			return false;
 		
		return $this->_float==$object->getDoubleValue()?true:false;
	}
	
	/**
	 * "Adopts" the value of the given {@link Primitive} into this one, assuming it is of the same class.
	 * @param ref object $object The {@link Primitive} to take values from.
	 * @access public
	 * @return void
	 */
	function adoptValue(&$object)
	{
		$this->_float = $object->getDoubleValue();
	}	
}