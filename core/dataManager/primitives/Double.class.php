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
 * @version $Id: Double.class.php,v 1.3 2005/01/19 21:09:41 adamfranco Exp $
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
	 * Returns true if the object passed is of the same data type with the same value. False otherwise.
	 * @param ref object $object A {@link Primitive} to compare.
	 * @access public
	 * @return boolean
	 */
	function isEqual(&$object)
	{
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
	
	/**
	 * Returns a new {@link Primitive} of the same class with the same value.
	 * @access public
	 * @return ref object
	 */
	function &clone()
	{
		return new Double($this->_float);
	}
	
}