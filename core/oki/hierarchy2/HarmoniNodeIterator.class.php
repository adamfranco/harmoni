<?

require_once(OKI."/hierarchy.interface.php");

// public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

/**
 * An iterator of node objects
 *
 * @package harmoni.osid_v1.hierarchy2
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniNodeIterator.class.php,v 1.6 2005/01/19 22:28:10 adamfranco Exp $
 */
 
class HarmoniNodeIterator
	extends NodeIterator
{ // begin NodeIterator

	/**
	 * @var array $_nodes The stored nodes.
	 * @access private
	 */
	var $_nodes = array();
	 
	/**
	 * @var int $_i The current posititon.
	 * @access private
	 */
	var $_i = -1;
	
	/**
	 * Constructor
	 */
	function HarmoniNodeIterator (& $nodeArray) {
		// make sure that we get an array of Node objects

		// load the types into our private array
		foreach (array_keys($nodeArray) as $i => $key) {
			$this->_nodes[] =& $nodeArray[$key];
		}
	}

	// public boolean hasNext();
	function hasNext() {
		return ($this->_i < count($this->_nodes)-1);
	}

	// public Type & next();
	function &next() {
		if ($this->hasNext()) {
			$this->_i++;
			return $this->_nodes[$this->_i];
		} else {
			throwError(new Error(NO_MORE_ITERATOR_ELEMENTS, "NodeIterator", 1));
		}
	}

} // end NodeIterator

?>