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
		
		// ok, we're going to passed an array of rows that corresonds to
		// our label[index] = valueVersion[n] setup.
		// that means we have to separate out the rows that have to do with each
		// label, and hand each package to a FieldValues object.
		
		$myID = null;
		
		$packages = array();
		
		foreach ($arrayOfRows as $line) {
			$label = $line['datasettypedef_label'];
			if (!is_array($packages[$label])) $packages[$label] = array();
			
			$packages[$label][] = $line;
			
			if (!$myID && $line['dataset_id']) $myID = $line['dataset_id'];
		}
		
		if (!$myID) {
			throwError ( new Error(
				"Serious error fetching DataSet: no ID was stored in the database!","DataSet",true));
			return false;
		}
		
		$this->_myID = $myID;

		// now go through each label we've found and populate the FieldValues object
		foreach (array_keys($packages) as $label) {
/*			if (!($fieldDefinition =& $this->_dataSetTypeDef->fieldExists($label))) {
				throwError( new Error(
					"Serious error with DataSetTypeDefinition mappings. DataSet contains field with label '$label'
					but no corresponding FieldDefinition was found within the DataSetTypeDefinition.",
					"FullDataSet",true));
				return false;
			}
			
			$newFV =& new FieldValues($fieldDefinition, $this, $label);
			$newFV->populate($package[$label]);*/
			// above = dumb. _fields array should have been setup by the constructor.
			
			$this->_fields[$label]->populate($packages[$label]);
		}
		
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
			
			$this->_myID = $this->_idManager->newID(new HarmoniType("Harmoni","HarmoniDataManager","DataSet"));
			
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
			throwError( new UnknownDBError("FullDataSet") );
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
	print "dataSet of type '".OKITypeToString($dataSet->_dataSetTypeDef->getType())."', ";
	print "version controlled = ".($dataSet->isVersionControlled()?"yes":"no")."\n\n";
	foreach ($fields as $label) {
		$numValues = $dataSet->numValues($label);
		
		print "$label: $numValues values\n";
		
		for ($i=0; $i<$numValues; $i++) {
			$vers =& $dataSet->getValueVersionsObject($label,$i);
			print "\t$i: ".$vers->numVersions()." versions\n";
			
			$verList = $vers->getVersionList();
			foreach ($verList as $verID) {
				$ver =& $vers->getVersion($verID);
				print "\t\t$verID, active=".(($ver->isActive())?"yes":"no").", ";
				$date =& $ver->getDate();
				print $date->toString().": ";
				$val =& $ver->getValue();
				if ($ver->_update) print "(flagged for update) ";
				print $val->toString()."\n";
			}
		}
		
	}
	print "</PRE>";
}

?>