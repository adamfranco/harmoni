<?php

require_once HARMONI."dataManager/record/Record.class.php";
require_once HARMONI."dataManager/record/RecordSet.class.php";
require_once HARMONI."dataManager/record/StorableRecordSet.class.php";

/**
 * The RecordManager handles the creation, tagging and fetching of {@link Record}s from the database.
 * @package harmoni.datamanager
 * @version $Id: RecordManager.class.php,v 1.7 2004/08/27 18:11:29 adamfranco Exp $
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
	function &getCachedRecordSet($id)
	{
		if (isset($this->_recordSetCache[$id]))
			return $this->_recordSetCache[$id];
		else return ($null=null);
	}
	
	/**
	 * Puts the passed {@link RecordSet} into the internal cache.
	 * @param ref object $set A {@link RecordSet}.
	 * @param boolean $force Re-cache even if we already have it cached. (default=no)
	 * @access public
	 * @return void
	 */
	function cacheRecordSet(&$set, $force=false)
	{
		$id = $set->getID();
		
		if ($force || !isset($this->_recordSetCache[$id])) {
			$this->_recordSetCache[$id] =& $set;
		}
	}
	
	/**
	 * Returns the Ids of all groups a Record is in.
	 *
	 * @param ref object $record The {@link Record}.
	 * @return array An indexed array of the group ids (integers).
	 */
	function getRecordSetIDsContaining(&$record) {
		return $this->getRecordSetIDsContainingID($record->getID());
	}
	
	/**
	 * Returns the Ids of all groups a Record ID is in.
	 *
	 * @param int $id
	 * @return array An indexed array of the group ids (integers).
	 */
	function getRecordSetIDsContainingID($id) {
		if (!$id) return array(); // no ID
		$query =& new SelectQuery;
		$query->addTable("dm_record_set");
		$query->addColumn("id");
		$query->addWhere("fk_record=".$id);
		
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
			if (!$this->getCachedRecordSet($id))
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
				$newSet =& $this->getCachedRecordSet($id);
				if (!$newSet) {
					$newSet =& new StorableRecordSet($id);
					$this->cacheRecordSet($newSet);
				}
				
				$newSet->takeRow($a);
			}
		}
		
		// now, if some of the IDs didn't exist in the DB, we'll create new ones.
		foreach ($groupIDsArray as $id) {
			if (!$this->getCachedRecordSet($id)) {
				$newSet =& new StorableRecordSet($id);
				$this->cacheRecordSet($newSet);
			}
		}
	}
	
	/**
	*  Fetches and returns an array of Record IDs from the database in one Query.
	* @return ref array Indexed by Record ID, values are {@link Record}s.
	* @param array $IDs
	* @param optional int $mode Specifies the mode the record should be fetched.
	* @param optional object $limitResults NOT YET IMPLEMENTED
	* criteria. If not specified, will fetch all IDs.
	*/
	function &fetchRecords( $IDs, $mode = RECORD_CURRENT, $limitResults = null ) {
		ArgumentValidator::validate($IDs, new ArrayValidatorRuleWithRule(new NumericValidatorRule()));
		ArgumentValidator::validate($mode, new IntegerValidatorRule());
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
		
//		print_r($fromCacheIDs);
//		print_r($fromDBIDs);
//		printDebugBacktrace();
		
		$records = array();

		// put all the records from the cache into the array
		foreach ($IDs as $id) {
			if (isset($this->_recordCache[$id])) $records[$id] =& $this->_recordCache[$id];
		}
		
		if (count($fromDBIDs)) {
			// first, make the new query
			$query =& new SelectQuery();
	
			$this->_setupSelectQuery($query, $mode);
	
			// and now, go through the records we already have cached but are fetching more information for,
			// and make sure that we don't fetch information for fields that are already fetched.
			$alreadyFetchedFields = array();
			
			// and, build the WHERE clause while we're at it.
			$t = array();
			foreach ($fromDBIDs as $id) {
				$t[] = "dm_record.id=".$id;
				
				if (isset($this->_recordCache[$id])) {
					$alreadyFetchedFields = array_unique(array_merge($alreadyFetchedFields, $this->_recordCache[$id]->getFetchedFieldIDs()));
				}
			}

			$query->addWhere("(".implode(" OR ", $t).")");
			if (count($alreadyFetchedFields)) {
				$temp = array();
				foreach ($alreadyFetchedFields as $id) {
					$temp[] = "dm_record_field.id != $id";
				}
				$query->addWhere('(' . implode(" AND ", $temp) . ')');
			}
			
			$dbHandler =& Services::getService("DBHandler");
			
//			print "<PRE>" . MySQL_SQLGenerator::generateSQLQuery($query)."</PRE>";
			
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
				if (!isset($records[$id])) {
					$schemaManager =& Services::getService("SchemaManager");
					$schema =& $schemaManager->getSchemaByID($type);
					$schema->load();
					$records[$id] =& new Record($schema, $vcontrol?true:false);
					$this->_recordCache[$id] =& $records[$id];
				}
				
				$records[$id]->takeRow($a);
				unset($a);
			}
			
		}				

		// make sure we found the data sets
		$rule =& new ExtendsValidatorRule("Record");
		foreach ($IDs as $id) {
			if (!$rule->check($records[$id]))
				throwError(new Error(UNKNOWN_ID.": Record $id was requested, but not found.", "DataManager", TRUE));
			
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
	 * @param optional array $ids An array of Record IDs to search among. If not specified, all records will be searched.
	 * @access public
	 */
	function getRecordIDsBySearch(&$criteria, $ids=null) {
		// this should happen in one query.
		// the WHERE clause of the SQL query will be relatively complicated.
		$query =& new SelectQuery();
		$this->_setupSelectQuery($query, RECORD_CURRENT);
		
		$searchString = $criteria->returnSearchString();
		
		if ($ids) {
			$parts1 = array();
			foreach ($ids as $id) {
				$parts1[] = "dm_record.id=$id";
			}
			$part1 = implode(" OR ", $parts1);
		}
		
		$part2 = $searchString;
		
		$fullWhere = (isset($part1)?"($part1) AND ":"")."($part2)";
		
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
	* Fetches a single Record from the database.
	* @return ref object
	* @param int $id
	* @param optional int $mode
	*/
	function &fetchRecord( $id, $mode=RECORD_CURRENT ) {
		$records =& $this->fetchRecords(array($id), $mode);
		return $records[$id];
	}
	
	/**
	 * Deletes the Record of the Specified Id
	 * @param int $id
	 * @param optional bool $prune Set to TRUE if you want the Record to actually be pruned from the database and not just deactivated.
	 */
	function &deleteRecord ( $id, $prune=false ) {
		$mode = $prune?RECORD_FULL:RECORD_NODATA;
		$record =& $this->fetchRecord( $id, $mode );
		$record->setActiveFlag(false);
		if ($prune) $record->prune( new PruneAllVersionConstraint() );
		$record->commit();
	}
	
	/**
	* Initializes a SelectQuery with the complex JOIN structures of the DataManager.
	* @return void
	* @param ref object $query
	* @param optional int $mode Specifies the mode we are fetching our results. Must be one of RESULT_* constants.
	* @access private
	*/
	function _setupSelectQuery(&$query, $mode=RECORD_CURRENT) {
		// this function sets up the selectquery to include all the necessary tables
		$query->addTable("dm_record");
		if ($mode > RECORD_NODATA) {
			if ($mode < RECORD_FULL) {
				$query->addTable("dm_record_field",LEFT_JOIN,"(dm_record_field.fk_record=dm_record.id AND dm_record_field.active=1)");
			} else {
				$query->addTable("dm_record_field",LEFT_JOIN,"dm_record_field.fk_record=dm_record.id");
			}
			$query->addTable("dm_schema_field",LEFT_JOIN,"dm_record_field.fk_schema_field=dm_schema_field.id");
		
			$dataTypeManager =& Services::getService("DataTypeManager");
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
			$query->addColumn("label","schema_field_label","dm_schema_field");
		}
		
		/* dm_record table */
		$query->addColumn("id","record_id","dm_record");
		$query->addColumn("created","record_created","dm_record");
		$query->addColumn("active","record_active","dm_record");
		$query->addColumn("ver_control","record_ver_control","dm_record");
		$query->addColumn("fk_schema","","dm_record"); //specify table to avoid ambiguity
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
		$newRecord->setFetchMode(RECORD_FULL);
		return $newRecord;
	}
	
	/**
	* @return array
	* @param ref object $type The {@link HarmoniType} to look for.
	* @param optional boolean $activeOnly Will only return active Records [default=false]
	* Returns an array of Record IDs that are of the Schema type $type.
	*/
	function getRecordIDsByType(&$type, $activeOnly=false) {
		// we're going to get all the IDs that match a given type.
		
		$query =& new SelectQuery();
		$query->addTable("dm_record");
		$query->addTable("dm_schema",INNER_JOIN,"dm_schema.id=dm_record.fk_schema");
		
		$query->addColumn("id","","dm_record");
		
		$query->setWhere("dm_schema.domain='".addslashes($type->getDomain())."' AND ".
						"dm_schema.authority='".addslashes($type->getAuthority())."' AND ".
						"dm_schema.keyword='".addslashes($type->getKeyword())."'".
						($activeOnly?" AND dm_record.active=1":""));
		
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
