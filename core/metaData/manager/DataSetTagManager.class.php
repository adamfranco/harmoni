<?

require_once HARMONI."metaData/manager/DataSetTag.class.php";

/**
* Handles the creation and retrieval of {@link DataSetTag}s to/from the database. See {@link DataSetTag} for a 
* more detailed explanation of the role of tags.
* @access public
* @package harmoni.datamanager
* @version $Id: DataSetTagManager.class.php,v 1.6 2004/01/07 21:20:19 gabeschine Exp $
* @copyright 2004, Middlebury College
*/
class DataSetTagManager extends ServiceInterface {
	
	var $_idManager;
	var $_dbID;
	
	function DataSetTagManager( &$idManager, $dbID) {
		$this->_idManager =& $idManager;
		$this->_dbID = $dbID;
	}
	
	/**
	 * Takes a DataSet and an optional date and creates a DataSetTag in the database based
	 * on the current active versions of values within the DataSet.
	 * @param ref object $dataSet Either a {@link CompactDataSet} or a {@link FullDataSet} to be tagged.
	 * @param opt object $date An optional {@link DateTime} object to attach to the tag instead of the current date/time.
	 * @return int The new tag's ID in the database.
	 * @access public
	 */
	function tagToDB( &$dataSet, $date=null ) {
//		if (!$dataSetID) return null;
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
		
		$idType =& new HarmoniType(
				"Harmoni",
				"HarmoniDataManager",
				"DataSetTag",
				"DataSetTags save a snapshot of a version-controlled dataset for future rollback.");
		$newID = $this->_idManager->newID($idType);
		$query->addRowOfValues(array(
				$newID,
				$dataSetID,
				$dbHandler->toDBDate($date,$this->_dbID)));
		
		$query2 =& new InsertQuery;
		$query2->setTable("dataset_tag_map");
		$query2->setColumns(array("fk_dataset_tag","fk_datasetfield"));
		
		foreach ($ids as $id) {
			$query2->addRowOfValues(array($newID,$id));
		}
		
		$result =& $dbHandler->query($query, $this->_dbID);
		$result2 =& $dbHandler->query($query2, $this->_dbID);
		
		if (!$result || !$result2) throwError ( new UnknownDBError("DataSetTagManager"));
		
		// we're done.
		return $newID;
	}
	
//	function _fetchTags( $id, $full=false) {
//		$query =& new SelectQuery;
//		
//		$query->addTable("dataset_tag_map");
//		$query->addTable
//	}
	
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
		
		$query->setWhere("fk_dataset=$id");
		
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
		
		$query->setWhere("fk_dataset=$id");
		
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
	
	function start() {}
	function stop() {}
	
}