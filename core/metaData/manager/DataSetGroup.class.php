<?

/**
 * The DataSetGroup class holds a list of IDs and their DataSets in a specific dataset group.
 * @package harmoni.datamanager
 * @version $Id
 * @copyright 2004, Middlebury College
 */
class DataSetGroup {
	
	var $_dataSetIDs;
	var $_dataSets;
	var $_newDataSets;
	var $_deletedDataSetIDs;
	var $_fetchedFull;
	var $_mgr;
	var $_myID;
	
	var $_dirty;
	
	function DataSetGroup(&$dataSetMgr, $id) {
		$this->_dataSetIDs = array();
		$this->_dataSets = array();
		$this->_newDataSets = array();
		$this->_deletedDataSets = array();
		$this->_mgr =& $dataSetMgr;
		
		$this->_myID = $id;
		
		$this->_dirty = false;
		$this->_fetchedFull = false;
	}
	
	function takeRow(&$row) {
		// If the asset is valid and active:
		if ($row["dataset_active"] == "1") {
			// This has to be in here, otherwise we don't get a reference to the dataSet
			// and when we try to do things to all of our dataSets, we have problems.
			// This problem comes up when commit is called as it only looks at 
			// _dataSets, not DataSetIds.
			$this->_dataSets[] =& $this->_mgr->fetchDataSet( $row["fk_dataset"] );
			
			$this->_dataSetIDs[] = $row["fk_dataset"];
			
		// If the dataset exists, but is inactive:
		} else if ($row["dataset_active"] == "0"){
			$this->_deletedDataSetIDs[] = $row["fk_dataset"];
		}
		
		// if we get NULL for the dataset_active field, then the dataSet has been pruned.
		// We'll just let it be deleted when we update.
	}
	
	function &fetchDataSets($editable = false, $limitResults = null) {
		// We need to fetch the dataSets if:
		// 	We dont' have any 
		// 		OR
		// 	Our counts don't match
		// 		OR
		// 	We're not fetched full and we are supposed to be editable.
		if (!count($this->_dataSets) || (count($this->_dataSets) != count($this->_dataSetIDs)) || (!$this->_fetchedFull && $editable) || (!$this->_fetchedFull && $editable)) {
			$sets =& $this->_mgr->fetchArrayOfIDs($this->_dataSetIDs, $editable, $limitResults);
			// Cycle through the resulting sets to put them in an indexed array
			$this->_dataSets = array();
			foreach ($sets as $key => $set) {
				$this->_dataSets[] =& $sets[$key];
			}
			
			$this->_fetchedFull = $editable;
		}
		
		if (count($this->_newDataSets)) {
			$sets = array();
			for($i=0; $i<count($this->_dataSets); $i++) {
				$sets[] =& $this->_dataSets[$i];
			}
			for($i=0; $i<count($this->_newDataSets); $i++) {
				$sets[] =& $this->_newDataSets[$i];
			}
			return $sets;
		}
				
		return $this->_dataSets;
	}
	
	function getDataSetIDs() {
		return $this->_dataSetIDs;
	}
	
	function commit() {
		$ids =	array();
		
		if (count($this->_newDataSets)) {
			for($i=0; $i<count($this->_newDataSets); $i++) {
				$this->_newDataSets[$i]->commit();
				$ids[] = $this->_newDataSets[$i]->getID();
			}
			$this->_newDataSets = array();
		}
		
		if (count($this->_dataSets)) {
			for($i=0; $i<count($this->_dataSets); $i++) {
				// only save if they were fetched not read only.
				if (!$this->_dataSets[$i]->readOnly()) 
					$this->_dataSets[$i]->commit();
				$ids[] = $this->_dataSets[$i]->getID();
			}
			$this->_dataSets = array();
			$this->_fetchedFull = false;
		}
		
		if ($this->_dirty) {
			// syncrhonize the database
			if (!count($ids)) {
				$ids = array_unique($this->_dataSetIDs);
			}
			
			// Make sure that we only have one ID for each set.
			$ids = array_unique($ids);

			$dbHandler =& Services::getService("DBHandler");
			// first delete all the old mappings
			$query =& new DeleteQuery;
			$query->setTable("dataset_group");
			$query->setWhere("dataset_group.id=".$this->_myID);
//			printpre(MySQL_SQLGenerator::generateSQLQuery($query));
			$dbHandler->query($query, $this->_mgr->_dbID);
			
			if (count($ids)) {
				// next insert all our mappings back in.
				$query =& new InsertQuery;
				$query->setTable("dataset_group");
				$query->setColumns(array("id","fk_dataset"));
				foreach ($ids as $id) {
					$query->addRowOfValues(array($this->_myID, $id));
				}
				
				// Add back in the deleted DataSetIds so that we dont' loose
				// our reference to them.
				foreach ($this->_deletedDataSetIds as $id) {
					$query->addRowOfValues(array($this->_myID, $id));
				}
				
//				printpre(MySQL_SQLGenerator::generateSQLQuery($query));
				$dbHandler->query($query,$this->_mgr->_dbID);
				// done!
			}
			
			$this->_dataSetIDs = $ids;
		}
	}
	
	function addID( $dataSetID ) {
		ArgumentValidator::validate($dataSetID, new IntegerValidatorRule);
		$this->_dirty = true;
		
		$this->_dataSetIDs[] = $dataSetID;
		$this->_dataSets[] =& $this->_mgr->fetchDataSet( $dataSetID );
	}
	
	function addDataSet(&$dataSet) {
		$this->_dirty = true;
		
		$this->_newDataSets[] =& $dataSet;
	}
	
}

?>