<?

require_once(OKI."/hierarchy.interface.php");

// public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

/**
 * An iterator of node objects
 *
 * @package harmoni.osid_v1.hierarchy
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniHierarchyIterator.class.php,v 1.10 2005/03/29 19:44:18 adamfranco Exp $
 */
 
class HarmoniHierarchyIterator
	extends HierarchyIterator
{ // begin HierarchyIterator

	/**
	 * @var array $_hierarchies The stored hierarchies.
	 * @access private
	 */
	var $_hierarchies = array();
	 
	/**
	 * @var int $_i The current posititon.
	 * @access private
	 */
	var $_i = -1;
	
	/**
	 * Constructor
	 */
	function HarmoniHierarchyIterator (& $hierarchyArray) {
		// make sure that we get an array of Hierarchy objects
		ArgumentValidator::validate($hierarchyArray, ArrayValidatorRuleWithRule::getRule(ExtendsValidatorRule::getRule("Hierarchy")));
		
		// load the types into our private array
		foreach (array_keys($hierarchyArray) as $i => $key) {
			$this->_hierarchies[] =& $hierarchyArray[$key];
		}
	}

	// public boolean hasNext();
	function hasNext() {
		return ($this->_i < count($this->_hierarchies)-1);
	}

	// public Type & next();
	function &next() {
		if ($this->hasNext()) {
			$this->_i++;
			return $this->_hierarchies[$this->_i];
		} else {
			throwError(new Error(NO_MORE_ITERATOR_ELEMENTS, "AssetIterator", 1));
		}
	}

} // end HierarchyIterator

?>