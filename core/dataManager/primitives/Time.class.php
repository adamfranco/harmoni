<?

require_once(HARMONI."utilities/DateTime.class.php");

/**
 * A simple Time (and date) data type, which takes advantage of the {@link DateTime} utility class.
 * @package harmoni.datamanager.primitives
 * @copyright 2004
 * @version $Id: Time.class.php,v 1.1 2004/07/26 04:21:16 gabeschine Exp $
 */
class Time extends DateTime /* implements Primitive */ {
	
	function Time(/* variable-length parameter list */) {
		// @todo implement multiple ways to get our values!
	}
	
	/**
	 * Returns true if the object passed is of the same data type with the same value. False otherwise.
	 * @param ref object $object A {@link Primitive} to compare.
	 * @access public
	 * @return boolean
	 */
	function isEqual(&$object)
	{
		return DateTime::compare($this,$object)==0?true:false;
	}
	
	/**
	 * "Adopts" the value of the given {@link Primitive} into this one, assuming it is of the same class.
	 * @param ref object $object The {@link Primitive} to take values from.
	 * @access public
	 * @return void
	 */
	function adoptValue(&$object)
	{
		$this->setDate($object->toTimestamp());
	}
	
	/**
	 * Returns a new {@link Primitive} of the same class with the same value.
	 * @access public
	 * @return ref object
	 */
	function &clone()
	{
		$new =& new Time();
		$new->setDate($this->toTimestamp());
		return $new;
	}
	
}