<?

require_once(OKI."/dr.interface.php");

/**
 * The HarmoniDigitalRepositoryInterface provides all of the methods of
 * the DR OSID plus several that are meant to enhance usage in PHP, such
 * as the collecting of changes for later committing and the exposure of
 * the hierarchical nature of DRs used in Harmoni
 *
 * @package harmoni.osid.dr
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniDigitalRepository.interface.php,v 1.3 2005/01/19 21:10:07 adamfranco Exp $
 */

class HarmoniDigitalRepositoryInterface
	extends DigitalRepository 
{  // begin DigitalRepository

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

}  // end DigitalRepository

?>