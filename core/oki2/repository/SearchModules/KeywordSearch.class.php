<?php

require_once(dirname(__FILE__)."/SearchModule.interface.php");

/**
 * Return assets of the specified type
 *
 * @package harmoni.osid_v2.repository.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: KeywordSearch.class.php,v 1.6 2007/09/04 20:25:47 adamfranco Exp $
 */

class KeywordSearch
	extends SearchModuleInterface {
	
	/**
	 * Constructor
	 * 
	 * @param object $dr
	 * @return object
	 * @access public
	 * @since 11/2/04
	 */
	function KeywordSearch ( $dr ) {
		$this->_dr =$dr;
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
		$matchingIds = array();
		
		$recordMgr = Services::getService("RecordManager");
		$schemaMgr = Services::getService("SchemaManager");
		$drMgr = Services::getService("Repository");
		
		$schemaIDs = $schemaMgr->getAllSchemaIDs();
		
		$includeFieldTypes = array("string", "shortstring");

		$assetContentID = "edu.middlebury.harmoni.repository.asset_content";
		
		// Create the search criteria object
		$criteria = new OrSearch();
		
		// create one string value
		$stringValue = HarmoniString::withValue($searchCriteria);
		
		foreach ($schemaIDs as $schemaID) {
			if ($schemaID != $assetContentID) {
				
				$schema =$schemaMgr->getSchemaByID($schemaID);
				$schema->load();
				$ids = $schema->getAllFieldIDs();
				
				foreach ($ids as $id) {
					$fieldType = $schema->getFieldType($id);
					
					if (in_array($fieldType, $includeFieldTypes)) {
						// add to the field criteria for this schematype/label				
						$criteria->addCriteria(new FieldValueSearch($schemaID, $schema->getFieldLabelFromID($id), $stringValue, SEARCH_TYPE_CONTAINS));
					}
				}
			}
		}
		
		// Get the asset Ids to limit to.
		$allAssets =$this->_dr->getAssets();
		$idStrings = array();
		while ($allAssets->hasNext()) {
			$asset =$allAssets->next();
			$id =$asset->getId();
			$idStrings[] = $id->getIdString();
		}
		
		// Run the search		
		$matchingIds = array_unique($recordMgr->getRecordSetIDsBySearch($criteria, $idStrings));		
				
		$idManager = Services::getService("Id");
		
		// Include Searches of displayname and description
		$displayNameSearch = new DisplayNameSearch($this->_dr);
		$displayNameResults = $displayNameSearch->searchAssets($searchCriteria);
		for ($i = 0; $i < count($displayNameResults); $i++) {
			$matchingIds[] = $displayNameResults[$i]->getIdString();
		}
		
		$descriptionSearch = new DescriptionSearch($this->_dr);
		$descriptionResults = $descriptionSearch->searchAssets($searchCriteria);
		for ($i=0; $i<count($descriptionResults); $i++) {
			$matchingIds[] = $descriptionResults[$i]->getIdString();
		}
		
		// Ensure uniqueness and convert the ids to id objects.
		$matchingIds = array_unique($matchingIds);
		sort($matchingIds);
		$idManager = Services::getService("Id");
		for ($i=0; $i<count($matchingIds); $i++) {
			$matchingIds[$i] =$idManager->getId($matchingIds[$i]);
		}
		
		// Return the array
		return $matchingIds;
	}
	
}

?>