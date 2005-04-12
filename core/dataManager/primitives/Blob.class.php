<?

/**
 * A simple Blob data type.
 *
 * @package harmoni.datamanager.primitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Blob.class.php,v 1.4 2005/04/12 18:48:03 adamfranco Exp $
 */
class Blob extends String {

	function Blob($string="") {
		$this->_string = $string;
	}
	
	/**
	 * Returns a new {@link Primitive} of the same class with the same value.
	 * @access public
	 * @return ref object
	 */
	function &replicate()
	{
		return new Blob($this->_string);
	}
	
	function getBlobValue() {
		return $this->_string;
	}
	
}