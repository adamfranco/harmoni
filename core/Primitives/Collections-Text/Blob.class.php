<?

/**
 * A simple Blob data type.
 *
 * @package harmoni.primitives.collections_text
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Blob.class.php,v 1.5.2.1 2006/08/25 15:29:21 adamfranco Exp $
 */
class Blob 
	extends String 
{

	function Blob($string="") {
		$this->_string = $string;
	}
	
	
	/**
	 * Instantiates a new Blob object with the passed value.
	 * @param string $value
	 * @return ref object
	 * @access public
	 * @static
	 */
	function &withValue($value) {
		$string =& new Blob($value);
		return $string;
	}

	/**
	 * Instantiates a new Blob object with the passed value.
	 *
	 * allowing 'fromString' instantiation
	 * @param string $aString
	 * @return ref object
	 * @access public
	 * @static
	 */
	function &fromString($aString) {
		$string =& new Blob($aString);
		return $string;
	}

	function value() {
		return $this->_string;
	}	
}