<?

require_once(OKI."/hierarchy.interface.php");

/**
 * TraversalInfoIterator returns a set, one at a time.  The purpose of all
 * Iterators is to to offer a way for SID methods to return multiple values of
 * a common type and not use an array.  Returning an array may not be
 * appropriate if the number of values returned is large or is fetched
 * remotely.  Iterators do not allow access to values by index, rather you
 * must access values in sequence. Similarly, there is no way to go backwards
 * through the sequence unless you place the values in a data structure, such
 * as an array, that allows for access by index.
 *
 * @package harmoni.osid_v1.hierarchy
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniTraversalInfoIterator.class.php,v 1.10 2005/01/19 22:28:09 adamfranco Exp $
 *
 * @todo Replace JavaDoc with PHPDoc
 */

class HarmoniTraversalInfoIterator
	extends TraversalInfoIterator
{ // begin TraversalInfoIterator

	/**
	 * @var array $_traversalInfos The stored traversalInfos.
	 * @access private
	 */
	var $_traversalInfos = array();
	 
	/**
	 * @var int $_i The current posititon.
	 * @access private
	 */
	var $_i = -1;
	
	/**
	 * Constructor
	 * 
	 * @todo Fill this in.
	 */
	function HarmoniTraversalInfoIterator (& $traversalInfoArray) {
		// make sure that we get an array of TraversalInfo objects
		ArgumentValidator::validate($traversalInfoArray, new ArrayValidatorRuleWithRule(new ExtendsValidatorRule("TraversalInfo")));
		
		// load the types into our private array
		foreach (array_keys($traversalInfoArray) as $i => $key) {
			$this->_traversalInfos[] =& $traversalInfoArray[$key];
		}
	}

	/**
	 * Return true if there are additional  TraversalInfos ; false otherwise.
	 *
	 * @return boolean
	 *
	 * @throws HierarchyException if there is a general failure.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function hasNext() {
		return ($this->_i < count($this->_traversalInfos)-1);
	}

	/**
	 * Return the next TraversalInfo
	 *
	 * @return TraversalInfo
	 *
	 * @throws HierarchyException if there is a general failure.	or if all
	 *		   objects have already been returned.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &next() {
		if ($this->hasNext()) {
			$this->_i++;
			return $this->_traversalInfos[$this->_i];
		} else {
			throwError(new Error(NO_MORE_ITERATOR_ELEMENTS, "TraversalInfoIterator", 1));
		}
	}

} // end TraversalInfoIterator

?>