<?

/**
 * A simple String data type.
 * @package harmoni.datamanager.primitives
 * @copyright 2004
 * @version $Id: String.class.php,v 1.2 2004/07/27 18:15:25 gabeschine Exp $
 */
class String extends Primitive /* = implements Primitive */ {
	
	var $_string;

	function String($string="") {
		$this->_string = (string) $string;
	}
	
	/**
	 * Returns the data in a string format.
	 * @access public
	 * @return string
	 */
	function toString()
	{
		return $this->_string;
	}
	
	/**
	 * Returns true if the object passed is of the same data type with the same value. False otherwise.
	 * @param ref object $object A {@link Primitive} to compare.
	 * @access public
	 * @return boolean
	 */
	function isEqual(&$object)
	{
		return strcmp($object->toString(), $this->toString())==0?true:false;
	}
	
	/**
	 * "Adopts" the value of the given {@link Primitive} into this one, assuming it is of the same class.
	 * @param ref object $object The {@link Primitive} to take values from.
	 * @access public
	 * @return void
	 */
	function adoptValue(&$object)
	{
		$this->_string = $object->toString();
	}
	
	/**
	 * Returns a new {@link Primitive} of the same class with the same value.
	 * @access public
	 * @return ref object
	 */
	function &clone()
	{
		return new String($this->_string);
	}
	
}