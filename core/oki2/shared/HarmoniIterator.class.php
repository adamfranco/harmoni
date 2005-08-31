<?

require_once(HARMONI."Primitives/Objects/SObject.class.php");

/**
 * A class for passing an arbitrary input array as an iterator.
 *
 * @package harmoni.osid_v2.shared
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniIterator.class.php,v 1.8 2005/08/31 15:00:52 adamfranco Exp $
 */
class HarmoniIterator
	extends SObject
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
	function HarmoniIterator (&$elementArray) {
		if($elementArray===NULL){
			$elementArray=array();
		}
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

	/**
	 * Gives the number of items in the iterator
	 *
	 * @return int
	 * @public
	 */
	 function count () {
	 	return count($this->_elements);
	 }
	 
	/**
	 * Skips the next $num items in the iterator
	 *
	 * @param int $num
	 * @return void
	 * @public
	 */
	 function skipNext($num) {
	 	if (($this->_i + $num) < count($this->_elements)-1)
		 	$this->_i += $num;
	 	else
	 		throwError(new Error(SharedException::NO_MORE_ITERATOR_ELEMENTS(),
	 			get_class($this), true));
	 }
}

?>