<?php

/**
 * Search Modules implement the functionality of searching the digital repository
 * 
 * @package harmoni.osid.dr.search
 * @version $Id: SearchModule.interface.php,v 1.1 2005/01/11 17:40:25 adamfranco Exp $
 * @date $Date: 2005/01/11 17:40:25 $
 * @copyright 2004 Middlebury College
 */

class SearchModuleInterface {
		
	/**
	 * Get the ids of the assets that match the search criteria
	 * 
	 * @param mixed $searchCriteria
	 * @return array
	 * @access public
	 * @date 11/2/04
	 */
	function searchAssets ( $searchCriteria ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
}

?>