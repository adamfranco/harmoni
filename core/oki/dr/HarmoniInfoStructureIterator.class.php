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
 * @version $Id: HarmoniInfoStructureIterator.class.php,v 1.6 2005/03/29 19:44:18 adamfranco Exp $
 */
class HarmoniInfoStructureIterator
	extends InfoStructureIterator
{ // begin InfoStructureIterator

	/**
	 * @var array $_assets The stored assets.
	 * @access private
	 */
	var $_infoStructures = array();
	 
	/**
	 * @var int $_i The current posititon.
	 * @access private
	 */
	var $_i = -1;
	
	/**
	 * Constructor
	 */
	function HarmoniInfoStructureIterator (& $infoStructureArray) {
		// make sure that we get an array of DigitalRepository objects
		ArgumentValidator::validate($infoStructureArray, ArrayValidatorRuleWithRule::getRule(ExtendsValidatorRule::getRule("InfoStructure")));
		
		// load the types into our private array
		foreach ($infoStructureArray as $key => $val) {
			$this->_infoStructures[] =& $infoStructureArray[$key];
		}
	}

	// public boolean hasNext();
	function hasNext() {
		return ($this->_i < count($this->_infoStructures)-1);
	}

	// public Type & next();
	function &next() {
		if ($this->hasNext()) {
			$this->_i++;
			return $this->_infoStructures[$this->_i];
		} else {
			throwError(new Error(NO_MORE_ITERATOR_ELEMENTS, "InfoStructureIterator", 1));
		}
	}

} // end InfoStructureIterator

?>