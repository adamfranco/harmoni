<?

require_once(HARMONI."oki/shared/HarmoniType.class.php");
require_once(HARMONI."dataManager/Primitive.interface.php");

/**
 * A {@link Primitive} that extends the {@link HarmoniType} class.
 * @package harmoni.datamanager.primitives
 * @copyright 2004
 * @version $Id: OKIType.class.php,v 1.2 2004/07/27 18:15:25 gabeschine Exp $
 */
class OKIType extends HarmoniType /* implements Primitive */ {

	function OKIType($one='', $two='', $three='', $four='') {
		parent::HarmoniType($one, $two, $three, $four);
	}
	
	/**
	 * Returns the data in a string format.
	 * @access public
	 * @return string
	 */
	function toString()
	{
		return OKITypeToString($this);
	}
	
	/**
	 * "Adopts" the value of the given {@link Primitive} into this one, assuming it is of the same class.
	 * @param ref object $object The {@link Primitive} to take values from.
	 * @access public
	 * @return void
	 */
	function adoptValue(&$object)
	{
		$this->_domain = $object->getDomain();
		$this->_authority = $object->getAuthority();
		$this->_keyword = $object->getKeyword();
		$this->_description = $object->getDescription();
	}
	
	/**
	 * Returns a new {@link Primitive} of the same class with the same value.
	 * @access public
	 * @return ref object
	 */
	function &clone()
	{
		return new OKIType($this->getDomain(), $this->getAuthority(), $this->getKeyword(), $this->getDescription());
	}
	
}