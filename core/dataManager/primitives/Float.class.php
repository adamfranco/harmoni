<?

/**
 * A simple Float data type.
 *
 * @package harmoni.datamanager.primitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Float.class.php,v 1.4 2005/04/12 18:48:04 adamfranco Exp $
 */
class Float extends Primitive /* = implements Primitive */ {
	
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
	 * Returns the data in a string format.
	 * @access public
	 * @return string
	 */
	function toString()
	{
		return (string) $this->_float;
	}
	
	/**
	 * Returns true if the object passed is of the same data type with the same value. False otherwise.
	 * @param ref object $object A {@link Primitive} to compare.
	 * @access public
	 * @return boolean
	 */
	function isEqual(&$object)
	{
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
	
	/**
	 * Returns a new {@link Primitive} of the same class with the same value.
	 * @access public
	 * @return ref object
	 */
	function &replicate()
	{
		return new Float($this->_float);
	}
	
}