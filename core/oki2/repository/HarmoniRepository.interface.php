<?php
/**
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniRepository.interface.php,v 1.9 2008/02/06 15:37:52 adamfranco Exp $
 */
 
require_once(OKI2."osid/repository/Repository.php");
require_once(OKI2."osid/repository/RepositoryException.php");

/**
 * The HarmoniDigitalRepositoryInterface provides all of the methods of
 * the DR OSID plus several that are meant to enhance usage in PHP, such
 * as the collecting of changes for later committing and the exposure of
 * the hierarchical nature of DRs used in Harmoni
 *
 *
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniRepository.interface.php,v 1.9 2008/02/06 15:37:52 adamfranco Exp $
 */

interface HarmoniRepositoryInterface
	extends Repository 
{  // begin DigitalRepository

	/**
	 * Saves this object to persistable storage.
	 * @access protected
	 */
	function save ();
	 


}  // end DigitalRepository

?>