<?php

require_once(OKI."/authorization.interface.php");

/**
 * Function is composed of Id, a referenceName, a description, a category, and a QualifierType.  Ids in Authorization are externally defined and their uniqueness is enforced by the implementation. <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
 * 
 * @package harmoni.osid.authorization
 */
class HarmoniFunction extends FunctionInterface {

	/**
	 * The Unique ID of this function.
	 * @attribute private object _id
	 */
	var $_id;

	
	/**
	 * The display name of this function.
	 * @attribute private string _referenceName
	 */
	var $_referenceName;

	
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
	 * The name of the Authorization database.
	 * @attribute private string _table
	 */
	var $_authzDB;


	/**
	 * The constructor.
	 * @param ref object id - is externally defined functionId - is externally defined
	 * @param string referenceName - is externally defined referenceName - the name to display for this Function
	 * @param string  description - is externally defined description - the description of this Function
	 * @param ref object functionType - is externally defined functionType - the Type of this Function
	 * @param ref object qualifierHierarchyId - is externally defined qualifierHierarchyId - the Id of the Qualifier Hierarchy associated with this Function 	 
	 * @param  dbIndex integer The index of the database connection as returned by the DBHandler.
	 * @param  authzDB string The name of the Authorization database.
	 * @access public
	 */
	function HarmoniFunction(& $id, $referenceName, $description, & $functionType, 
							 & $qualifierHierarchyId, $dbIndex, $authzDB) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($referenceName, $stringRule, true);
		ArgumentValidator::validate($description, $stringRule, true);
		$extendsRule =& new ExtendsValidatorRule("HarmoniId");
		ArgumentValidator::validate($id, $extendsRule, true);
		ArgumentValidator::validate($qualifierHierarchyId, $extendsRule, true);
		$extendsRule =& new ExtendsValidatorRule("HarmoniType");
		ArgumentValidator::validate($functionType, $extendsRule, true);
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($dbIndex, $integerRule, true);
		ArgumentValidator::validate($authzDB, $stringRule, true);
		// ** end of parameter validation
		
		$this->_id =& $id;
		$this->_referenceName = $referenceName;
		$this->_description = $description;
		$this->_functionType =& $functionType;
		$this->_qualifierHierarchyId =& $qualifierHierarchyId;
		$this->_dbIndex = $dbIndex;
		$this->_authzDB = $authzDB;
	}
		
	
	/**
	 * Get the Unique Id for this Function.
	 * @return object osid.shared.Id
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function & getId() {
		return $this->_id;
	}
	
	

	/* :: full java declaration :: osid.shared.Id getId()
	/**
	 * Get the name for this Function.
	 * @return String
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function getReferenceName() {
		return $this->_referenceName;
	}



	/* :: full java declaration :: String getReferenceName()
	/**
	 * Get the description for this Function.
	 * @return String
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function getDescription() {
		return $this->_description;
	}



	/* :: full java declaration :: String getDescription()
	/**
	 * Get the FunctionType for this Function.
	 * @return object osid.shared.Type
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function & getFunctionType() {
		return $this->_functionType;
	}



	/* :: full java declaration :: osid.shared.Type getFunctionType()
	/**
	 * Get the QualifierHierarchyId for this Function.
	 * @return object osid.shared.Id
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function & getQualifierHierarchyId() {
		return $this->_qualifierHierarchyId;	
	}
	
	

	/* :: full java declaration :: osid.shared.Id getQualifierHierarchyId()
	/**
	 * Update the name for this Function.
	 * @param string referenceName
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package harmoni.osid.authorization
	 */
	function updateReferenceName($referenceName) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($referenceName, $stringRule, true);
		// ** end of parameter validation

		if ($this->_referenceName == $referenceName)
		    return; // nothing to update
		
		// update the object
		$this->_referenceName = $referenceName;
		
		// update the database
		$dbHandler =& Services::requireService("DBHandler");
		$dbPrefix = $this->_authzDB.".az_function";
		
		$query =& new UpdateQuery();
		$query->setTable($dbPrefix);
		$id =& $this->getId();
		$idValue = $id->getIdString();
		$where = "{$dbPrefix}.function_id = '{$idValue}'";
		$query->setWhere($where);
		$query->setColumns(array("{$dbPrefix}.function_reference_name"));
		$query->setValues(array("'$referenceName'"));
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error("The function with Id: ".$idValue." does not exist in the database.","Authorization",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error("Multiple functions with Id: ".$idValue." exist in the database. Note: their display names have been updated." ,"Authorization",true));
	}



	/* :: full java declaration :: void updateReferenceName(String referenceName)
	/**
	 * Update the description for this Function.
	 * @param string description
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package harmoni.osid.authorization
	 */
	function updateDescription($description) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($description, $stringRule, true);
		// ** end of parameter validation
		
		if ($this->_description == $description)
		    return; // nothing to update

		// update the object
		$this->_description = $description;

		// update the database
		$dbHandler =& Services::requireService("DBHandler");
		$dbPrefix = $this->_authzDB.".az_function";
		
		$query =& new UpdateQuery();
		$query->setTable($dbPrefix);
		$id =& $this->getId();
		$idValue = $id->getIdString();
		$where = "{$dbPrefix}.function_id = '{$idValue}'";
		$query->setWhere($where);
		$query->setColumns(array("{$dbPrefix}.function_description"));
		$query->setValues(array("'$description'"));
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error("The function with Id: ".$idValue." does not exist in the database.","Authorization",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error("Multiple functions with Id: ".$idValue." exist in the database. Note: their descriptions have been updated." ,"Authorization",true));
	}
}


?>