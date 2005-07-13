<?

/**
 * A simple Blob data type.
 *
 * @package harmoni.datamanager.primitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Blob.class.php,v 1.5 2005/07/13 20:16:31 adamfranco Exp $
 */
class Blob extends String {

	function Blob($string="") {
		$this->_string = $string;
	}
	
	function getBlobValue() {
		return $this->_string;
	}
	
}