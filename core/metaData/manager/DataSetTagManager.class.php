<?

require_once HARMONI."metaData/manager/DataSetTag.class.php";

/**
* Handles the creation and retrieval of {@link DataSetTag}s to/from the database. See {@link DataSetTag} for a 
* more detailed explanation of the role of tags.
* @access public
* @package harmoni.datamanager
* @version $Id: DataSetTagManager.class.php,v 1.15 2004/03/31 19:13:26 adamfranco Exp $
* @copyright 2004, Middlebury College
*/
class DataSetTagManager extends ServiceInterface {
	
	var $_dbID;
	
	function DataSetTagManager( $dbID) {
		$this->_dbID = $dbID;
	}
	
	/**
	 * Takes a DataSet and an optional date and creates a DataSetTag in the database based
	 * on the current active versions of values within the DataSet.
	 * @param ref object $dataSet Either a {@link CompactDataSet} or a {@link FullDataSet} to be tagged.
	 * @param optional object $date An optional {@link DateTime} object to attach to the tag instead of the current date/time.
	 * @return int The new tag's ID in the database.
	 * @access public
	 */
	function tagToDB( &$dataSet, $date=null ) {
		// if the dataset is not versionControlled, there's no point in tagging
		if (!$dataSet->isVersionControlled()) return null;
		
		$dataSetID = $dataSet->getID();
		if (!$date) $date =& DateTime::now();
		
		$query =& new SelectQuery();
		$query->addTable("datasetfield");
		
		$query->addColumn("datasetfield_id");
		$query->setWhere("datasetfield_active=1 AND fk_dataset=".$dataSetID);
		
		$dbHandler =& Services::getService("DBHandler");
		$results =& $dbHandler->query($query, $this->_dbID);
		
		if (!$results) throwError( new UnknownDBError("DataSetTagManager"));
		
		$ids = array();
		while ($results->hasMoreRows()) {
			$ids[] = $results->field(0);
			$results->advanceRow();
		}
		
		// now let's dump it all to the DB
		$query =& new InsertQuery;
		
		$query->setTable("dataset_tag");
		$query->setColumns(array("dataset_tag_id","fk_dataset","dataset_tag_date"));
		
		$sharedManager =& Services::getService("Shared");
		$newID =& $sharedManager->createId();
		$query->addRowOfValues(array(
				$newID->getIdString(),
				$dataSetID,
				$dbHandler->toDBDate($date,$this->_dbID)));
		
		$query2 =& new InsertQuery;
		$query2->setTable("dataset_tag_map");
		$query2->setColumns(array("fk_dataset_tag","fk_datasetfield"));
		
		foreach ($ids as $id) {
			$query2->addRowOfValues(array($newID->getIdString(),$id));
		}
		
		$result =& $dbHandler->query($query, $this->_dbID);
		$result2 =& $dbHandler->query($query2, $this->_dbID);
		
		if (!$result || !$result2) throwError ( new UnknownDBError("DataSetTagManager"));
		
		// we're done.
		return $newID->getIdString();
	}

	/**
	 * Removes from the Database all tags associated with $dataSet.
	 * @param ref object A DataSet object.
	 * @return void
	 */
	function pruneTags(&$dataSet) {
		$theID = $dataSet->getID();
		if (!$theID) return;
		
		$dbHandler =& Services::getService("DBHandler");
		// first get a list of tags for this dataset
		$query =& new SelectQuery;
		$query->addTable("dataset_tag");
		$query->addColumn("dataset_tag_id");
		$query->setWhere("fk_dataset=$theID");
		
		$res =& $dbHandler->query($query, $this->_dbID);
		
		$ids = array();
		while ($res->hasMoreRows()) {
			$ids[] = "fk_dataset_tag=".$res->field(0);
			$res->advanceRow();
		}
		
		if (!count($ids)) return;
		
		$query =& new DeleteQuery;
		$query->setTable("dataset_tag");
		$query->setWhere("fk_dataset=$theID");
		
		$dbHandler->query($query, $this->_dbID);
		
		$query =& new DeleteQuery;
		$query->setTable("dataset_tag_map");
		$query->setWhere(implode(" OR ",$ids));
		
		$dbHandler->query($query, $this->_dbID);
	}
	
	/**
	 * Removes specific tag from the database.
	 * @param ref object $tag A {@link DataSetTag} object.
	 * @return void
	 */
	function pruneTag(&$tag) {
		$id = $tag->getID();
		
		$dbHandler=& Services::getService("DBHandler");
		
		// first get rid of all our mappings
		$query =& new DeleteQuery;
		$query->setTable("dataset_tag_map");
		$query->setWhere("fk_dataset_tag=$id");
		
		$dbHandler->query($query, $this->_dbID);
		
		// now get rid of the tag
		unset($query);
		$query =& new DeleteQuery;
		$query->setTable("dataset_tag");
		$query->setWhere("dataset_tag_id=$id");
		
		$dbHandler->query($query, $this->_dbID);
	}
	
	/**
	 * Checks to see if any of our Tags are empty, and if so, deletes them.
	 * @param ref object $dataSet The {@link FullDataSet} to check.
	 * @return void
	 */
	function checkForEmptyTags(&$dataSet) {
		// to do this, we are going to fetch the tag descriptors (from the "dataset_tag" table)
		// and then fetch the full tags (which inner joins onto the "dataset_tag_map" table),
		// find out if there are any descriptors not represented in full tags, and delete those.
		
		$tagDescriptors =& $this->fetchTagDescriptors($dataSet->getID());
		$fullTags =& $this->fetchTags($dataSet->getID());
		
		if (count($tagDescriptors) == count($fullTags)) return;
		
		$pruneIDs = array();
		foreach (array_keys($tagDescriptors) as $tagID) {
			if (!isset($fullTags[$tagID])) $pruneIDs[] = "dataset_tag_id=".$tagID;
		}
		
		if (count($pruneIDs)) {
			$query =& new DeleteQuery;
			$query->setTable("dataset_tag");
			$query->setWhere(implode(" OR ",$pruneIDs));
			
			$dbHandler =& Services::getService("DBHandler");
			$dbHandler->query($query, $this->_dbID);
		}
	}
	
	/**
	 * Returns an array of {@link DataSetTag}s without having loaded all of the mapping data. Useful for
	 * just checking what tags are available and what dates they were created on.
	 * @param int $id The ID of the DataSet to look for.
	 * @return ref array
	 * @access public
	 */
	function &fetchTagDescriptors( $id) {
		$query =& new SelectQuery;
		
		$query->addTable("dataset_tag");
		$query->addColumn("dataset_tag_id");
		$query->addColumn("dataset_tag_date");
//		$query->addColumn("fk_dataset");
		
		$query->setWhere("dataset_tag.fk_dataset=$id");
		
		$dbHandler =& Services::getService("DBHandler");
		
		$result =& $dbHandler->query($query,$this->_dbID);
		
		if (!$result) throwError( new UnknownDBError("DataSetTagManager"));
		
		$tags = array();
		while ($result->hasMoreRows()) {
			$a = $result->getCurrentRow();
			$result->advanceRow();
			
			$newTag =& new DataSetTag($a["dataset_tag_id"], $id, 
					$dbHandler->fromDBDate($a["dataset_tag_date"], $this->_dbID));
			
			$tags[$a["dataset_tag_id"]] =& $newTag;
		}
		
		return $tags;
	}
	
	/**
	 * Fetches all of the {@link DataSetTag}s available for DataSet ID $id with all mapping data loaded.
	 * @param int $id The DataSet ID.
	 * @return ref array
	 * @access public
	 */
	function &fetchTags($id) {
		$query =& new SelectQuery;
		
		$query->addTable("dataset_tag_map");
		$query->addTable("dataset_tag",INNER_JOIN,"fk_dataset_tag=dataset_tag_id");
		$query->addTable("datasetfield",INNER_JOIN,"fk_datasetfield=datasetfield_id");
		$query->addTable("datasettypedef",INNER_JOIN,"fk_datasettypedef=datasettypedef_id");
		
		$query->addColumn("dataset_tag_id");
		$query->addColumn("dataset_tag_date");
		
		$query->addColumn("datasetfield_index");
		$query->addColumn("datasetfield_id");
		
		$query->addColumn("datasettypedef_label");
		
		$query->setWhere("dataset_tag.fk_dataset=$id");
		
		$dbHandler =& Services::getService("DBHandler");
		$result =& $dbHandler->query($query, $this->_dbID);
		
		if (!$result) throwError( new UnknownDBError("DataSetTagManager"));
		
		$tagRows = array();
		$dates = array();
		
		while ($result->hasMoreRows()) {
			$a = $result->getCurrentRow();
			$result->advanceRow();
			$tagID = $a["dataset_tag_id"];
			
			if (!isset($tagRows[$tagID])) {
				$tagRows[$tagID] = array();
			}
			
			$tagRows[$tagID][] = $a;
			if (!isset($dates[$tagID])) $dates[$tagID] =& $dbHandler->fromDBDate($a["dataset_tag_date"], $this->_dbID);
		}
		
		$tags = array();
		foreach (array_keys($tagRows) as $tagID) {
			$newTag =& new DataSetTag($tagID, $id, $dates[$tagID]);
			$newTag->populate($tagRows[$tagID]);
			
			$tags[$tagID] =& $newTag;
		}
		
		return $tags;
	}
	
	/**
	 * Deletes all tags stored in the database for DataSet id $id.
	 * @access public
	 * @param int $id
	 * @return void
	 */
	function deleteDataSetTags($id) {
		// first get a list of DataSetTag IDs for this dataset.
		$query =& new SelectQuery;
		$query->addTable("dataset_tag");
		$query->addColumn("dataset_tag_id");
		$query->setWhere("fk_dataset=$id");

		$dbHandler =& Services::getService("DBHandler");
		$res =& $dbHandler->query($query, $this->_dbID);
		
		$ids = array();
		while ($res->hasMoreRows()) {
			$ids[] = $res->field(0);
			$res->advanceRow();
		}
		
		// now delete the datasets
		$query =& new DeleteQuery;
		
		$query->setTable("dataset_tag");
		$query->setWhere("fk_dataset=$id");
		
		$dbHandler->query($query, $this->_dbID);
		
		// and delete the mappings
		$wheres = array();
		foreach ($ids as $tagID) {
			$wheres[] = "fk_dataset_tag=$tagID";
		}
		
		$query->reset();
		$query->setTable("dataset_tag_map");
		$query->setWhere(implode(" OR ", $wheres));
		
		$dbHandler->query($query,$this->_dbID);
	}
	
	function start() {}
	function stop() {}
	
}