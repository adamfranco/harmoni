<?
/**
 * @package harmoni.osid_v1.dr
 */

require_once(OKI."dr.interface.php");

// public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

/**
 * An iterator of Asset objects.
 *
 *
 * @package harmoni.osid_v1.dr
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniAssetIterator.class.php,v 1.7 2005/02/04 15:59:05 adamfranco Exp $ */

class HarmoniAssetIterator
	extends DigitalRepositoryIterator
{ // begin AssetIterator

	/**
	 * @var array $_assets The stored assets.
	 * @access private
	 */
	var $_assets = array();
	 
	/**
	 * @var int $_i The current posititon.
	 * @access private
	 */
	var $_i = -1;
	
	/**
	 * Constructor
	 */
	function HarmoniAssetIterator (& $assetArray) {
		// make sure that we get an array of DigitalRepository objects
		ArgumentValidator::validate($assetArray, new ArrayValidatorRuleWithRule(new ExtendsValidatorRule("Asset")));
		
		// load the types into our private array
		foreach ($assetArray as $key => $val) {
			$this->_assets[] =& $assetArray[$key];
		}
	}

	// public boolean hasNext();
	function hasNext() {
		return ($this->_i < count($this->_assets)-1);
	}

	// public Type & next();
	function &next() {
		if ($this->hasNext()) {
			$this->_i++;
			return $this->_assets[$this->_i];
		} else {
			throwError(new Error(NO_MORE_ITERATOR_ELEMENTS, "AssetIterator", 1));
		}
	}

} // end AssetIterator

?>