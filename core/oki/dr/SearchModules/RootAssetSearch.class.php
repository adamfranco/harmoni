<?php

require_once(dirname(__FILE__)."/SearchModule.interface.php");

/**
 * Return assets of the specified type
 *
 * @package harmoni.osid_v1.dr.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RootAssetSearch.class.php,v 1.3 2005/01/19 22:28:08 adamfranco Exp $
 */

class RootAssetSearch
	extends SearchModuleInterface {
	
	/**
	 * Constructor
	 * 
	 * @param object $dr
	 * @return object
	 * @access public
	 * @since 11/2/04
	 */
	function RootAssetSearch ( $dr ) {
		$this->_dr =& $dr;
	}
	
	
		
	/**
	 * Get the ids of the assets that match the search criteria
	 * 
	 * @param mixed $searchCriteria
	 * @return array
	 * @access public
	 * @since 11/2/04
	 */
	function searchAssets ( $searchCriteria ) {
		// get the root Nodes
		$rootNodes =& $this->_dr->_node->getChildren();
		
		// Add the ids of the root nodes to an array
		$rootIds = array();
		while ($rootNodes->hasNext()) {
			$rootNode =& $rootNodes->next();
			$rootIds[] =& $rootNode->getId();
		}
		
		// Return the array
		return $rootIds;
	}
	
}

?>