<?
/**
 * @package harmoni.osid_v1.dr
 */
 
require_once(OKI."dr.interface.php");

// public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

/**
 *
 * @package harmoni.osid_v1.dr
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniDigitalRepositoryIterator.class.php,v 1.7 2005/02/04 15:59:05 adamfranco Exp $
 */
class HarmoniDigitalRepositoryIterator
	extends DigitalRepositoryIterator
{ // begin DigitalRepositoryIterator

	/**
	 * @var array $_drs The stored drs.
	 * @access private
	 */
	var $_drs = array();
	 
	/**
	 * @var int $_i The current posititon.
	 * @access private
	 */
	var $_i = -1;
	
	/**
	 * Constructor
	 */
	function HarmoniDigitalRepositoryIterator (& $drArray) {
		// make sure that we get an array of DigitalRepository objects
		ArgumentValidator::validate($drArray, new ArrayValidatorRuleWithRule(new ExtendsValidatorRule("DigitalRepository")));
		
		// load the types into our private array
		foreach ($drArray as $key => $val) {
			$this->_drs[] =& $drArray[$key];
		}
	}

	// public boolean hasNext();
	function hasNext() {
		return ($this->_i < count($this->_drs)-1);
	}

	// public Type & next();
	function &next() {
		if ($this->hasNext()) {
			$this->_i++;
			return $this->_drs[$this->_i];
		} else {
			throwError(new Error(NO_MORE_ITERATOR_ELEMENTS, "DigitalRepositoryIterator", 1));
		}
	}

} // end DigitalRepositoryIterator

?>