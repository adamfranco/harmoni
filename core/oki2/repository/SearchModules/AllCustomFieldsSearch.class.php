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
 * @version $Id: AllCustomFieldsSearch.class.php,v 1.6 2005/07/18 14:45:24 gabeschine Exp $
 */

class AllCustomFieldsSearch
	extends SearchModuleInterface {
	
	/**
	 * Constructor
	 * 
	 * @param object $dr
	 * @return object
	 * @access public
	 * @since 11/2/04
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
	 * @since 11/2/04
	 */
	function searchAssets ( $searchCriteria ) {
		$matchingIds = array();
		
		$recordMgr =& Services::getService("RecordManager");
		$schemaMgr =& Services::getService("SchemaManager");
		$drMgr =& Services::getService("DR");
		
		$schemaTypes = $schemaMgr->getAllSchemaIDs();
		
		$excludedFieldTypes = array("time");
		$assetContentType = "edu.middlebury.harmoni.repository.asset_content";
		
		// Create the search criteria object
		$criteria =& new OrSearch();
		
		foreach ($schemaTypes as $schemaType) {
			if ($schemaType == $assetContentType) {
				
				$schema =& $schemaMgr->getSchemaByID($schemaType);
				$schema->load();
				$ids = $schema->getAllIDs();
				
				foreach ($ids as $id) {
					$fieldType = $schema->getFieldType($id);
					
					if (!in_array($fieldType, $excludedFieldTypes)) {
						// Make a value appropriate to the field type.
						$dtM =& Services::getService("DataTypeManager");
						$class = $dtM->primitiveClassForType($fieldType);
						eval('$searchValue =& '.$class.'::withValue('.addslashes($searchCriteria).');');
						
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
				$matchingIds[] =& $assetId;
		}
		
		// Return the array
		return $matchingIds;
	}
	
}

?>