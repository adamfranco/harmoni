<?

/**
 * A class for passing an arbitrary input array as an iterator.
 *
 * @package harmoni.osid_v2.shared
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniIterator.class.php,v 1.5 2005/02/04 15:59:10 adamfranco Exp $
 */
class HarmoniIterator
{

	/**
	 * @var array $_elements The stored elements.
	 * @access private
	 */
	var $_elements = array();
	 
	/**
	 * @var int $_i The current posititon.
	 * @access private
	 */
	var $_i = -1;
	
	/**
	 * Constructor
	 */
	function HarmoniIterator (& $elementArray) {
		// load the elements into our private array
		foreach (array_keys($elementArray) as $i => $key) {
			$this->_elements[] =& $elementArray[$key];
		}
	}

	// public boolean hasNext();
	function hasNext() {
		return ($this->_i < count($this->_elements)-1);
	}

	// public Type & next();
	function &next() {
		if ($this->hasNext()) {
			$this->_i++;
			return $this->_elements[$this->_i];
		} else {
			throwError(new Error(SharedException::NO_MORE_ITERATOR_ELEMENTS(), get_class($this), 1));
		}
	}
}

?>