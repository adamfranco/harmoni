<?

require_once HARMONI."metaData/manager/search/SearchCriteria.interface.php";

class FieldValueSearch extends SearchCriteria {
	
	var $_dataSetType;
	var $_label;
	var $_value;
	
	function FieldValueSearch( &$dataSetType, $label, &$value) {
		$this->_dataSetType =& $dataSetType;
		$this->_label = $label;
		$this->_value =& $value;
	}
	
	function returnSearchString() {
		$mgr =& Services::getService("DataSetTypeManager");
		$typeMgr =& Services::getService("DataTypeManager");
		
		$def =& $mgr->getDataSetTypeDefinition($this->_dataSetType);
		$def->load();
		
		$fieldDef =& $def->getFieldDefinition($this->_label);
		
		// first check if the $value we have is of the correct data type
		if (!$typeMgr->isObjectOfDataType($this->_value, $fieldDef->getType())) {
			throwError( new Error("Cannot take ".get_class($this->_value)." object as search criteria
			for field $this->_label!","FieldValueSearch",true));
		}
		
		// ok, looks good.
		$tmpObj =& $typeMgr->newDataObject($fieldDef->getType());
		
		$string = $tmpObj->makeSearchString($this->_value);
		
		return "(datasetfield.fk_datasettypedef=".$fieldDef->getID()." AND ".$string.")";
	}
	
	function getTypeList() {
		$mgr =& Services::getService("DataSetTypeManager");
		return array($mgr->getIDForType($this->_dataSetType));
	}
	
}

?>