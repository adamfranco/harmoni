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
  * @version $Id: HarmoniInfoPartIterator.class.php,v 1.5 2005/02/04 15:59:05 adamfranco Exp $
  */
class HarmoniInfoPartIterator
	extends InfoPartIterator
{ // begin InfoPartIterator

	/**
	 * @var array $_parts The stored parts.
	 * @access private
	 */
	var $_infoParts = array();
	 
	/**
	 * @var int $_i The current posititon.
	 * @access private
	 */
	var $_i = -1;
	
	/**
	 * Constructor
	 */
	function HarmoniInfoPartIterator (& $infoPartArray) {
		// make sure that we get an array of DigitalRepository objects
		ArgumentValidator::validate($infoPartArray, new ArrayValidatorRuleWithRule(new ExtendsValidatorRule("InfoPart")));
		
		// load the types into our private array
		foreach ($infoPartArray as $key => $val) {
			$this->_infoParts[] =& $infoPartArray[$key];
		}
	}

	// public boolean hasNext();
	function hasNext() {
		return ($this->_i < count($this->_infoParts)-1);
	}

	// public Type & next();
	function &next() {
		if ($this->hasNext()) {
			$this->_i++;
			return $this->_infoParts[$this->_i];
		} else {
			throwError(new Error(NO_MORE_ITERATOR_ELEMENTS, "InfoPartIterator", 1));
		}
	}

} // end InfoPartIterator

?>