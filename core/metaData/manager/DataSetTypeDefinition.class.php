<?php

class DataSetTypeDefinition {
	
	var $_manager;
	var $_idmanager;
	var $_db;
	var $_dbID;
	var $_type;
	var $_id;
	
	var $_fetchedFromDB;
	
	var $_fields;
	
	function DataSetTypeDefinition(&$manager, &$idmanager, $dbID, &$type, $id=null) {
		$this->_manager =& $manager;
		$this->_idmanager =& $idmanager;
		$this->_dbID = $dbID;
		$this->_type =& $type;
		$this->_db =& Services::requireService("DBHandler");
		
		$this->_fetchedFromDB = false;
		$this->_fields = array();
		
		// if all we're passed is a type, try to get the ID from the DataSetTypeManager
		if (!$id) {
			$id = $manager->getIDForType($type);
		}
		
		$this->_id = $id;
	}
	
}


?>