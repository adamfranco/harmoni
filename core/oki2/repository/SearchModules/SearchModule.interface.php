<?php
/**
 * @package harmoni.osid_v2.repository.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SearchModule.interface.php,v 1.5 2006/01/18 16:12:26 adamfranco Exp $
 */

/**
 * Search Modules implement the functionality of searching the digital repository
 * 
 *
 * @package harmoni.osid_v2.repository.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SearchModule.interface.php,v 1.5 2006/01/18 16:12:26 adamfranco Exp $
 */

class SearchModuleInterface {
		
	/**
	 * Get the ids of the assets that match the search criteria
	 * 
	 * @param mixed $searchCriteria
	 * @return array
	 * @access public
	 * @since 11/2/04
	 */
	function &searchAssets ( $searchCriteria ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
}

?>