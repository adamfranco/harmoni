<?

require_once HARMONI."metaData/manager/DataSetTag.class.php";

/**
* Handles the creation and retrieval of {@link Tag}s to/from the database. See {@link Tag} for a 
* more detailed explanation of the role of tags.
* @access public
* @package harmoni.datamanager
* @version $Id: TagManager.class.php,v 1.2 2004/07/27 18:15:26 gabeschine Exp $
* @copyright 2004, Middlebury College
*/
class TagManager extends ServiceInterface {
	
	/**
	 * Takes a {@link Record} and an optional date and creates a {@link Tag} in the database based
	 * on the current active versions of values within the {@link Record}.
	 * @param ref object $record The {@link Record} to be tagged.
	 * @param optional object $date An optional {@link DateTime} object to attach to the tag instead of the current date/time.
	 * @return int The new tag's ID in the database.
	 * @access public
	 */
	function tagRecord( &$record, $date=null ) {
		// if the dataset is not versionControlled, there's no point in tagging
		if (!$record->isVersionControlled()) return null;
		
		$id = $record->getID();
		if (!$date) $date =& DateTime::now();
		
		// spider through the record and get the IDs of the active versions.
		$ids = array();
		$schema =& $record->getSchema();
		foreach ($schema->getAllLabels() as $label) {
			$values =& $record->getAllRecordFieldValues($label);
			foreach (array_keys($values) as $key) {
				if ($values[$key]->hasActiveValue()) {
					$actVer =& $values[$key]->getActiveVersion();
					$ids[] = $actVer->getID();
				}
			}
		}
		
		// now let's dump it all to the DB
		$query =& new InsertQuery;
		
		$query->setTable("dm_tag");
		$query->setColumns(array("id","fk_record","date"));
		
		$sharedManager =& Services::getService("Shared");
		$newID =& $sharedManager->createId();
		$query->addRowOfValues(array(
				$newID->getIdString(),
				$dataSetID,
				$dbHandler->toDBDate($date,DATAMANAGER_DBID)));
		
		$query2 =& new InsertQuery;
		$query2->setTable("dm_tag_map");
		$query2->setColumns(array("fk_tag","fk_record_field"));
		
		foreach ($ids as $id) {
			$query2->addRowOfValues(array($newID->getIdString(),$id));
		}
		
		$result =& $dbHandler->query($query, DATAMANAGER_DBID);
		$result2 =& $dbHandler->query($query2, DATAMANAGER_DBID);
		
		if (!$result || !$result2) throwError ( new UnknownDBError("TagManager"));
		
		// we're done.
		return $newID->getIdString();
	}

	/**
	 * Removes from the Database all tags associated with $record.
	 * @param ref object $record A {@link Record} object.
	 * @return void
	 */
	function pruneTags(&$record) {
		$theID = $record->getID();
		if (!$theID) return;
		
		$dbHandler =& Services::getService("DBHandler");
		// first get a list of tags for this dataset
		$query =& new SelectQuery;
		$query->addTable("dm_tag");
		$query->addColumn("id");
		$query->setWhere("fk_record=$theID");
		
		$res =& $dbHandler->query($query, DATAMANAGER_DBID);
		
		$ids = array();
		while ($res->hasMoreRows()) {
			$ids[] = "fk_tag=".$res->field(0);
			$res->advanceRow();
		}
		
		if (!count($ids)) return;
		
		$query =& new DeleteQuery;
		$query->setTable("dm_tag");
		$query->setWhere("fk_record=$theID");
		
		$dbHandler->query($query, DATAMANAGER_DBID);
		
		$query =& new DeleteQuery;
		$query->setTable("dm_tag_map");
		$query->setWhere(implode(" OR ",$ids));
		
		$dbHandler->query($query, DATAMANAGER_DBID);
	}
	
	/**
	 * Removes specific tag from the database.
	 * @param ref object $tag A {@link Tag} object.
	 * @return void
	 */
	function pruneTag(&$tag) {
		$id = $tag->getID();
		if (!$id) return;
		
		$dbHandler=& Services::getService("DBHandler");
		
		// first get rid of all our mappings
		$query =& new DeleteQuery;
		$query->setTable("dm_tag_map");
		$query->setWhere("fk_tag=$id");
		
		$dbHandler->query($query, DATAMANAGER_DBID);
		
		// now get rid of the tag
		unset($query);
		$query =& new DeleteQuery;
		$query->setTable("dm_tag");
		$query->setWhere("id=$id");
		
		$dbHandler->query($query, DATAMANAGER_DBID);
	}
	
	/**
	 * Checks to see if any of our Tags are empty, and if so, deletes them.
	 * @param ref object $record The {@link Record} to check.
	 * @return void
	 */
	function checkForEmptyTags(&$record) {
		// to do this, we are going to fetch the tag descriptors (from the "dm_tag" table)
		// and then fetch the full tags (which inner joins onto the "dm_tag_map" table),
		// find out if there are any descriptors not represented in full tags, and delete those.
		if (!$record->getID()) return;
		
		$tagDescriptors =& $this->fetchTagDescriptors($record->getID());
		$fullTags =& $this->fetchTags($record->getID());
		
		if (count($tagDescriptors) == count($fullTags)) return;
		
		$pruneIDs = array();
		foreach (array_keys($tagDescriptors) as $tagID) {
			if (!isset($fullTags[$tagID])) $pruneIDs[] = "id=".$tagID;
		}
		
		if (count($pruneIDs)) {
			$query =& new DeleteQuery;
			$query->setTable("dm_tag");
			$query->setWhere(implode(" OR ",$pruneIDs));
			
			$dbHandler =& Services::getService("DBHandler");
			$dbHandler->query($query, DATAMANAGER_DBID);
		}
	}
	
	/**
	 * Returns an array of {@link Tag}s without having loaded all of the mapping data. Useful for
	 * just checking what tags are available and what dates they were created on.
	 * @param int $id The ID of the {@link Record} to look for.
	 * @return ref array
	 * @access public
	 */
	function &fetchTagDescriptors($id) {
		$query =& new SelectQuery;
		
		$query->addTable("dm_tag");
		$query->addColumn("id");
		$query->addColumn("date");
		
		$query->setWhere("dm_tag.fk_record=$id");
		
		$dbHandler =& Services::getService("DBHandler");
		
		$result =& $dbHandler->query($query,DATAMANAGER_DBID);
		
		if (!$result) throwError( new UnknownDBError("TagManager"));
		
		$tags = array();
		while ($result->hasMoreRows()) {
			$a = $result->getCurrentRow();
			$result->advanceRow();
			
			$newTag =& new Tag($id, 
					$dbHandler->fromDBDate($a["dataset_tag_date"], DATAMANAGER_DBID), $a["id"]);
			
			$tags[$a["id"]] =& $newTag;
		}
		
		return $tags;
	}
	
	/**
	 * Fetches all of the {@link Tag}s available for {@link Record} ID $id with all mapping data loaded.
	 * @param int $id The {@link Record} ID.
	 * @return ref array
	 * @access public
	 */
	function &fetchTags($id) {
		$query =& new SelectQuery;
		
		$query->addTable("dm_tag_map");
		$query->addTable("dm_tag",INNER_JOIN,"dm_tag_map.fk_tag=dm_tag.id");
		$query->addTable("dm_record_field",INNER_JOIN,"dm_tag_map.fk_record_field=dm_record_field.id");
		$query->addTable("dm_schema_field",INNER_JOIN,"dm_record_field.fk_schema_field=dm_schema_field.id");
		
		$query->addColumn("id","tag_id","dm_tag");
		$query->addColumn("date","tag_date","dm_tag");
		
		$query->addColumn("index","record_field_index","dm_record_field");
		$query->addColumn("id","record_field_id","dm_record_field");
		
		$query->addColumn("label","schema_field_label","dm_schema_field");
		
		$query->setWhere("dm_tag.fk_record=$id");
		
		$dbHandler =& Services::getService("DBHandler");
		$result =& $dbHandler->query($query, DATAMANAGER_DBID);
		
		if (!$result) throwError( new UnknownDBError("TagManager"));
		
		$tagRows = array();
		$dates = array();
		
		while ($result->hasMoreRows()) {
			$a = $result->getCurrentRow();
			$result->advanceRow();
			$tagID = $a["tag_id"];
			
			if (!isset($tagRows[$tagID])) {
				$tagRows[$tagID] = array();
			}
			
			$tagRows[$tagID][] = $a;
			if (!isset($dates[$tagID])) $dates[$tagID] =& $dbHandler->fromDBDate($a["tag_date"], DATAMANAGER_DBID);
		}
		
		$tags = array();
		foreach (array_keys($tagRows) as $tagID) {
			$newTag =& new Tag($id, $dates[$tagID], $tagID);
			$newTag->populate($tagRows[$tagID]);
			
			$tags[$tagID] =& $newTag;
		}
		
		return $tags;
	}
	
	/**
	 * Deletes all tags stored in the database for {@link Record} id $id.
	 * @access public
	 * @param int $id
	 * @return void
	 */
	function deleteRecordTags($id) {
		if (!$id) return;
		// first get a list of Tag IDs for this dataset.
		$query =& new SelectQuery;
		$query->addTable("dm_tag");
		$query->addColumn("id");
		$query->setWhere("fk_record=$id");

		$dbHandler =& Services::getService("DBHandler");
		$res =& $dbHandler->query($query, DATAMANAGER_DBID);
		
		$ids = array();
		while ($res->hasMoreRows()) {
			$ids[] = $res->field(0);
			$res->advanceRow();
		}
		
		// now delete the datasets
		$query =& new DeleteQuery;
		
		$query->setTable("dm_tag");
		$query->setWhere("fk_record=$id");
		
		$dbHandler->query($query, DATAMANAGER_DBID);
		
		// and delete the mappings
		$wheres = array();
		foreach ($ids as $tagID) {
			$wheres[] = "fk_tag=$tagID";
		}
		
		$query->reset();
		$query->setTable("dm_tag_map");
		$query->setWhere(implode(" OR ", $wheres));
		
		$dbHandler->query($query,DATAMANAGER_DBID);
	}
	
	function start() {}
	function stop() {}
	
}