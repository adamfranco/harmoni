<?php

require_once(dirname(__FILE__)."/SearchModule.interface.php");

/**
 * Return assets of the specified type
 *
 * @package harmoni.osid.dr.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RootAssetSearch.class.php,v 1.2 2005/01/19 21:10:07 adamfranco Exp $
 */

class RootAssetSearch
	extends SearchModuleInterface {
	
	/**
	 * Constructor
	 * 
	 * @param object $dr
	 * @return object
	 * @access public
	 * @date 11/2/04
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
	 * @date 11/2/04
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