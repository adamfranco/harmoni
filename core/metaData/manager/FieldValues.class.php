<?

require_once HARMONI."metaData/manager/ValueVersions.classes.php";

class FieldValues {
	
	var $_numValues;
	var $_values;
	
	var $_parent;
	var $_fieldDefinition;
	var $_myLabel;
	
	function FieldValues( &$fieldDefinition, &$parent, $label ) {
//		ArgumentValidator::validate($values, new ArrayValidatorRule());
		$this->_numValues = 0;
		
		$this->_myLabel = $label;
		
		$this->_parent =& $parent;
		$this->_fieldDefinition =& $fieldDefinition;
	}
	
	function populate( $arrayOfRows ) {
		
	}
	
	function &getValue($index) {
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		return $this->_values[$index];
	}
	
	function &getAllValues() {
		$values = array();
		for ($i=0; $i< $this->_numValues; $i++) {
			$values[] =& $this->_values[$i]->getValue();
		}
		return $values;
	}
	
	function _checkObjectType(&$object) {
		$dataTypeManager =& Services::requireService("DataTypeManager");
		$type = $this->_fieldDefinition->getType();
		
		if ($dataTypeManager->isObjectOfDataType($object,$type)) return true;
		
		// otherwise... throw an error.
		throwError( new Error(
		"While trying to add/set a value in DataSet ID ".$this->_parent->getID().", we recieved an unexpected
		data type. Expecting: $type, but got an object of class ".get_class($object).".", "FieldValues",true));
		return false;
	}
	
	function addValue(&$value) {
		if ($this->_parent->readOnly()) {
			throwError( new Error("Can not add value to DataSet because it was fetched
			from the database readonly. You must re-fetch it fully to make changes.","FieldValues",true));
		}
		
		if (!$this->_fieldDefinition->getMultFlag()) {
			$label = $this->_myLabel;
			throwError ( new Error(
			"Field label '$label' can not add a new value because it does not allow multiple
				values. In DataSetType ".OKITypeToString($this->_parent->_dataSetTypeDef->getType()).".",
			"DataSet",true));
			return false;
		}
		$this->_checkObjectType($value);
		
		$this->_values[$this->_numValues] =& new ValueVersions($this);
		$this->_values[$this->_numValues]->setValue($value);
		$this->_numValues++;
		return true;
	}
	
	function setValue($index, &$value) {
		if ($this->_parent->readOnly()) {
			throwError( new Error("Can not set value in DataSet because it was fetched
			from the database readonly. You must re-fetch it fully to make changes.","FieldValues",true));
		}
		
		// any field can have at least one value.. if index 0 is not yet set up, set it up
		if ($index == 0 && !isset($this->_values[0])) {
			$this->_values[0] =& new ValueVersions($this);
			$this->_numValues++;
		}
		
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		
		$this->_values[$index]->setValue($value);
	}
	
	function numValues() { return $this->_numValues; }
	
	function numVersions( $index=0 ) {
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		return $this->_values[$index]->numVersions();
	}
	
	function getVersionList( $index=0 ) {
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		return $this->_values[$index]->getVersionList();
	}
	
	function &getVersion( $verID, $index=0 ) {
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		
		return $this->_values[$index]->getVersion($verID);
	}
	
}

?>