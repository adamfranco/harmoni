<?

/**
 * A simple Blob data type.
 * @package harmoni.datamanager.primitives
 * @copyright 2004
 * @version $Id: Blob.class.php,v 1.2 2004/08/12 20:21:15 gabeschine Exp $
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
	function &clone()
	{
		return new Blob($this->_string);
	}
	
	function getBlobValue() {
		return $this->_string;
	}
	
}