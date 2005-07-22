<?

/**
 * A simple Blob data type.
 *
 * @package harmoni.datamanager.primitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Blob.class.php,v 1.3 2005/07/22 20:29:20 gabeschine Exp $
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

	function value() {
		return $this->_string;
	}
	
}