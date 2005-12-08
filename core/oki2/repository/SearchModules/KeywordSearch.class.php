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
 * @version $Id: KeywordSearch.class.php,v 1.1 2005/12/08 17:10:01 adamfranco Exp $
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
		$matchingIds = array();
		
		$recordMgr =& Services::getService("RecordManager");
		$schemaMgr =& Services::getService("SchemaManager");
		$drMgr =& Services::getService("Repository");
		
		$schemaTypes = $schemaMgr->getAllSchemaIDs();
		
		$excludedFieldTypes = array(
									"blob", 
									"boolean", 
									"datetime",
									"float", 
									"fuzzydate",
									"integer",
									"time");
		$assetContentType = "edu.middlebury.harmoni.repository.asset_content";
		
		// Create the search criteria object
		$criteria =& new OrSearch();
		
		foreach ($schemaTypes as $schemaType) {
			if ($schemaType != $assetContentType) {
				
				$schema =& $schemaMgr->getSchemaByID($schemaType);
				$schema->load();
				$ids = $schema->getAllIDs();
				
				foreach ($ids as $id) {
					$fieldType = $schema->getFieldType($id);
					
					if (!in_array($fieldType, $excludedFieldTypes)) {
						// Make a value appropriate to the field type.
						$dtM =& Services::getService("DataTypeManager");
						$class = $dtM->primitiveClassForType($fieldType);
						eval('$searchValue =& '.$class.'::withValue("'.addslashes($searchCriteria).'");');
						
						// add to the field criteria for this schematype/label				
						$criteria->addCriteria(new FieldValueSearch($schemaType, $label, $searchValue, SEARCH_TYPE_CONTAINS));
					}
				}
			}
		}
		
		// Run the search
		$recordIDs = $recordMgr->getRecordIDsBySearch($criteria);

		$groupIds = array();
		foreach  ($recordIDs as $id) {
			$recordSetIds =& $recordMgr->getRecordSetIDsContainingID($id);
			$groupIds = array_merge($groupIds, $recordSetIds);
		}
				
		$groupIds = array_unique($groupIds);
				
		$idManager =& Services::getService("Id");
		
		$myId =& $this->_dr->getId();
		
		foreach ($groupIds as $id) {
			$assetId =& $idManager->getId($id);
			$asset =& $drMgr->getAsset($assetId);
			$dr =& $asset->getDigitalRepository();
			
			if ($myId->isEqual($dr->getId()))
				$matchingIds[] = $assetId->getIdString();
		}
		
		// Include Searches of displayname and description
		$displayNameSearch =& new DisplayNameSearch;
		$displayNameResults = $displayNameSearch->searchAssets($searchCriteria);
		for ($i = 0; $i < count($displayNameResults); $i++)
			$matchingIds[] = $displayNameResults[$i]->getIdString();
		
		$descriptionSearch =& new DescriptionSearch;
		$descriptionResults = $descriptionSearch->searchAssets($searchCriteria);
		for ($i=0; $i<count($descriptionResults); $i++)
			$matchingIds[] = $descriptionResults[$i]->getIdString();
		
		
		// Ensure uniqueness and convert the ids to id objects.
		$matchingIds = array_unique($matchingIds);
		$idManager =& Services::getService("Id");
		for ($i=0; $i<count($matchingIds); $i++)
			$matchingIds[$i] =& $idManager->getId($matchingIds[$i]);
		
		// Return the array
		return $matchingIds;
	}
	
}

?>