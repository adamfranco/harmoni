<?php

require_once(OKI2."/osid/authorization/Function.php");

/**
 * Function is composed of Id, a displayName, a description, a category, and a
 * QualifierType.  Ids in Authorization are externally defined and their
 * uniqueness is enforced by the implementation.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 *
 * @package harmoni.osid_v2.authorization
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniFunction.class.php,v 1.10 2005/04/04 17:39:40 adamfranco Exp $
 */
class HarmoniFunction
	extends FunctionInterface 
{

	/**
	 * The Unique ID of this function.
	 * @var object _id 
	 * @access private
	 */
	var $_id;

	
	/**
	 * The display name of this function.
	 * @var string _referenceName 
	 * @access private
	 */
	var $_referenceName;

	
	/**
	 * The description of this function.
	 * @var string _description 
	 * @access private
	 */
	var $_description;

	
	/**
	 * The type of this function.
	 * @var object _functionType 
	 * @access private
	 */
	var $_functionType;
	
	
	/**
	 * The ID of the qualifier hierarchy that is associated with this function.
	 * @var object _qualifierHierarchyId 
	 * @access private
	 */
	var $_qualifierHierarchyId; 


	/**
	 * The index of the database connection as returned by the DBHandler.
	 * @var integer _dbIndex 
	 * @access private
	 */
	var $_dbIndex;
	
	
	/**
	 * The name of the Authorization database.
	 * @var string _table 
	 * @access private
	 */
	var $_authzDB;


	/**
	 * The constructor.
	 * @param ref object id - is externally defined functionId - is externally 
	 *		defined.
	 * @param string referenceName - is externally defined referenceName - the 
	 *		name to display for this Function
	 * @param string  description - is externally defined description - the 
	 *		description of this Function
	 * @param ref object functionType - is externally defined functionType - the 
	 *		Type of this Function
	 * @param ref object qualifierHierarchyId - is externally defined 
	 *		qualifierHierarchyId - the Id of the Qualifier Hierarchy associated 
	 *		with this Function	 
	 * @param  integer dbIndex The index of the database connection as returned 
	 *		by the DBHandler.
	 * @param  string authzDB The name of the Authorization database.
	 * @access public
	 */
	function HarmoniFunction(& $id, $referenceName, $description, & $functionType, 
							 & $qualifierHierarchyId, $dbIndex, $authzDB) {
		// ** parameter validation
		$stringRule =& StringValidatorRule::getRule();
		ArgumentValidator::validate($referenceName, $stringRule, true);
		ArgumentValidator::validate($description, $stringRule, true);
		$extendsRule =& ExtendsValidatorRule::getRule("Id");
		ArgumentValidator::validate($id, $extendsRule, true);
		ArgumentValidator::validate($qualifierHierarchyId, $extendsRule, true);
		$extendsRule =& ExtendsValidatorRule::getRule("Type");
		ArgumentValidator::validate($functionType, $extendsRule, true);
		$integerRule =& IntegerValidatorRule::getRule();
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
	 * Get the unique Id for this Function.
	 *	
	 * @return object Id
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getId () { 
		return $this->_id;
	}
	
	/**
	 * Get the permanent reference name for this Function.
	 *	
	 * @return string
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getReferenceName () { 
		return $this->_referenceName;
	}

	/**
	 * Get the description for this Function.
	 *	
	 * @return string
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getDescription () { 
		return $this->_description;
	}

	/**
	 * Get the FunctionType for this Function.
	 *	
	 * @return object Type
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getFunctionType () { 
		return $this->_functionType;
	}

	/**
	 * Get the QualifierHierarchyId for this Function.
	 *	
	 * @return object Id
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getQualifierHierarchyId () { 
		return $this->_qualifierHierarchyId;	
	}
	
	/**
	 * Update the description for this Function.
	 * 
	 * @param string $description
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function updateDescription ( $description ) { 
		// ** parameter validation
		$stringRule =& StringValidatorRule::getRule();
		ArgumentValidator::validate($description, $stringRule, true);
		// ** end of parameter validation
		
		if ($this->_description == $description)
			return; // nothing to update

		// update the object
		$this->_description = $description;

		// update the database
		$dbHandler =& Services::getService("DBHandler");
		$dbPrefix = $this->_authzDB.".az_function";
		
		$query =& new UpdateQuery();
		$query->setTable($dbPrefix);
		$id =& $this->getId();
		$idValue = $id->getIdString();
		$where = "{$dbPrefix}.function_id = '{$idValue}'";
		$query->setWhere($where);
		$query->setColumns(array("{$dbPrefix}.function_description"));
		$query->setValues(array("'".addslashes($description)."'"));
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error(AuthorizationExeption::OPERATION_FAILED(),"AuthorizationFunction",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error(AuthorizationExeption::OPERATION_FAILED() ,"AuthorizationFunction",true));
	}
	
	/**
	 * Update the reference name for this Function.
	 *
	 * WARNING: NOT IN OSID
	 * 
	 * @param string $referenceName
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function updateReferenceName ( $referenceName ) {
		// ** parameter validation
		$stringRule =& StringValidatorRule::getRule();
		ArgumentValidator::validate($referenceName, $stringRule, true);
		// ** end of parameter validation

		if ($this->_referenceName == $referenceName)
			return; // nothing to update
		
		// update the object
		$this->_referenceName = $referenceName;
		
		// update the database
		$dbHandler =& Services::getService("DBHandler");
		$dbPrefix = $this->_authzDB.".az_function";
		
		$query =& new UpdateQuery();
		$query->setTable($dbPrefix);
		$id =& $this->getId();
		$idValue = $id->getIdString();
		$where = "{$dbPrefix}.function_id = '{$idValue}'";
		$query->setWhere($where);
		$query->setColumns(array("{$dbPrefix}.function_reference_name"));
		$query->setValues(array("'".addslashes($referenceName)."'"));
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error(AuthorizationExeption::OPERATION_FAILED(),"AuthorizationFunction",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error(AuthorizationExeption::OPERATION_FAILED() ,"AuthorizationFunction",true));
	}

}

?>