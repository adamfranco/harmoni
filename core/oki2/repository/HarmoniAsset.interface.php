<?

require_once(OKI."dr.interface.php");

/**
 * The HarmoniAssetInterface provides all of the methods of
 * the DR OSID plus several that are meant to enhance usage in PHP, such
 * as the collecting of changes for later committing and the exposure of
 * the hierarchical nature of DRs used in Harmoni
 *
 * @package harmoni.osid.dr
 * @author Adam Franco
 * @copyright 2004 Middlebury College
 * @access public
 */

class HarmoniAssetInterface
	extends Asset 
{  // begin Asset

	/**
	 * Saves this object to persistable storage.
	 * @access protected
	 */
	function save () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	 
	/**
	 * Loads this object from persistable storage.
	 * @access protected
	 */
	function load () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}	

}  // end Asset

?>