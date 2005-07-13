<?

require_once(HARMONI."utilities/SObject.class.php");

/**
 * A primitive data type is nothing more than an object-representation of data types such as "string" or
 * "integer", etc. 
 *
 * @package harmoni.datamanager
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Primitive.interface.php,v 1.4 2005/07/13 17:41:11 adamfranco Exp $
 */
class Primitive
	extends SObject
{
	
	/**
	 * "Adopts" the value of the given {@link Primitive} into this one, assuming it is of the same class.
	 * @param ref object $object The {@link Primitive} to take values from.
	 * @access public
	 * @return void
	 * @deprecated
	 */
	function adoptValue(&$object)
	{
		
	}
	
	/**
	 * Returns the data in a string format.
	 * @access public
	 * @return string
	 * @deprecated
	 */
	function toString()
	{
		return $this->printableString();
	}
	
	/**
	 * Returns true if the object passed is of the same data type with the same value. False otherwise.
	 * @param ref object $object A {@link Primitive} to compare.
	 * @access public
	 * @return boolean
	 * @deprecated
	 */
	function isEqual(&$object)
	{
		return $this->isEqualTo($object);
	}
	
	/**
	 * Returns a new {@link Primitive} of the same class with the same value.
	 * @access public
	 * @return ref object
	 * @deprecated
	 */
	function &replicate()
	{
		return $this->deepCopy();
	}
	
}