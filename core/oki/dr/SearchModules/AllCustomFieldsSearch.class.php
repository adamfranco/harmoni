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
 * @version $Id: AllCustomFieldsSearch.class.php,v 1.3 2005/01/19 21:10:07 adamfranco Exp $
 */

class AllCustomFieldsSearch
	extends SearchModuleInterface {
	
	/**
	 * Constructor
	 * 
	 * @param object $dr
	 * @return object
	 * @access public
	 * @date 11/2/04
	 */
	function AllCustomFieldsSearch ( $dr ) {
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
		$matchingIds = array();
		
		$recordMgr =& Services::getService("RecordManager");
		$schemaMgr =& Services::getService("SchemaManager");
		$drMgr =& Services::getService("DR");
		
		$schemaTypes =& $schemaMgr->getAllSchemaTypes();
		
		$excludedFieldTypes = array("time");
		$assetContentType =& new HarmoniType("DR", "Harmoni", "AssetContent");
		
		// Create the search criteria object
		$criteria =& new AndSearch();
		$criteria->addCriteria(new ActiveRecordsSearch());
		$fieldCriteria =& new OrSearch();
		$criteria->addCriteria($fieldCriteria);
		
		while ($schemaTypes->hasNext()) {
			$schemaType =& $schemaTypes->next();
			if (!$schemaType->isEqual($assetContentType)) {
				
				$schema =& $schemaMgr->getSchemaByType($schemaType);
				$schema->load();
				$labels = $schema->getAllLabels();
				
				foreach ($labels as $label) {
					$fieldType = $schema->getFieldType($label);
					
					if (!in_array($fieldType, $excludedFieldTypes)) {
						// Make a value appropriate to the field type.
						$searchValue = new $fieldType($searchCriteria);
						
						// add to the field criteria for this schematype/label				
						$fieldCriteria->addCriteria(new FieldValueSearch($schemaType, $label, $searchValue, SEARCH_TYPE_CONTAINS));
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
				
		$sharedManager =& Services::getService("Shared");
		
		$myId =& $this->_dr->getId();
		
		foreach ($groupIds as $id) {
			$assetId =& $sharedManager->getId($id);
			$asset =& $drMgr->getAsset($assetId);
			$dr =& $asset->getDigitalRepository();
			
			if ($myId->isEqual($dr->getId()))
				$matchingIds[] =& $assetId;
		}
		
		// Return the array
		return $matchingIds;
	}
	
}

?>