<?php

require_once HARMONI."dataManager/search/SearchCriteria.interface.php";

/**
 * Searches for only {@link Record}s that contain a certain field=value pair.
 *
 * @package harmoni.datamanager.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: FieldValueSearch.class.php,v 1.12 2007/04/12 15:37:25 adamfranco Exp $
 */
class FieldValueSearch extends SearchCriteria {
	
	var $_schemaID;
	var $_label;
	var $_value;
	var $_comparison;
	
	/**
	 * The constructor.
	 * @param string $schemaID The ID that references the {@link Schema} to apply this search to.
	 * @param string $label The specific field within that {@link Schema} to check.
	 * @param ref object $value An {@link SObject} object which holds the value to search for.
	 * @param optional int $comparisonType The comparison type to use (equals, contains, less than, etc.) See the SEARCH_TYPE_* constants. Defaults to SEARCH_TYPE_EQUALS
	 * @return void
	 */
	function FieldValueSearch( $schemaID, $label, &$value, $comparisonType=SEARCH_TYPE_EQUALS) {
		$this->_schemaID =& $schemaID;
		$this->_label = $label;
		$this->_value =& $value;
		$this->_comparison = $comparisonType;
	}
	
	function returnSearchString() {
		$mgr =& Services::getService("SchemaManager");
		$typeMgr =& Services::getService("DataTypeManager");
		
		$def =& $mgr->getSchemaByID($this->_schemaID);
		$def->load();
		
		$fieldID = $def->getFieldIDFromLabel($this->_label);
		
		$field =& $def->getField($fieldID);
		
		
		// first check if the $value we have is of the correct data type
		$extendsRule =& ExtendsValidatorRule::getRule("HarmoniIterator");
		if (!$typeMgr->isObjectOfDataType($this->_value, $field->getType()) 
			&& !$extendsRule->check($this->_value)) 
		{
			throwError( new Error("Cannot take a '".get_class($this->_value)."' object as search criteria
			for field '$this->_label'; a '".$field->getType()."' is required.","FieldValueSearch",true));
		}
		
		$class = $typeMgr->storablePrimitiveClassForType($field->getType());
		eval('$string = '.$class.'::makeSearchString($this->_value, $this->_comparison);');
		
		return "(dm_record_field.fk_schema_field='".addslashes($fieldID)."' AND ".$string." AND dm_record_field.active=1)";
	}

	function postProcess($ids) { return $ids; }
	
}

?>
