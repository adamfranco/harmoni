<?php


/**
 * Function is composed of Id, a displayName, a description, a category, and a QualifierType.  Ids in Authorization are externally defined and their uniqueness is enforced by the implementation. <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
 * 
 * @package osid.authorization
 */
class HarmoniFunction /* :: API interface */
{

	/**
	 * The Unique ID of this function.
	 * @attribute private object _id
	 */
	var $_id;

	
	/**
	 * The display name of this function.
	 * @attribute private string _displayName
	 */
	var $_displayName;

	
	/**
	 * The description of this function.
	 * @attribute private string _description
	 */
	var $_description;

	
	/**
	 * The type of this function.
	 * @attribute private object _functionType
	 */
	var $_functionType;
	
	
	/**
	 * The ID of the qualifier hierarchy that is associated with this function.
	 * @attribute private object _qualifierHierarchyId
	 */
	var $_qualifierHierarchyId;	


	/**
	 * The index of the database connection as returned by the DBHandler.
	 * @attribute private integer _dbIndex
	 */
	var $_dbIndex;
	
	
	/**
	 * The name of the table that stores all authorizatoin Functions.
	 * @attribute private string _table
	 */
	var $_table;


	/**
	 * The constructor.
	 * @param object functionId - is externally defined functionId - is externally defined
	 * @param string displayName - is externally defined displayName - the name to display for this Function
	 * @param string  description - is externally defined description - the description of this Function
	 * @param object functionType - is externally defined functionType - the Type of this Function
	 * @param object qualifierHierarchyId - is externally defined qualifierHierarchyId - the Id of the Qualifier Hierarchy associated with this Function 	 
	 * @access public
	 */
	function HarmoniFunction($id, $displayName, $description, $functionType, 
							 $qualifierHierarchyId, $dbIndex, $table) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($displayName, $stringRule, true);
		ArgumentValidator::validate($description, $stringRule, true);
		ArgumentValidator::validate($table, $stringRule, true);
		$extendsRule =& new ExtendsRule("HarmoniId");
		ArgumentValidator::validate($id, $extendsRule, true);
		ArgumentValidator::validate($qualifierHierarchyId, $extendsRule, true);
		$extendsRule =& new ExtendsRule("HarmoniType");
		ArgumentValidator::validate($functionType, $extendsRule, true);
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($dbIndex, $integerRule, true);
		// ** end of parameter validation
		
		$this->_id = $id;
		$this->_displayName = $displayName;
		$this->_description = $description;
		$this->_functionType = $functionType;
		$this->_qualifierHierarchyId = $qualifierHierarchyId;
		$this->_dbIndex = $dbIndex;
		$this->_table = $table;
	}
		
	
	/**
	 * Get the Unique Id for this Function.
	 * @return object osid.shared.Id
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function & getId() {
		return $this->_id;
	}
	
	

	/* :: full java declaration :: osid.shared.Id getId()
	/**
	 * Get the name for this Function.
	 * @return String
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function getDisplayName() {
		return $this->_displayName;
	}



	/* :: full java declaration :: String getDisplayName()
	/**
	 * Get the description for this Function.
	 * @return String
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function getDescription() {
		return $this->_description;
	}



	/* :: full java declaration :: String getDescription()
	/**
	 * Get the FunctionType for this Function.
	 * @return object osid.shared.Type
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function & getFunctionType() {
		return $this->_functionType;
	}



	/* :: full java declaration :: osid.shared.Type getFunctionType()
	/**
	 * Get the QualifierHierarchyId for this Function.
	 * @return object osid.shared.Id
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function & getQualifierHierarchyId() {
		return $this->_qualifierHierarchyId;	
	}
	
	

	/* :: full java declaration :: osid.shared.Id getQualifierHierarchyId()
	/**
	 * Update the name for this Function.
	 * @param string displayName
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.authorization
	 */
	function updateDisplayName($displayName) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($displayName, $stringRule, true);
		// ** end of parameter validation
		
		$this->_displayName = $displayName;
		// now update the database
		
	}



	/* :: full java declaration :: void updateDisplayName(String displayName)
	/**
	 * Update the description for this Function.
	 * @param string description
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.authorization
	 */
	function updateDescription($description) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($description, $stringRule, true);
		// ** end of parameter validation
		
		$this->_description = $description;
	}
}


?>