<?

/**
 * A simple Integer data type.
 *
 * @package harmoni.datamanager.primitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Integer.class.php,v 1.3 2005/01/19 21:09:41 adamfranco Exp $
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
	 * Returns the data in a string format.
	 * @access public
	 * @return string
	 */
	function toString()
	{
		return (string) $this->_int;
	}
	
	/**
	 * Returns true if the object passed is of the same data type with the same value. False otherwise.
	 * @param ref object $object A {@link Primitive} to compare.
	 * @access public
	 * @return boolean
	 */
	function isEqual(&$object)
	{
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
	
	/**
	 * Returns a new {@link Primitive} of the same class with the same value.
	 * @access public
	 * @return ref object
	 */
	function &clone()
	{
		return new Integer($this->_int);
	}
	
}