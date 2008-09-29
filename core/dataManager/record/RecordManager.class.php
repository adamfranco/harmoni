<?php

require_once HARMONI."dataManager/record/Record.class.php";
require_once HARMONI."dataManager/record/RecordSet.class.php";
require_once HARMONI."dataManager/record/StorableRecordSet.class.php";

/**
 * The RecordManager handles the creation, tagging and fetching of {@link DMRecord}s from the database.
 *
 * @package harmoni.datamanager
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RecordManager.class.php,v 1.30 2008/02/15 18:11:45 adamfranco Exp $
 *
 * @author Gabe Schine
 */
class RecordManager {
	
	var $_versionConstraint = null;
	
	var $_recordCache;
	var $_recordSetCache;
	
	var $_cacheMode;
	
	function RecordManager() {
		$this->_recordCache = array();
		$this->_recordSetCache = array();
		$this->_cacheMode = true;
	}

	/**
	 * If set to true, records will be cached, otherwise not.
	 * @param boolean $mode
	 * @static
	 * @return void
	 */
	static function setCacheMode($mode) {
		$mgr = Services::getService("RecordManager");
		$mgr->_setCacheMode($mode);
	}

	function _setCacheMode($mode) {
		$this->_cacheMode = $mode;
	}
	
	/**
	 * Returns a {@link RecordSet} object associated with the numeric ID.
	 * @param int $groupID The RecordSet ID.
	 * @param optional bool $dontLoad If set to TRUE will not attempt to load the RecordSet, only return it if it's already loaded.
	 * @return ref object OR NULL if not found.
	 */
	function fetchRecordSet($groupID, $dontLoad=false) {
		if ($dontLoad) {
			return $this->getCachedRecordSet($groupID);
		} else {
			$this->loadRecordSets(array($groupID));
			return $this->getCachedRecordSet($groupID);
		}
	}
	
	/**
	 * Returns a cached {@link RecordSet}.
	 * @param int $id The ID of the RecordSet.
	 * @access public
	 * @return ref object
	 */
	function getCachedRecordSet($id)
	{
		if (isset($this->_recordSetCache[$id])) {
			return $this->_recordSetCache[$id];
		} else {
			$null = null;
			return $null;
		}
	}
	
	/**
	 * Puts the passed {@link RecordSet} into the internal cache.
	 * @param ref object $set A {@link RecordSet}.
	 * @param boolean $force Re-cache even if we already have it cached. (default=no)
	 * @access public
	 * @return void
	 */
	function cacheRecordSet($set, $force=false)
	{
		$id = $set->getID();
		
		if ($force || !isset($this->_recordSetCache[$id])) {
			$this->_recordSetCache[$id] =$set;
		}
	}

	/**
	 * Removes a recordset (and all of its records!) from the cache.
	 * @param int $id The ID of the record set.
	 * @access public
	 * @return void
	 */
	function uncacheRecordSet($id) {
		$set =$this->getCachedRecordSet($id);
		if ($set) {
			foreach($set->getRecordIDs() as $i) {
				$this->uncacheRecord($i);
			}
		}
		unset($this->_recordSetCache[$id]);
	}

	/**
	 * Removes a record from the cache.
	 * @param int $id The ID of the record.
	 * @access public
	 * @return void
	 */
	function uncacheRecord($id) {
		unset($this->_recordCache[$id]);
	}
	
	/**
	 * Returns the Ids of all groups a DMRecord is in.
	 *
	 * @param ref object $record The {@link DMRecord}.
	 * @return array An indexed array of the group ids (integers).
	 */
	function getRecordSetIDsContaining($record) {
		return $this->getRecordSetIDsContainingID($record->getID());
	}
	
	/**
	 * Returns the Ids of all groups a DMRecord ID is in.
	 *
	 * @param int $id
	 * @return array An indexed array of the group ids (integers).
	 */
	function getRecordSetIDsContainingID($id) {
		if (!$id) return array(); // no ID
		$query = new SelectQuery;
		$query->addTable("dm_record_set");
		$query->addColumn("id");
		$query->addWhere("fk_record='".addslashes($id)."'");
		
		$dbHandler = Services::getService("DatabaseManager");
		$result = $dbHandler->query($query,DATAMANAGER_DBID);
		
		$groupIds = array();
		while ($result->hasMoreRows()) {
			$groupIds[] = $result->field("id");
			$result->advanceRow();
		}
		
		$result->free();
		
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
			if (!$this->getCachedRecordSet($id))
				$fromDBIDs[] = $id;
		}

		if (count($fromDBIDs)) {
			$wheres = array();
			foreach ($fromDBIDs as $id) {
				$wheres[] = "dm_record_set.id='".addslashes($id)."'";
			}
			
			$query = new SelectQuery;
			$query->addTable("dm_record_set");
			$query->addTable("dm_record", LEFT_JOIN, "dm_record_set.fk_record=dm_record.id");
			$query->addColumn("id","","dm_record_set");
			$query->addColumn("fk_record","","dm_record_set");
			$query->setWhere(implode(" OR ",$wheres));
			
			$dbHandler = Services::getService("DatabaseManager");
			$result = $dbHandler->query($query,DATAMANAGER_DBID);

			while ($result->hasMoreRows()) {
				$a = $result->getCurrentRow();
				$result->advanceRow();
				$id = $a["id"];
				$newSet =$this->getCachedRecordSet($id);
				if (!$newSet) {
					$newSet = new StorableRecordSet($id);
					$this->cacheRecordSet($newSet);
				}
				
				$newSet->takeRow($a);
			}
			
			$result->free();
		}
		
		// now, if some of the IDs didn't exist in the DB, we'll create new ones.
		foreach ($groupIDsArray as $id) {
			if (!$this->getCachedRecordSet($id)) {
				$newSet = new StorableRecordSet($id);
				$this->cacheRecordSet($newSet);
			}
		}
	}

	/**
	* Pre-loads all of the records which are contained in the RecordSet IDs passed.
	* This is useful to speed up fetching records for multiple RecordSets
	* @return void
	* @param array $IDs An array of RecordSet ids.
	* @param optional int $fetchMode the fetchmode to get the records (one of RECORD_*).
	* @access public
	*/
	function preCacheRecordsFromRecordSetIDs($ids, $fetchMode=RECORD_CURRENT) {
		$this->loadRecordSets($ids);
		$recordIDs = array();
		foreach ($ids as $id) {
			$set =$this->fetchRecordSet($id);
			$temp = $set->getRecordIDs();
			$recordIDs = array_merge($temp, $recordIDs);
		}
		$recordIDs = array_unique($recordIDs);

		$this->fetchRecords($recordIDs, $fetchMode);
	}
	
	/**
	*  Fetches and returns an array of DMRecord IDs from the database in one Query.
	* @return ref array Indexed by DMRecord ID, values are {@link DMRecord}s.
	* @param array $IDs
	* @param optional int $mode Specifies the mode the record should be fetched.
	* @param optional object $limitResults NOT YET IMPLEMENTED
	* criteria. If not specified, will fetch all IDs.
	*/
	function fetchRecords( $IDs, $mode = RECORD_CURRENT, $limitResults = null ) {
		ArgumentValidator::validate($IDs, ArrayValidatorRuleWithRule::getRule(OrValidatorRule::getRule(StringValidatorRule::getRule(), IntegerValidatorRule::getRule())));
		ArgumentValidator::validate($mode, IntegerValidatorRule::getRule());
		$IDs = array_unique($IDs);

		// let's weed out those IDs that we can take from cache
		$fromCacheIDs = array();
		$fromDBIDs = array();
		if (count($this->_recordCache)) {
			foreach ($IDs as $id) {
				// only take from the cache if we have it cached, AND
				// what is cached is fetched at a higher/equal data-mode than what's requested
				if (isset($this->_recordCache[$id]) && 
							$this->_recordCache[$id]->getFetchMode()>=$mode) {
					$fromCacheIDs[] = $id;
				} else {
					$fromDBIDs[] = $id;
				}
			}
		} else {
			$fromDBIDs = $IDs;
		}
		
		$records = array();

		// put all the records from the cache into the array
		foreach ($IDs as $id) {
			if (isset($this->_recordCache[$id])) $records[$id] =$this->_recordCache[$id];
		}
		
		if (count($fromDBIDs)) {
			// first, make the new query
			$query = new SelectQuery();
	
			$this->_setupSelectQuery($query, $mode);
	
			// and now, go through the records we already have cached but are fetching more information for,
			// and make sure that we don't fetch information for fields that are already fetched.
			$alreadyFetchedFields = array();
			
			// and, build the WHERE clause while we're at it.
			$t = array();
			foreach ($fromDBIDs as $id) {
				$t[] = "dm_record.id='".addslashes($id)."'";
				
				if (isset($this->_recordCache[$id])) {
					$alreadyFetchedFields = array_unique(array_merge($alreadyFetchedFields, $this->_recordCache[$id]->getFetchedFieldIDs()));
				}
			}

			$query->addWhere("(".implode(" OR ", $t).")");
			if (count($alreadyFetchedFields)) {
				$temp = array();
				foreach ($alreadyFetchedFields as $id) {
					$temp[] = "dm_record_field.id != '".addslashes($id)."'";
				}
				$query->addWhere('(' . implode(" AND ", $temp) . ')');
			}
			
			$dbHandler = Services::getService("DatabaseManager");
			
//			print "<PRE>" . MySQL_SQLGenerator::generateSQLQuery($query)."</PRE>";
			
			$result =$dbHandler->query($query,DATAMANAGER_DBID);
			
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
				if (!isset($records[$id])) {
					$schemaManager = Services::getService("SchemaManager");
					$schema =$schemaManager->getSchemaByID($type);
					$schema->load();
					$records[$id] = new DMRecord($schema, $vcontrol?true:false, $mode);
					if ($this->_cacheMode) $this->_recordCache[$id] =$records[$id];
				}
				
				$records[$id]->takeRow($a);
				unset($a);
			}
			
			$result->free();
			
		}				

		// make sure we found the data sets
		$rule = ExtendsValidatorRule::getRule("DMRecord");
		foreach ($IDs as $id) {
			if (!isset($records[$id]) || !$rule->check($records[$id]))
				throw new UnknownIdException("DMRecord $id was requested, but not found.");
			
			// and set the fetch mode.
			$records[$id]->setFetchMode($mode);
//			print "<pre>";print_r($records[$id]);print "</pre>";
		}
			
		return $records;
	}
	
	/**
	 * Takes an array of IDs and some search criteria, and weeds out the IDs that don't
	 * match that criteria.
	 * @param ref object $criteria The {@link SearchCriteria}.
	 * @param optional array $ids An array of DMRecord IDs to search among. If not specified, all records will be searched.
	 * @access public
	 */
	function getRecordIDsBySearch($criteria, $ids=null) {
		// this should happen in one query.
		// the WHERE clause of the SQL query will be relatively complicated.
		$query = new SelectQuery();
		$this->_setupSelectQuery($query, RECORD_CURRENT);
		
		$searchString = $criteria->returnSearchString();
		
		if ($ids) {
			$parts1 = array();
			foreach ($ids as $id) {
				$parts1[] = "'".addslashes($id)."'";
			}
			$part1 = "dm_record.id IN (".implode(", ", $parts1).")";
		}
		
		$part2 = $searchString;
		
		$fullWhere = (isset($part1)?"($part1) AND ":"")."($part2)";
		
		$query->setWhere($fullWhere);
		
//		print "<PRE>". MySQL_SQLGenerator::generateSQLQuery($query)."</PRE>";
		
		$dbHandler = Services::getService("DatabaseManager");
		
		$result =$dbHandler->query($query, DATAMANAGER_DBID);
		
		$resultIds = array();
		
		while ($result->hasMoreRows()) {
			$a = $result->getCurrentRow();
			$result->advanceRow();
			
			$resultIds[] = $a["record_id"];
		}
		
		$result->free();
		
		$ids = $criteria->postProcess($resultIds);
		return array_unique($ids);
	}
	
	/**
	 * Takes an array of record set IDs and some search criteria, and weeds out 
	 * the IDs that don't match that criteria.
	 * @param ref object $criteria The {@link SearchCriteria}.
	 * @param optional array $ids An array of RecordSet IDs to search among.
	 *								If not specified, all records will be searched.
	 * @return array
	 * @access public
	 */
	function getRecordSetIDsBySearch($criteria, $ids=null) {
		// this should happen in one query.
		// the WHERE clause of the SQL query will be relatively complicated.
		$query = new SelectQuery();
		
		$query->addColumn("id","record_set_id","dm_record_set");
		
		$query->addTable("dm_record");
		$query->addTable("dm_record_field",LEFT_JOIN,"(dm_record_field.fk_record=dm_record.id AND dm_record_field.active=1)");
		$query->addTable("dm_schema_field",LEFT_JOIN,"dm_record_field.fk_schema_field=dm_schema_field.id");
		$query->addTable("dm_record_set", INNER_JOIN, "dm_record_set.fk_record = dm_record.id");
		
		$dataTypeManager = Services::getService("DataTypeManager");
		$list = $dataTypeManager->getRegisteredStorablePrimitives();

		foreach ($list as $type) {
			eval("$type::alterQuery(\$query);");
		}
		
		$searchString = $criteria->returnSearchString();
		
		if ($ids) {
			$parts1 = array();
			foreach ($ids as $id) {
				$parts1[] = "'".addslashes($id)."'";
			}
			$part1 = "\n\tdm_record_set.id IN (\n\t\t".implode(",\n\t\t", $parts1).")";
		}
		
		$part2 = $searchString;
		
		$fullWhere = (isset($part1)?"($part1) \n\tAND ":"")."($part2)";
		
		$query->setWhere($fullWhere);
		
// 		print "<PRE>". MySQL_SQLGenerator::generateSQLQuery($query)."</PRE>";
		
		$dbHandler = Services::getService("DatabaseManager");
		
		$result =$dbHandler->query($query, DATAMANAGER_DBID);
		
		$resultIds = array();
		
		while ($result->hasMoreRows()) {
			$a = $result->getCurrentRow();
			$result->advanceRow();
			
			$resultIds[] = $a["record_set_id"];
		}
		
		$result->free();
		
		$ids = $criteria->postProcess($resultIds);
		return array_unique($ids);
	}
	
	/**
	* Fetches a single DMRecord from the database.
	* @return ref object
	* @param int $id
	* @param optional int $mode
	*/
	function fetchRecord( $id, $mode=RECORD_CURRENT ) {
		$records =$this->fetchRecords(array($id), $mode);
		return $records[$id];
	}
	
	/**
	 * Deletes the DMRecord of the Specified Id
	 * @param int $id
	 * @param optional bool $prune Set to TRUE if you want the DMRecord to actually be pruned from the database and not just deactivated.
	 */
	function deleteRecord ( $id, $prune=false ) {
		$mode = RECORD_FULL;
		$record =$this->fetchRecord( $id, $mode );
		$record->delete();
		$record->commit();
	}
	
	/**
	 * Delete the DMRecord Set and any records that are referenced only by this record
	 * set and not shared with other record sets.
	 * 
	 * @param int $id The Id of the set to delete.
	 * @param optional boolean $prune If TRUE will make sure that the Records are removed
	 * from the database.
	 * @return void
	 * @access public
	 * @since 10/6/04
	 */
	function deleteRecordSet ($id, $prune = false) {
		ArgumentValidator::validate($id, StringValidatorRule::getRule());
		$recordSet =$this->fetchRecordSet($id);
		
		$recordSet->loadRecords($prune?RECORD_FULL:RECORD_NODATA);
		// Delete the records in the set.
		$records =$recordSet->getRecords();
		
		foreach (array_keys($records) as $key) {
			$record =$records[$key];
			
			// Only delete records if they are not shared with other sets.
			$setsContaining = $this->getRecordSetIDsContaining($record);
			if (count($setsContaining) == 1 
				&& $setsContaing[0] == $id)
			{
				$this->deleteRecord($record->getID(), $prune);
			}
		}
		
		// Delete the set from the database
		$query = new DeleteQuery;
		$query->setTable("dm_record_set");
		$query->addWhere("id = '".addslashes($id)."'");
		
		$dbHandler = Services::getService("DatabaseManager");
		$result =$dbHandler->query($query,DATAMANAGER_DBID);
		
		$this->_recordSetCache[$id] = NULL;
		unset($this->_recordSetCache[$id]);
	}
	
	/**
	* Initializes a SelectQuery with the complex JOIN structures of the DataManager.
	* @return void
	* @param ref object $query
	* @param optional int $mode Specifies the mode we are fetching our results. Must be one of RESULT_* constants.
	* @access private
	*/
	function _setupSelectQuery($query, $mode=RECORD_CURRENT) {
		// this function sets up the selectquery to include all the necessary tables
		$query->addTable("dm_record");
		if ($mode > RECORD_NODATA) {
			if ($mode < RECORD_FULL) {
				$query->addTable("dm_record_field",LEFT_JOIN,"(dm_record_field.fk_record=dm_record.id AND dm_record_field.active=1)");
			} else {
				$query->addTable("dm_record_field",LEFT_JOIN,"dm_record_field.fk_record=dm_record.id");
			}
			$query->addTable("dm_schema_field",LEFT_JOIN,"dm_record_field.fk_schema_field=dm_schema_field.id");
		
			$dataTypeManager = Services::getService("DataTypeManager");
			$list = $dataTypeManager->getRegisteredStorablePrimitives();

			foreach ($list as $type) {
				eval("$type::alterQuery(\$query);");
			}
			
			/* dm_record_field table */
			$query->addColumn("id","record_field_id","dm_record_field");
			$query->addColumn("value_index","record_field_index","dm_record_field");
			$query->addColumn("active","record_field_active","dm_record_field");
			$query->addColumn("modified","record_field_modified","dm_record_field");
			$query->addColumn("fk_data");
			
			/* dm_schema_field table */
			$query->addColumn("id","schema_field_id","dm_schema_field");
//			$query->addColumn("label","schema_field_label","dm_schema_field");
		}
		
		/* dm_record table */
		$query->addColumn("id","record_id","dm_record");
		$query->addColumn("created","record_created","dm_record");
		$query->addColumn("ver_control","record_ver_control","dm_record");
		$query->addColumn("fk_schema","","dm_record"); //specify table to avoid ambiguity
	}
	
	/**
	* Returns a new {@link DMRecord} object that can be inserted into the database.
	* @return ref object
	* @param string $type The Schema type/ID that refers to the Schema to associate this DMRecord with.
	* @param optional bool $verControl Specifies if the DMRecord should be created with Version Control. Default=no.
	*/
	function createRecord( $type, $verControl = false ) {
		$schemaManager = Services::getService("SchemaManager");
		if (!$schemaManager->schemaExists($type)) {
			throwError ( new Error("could not create new DMRecord of type ".$type.
			" because the requested type does not seem to be registered
			with the SchemaManager.","RecordManager",true));
		}
		
		// ok, let's make a new one.
		$schema =$schemaManager->getSchemaByID($type);
		// load from the DB
		$schema->load();
		debug::output("Creating new DMRecord of type '".$type."', which allows fields: ".implode(", ",$schema->getAllIDs()),DEBUG_SYS4,"DataManager");
		$newRecord = new DMRecord($schema, $verControl);
		return $newRecord;
	}
	
	/**
	* @return array
	* @param string $type The Schema type to look for.
	* Returns an array of DMRecord IDs that are of the Schema type $type.
	*/
	function getRecordIDsByType($type) {
		// we're going to get all the IDs that match a given type.
		
		$query = new SelectQuery();
		$query->addTable("dm_record");
		$query->addTable("dm_schema",INNER_JOIN,"dm_schema.id=dm_record.fk_schema");
		
		$query->addColumn("id","","dm_record");
		
		$query->setWhere("dm_schema.id='".addslashes($type)."'");
		
		$dbHandler = Services::getService("DatabaseManager");
		
		$result =$dbHandler->query($query,DATAMANAGER_DBID);
		
		if (!$result) {
			throwError( new UnknownDBError("RecordManager") );
			return false;
		}
		
		$array = array();
		while ($result->hasMoreRows()) {
			$array[] = $result->field(0);
			$result->advanceRow();
		}
		
		$result->free();
		
		return $array;
	}	
}
