<?

require_once(OKI."/hierarchy.interface.php");

// public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

/**
 * An iterator of node objects
 *
 * @package harmoni.osid_v1.shared
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniIdIterator.class.php,v 1.4 2005/01/19 22:28:11 adamfranco Exp $
 */
 
class HarmoniIdIterator
	extends IdIterator
{ // begin IdIterator

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
	function HarmoniIdIterator (& $idArray) {
		// make sure that we get an array of Id objects
		ArgumentValidator::validate($idArray, new ArrayValidatorRuleWithRule(new ExtendsValidatorRule("Id")));
		
		// load the types into our private array
		foreach (array_keys($idArray) as $i => $key) {
			$this->_hierarchies[] =& $idArray[$key];
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

} // end IdIterator

?>