<?

require_once HARMONI."dataManager/search/SearchCriteria.interface.php";

/**
 * Searches for only {@link Record}s that contain a certain field=value pair.
 * @package harmoni.datamanager.search
 * @version $Id: FieldValueSearch.class.php,v 1.4 2005/01/08 22:17:05 gabeschine Exp $
 * @copyright 2004, Middlebury College
 */
class FieldValueSearch extends SearchCriteria {
	
	var $_schemaType;
	var $_label;
	var $_value;
	var $_comparison;
	
	/**
	 * The constructor.
	 * @param ref object $schemaType The {@link HarmoniType} that references the {@link Schema} to apply this search to.
	 * @param string $label The specific field within that {@link Schema} to check.
	 * @param ref object $value A {@link Primitive} object which holds the value to search for.
	 * @param optional int $comparisonType The comparison type to use (equals, contains, less than, etc.) See the SEARCH_TYPE_* constants. Defaults to SEARCH_TYPE_EQUALS
	 * @return void
	 */
	function FieldValueSearch( &$schemaType, $label, &$value, $comparisonType=SEARCH_TYPE_EQUALS) {
		$this->_schemaType =& $schemaType;
		$this->_label = $label;
		$this->_value =& $value;
		$this->_comparison = $comparisonType;
	}
	
	function returnSearchString() {
		$mgr =& Services::getService("SchemaManager");
		$typeMgr =& Services::getService("DataTypeManager");
		
		$def =& $mgr->getSchemaByType($this->_schemaType);
		$def->load();
		
		$field =& $def->getField($this->_label);
		
		// first check if the $value we have is of the correct data type
		if (!$typeMgr->isObjectOfDataType($this->_value, $field->getType())) {
			throwError( new Error("Cannot take a '".get_class($this->_value)."' object as search criteria
			for field '$this->_label'; a '".$field->getType()."' is required.","FieldValueSearch",true));
		}
		
		// ok, looks good.
		$tmpObj =& $typeMgr->newStorablePrimitive($field->getType());
		
		$string = $tmpObj->makeSearchString($this->_value, $this->_comparison);
		
		return "(dm_record_field.fk_schema_field=".$def->getFieldID($this->_label)." AND ".$string." AND dm_record_field.active=1)";
	}

	function postProcess($ids) { return $ids; }
	
}

?>
