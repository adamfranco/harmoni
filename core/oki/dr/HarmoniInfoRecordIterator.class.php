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
 * @version $Id: HarmoniInfoRecordIterator.class.php,v 1.6 2005/03/29 19:44:17 adamfranco Exp $
 */
class HarmoniInfoRecordIterator
	extends InfoRecordIterator
{ // begin InfoRecordIterator

	/**
	 * @var array $_infoRecords The stored InfoRecords.
	 * @access private
	 */
	var $_infoRecords = array();
	 
	/**
	 * @var int $_i The current posititon.
	 * @access private
	 */
	var $_i = -1;
	
	/**
	 * Constructor
	 */
	function HarmoniInfoRecordIterator (& $infoRecordArray) {
		// make sure that we get an array of DigitalRepository objects
		ArgumentValidator::validate($infoRecordArray, ArrayValidatorRuleWithRule::getRule(ExtendsValidatorRule::getRule("InfoRecord")));
		
		// load the types into our private array
		foreach ($infoRecordArray as $key => $val) {
			$this->_infoRecords[] =& $infoRecordArray[$key];
		}
	}

	// public boolean hasNext();
	function hasNext() {
		return ($this->_i < count($this->_infoRecords)-1);
	}

	// public Type & next();
	function &next() {
		if ($this->hasNext()) {
			$this->_i++;
			return $this->_infoRecords[$this->_i];
		} else {
			throwError(new Error(NO_MORE_ITERATOR_ELEMENTS, "InfoRecordIterator", 1));
		}
	}

} // end InfoRecordIterator

?>