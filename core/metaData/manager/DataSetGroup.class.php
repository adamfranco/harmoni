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
	var $_fetchedFull;
	var $_mgr;
	var $_myID;
	
	var $_dirty;
	
	function DataSetGroup(&$dataSetMgr, $id) {
		$this->_dataSetIDs = array();
		$this->_dataSets = array();
		$this->_newDataSets = array();
		$this->_mgr =& $dataSetMgr;
		
		$this->_myID = $id;
		
		$this->_dirty = false;
		$this->_fetchedFull = false;
	}
	
	function takeRow(&$row) {
		$this->_dataSetIDs[] = $a["fk_dataset"];
	}
	
	function &fetchDataSets($editable = false, $limitResults = null) {
		if (!count($this->_dataSets) || (!$this->_fetchedFull && $editable)) {
			$this->_dataSets =& $this->_mgr->fetchArrayOfIDs($this->_dataSetIDs, $editable, $limitResults);
			
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
		$ids = array();
		
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
				if (!$this->_dataSets[$i]->readOnly) $this->_dataSets[$i]->commit();
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
			
			$dbHandler =& Services::getService("DBHandler");
			// first delete all the old mappings
			$query =& new DeleteQuery;
			$query->setTable("dataset_group");
			$query->setWhere("dataset_group.id=".$this->_myID);
			$dbHandler->query($query, $this->_mgr->_dbID);
			
			if (count($ids)) {
				// next insert all our mappings back in.
				$query =& new InsertQuery;
				$query->setTable("dataset_group");
				$query->setColumns(array("id","fk_dataset"));
				foreach ($ids as $id) {
					$query->addRowOfValues(array($this->_myID, $id));
				}
				
				$dbHandler->query($query,$this->_mgr->_dbID);
				// done!
			}
			
			$this->_dataSetIDs = $ids;
		}
	}
	
	function addID( $dataSetID ) {
		$this->_dirty = true;
		
		$this->_dataSetIDs[] = $dataSetID;
	}
	
	function addDataSet(&$dataSet) {
		$this->_dirty = true;
		
		$this->_newDataSets =& $dataSet;
	}
	
}

?>