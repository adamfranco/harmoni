<?php

class DataSetManager {
	
	var $_idManager;
	var $_dbID;
	var $_typeManager;
	
	function DataSetManager( &$idManager, $dbID, &$dataSetTypeManager) {
		$this->_idManager =& $idManager;
		$this->_dbID = $dbID;
		$this->_typeManager = $dataSetTypeManager;
	}
	
	function &fetchArrayOfIDs( $dataSetIDs, $allVersions=false ) {
		
	}
	
	function &fetchDataSet( $dataSetID, $allVersions=false ) {
		
	}
	
	function &fetchDataSetTag( $tagID ) {
		
	}
	
	function &newDataSet( &$type ) {
		
	}
	
	function getDataSetIDsOfType(&$type) {
		
	}
	
	function getTags( $dataSetID ) {
		
	}
	
	
	
}

?>