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
 * @version $Id: Function.class.php,v 1.1 2008/04/24 20:51:43 adamfranco Exp $
 */
class AuthZ2_Function
	implements FunctionInterface 
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
	function __construct(Id $id, $referenceName, $description, Type $functionType, 
							 Id $qualifierHierarchyId, $dbIndex) {
		// ** parameter validation
		$stringRule = StringValidatorRule::getRule();
		ArgumentValidator::validate($referenceName, $stringRule, true);
		ArgumentValidator::validate($description, $stringRule, true);
		$integerRule = IntegerValidatorRule::getRule();
		ArgumentValidator::validate($dbIndex, $integerRule, true);
		// ** end of parameter validation
		
		$this->_id =$id;
		$this->_referenceName = $referenceName;
		$this->_description = $description;
		$this->_functionType =$functionType;
		$this->_qualifierHierarchyId =$qualifierHierarchyId;
		$this->_dbIndex = $dbIndex;
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
	function getId () { 
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
	function getFunctionType () { 
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
	function getQualifierHierarchyId () { 
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
		$stringRule = StringValidatorRule::getRule();
		ArgumentValidator::validate($description, $stringRule, true);
		// ** end of parameter validation
		
		if ($this->_description == $description)
			return; // nothing to update

		// update the object
		$this->_description = $description;

		// update the database
		$dbHandler = Services::getService("DatabaseManager");
		
		$query = new UpdateQuery();
		$query->setTable("az2_function");
		$query->addWhereEqual("id", $this->getId()->getIdString());
		$query->addValue("description", $description);
		
		$queryResult = $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new HarmoniError(AuthorizationExeption::OPERATION_FAILED(),"AuthorizationFunction",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new HarmoniError(AuthorizationExeption::OPERATION_FAILED() ,"AuthorizationFunction",true));
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
		$stringRule = StringValidatorRule::getRule();
		ArgumentValidator::validate($referenceName, $stringRule, true);
		// ** end of parameter validation

		if ($this->_referenceName == $referenceName)
			return; // nothing to update
		
		// update the object
		$this->_referenceName = $referenceName;
		
		// update the database
		$dbHandler = Services::getService("DatabaseManager");
		
		$query = new UpdateQuery();
		$query->setTable("az2_function");
		$query->addWhereEqual("id", $this->getId()->getIdString());
		$query->addValue("reference_name", $referenceName);
		
		$queryResult =$dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new HarmoniError(AuthorizationExeption::OPERATION_FAILED(),"AuthorizationFunction",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new HarmoniError(AuthorizationExeption::OPERATION_FAILED() ,"AuthorizationFunction",true));
	}

}

?>