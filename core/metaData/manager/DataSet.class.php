<?php

require_once HARMONI."metaData/manager/FieldValues.class.php";

define("NEW_VALUE",-1);

class CompactDataSet {
	
	var $_idManager;
	var $_dbID;
	var $_dataSetTypeDef;
	var $_versionControlled;
	var $_fields;
	var $_full;
	
	var $_myID;
	var $_active;
	
	function CompactDataSet(&$idManager, $dbID, &$dataSetTypeDef, $verControl=false ) {
		ArgumentValidator::validate($verControl, new BooleanValidatorRule());
		$this->_idManager = $idManager;
		$this->_dbID = $dbID;
		$this->_dataSetTypeDef = $dataSetTypeDef;
		$this->_fields = array();
		$this->_versionControlled = $verControl;
		$this->_active = true;
		
		$this->_myID = null;
		
		// set up the individual fields
		foreach ($dataSetTypeDef->getAllLabels() as $label) {
			$def =& $dataSetTypeDef->getFieldDefinition($label);
			$this->_fields[$label] =& new FieldValues($def, $this, $label );
			unset($def);
		}
	}
	
	function getID() { return $this->_myID; }
	
	function readOnly() {
		return true;
	}
	
	function isCompact() {
		return true;
	}
	
	function _checkLabel($label, $function) {
		if (!$this->_dataSetTypeDef->fieldExists($label)) {
			throwError(new FieldNotFoundError($label,OKITypeToString($this->_dataSetTypeDef->getType())));
			return false;
		}
		return true;
	}
	
	function &getValueVersionsObject($label, $index=0) {
		$this->_checkLabel($label, __FUNCTION__);
		
		return $this->_fields[$label]->getValue($index);
	}
	
	function &getAllValueVersionsObjects($label) {
		$this->_checkLabel($label, __FUNCTION__);
		
		return $this->_fields[$label]->getAllValues();
	}
	
	function populate( $arrayOfRows = null ) {
		
	}
	
	function numValues($label) {
		$this->_checkLabel($label, __FUNCTION__);
		
		return $this->_fields[$label]->numValues();
	}
	
	function isVersionControlled() {
		return $this->_versionControlled;
	}
}

class FullDataSet extends CompactDataSet {
	
	function FullDataSet(&$idManager, $dbID, &$dataSetTypeDef, $verControl=false ) {
		parent::CompactDataSet($idManager, $dbID, $dataSetTypeDef, $verControl);
/*		ArgumentValidator::validate($verControl, new BooleanValidatorRule());
		$this->_idManager = $idManager;
		$this->_dbID = $dbID;
		$this->_dataSetTypeDef = $dataSetTypeDef;
		$this->_fields = array();
		
		// set up the individual fields
		foreach ($dataSetTypeDef->getAllLabels() as $label) {
			$def =& $dataSetTypeDef->getFieldDefinition($label);
			$this->_fields[$label] =& new FieldValues($def, $this, $label );
			unset($def);
		}
*/	}
	
	function readOnly() {
		return false;
	}

	function isCompact() {
		return false;
	}

	function setValue($label, &$obj, $index=0) {
		$this->_checkLabel($label, __FUNCTION__);
		
		if ($index == NEW_VALUE) {
			return $this->_fields[$label]->addValue($obj);
		}
		return $this->_fields[$label]->setValue($index, $obj);
	}
		
	function commit() {
		if ($this->_myID) {
			// we're already in the database
			$query =& new UpdateQuery();
			
			$query->setTable("dataset");
			$query->setColumns(array("dataset_active","dataset_ver_control"));
			$query->setValues(array(
				($this->_active)?1:0,
				($this->_versionControlled)?1:0
				));
			$query->setWhere("dataset_id=".$this->_myID);
		} else {
			// we'll have to make a new entry
			$dataSetTypeManager =& Services::getService("DataSetTypeManager");
			
			$this->_myID = $this->_idManager->newID(new HarmoniDataType("Harmoni","HarmoniDataManager","DataSet"));
			
			$query =& new InsertQuery();
			$query->setTable("dataset");
			$query->setColumns(array("dataset_id","fk_datasettype","dataset_created","dataset_active","dataset_ver_control"));
			$query->addRowOfValues(array(
				$this->_myID,
				$dataSetTypeManager->getIDForType($this->_dataSetTypeDef->getType()),
				"NOW()",
				($this->_active)?1:0,
				($this->_versionControlled)?1:0
				));
		}
		
		// execute the query;
		$dbHandler =& Services::getService("DBHandler");
		
		$result =& $dbHandler->query($query,$this->_dbID);
		
		if (!$result) {
			throwError( new UnknownDBError() );
			return false;
		}
		
		// now let's cycle through our FieldValues and commit them
		foreach ($this->_dataSetTypeDef->getAllLabels() as $label) {
			$this->_fields[$label]->commit();
		}
		
		return true;
	}
	
	function clone() {
		
	}
	
	function deleteAllValues($label) {
		$this->_checkLabel($label, __FUNCTION__);
		
		$num = $this->_fields[$label]->numValues();
		$good = true;
		for($i=0; $i<$num; $i++) {
			if (!$this->_fields[$label]->deleteValue($i)) $good=false;
		}
		
		return $good;
	}
	
	function deleteValue($label, $index=0) {
		$this->_checkLabel($label, __FUNCTION__);
		
		return $this->_fields[$label]->deleteValue($index);
	}
	
	function delete() {
		$this->_active = false;
	}
	
}

class FieldNotFoundError extends Error {
	function FieldNotFoundError($label,$type) {
		parent::Error("The field labeled '$label' was not found in DataSetType '$type'.","DataSet",true);
	}
}

class ValueIndexNotFoundError extends Error {
	function ValueIndexNotFoundError($label,$id,$index) {
		parent::Error("The value index $index was not found for field '$label' in DataSet ID $id.","DataSet",true);
	}
}

function renderDataSet(&$dataSet) {
	$fields = $dataSet->_dataSetTypeDef->getAllLabels();
	
	print "<PRE>";
	foreach ($fields as $label) {
		$numValues = $dataSet->numValues($label);
		
		print "$label: $numValues values\n";
		
		for ($i=0; $i<$numValues; $i++) {
			$vers =& $dataSet->getValueVersionsObject($label,$i);
			print "\t$i: ".$vers->numVersions()." versions\n";
			
			$verList = $vers->getVersionList();
			foreach ($verList as $verID) {
				$ver =& $vers->getVersion($verID);
				print "\t\t$verID, active=".(($ver->isActive())?"yes":"no").": ";
				$val =& $ver->getValue();
				print $val->toString()."\n";
			}
		}
		
	}
	print "</PRE>";
}

?>