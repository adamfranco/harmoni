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
	
	function CompactDataSet(&$idManager, $dbID, &$dataSetTypeDef, $verControl=false ) {
		ArgumentValidator::validate($verControl, new BooleanValidatorRule());
		$this->_idManager = $idManager;
		$this->_dbID = $dbID;
		$this->_dataSetTypeDef = $dataSetTypeDef;
		$this->_fields = array();
		$this->_versionControlled = $verControl;
		
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
		
	}
	
	function clone() {
		
	}
	
	function deleteAllValues($label) {
		
	}
	
	function deleteValue($label, $index=0) {
		
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