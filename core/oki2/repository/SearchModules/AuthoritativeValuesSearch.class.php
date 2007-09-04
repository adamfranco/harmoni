<?php
/**
 * @package harmoni.osid_v2.repository.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AuthoritativeValuesSearch.class.php,v 1.4 2007/09/04 20:25:47 adamfranco Exp $
 */

require_once(dirname(__FILE__)."/RegexSearch.abstract.php");

/**
 * Return assets of the specified type
 * 
 *
 * @package harmoni.osid_v2.repository.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AuthoritativeValuesSearch.class.php,v 1.4 2007/09/04 20:25:47 adamfranco Exp $
 */

class AuthoritativeValuesSearch
	extends SearchModuleInterface
{
	
	/**
	 * Constructor
	 * 
	 * @param object $dr
	 * @return object
	 * @access public
	 * @since 11/2/04
	 */
	function AuthoritativeValuesSearch ( $repository ) {
		$this->_repository =$repository;
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
		$repositoryMgr = Services::getService("Repository");
		
		$schema =$schemaMgr->getSchemaByID(
			$searchCriteria['RecordStructureId']->getIdString());
		
		if ($searchCriteria['AuthoritativeValue']->asString() == '__NonMatching__') {
			$authoritativeValueArray = array();
			$recordStructure =$this->_repository->getRecordStructure(
				$searchCriteria['RecordStructureId']);
			$partStructure =$recordStructure->getPartStructure(
				$searchCriteria['PartStructureId']);
			
			$criteria = new FieldValueSearch(
				$searchCriteria['RecordStructureId']->getIdString(), 
				$schema->getFieldLabelFromID(
					$searchCriteria['PartStructureId']->getIdString()),
				$partStructure->getAuthoritativeValues(), 
				SEARCH_TYPE_NOT_IN_LIST);
		} else {
			$criteria = new FieldValueSearch(
				$searchCriteria['RecordStructureId']->getIdString(), 
				$schema->getFieldLabelFromID(
					$searchCriteria['PartStructureId']->getIdString()),
				$searchCriteria['AuthoritativeValue'], 
				SEARCH_TYPE_EQUALS);
		}

		
		// Get the asset Ids to limit to.
		$allAssets =$this->_repository->getAssets();
		$idStrings = array();
		while ($allAssets->hasNext()) {
			$asset =$allAssets->next();
			$id =$asset->getId();
			$idStrings[] = $id->getIdString();
		}
		
		// Run the search		
		$matchingIds = array_unique($recordMgr->getRecordSetIDsBySearch($criteria, $idStrings));
		
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