<?php

require_once HARMONI."dataManager/record/Record.class.php";

/**
 * The RecordManager handles the creation, tagging and fetching of {@link Record}s from the database.
 * @package harmoni.datamanager
 * @version $Id: RecordManager.class.php,v 1.1 2004/07/26 04:21:16 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class RecordManager extends ServiceInterface {
	
	var $_versionConstraint = null;
	
	var $_recordCache;
	var $_recordSetCache;
	
	function RecordManager() {
		$this->_recordCache = array();
		$this->_recordSetCache = array();
	}
	
	/**
	 * Returns a {@link RecordSet} object associated with the numeric ID.
	 * @param int $groupID The DataSetGroup ID.
	 * @param optional bool $dontLoad If set to TRUE will not attempt to load the RecordSet, only return it if it's already loaded.
	 * @return ref object OR NULL if not found.
	 */
	function &fetchRecordSet($groupID, $dontLoad=false) {
		if ($dontLoad) {
			return isset($this->_recordSetCache[$groupID])?$this->_recordSetCache[$groupID]:null;
		} else {
			$this->loadRecordSets(array($groupID));
			$null = null;
			return $this->_recordSetCache[$groupID]?$this->_recordSetCache[$groupID]:$null;
		}
	}
	
	/**
	 * Returns the Ids of all groups a Record is in.
	 *
	 * @param ref object $record The {@link Record}.
	 * @return array An indexed array of the group ids (integers).
	 */
	function getRecordSetIDsContaining(&$record) {
		if (!$record->getID()) return array(); // no ID
		$query =& new SelectQuery;
		$query->addTable("dm_record_set");
		$query->addColumn("id");
		$query->addWhere("fk_record=".$record->getID());
		
		$dbHandler =& Services::getService("DBHandler");
		$result = $dbHandler->query($query,DATAMANAGER_DBID);
		
		$groupIds = array();
		while ($result->hasMoreRows()) {
			$groupIds[] = $result->field("id");
			$result->advanceRow();
		}
		
		return $groupIds;
	}
	
	/**
	 * Loads the specified {@link RecordSet}s into the cache.
	 * @param array $groupIDsArray An array of numeric IDs.
	 * @return void
	 */
	function loadRecordSets($groupIDsArray) {
		$fromDBIDs = array();
		
		foreach ($groupIDsArray as $id) {
			if (!isset($this->_recordSetCache[$id]))
				$fromDBIDs[] = $id;
		}

		if (count($fromDBIDs)) {
			$wheres = array();
			foreach ($fromDBIDs as $id) {
				$wheres[] = "dm_record_set.id=$id";
			}
			
			$query =& new SelectQuery;
			$query->addTable("dm_record_set");
			$query->addTable("dm_record", LEFT_JOIN, "dm_record_set.fk_record=dm_record.id");
			$query->addColumn("id","","dm_record_set");
			$query->addColumn("fk_record","","dm_record_set");
			$query->addColumn("active","","dm_record");
			$query->setWhere(implode(" OR ",$wheres));
			
			$dbHandler =& Services::getService("DBHandler");
			$result = $dbHandler->query($query,DATAMANAGER_DBID);
			
			while ($result->hasMoreRows()) {
				$a = $result->getCurrentRow();

				$result->advanceRow();
				$id = $a["id"];
				if (!isset($this->_recordSetCache[$id])) {
					$this->_recordSetCache[$id] =& new RecordSet($id);
				}
				
				$this->_recordSetCache[$id]->takeRow($a);
			}
		}
	}
	
	/**
	*  Fetches and returns an array of Record IDs from the database in one Query.
	* @return ref array Indexed by Record ID, values are {@link Record}s.
	* @param array $IDs
	* @param optional bool $editable If TRUE will fetch the Records as Editable and with ALL versions. Default: FALSE (will only fetch ACTIVE values).
	* @param optional object $limitResults NOT YET IMPLEMENTED
	* criteria. If not specified, will fetch all IDs.
	*/
	function &fetchRecords( $IDs, $editable=false, $limitResults = null ) {
		ArgumentValidator::validate($IDs, new ArrayValidatorRuleWithRule(new NumericValidatorRule()));
		$IDs = array_unique($IDs);

		// let's weed out those IDs that we can take from cache
		$fromCacheIDs = array();
		$fromDBIDs = array();
		if (count($this->_recordCache)) {
			foreach ($IDs as $id) {
				// only take from the cache if we have it cached, AND
				// either we are not fetching editable sets OR (if we are) the cached one is also editable.
				if (isset($this->_recordCache[$id]) && 
							(!$editable || !($this->_recordCache[$id]->getFetchMode()&RECORD_FULL))) {
					$fromCacheIDs[] = $id;
				} else {
					$fromDBIDs[] = $id;
				}
			}
		} else {
			$fromDBIDs = $IDs;
		}
		
		$records = array();
		
		if (count($fromDBIDs)) {
			// first, make the new query
			$query =& new SelectQuery();
	
			$this->_setupSelectQuery($query);
	
			$t = array();
			foreach ($fromDBIDs as $id) {
				$t[] = "dm_record.id=".$id;
			}
			$query->addWhere("(".implode(" OR ", $t).")");
//			$query->addWhere("dm_record.active=1");
			
			// @todo
			// This doesn't return data for the dataset if there aren't any 
			// fields in the dataset.
			if (!$editable) $query->addWhere("(dm_record_field.active=1 OR dm_record_field.active IS NULL)");
			
			$dbHandler =& Services::getService("DBHandler");
			
			//print "<PRE>" . MySQL_SQLGenerator::generateSQLQuery($query)."</PRE>";
			
			$result =& $dbHandler->query($query,DATAMANAGER_DBID);
			
			if (!$result) {
				throwError(new UnknownDBError("RecordManager"));
			}
			
			// now, we need to parse things out and distribute the lines accordingly
			while ($result->hasMoreRows()) {
				$a = $result->getCurrentRow();
				$result->advanceRow();
				
				$id = $a['record_id'];
				$type = $a['fk_schema'];
				$vcontrol =$a['record_ver_control'];
				if (!$records[$id]) {
					$schemaManager =& Services::getService("SchemaManager");
					$schema =& $schemaManager->getSchemaByID($type);
					$schema->load();
					$records[$id] =& new Record($schema,
								$vcontrol?true:false);
				}
				
				$records[$id]->takeRow($a);
				$records[$id]->setFetchMode($editable?RECORD_FULL:RECORD_CURRENT);
				unset($a);
			}
			
			// now, lets update the cache to hold the sets we just fetched
			foreach (array_keys($records) as $id) {
				$this->_recordCache[$id] =& $records[$id];
			}
		}
				
		// and add the IDs we're gonna take from cache to the array to return
		// -- only put into cache if we're not limiting results
		if (!$limitResults) {
			foreach ($fromCacheIDs as $id) {
				if (!isset($records[$id])) $records[$id] =& $this->_recordCache[$id];
			}
		}
		
		// make sure we found the data sets
		$rule =& new ExtendsValidatorRule("Record");
		foreach ($IDs as $id) {
			if (!$rule->check($records[$id]))
				throwError(new Error(UNKNOWN_ID.": Record $id was requested, but not found.", "DataManager", TRUE));
		}
			
		return $sets;
	}
	
	/**
	 * Takes an array of IDs and some search criteria, and weeds out the IDs that don't
	 * match that criteria.
	 * @param ref object $criteria The {@link SearchCriteria}.
	 * @param optional array $ids An array of Record IDs to search among. If not specified, all records will be searched.
	 * @access public
	 */
	function getRecordIDsBySearch(&$criteria, $ids=null) {
		// this should happen in one query.
		// the WHERE clause of the SQL query will be relatively complicated.
		$query =& new SelectQuery();
		$this->_setupSelectQuery($query, TRUE);
		
		$typeIDs = array_unique($criteria->getTypeList());
		
		$searchString = $criteria->returnSearchString();
		
		if ($ids) {
			$parts1 = array();
			foreach ($ids as $id) {
				$parts1[] = "dm_record.id=$id";
			}
			$part1 = implode(" OR ", $parts1);
		}
		
		$parts2 = array();
		foreach ($typeIDs as $typeID) {
			$parts2[] = "dm_record.fk_schema!=$typeID";
		}
		$part2 = implode(" AND ",$parts2);
		
		$part3 = $searchString;
		
		$fullWhere = (isset($part1)?"($part1) AND ":"")."(($part2) OR $part3)";
		
		$query->setWhere($fullWhere);
		
//		print "<PRE>". MySQL_SQLGenerator::generateSQLQuery($query)."</PRE>";
		
		$dbHandler =& Services::getService("DBHandler");
		
		$result =& $dbHandler->query($query, DATAMANAGER_DBID);
		
		$resultIds = array();
		
		while ($result->hasMoreRows()) {
			$a = $result->getCurrentRow();
			$result->advanceRow();
			
			$resultIds[] = $a["record_id"];
		}
		
		return array_unique($resultIds);
	}
	
	/**
	* Fetches a single Record from the database, editable if $editable=true.
	* @return ref object
	* @param int $id
	* @param optional bool $editable
	*/
	function &fetchRecord( $id, $editable=false ) {
		$records =& $this->fetchRecords(array($id), $editable);
		return $records[$id];
	}
	
	/**
	 * Deletes the Record of the Specified Id
	 * @param int $id
	 */
	function & deleteDataSet ( $record ) {
		$record =& $this->fetchRecord( $id, TRUE );
		$record->setActiveFlag(false);
		$record->commit();
	}
	
	/**
	* Initializes a SelectQuery with the complex JOIN structures of the DataManager.
	* @return void
	* @param ref object $query
	* @param optional boolean $idsOnly If TRUE will only ask for the dm_record.id column from the Database. Default = FALSE;
	* @access private
	*/
	function _setupSelectQuery(&$query, $idsOnly=false) {
		// this function sets up the selectquery to include all the necessary tables

		$query->addTable("dm_record");
		$query->addTable("dm_record_field",LEFT_JOIN,"dm_record_field.fk_record=dm_record.id");
		$query->addTable("dm_schema_field",LEFT_JOIN,"dm_record.fk_schema=dm_schema_field.id");
		
		$dataTypeManager =& Services::getService("DataTypeManager");
		$list = $dataTypeManager->getRegisteredStorablePrimitives();
		
		foreach ($list as $type) {
			eval("$type::alterQuery(\$query);");
		}
		
		/* dm_record table */
		$query->addColumn("id","record_id","dm_record");
		if (!$idsOnly) {
			$query->addColumn("created","record_created","dm_record");
			$query->addColumn("active","record_created","dm_record");
			$query->addColumn("ver_control");
			$query->addColumn("fk_schema","","dataset"); //specify table to avoid ambiguity
			
			/* dm_record_field table */
			$query->addColumn("id","record_field_id","dm_record_field");
			$query->addColumn("index","record_field_index","dm_record_field");
			$query->addColumn("active","record_field_active","dm_record_field");
			$query->addColumn("modified","record_field_modified","dm_record_field");
			$query->addColumn("fk_data");
			
			/* dm_schema_field table */
			$query->addColumn("id","schema_field_id","dm_schema_field");
			$query->addColumn("label","schema_field_label","dm_schema_field");
		}
	}
	
	/**
	* Returns a new {@link Record} object that can be inserted into the database.
	* @return ref object
	* @param ref object $type The {@link HarmoniType} object that refers to the Schema to associated this Record with.
	* @param optional bool $verControl Specifies if the Record should be created with Version Control. Default=no.
	*/
	function &createRecord( &$type, $verControl = false ) {
		$schemaManager =& Services::getService("SchemaManager");
		if (!$schemaManager->schemaExists($type)) {
			throwError ( new Error("could not create new Record of type ".OKITypeToString($type).
			" because the requested type does not seem to be registered
			with the SchemaManager.","RecordManager",true));
		}
		
		// ok, let's make a new one.
		$schema =& $schemaManager->getSchemaByType($type);
		// load from the DB
		$schema->load();
		debug::output("Creating new Record of type '".OKITypeToString($type)."', which allows fields: ".implode(", ",$schema->getAllLabels()),DEBUG_SYS4,"DataManager");
		$newRecord =& new Record($schema, $verControl);
		return $newRecord;
	}
	
	/**
	* @return array
	* @param ref object $type The {@link HarmoniType} to look for.
	* Returns an array of Record IDs that are of the Schema type $type.
	*/
	function getRecordIDsOfType(&$type) {
		// we're going to get all the IDs that match a given type.
		
		$query =& new SelectQuery();
		$query->addTable("dm_record");
		$query->addTable("dm_schema",INNER_JOIN,"dm_schema.id=dm_record.fk_schema");
		
		$query->addColumn("id","","dm_record");
		
		$query->setWhere("dm_schema.domain='".addslashes($type->getDomain())."' AND ".
						"dm_schema.authority='".addslashes($type->getAuthority())."' AND ".
						"dm_schema.keyword='".addslashes($type->getKeyword())."'");
		
		$dbHandler =& Services::getService("DBHandler");
		
		$result =& $dbHandler->query($query,DATAMANAGER_DBID);
		
		if (!$result) {
			throwError( new UnknownDBError("RecordManager") );
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
