<?php

require_once HARMONI."metaData/manager/DataSet.class.php";

/**
 * The DataSetManager handles the creation, tagging and fetching of DataSets from the database.
 * @package harmoni.datamanager
 * @version $Id: DataSetManager.class.php,v 1.25 2004/01/16 20:36:10 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class DataSetManager extends ServiceInterface {
	
	var $_idManager;
	var $_dbID;
	var $_typeManager;
	
	var $_versionConstraint = null;
	
	var $_dataSetCache;
	var $_dataSetGroupCache;
	
	function DataSetManager( &$idManager, $dbID, &$dataSetTypeManager) {
		$this->_idManager =& $idManager;
		$this->_dbID = $dbID;
		$this->_typeManager = $dataSetTypeManager;
		
		$this->_dataSetCache = array();
		$this->_dataSetGroupCache = array();
	}
	
	/**
	 * Returns a {@link DataSetGroup} object associated with the numeric ID. If none exists in the Database,
	 * a new one is created with the given ID.
	 * @param int $groupID The DataSetGroup ID.
	 * @param optional bool $dontLoad If set to TRUE will not attempt to load the DataSetGroup, only return it if it's already loaded.
	 * @return ref object
	 */
	function &fetchDataSetGroup($groupID, $dontLoad=false) {
		if ($dontLoad) {
			return isset($this->_dataSetGroupCache[$groupID])?$this->_dataSetGroupCache[$groupID]:null;
		} else {
			$this->loadGroups(array($groupID));
			
			// if we still don't have it cached, that means it doesn't exist in the DB
			// so create a new one
			if (!isset($this->_dataSetGroupCache[$groupID]))
				$this->_dataSetGroupCache[$groupID] =& new DataSetGroup($this, $groupID);
			
			return $this->_dataSetGroupCache[$groupID];
		}
	}
	
	/**
	 * Loads the specified DataSetGroups into the cache.
	 * @param array $groupIDsArray An array of numeric IDs.
	 * @return void
	 */
	function loadGroups($groupIDsArray) {
		$fromDBIDs = array();
		
		foreach ($groupIDsArray as $id) {
			if (!isset($this->_dataSetGroupCache[$id]))
				$fromDBIDs[] = $id;
		}
		
		if (count($fromDBIDs)) {
			$wheres = array();
			foreach ($fromDBIDs as $id) {
				$wheres[] = "dataset_group.id=$id";
			}
			
			$query =& new SelectQuery;
			$query->addTable("dataset_group");
			$query->addColumn("id");
			$query->addColumn("fk_dataset");
			$query->setWhere(implode(" OR ",$wheres));
			
			$dbHandler =& Services::getService("DBHandler");
			$result = $dbHandler->query($query,$this->_dbID);
			
			while ($result->hasMoreRows()) {
				$a = $result->getCurrentRow();
				$result->advanceRow();
				$id = $a["id"];
				if (!isset($this->_dataSetGroupCache[$id])) {
					$this->_dataSetGroupCache[$id] =& new DataSetGroup($this, $id);
				}
				
				$this->_dataSetGroupCache[$id]->takeRow($a);
			}
		}
	}
	
	/**
	*  Fetches and returns an array of DataSet IDs from the database in one Query.
	* @return ref array Indexed by DataSet ID, values are either {@link CompactDataSet}s or {@link FullDataSet}s.
	* @param array $dataSetIDs
	* @param optional bool $editable If TRUE will fetch the DataSets as Editable and with ALL versions. Default: FALSE (will only fetch ACTIVE values).
	* @param optional object $limitResults NOT YET IMPLEMENTED
	* criteria. If not specified, will fetch all IDs.
	*/
	function &fetchArrayOfIDs( $dataSetIDs, $editable=false, $limitResults = null ) {
		ArgumentValidator::validate($dataSetIDs, new ArrayValidatorRuleWithRule(new NumericValidatorRule()));
		$dataSetIDs = array_unique($dataSetIDs);
		
		// let's weed out those IDs that we can take from cache
		$fromCacheIDs = array();
		$fromDBIDs = array();
		if (count($this->_dataSetCache)) {
			foreach ($dataSetIDs as $dataSetID) {
				// only take from the cache if we have it cached, AND
				// either we are not fetching editable sets OR (if we are) the cached one is also editable.
				if (isset($this->_dataSetCache[$dataSetID]) && 
							(!$editable || !$this->_dataSetCache[$dataSetID]->readOnly())) {
					$fromCacheIDs[] = $dataSetID;
				} else {
					$fromDBIDs[] = $dataSetID;
				}
			}
		}
		
		$sets = array();
		
		if (count($fromDBIDs)) {
			// first, make the new query
			$query =& new SelectQuery();
	
			$this->_setupSelectQuery($query);
	
			$t = array();
			foreach ($fromDBIDs as $dataSetID) {
				$t[] = "dataset_id=".$dataSetID;
			}
			$query->addWhere("(".implode(" OR ", $t).")");
			if (!$editable) $query->addWhere("datasetfield_active=1");
			
			$dbHandler =& Services::getService("DBHandler");
			
	//		print "<PRE>" . MySQL_SQLGenerator::generateSQLQuery($query)."</PRE>";
			
			$result =& $dbHandler->query($query,$this->_dbID);
			
			if (!$result) {
				throwError(new UnknownDBError("DataSetManager"));
			}
			
			// now, we need to parse things out and distribute the lines accordingly
			$classToMake = $editable?"FullDataSet":"CompactDataSet";
			
			while ($result->hasMoreRows()) {
				$a = $result->getCurrentRow();
				$result->advanceRow();
				
				$id = $a['dataset_id'];
				$type = $a['fk_datasettype'];
				$vcontrol =$a['dataset_ver_control'];
				if (!$sets[$id]) {
					$dataSetTypeDef =& $this->_typeManager->getDataSetTypeDefinitionByID($type);
					$dataSetTypeDef->load();
					$sets[$id] =& new $classToMake($this->_idManager,
								$this->_dbID,
								$dataSetTypeDef,
								$vcontrol?true:false);
				}
				
				$sets[$id]->takeRow($a);
				unset($a);
			}
			
			// now, lets update the cache to hold the sets we just fetched
			foreach (array_keys($sets) as $id) {
				$this->_dataSetCache[$id] =& $sets[$id];
			}
		}
				
		// and add the IDs we're gonna take from cache to the array to return
		// -- only put into cache if we're not limiting results
		if (!$limitResults) {
			foreach ($fromCacheIDs as $id) {
				if (!isset($sets[$id])) $sets[$id] =& $this->_dataSetCache[$id];
			}
		}
			
		return $sets;
	}
	
	/**
	 * Takes an array of IDs and some search criteria, and weeds out the IDs that don't
	 * match that criteria.
	 * @param ref object $criteria The {@link SearchCriteria}.
	 * @param optional array $ids An array of DataSet IDs to search among. If not specified, all datasets will be searched.
	 * @access public
	 */
	function selectIDsBySearch(&$criteria, $ids=null) {
		// this should happen in one query.
		// the WHERE clause of the SQL query will be relatively complicated.
		$query =& new SelectQuery();
		$this->_setupSelectQuery($query, TRUE);
		
		$typeIDs = array_unique($criteria->getTypeList());
		
		$searchString = $criteria->returnSearchString();
		
		if ($ids) {
			$parts1 = array();
			foreach ($ids as $id) {
				$parts1[] = "dataset.dataset_id=$id";
			}
			$part1 = implode(" OR ", $parts1);
		}
		
		$parts2 = array();
		foreach ($typeIDs as $typeID) {
			$parts2[] = "dataset.fk_datasettype!=$typeID";
		}
		$part2 = implode(" AND ",$parts2);
		
		$part3 = $searchString;
		
		$fullWhere = (isset($part1)?"($part1) AND ":"")."(($part2) OR $part3)";
		
		$query->setWhere($fullWhere);
		
//		print "<PRE>". MySQL_SQLGenerator::generateSQLQuery($query)."</PRE>";
		
		$dbHandler =& Services::getService("DBHandler");
		
		$result =& $dbHandler->query($query, $this->_dbID);
		
		$resultIds = array();
		
		while ($result->hasMoreRows()) {
			$a = $result->getCurrentRow();
			$result->advanceRow();
			
			$resultIds[] = $a["dataset_id"];
		}
		
		return array_unique($resultIds);
	}
	
	/**
	* Fetches a single DataSet from the database, editable if $editable=true.
	* @return ref object
	* @param int $dataSetID
	* @param optional bool $editable
	*/
	function &fetchDataSet( $dataSetID, $editable=false ) {
		$sets =& $this->fetchArrayOfIDs(array($dataSetID), $editable);
		return $sets[$dataSetID];
	}
	
	/**
	* Initializes a SelectQuery with the complex JOIN structures of the HarmoniDataManager.
	* @return void
	* @param ref object $query
	* @param optional boolean $idsOnly If TRUE will only ask for the dataset.dataset_id column from the Database. Default = FALSE;
	* @access private
	*/
	function _setupSelectQuery(&$query, $idsOnly=false) {
		// this function sets up the selectquery to include all the necessary tables
		
		$query->addTable("datasetfield");
		$query->addTable("dataset",INNER_JOIN,"fk_dataset=dataset_id");
		$query->addTable("datasettypedef",INNER_JOIN,"fk_datasettypedef=datasettypedef_id");
//		$query->addTable("datasettype",INNER_JOIN,"dataset.fk_datasettype=datasettype_id");
		
		$dataTypeManager =& Services::getService("DataTypeManager");
		$list = $dataTypeManager->getRegisteredTypeClasses();
		
		foreach ($list as $type) {
			eval("$type::alterQuery(\$query);");
		}
		
		/* dataset table */
		$query->addColumn("dataset_id");
		if (!$idsOnly) {
			$query->addColumn("dataset_created");
			$query->addColumn("dataset_active");
			$query->addColumn("dataset_ver_control");
			$query->addColumn("fk_datasettype","","dataset"); //specify table to avoid ambiguity
			
			/* datasetfield table */
			$query->addColumn("datasetfield_id");
			$query->addColumn("datasetfield_index");
			$query->addColumn("datasetfield_active");
			$query->addColumn("datasetfield_modified");
			$query->addColumn("fk_data");
			
			/* datasettypedef table */
			$query->addColumn("datasettypedef_id");
			$query->addColumn("datasettypedef_label");
		}
	}
	
	/**
	*  Returns a new {@link FullDataSet} object that can be inserted into the database.
	* @return ref object
	* @param ref object $type The {@link HarmoniType} object that refers to the DataSetTypeDefinition to associated this DataSet with.
	* @param optional bool $verControl Specifies if the DataSet should be created with Version Control. Default=no.
	*/
	function &newDataSet( &$type, $verControl = false ) {
		if (!$this->_typeManager->dataSetTypeExists($type)) {
			throwError ( new Error("DataSetManager::newDataSet('".OKITypeToString($type)."') - 
			could not create new DataSet because the requested type does not seem to be registered
			with the DataSetTypeManager.","DataSetManager",true));
		}
		
		// ok, let's make a new one.
		$typeDef =& $this->_typeManager->getDataSetTypeDefinition($type);
		// load from the DB
		$typeDef->load();
		debug::output("Creating new DataSet of type '".OKITypeToString($type)."', which allows fields: ".implode(", ",$typeDef->getAllLabels()),DEBUG_SYS4,"DataSetManager");
		$newDataSet =& new FullDataSet($this->_idManager, $this->_dbID, $typeDef, $verControl);
		return $newDataSet;
	}
	
	/**
	* @return array
	* @param ref object $type The {@link HarmoniType} to look for.
	*  Returns an array of DataSet IDs that are of the DataSetTypeDefinition type $type.
	*/
	function getDataSetIDsOfType(&$type) {
		// we're going to get all the IDs that match a given type.
		
		$query =& new SelectQuery();
		$query->addTable("dataset");
		$query->addTable("datasettype",INNER_JOIN,"datasettype_id=fk_datasettype");
		
		$query->addColumn("dataset_id");
		
		$query->setWhere("datasettype_domain='".addslashes($type->getDomain())."' AND ".
						"datasettype_authority='".addslashes($type->getAuthority())."' AND ".
						"datasettype_keyword='".addslashes($type->getKeyword())."'");
		
		$dbHandler =& Services::getService("DBHandler");
		
		$result =& $dbHandler->query($query,$this->_dbID);
		
		if (!$result) {
			throwError( new UnknownDBError("DataSetManager") );
			return false;
		}
		
		$array = array();
		while ($result->hasMoreRows()) {
			$array[] = $result->field(0);
			$result->advanceRow();
		}
		
		return $array;
	}
	
	function start() {}
	function stop() {}
	
}

?>