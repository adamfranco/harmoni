<?php

/**
 * This class provides a mechanism for caching different authorization components and
 * also acts as an interface between the datastructures and the database.
 * 
 * @version $Id: AuthorizationCache.class.php,v 1.2 2004/06/22 15:23:07 dobomode Exp $
 * @package harmoni.osid.authorization
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class AuthorizationCache {

	/**
	 * An array of the cached Qualifier objects. The index of each element is the Id
	 * of the corresponding Qualifier.
	 * @attribute protected array _qualifiers
	 */
	var $_qualifiers;


	/**
	 * An array of the cached Function objects. The index of each element is the Id
	 * of the corresponding Function.
	 * @attribute protected array _functions
	 */
	var $_functions;


	/**
	 * An array of the cached Authorization objects. The index of each element is the Id
	 * of the corresponding Authorization.
	 * @attribute protected array _authorizations
	 */
	var $_authorizations;
	
	
	/**
	 * The database connection as returned by the DBHandler.
	 * @attribute protected integer _dbIndex
	 */
	var $_dbIndex;

	
	/**
	 * The name of the hierarchy database.
	 * @attribute protected string _hierarchyDB
	 */
	var $_authzDB;
	
	
	/**
     * Constructor
     * @access protected
     */
	function AuthorizationCache($dbIndex, $authzDB) {
		// ** argument validation **
		ArgumentValidator::validate($dbIndex, new IntegerValidatorRule(), true);
		ArgumentValidator::validate($authzDB, new StringValidatorRule(), true);
		// ** end of argument validation **

		$this->_dbIndex = $dbIndex;
		$this->_authzDB = $authzDB;
		$this->_qualifiers = array();
		$this->_functions = array();
		$this->_authorizations = array();
	}
	
	
	
	/**
	 * Creates a new Authorization object, caches it, and inserts it into the database.
	 * @access public
	 * @param ref object agentId who is authorized to perform this Function for this Qualifer and its descendants
	 * @param ref object functionId the Id of the Function for this Authorization
	 * @param ref object qualifierId the Id of the Qualifier for this Authorization
	 * @param ref object effectiveDate when the Authorization becomes effective
	 * @param ref object expirationDate when the Authorization stops being effective
	 * @return ref object Authorization
	 **/
	function & createAuthorization(& $agentId, & $functionId, & $qualifierId, & $effectiveDate, & $expirationDate) {
		// ** parameter validation
		ArgumentValidator::validate($agentId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($functionId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($qualifierId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($effectiveDate, new OptionalRule(new ExtendsValidatorRule("DateTime")), true);
		ArgumentValidator::validate($expirationDate, new OptionalRule(new ExtendsValidatorRule("DateTime")), true);
		// ** end of parameter validation
		
		// create the authorization object
		$sharedManager =& Services::requireService("Shared");
		$id =& $sharedManager->createId();
		// figure out whether it's dated or not
		$dated = isset($effectiveDate) && isset($expirationDate);
		if ($dated)
			$authorization =& new HarmoniAuthorization($id, $agentId, $functionId, $qualifierId,
													   true, $this, $effectiveDate, $expirationDate);
		else													 
			$authorization =& new HarmoniAuthorization($id, $agentId, $functionId, $qualifierId,
													   true, $this);
		
		// now insert into database
		$dbHandler =& Services::requireService("DBHandler");
		$dbt = $this->_authzDB.".az_authorization";
		$idValue = $id->getIdString();

		$query =& new InsertQuery();
		$query->setTable($dbt);
		$columns = array();
		$columns[] = "authorization_id";
		$columns[] = "fk_agent";
		$columns[] = "fk_function";
		$columns[] = "fk_qualifier";
		if ($dated) {
			$columns[] = "authorization_effective_date";
			$columns[] = "authorization_expiration_date";
		}
		$query->setColumns($columns);
		$values = array();
		$values[] = "'".$idValue."'";
		$values[] = "'".$agentId->getIdString()."'";
		$values[] = "'".$functionId->getIdString()."'";
		$values[] = "'".$qualifierId->getIdString()."'";
		if ($dated) {
			$timestamp = $dbHandler->toDBDate($effectiveDate, $this->_dbIndex);
			$values[] = "'".$timestamp."'";
			$timestamp = $dbHandler->toDBDate($expirationDate, $this->_dbIndex);
			$values[] = "'".$timestamp."'";
		}
		$query->setValues($values);
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() != 1) {
			$err = "Could not insert into database.";
			throwError(new Error($err, "authorizarion", true));
		}

		$this->_authorizations[$idValue] =& $authorization;

		return $authorization;			
	}
	
	
	/**
	 * Creates a new Function, insertsi in the DB and caches it.
	 * @param ref object functionId is externally defined
	 * @param string displayName the name to display for this Function
	 * @param string description the description of this Function
	 * @param ref object functionType the Type of this Function
	 * @param ref object qualifierHierarchyId the Id of the Qualifier Hierarchy associated with this Function
	 * @return ref object Function
	 */
	function & createFunction(& $functionId, $displayName, $description, & $functionType, & $qualifierHierarchyId) {
		// ** parameter validation
		ArgumentValidator::validate($functionId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($displayName, new StringValidatorRule(), true);
		ArgumentValidator::validate($description, new StringValidatorRule(), true);
		ArgumentValidator::validate($functionType, new ExtendsValidatorRule("TypeInterface"), true);
		ArgumentValidator::validate($qualifierHierarchyId, new ExtendsValidatorRule("Id"), true);
		// ** end of parameter validation
		
		// create the Function object
		$sharedManager =& Services::requireService("Shared");
		$function =& new HarmoniFunction($functionId, $displayName, $description, 
									     $functionType, $qualifierHierarchyId,
										 $this->_dbIndex, $this->_authzDB);
		
		// now insert into database
		$dbHandler =& Services::requireService("DBHandler");
		$db = $this->_authzDB.".";
		$dbt = $this->_authzDB.".az_function";
		$idValue = $functionId->getIdString();

		// 1. Insert the type
		
		$domain = $functionType->getDomain();
		$authority = $functionType->getAuthority();
		$keyword = $functionType->getKeyword();
		$functionTypeDescription = $functionType->getDescription();

		// check whether the type is already in the DB, if not insert it
		$query =& new SelectQuery();
		$query->addTable($db."type");
		$query->addColumn("type_id", "id", $db."type");
		$where = $db."type.type_domain = '".$domain."'";
		$where .= " AND {$db}type.type_authority = '".$authority."'";
		$where .= " AND {$db}type.type_keyword = '".$keyword."'";
		$where .= " AND {$db}type.type_description = '".$functionTypeDescription."'";
											  
		$query->addWhere($where);

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() > 0) // if the type is already in the database
			$functionTypeIdValue = $queryResult->field("id"); // get the id
		else { // if not, insert it
			$query =& new InsertQuery();
			$query->setTable($db."type");
			$columns = array();
			$columns[] = "type_domain";
			$columns[] = "type_authority";
			$columns[] = "type_keyword";
			$columns[] = "type_description";
			$query->setColumns($columns);
			$values = array();
			$values[] = "'".$domain."'";
			$values[] = "'".$authority."'";
			$values[] = "'".$keyword."'";
			$values[] = "'".$functionTypeDescription."'";
			$query->setValues($values);

			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
			$functionTypeIdValue = $queryResult->getLastAutoIncrementValue();
		}
		
		// 2. Now that we know the id of the type, insert in the DB
		$query =& new InsertQuery();
		$query->setTable($dbt);
		$columns = array();
		$columns[] = "function_id";
		$columns[] = "function_reference_name";
		$columns[] = "function_description";
		$columns[] = "fk_qualifier_hierarchy";
		$columns[] = "fk_type";
		$query->setColumns($columns);
		$values = array();
		$values[] = "'".$idValue."'";
		$values[] = "'".$displayName."'";
		$values[] = "'".$description."'";
		$values[] = "'".$qualifierHierarchyId->getIdString()."'";
		$values[] = "'".$functionTypeIdValue."'";
		$query->setValues($values);
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() != 1) {
			$err = "Could not insert into database.";
			throwError(new Error($err, "authorizarion", true));
		}

		$this->_functions[$idValue] =& $function;

		return $function;
	}


	/** 
	 * Creates a new Qualifier in the Authorization Service that has no parent.  This is different from making a new instance of a Qualifier object locally as the Qualifier will be inserted into the Authorization Service.
	 * @param ref object qualifierId is externally defined
	 * @param string displayName the name to display for this Qualifier
	 * @param string description the description of this Qualifier
	 * @param ref object qualifierType the Type of this Qualifier
	 * @param ref object qualifierHierarchyId the Id of the Qualifier Hierarchy associated with this Qualifier
	 * @return ref object Qualifier
	 */
	function & createRootQualifier(& $qualifierId, $displayName, $description, & $qualifierType, & $qualifierHierarchyId) {
		// ** parameter validation
		ArgumentValidator::validate($qualifierId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($displayName, new StringValidatorRule(), true);
		ArgumentValidator::validate($description, new StringValidatorRule(), true);
		ArgumentValidator::validate($qualifierType, new ExtendsValidatorRule("TypeInterface"), true);
		ArgumentValidator::validate($qualifierHierarchyId, new ExtendsValidatorRule("Id"), true);
		// ** end of parameter validation

		// create the node for the qualifier		
		$hierarchyManager =& Services::requireService("Hierarchy");
		$hierarchy =& $hierarchyManager->getHierarchy($qualifierHierarchyId);
		$node =& $hierarchy->createRootNode($qualifierId, $qualifierType, $displayName, $description);

		// now create the qualifier
		$qualifier =& new HarmoniQualifier($node, $this);
		
		// and cache it
		$this->_qualifiers[$qualifierId->getIdString()] =& $qualifier;
		
		return $qualifier;
	}


	/** 
	 * Creates a new Qualifier in the Authorization Service. This is different than making a new instance of a Qualifier object locally as the Qualifier will be inserted into the Authorization Service.
	 * @param ref object qualifierId is externally defined
	 * @param string displayName the name to display for this Qualifier
	 * @param string description the description of this Qualifier
	 * @param ref object qualifierType the Type of this Qualifier
	 * @param ref object parentId the parent of this Qualifier
	 * @return Qualifier
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}, {@link AuthorizationException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.authorization
	 */
	function & createQualifier(& $qualifierId, $displayName, $description, & $qualifierType, & $parentId) {
		// ** parameter validation
		ArgumentValidator::validate($qualifierId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($displayName, new StringValidatorRule(), true);
		ArgumentValidator::validate($description, new StringValidatorRule(), true);
		ArgumentValidator::validate($qualifierType, new ExtendsValidatorRule("TypeInterface"), true);
		ArgumentValidator::validate($parentId, new ExtendsValidatorRule("Id"), true);
		// ** end of parameter validation

		// create the node for the qualifier		
		$hierarchyManager =& Services::requireService("Hierarchy");
		
		// get the hierarchy id from the node
		$parentNode =& $hierarchyManager->getNode($parentId);
		$qualifierHierarchyId =& $parentNode->getHierarchyId();
		// now get the hierarchy and create the node
		$hierarchy =& $hierarchyManager->getHierarchy($qualifierHierarchyId);
		$node =& $hierarchy->createNode($qualifierId, $parentId, $qualifierType, $displayName, $description);

		// now create the qualifier
		$qualifier =& new HarmoniQualifier($node, $this);
		
		// and cache it
		$this->_qualifiers[$qualifierId->getIdString()] =& $qualifier;
		
		return $qualifier;
	}
	

	/**
	 * Returns the Function with the specified id.
	 * @access public
	 * @param string id The id of the function.
	 * @return ref object The Function with the specified id.
	 **/
	function & getFunction(& $idValue) {
		// ** parameter validation
		ArgumentValidator::validate($idValue, new StringValidatorRule(), true);
		// ** end of parameter validation
		
		if (isset($this->_functions[$idValue]))
		    return $this->_functions[$idValue];

		$dbHandler =& Services::requireService("DBHandler");
		
		$db = $this->_authzDB;
		$dbt = $db.".az_function";
		$query =& new SelectQuery();
		$query->addColumn("function_id", "id", $dbt);
		$query->addColumn("function_reference_name", "reference_name", $dbt);
		$query->addColumn("function_description", "description", $dbt);
		$query->addColumn("fk_qualifier_hierarchy", "hierarchy_id", $dbt);
		$query->addColumn("type_domain", "domain", $db.".type");
		$query->addColumn("type_authority", "authority", $db.".type");
		$query->addColumn("type_keyword", "keyword", $db.".type");
		$query->addColumn("type_description", "type_description", $db.".type");
		$query->addTable($dbt);
		$joinc = $dbt.".fk_type = ".$db.".type.type_id";
		$query->addTable($db.".type", INNER_JOIN, $joinc);
		$where = $dbt.".function_id = '$idValue'";
		$query->addWhere($where);
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		if ($queryResult->getNumberOfRows() != 1) {
		    $str = "Exactly one row must have been returned";
			throwError($str, "authorization", true);
		}
		
		$row = $queryResult->getCurrentRow();
		$type =& new HarmoniType($row['domain'], $row['authority'], 
							     $row['keyword'], $row['type_description']);
		
		
		$shared_manager =& Services::requireService("Shared");
		$functionId =& $shared_manager->getId($row['id']);
		$hierarchyId =& $shared_manager->getId($row['hierarchy_id']);
		$function =& new HarmoniFunction($functionId, $row['reference_name'],
										 $row['description'], $type, $hierarchyId ,
										 $this->_dbIndex, $this->_authzDB);
		
		$this->_functions[$idValue] =& $function;
		
		return $function;
	}
	
	
	/**
	 * Returns the Qualifier with the specified id.
	 * @access public
	 * @param string id The id of the Qualifier .
	 * @return ref object The Qualifier with the specified id.
	 **/
	function & getQualifier($qualifierId) {
		// ** parameter validation
		ArgumentValidator::validate($qualifierId, new ExtendsValidatorRule("Id"), true);
		// ** end of parameter validation
		
		$idValue =& $qualifierId->getIdString();

		if (isset($this->_qualifiers[$idValue]))
		    return $this->_qualifiers[$idValue];

		// get the node for the qualifier		
		$hierarchyManager =& Services::requireService("Hierarchy");
		$node =& $hierarchyManager->getNode($qualifierId);
		// now create the qualifier
		$qualifier =& new HarmoniQualifier($node, $this);
		
		$this->_qualifiers[$idValue] =& $qualifier;
		
		return $qualifier;

	}
	

	/**
	 * Deletes the given Authorization.
	 * @access public
	 * @param ref object authorization The Authorization to delete.
	 **/
	function deleteAuthorization(& $authorization) {
		// ** parameter validation
		ArgumentValidator::validate($authorization, new ExtendsValidatorRule("Authorization"), true);
		// ** end of parameter validation

		// get the id
		$idValue = $authorization->_id->getIdString();
		
		// now remove from database
		$dbHandler =& Services::requireService("DBHandler");
		$dbt = $this->_authzDB.".az_authorization";

		$query =& new DeleteQuery();
		$query->setTable($dbt);
		$query->addWhere($dbt.".authorization_id = '".$idValue."'");
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		if ($queryResult->getNumberOfRows() != 1) {
			$err = "Zero or more than one Authorization were deleted (must have been exactly one).";
			throwError(new Error($err, "authorizarion", true));
		}
		
		// update cache
		$this->_authorizations[$idValue] = null;
		unset($this->_authorizations[$idValue]);
		$authorization = null;
	}
	
	
	/**
	 * Deletes the given Authorization.
	 * @access public
	 * @param ref object authorization The Authorization to delete.
	 **/
	function deleteQualifier(& $qualifierId) {
		// ** parameter validation
		ArgumentValidator::validate($qualifierId, new ExtendsValidatorRule("Id"), true);
		// ** end of parameter validation

		// get the id
		$idValue = $qualifierId->getIdString();

		// create the node for the qualifier		
		$hierarchyManager =& Services::requireService("Hierarchy");

		$node =& $hierarchyManager->getNode($qualifierId);
		$qualifierHierarchyId =& $node->getHierarchyId();

		$hierarchy =& $hierarchyManager->getHierarchy($qualifierHierarchyId);
		$hierarchy->deleteNode($qualifierId);
		
		// update cache
		$this->_qualifiers[$idValue] = null;
		unset($this->_qualifiers[$idValue]);
	}
	
	

	/**
	 * Deletes the given Authorization.
	 * @access public
	 * @param ref object authorization The Authorization to delete.
	 **/
	function deleteFunction(& $functionId) {
		// ** parameter validation
		ArgumentValidator::validate($functionId, new ExtendsValidatorRule("Id"), true);
		// ** end of parameter validation

		// get the id
		$idValue = $functionId->getIdString();
		
		// now remove from database
		$dbHandler =& Services::requireService("DBHandler");
		$dbt = $this->_authzDB.".az_function";

		$query =& new DeleteQuery();
		$query->setTable($dbt);
		$query->addWhere($dbt.".function_id = '".$idValue."'");
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		if ($queryResult->getNumberOfRows() != 1) {
			$err = "Zero or more than one function were deleted (must have been exactly one).";
			throwError(new Error($err, "authorizarion", true));
		}
		
		// update cache
		$this->_functions[$idValue] = null;
		unset($this->_functions[$idValue]);
	}
	
	
	/**
	 * Auxilliary private function that returns Authorizations according to a
	 * criteria. Null values are interpreted as wildmarks.
	 * @access public
	 * @param string aId The string id of an agent.
	 * @param string fId The string id of a function.
	 * @param string qId The string id of a qualifier.
	 * @param object fType The type of a function.
	 * @param boolean isExplicit If True, only explicit Authorizations will be returned.
	 * @param boolean isActiveNow If True, only active Authorizations will be returned.
	 * @return ref object An AuthorizationIterator.
	 **/
	function getAZs($aId, $fId, $qId, $fType, $isExplicit, $isActiveNow) {
		// ** parameter validation
		$rule =& new StringValidatorRule();
		ArgumentValidator::validate($aId, new OptionalRule($rule), true);
		ArgumentValidator::validate($fId, new OptionalRule($rule), true);
		ArgumentValidator::validate($qId, new OptionalRule($rule), true);
		ArgumentValidator::validate($fType, new OptionalRule(new ExtendsValidatorRule("TypeInterface")), true);
		ArgumentValidator::validate($isExplicit, new BooleanValidatorRule(), true);
		ArgumentValidator::validate($isActiveNow,new BooleanValidatorRule(), true);
		// ** end of parameter validation
		
		$sharedManager =& Services::requireService("Shared");
		
		$qualifiers = array();
		// if a Qualifier criteria was passed, then
		// the following array will store the ids of all qualifiers that need
		// to be checked for authorizations, i.e. all ancestors of the given qualifier.
		if (isset($qId)) {
			$qualifiers = array();
			$hierarchyManager =& Services::requireService("Hierarchy");

			$node =& $hierarchyManager->getNode($sharedManager->getId($qId));
			$hierarchyId =& $node->getHierarchyId();
			$hierarchy =& $hierarchyManager->getHierarchy($hierarchyId);
			
			// these are the ancestor nodes
			$nodes =& $hierarchy->traverse($sharedManager->getId($qId), TRAVERSE_MODE_DEPTH_FIRST,
					TRAVERSE_DIRECTION_UP, TRAVERSE_LEVELS_INFINITE);
					
			// now get the id of each node and store in array
			while($nodes->hasNext()){
				$info =& $nodes->next();
				$id =& $info->getNodeId();
				$qualifiers[] = $id->getIdString();
			} // while
		}
		
		// setup the query
		$dbHandler =& Services::requireService("DBHandler");
		$db = $this->_authzDB.".";
		$query =& new SelectQuery();
		$query =& new SelectQuery();
		$query->addColumn("authorization_id", "id", $db."az_authorization");
		$query->addColumn("fk_agent", "aId", $db."az_authorization");
		$query->addColumn("fk_function", "fId", $db."az_authorization");
		$query->addColumn("fk_qualifier", "qId", $db."az_authorization");
		$query->addColumn("authorization_effective_date", "eff_date", $db."az_authorization");
		$query->addColumn("authorization_expiration_date", "exp_date", $db."az_authorization");


//		$query->addColumn("function_reference_name", "reference_name", $dbt);
//		$query->addColumn("function_description", "description", $dbt);
//		$query->addColumn("fk_qualifier_hierarchy", "hierarchy_id", $dbt);
//		$query->addColumn("type_domain", "domain", $db.".type");
//		$query->addColumn("type_authority", "authority", $db.".type");
//		$query->addColumn("type_keyword", "keyword", $db.".type");
//		$query->addColumn("type_description", "type_description", $db.".type");

		$query->addTable($db."az_authorization");
//		$joinc = $dbt.".fk_type = ".$db.".type.type_id";
//		$query->addTable($db.".type", INNER_JOIN, $joinc);
//		$where = $dbt.".function_id = '$idValue'";
//		$query->addWhere($where);

		// now include criteria
		if (isset($aId)) {
			$joinc = $db."az_authorization.fk_agent = ".$db."agent.agent_id";
			$query->addTable($db."agent", INNER_JOIN, $joinc);
			$where = $db."az_authorization.fk_agent = '$aId'";
			$query->addWhere($where);
		}
		if (isset($fId)) {
			$joinc = $db."az_authorization.fk_function = ".$db."az_function.function_id";
			$query->addTable($db."az_function", INNER_JOIN, $joinc);
			$where = $db."az_authorization.fk_function = '$fId'";
			$query->addWhere($where);
		}
		if (isset($qId)) {
			$where = $db."az_authorization.fk_qualifier = '$qId'";
			$query->addWhere($where);
		}


		echo "<pre>\n";
		echo MySQL_SQLGenerator::generateSQLQuery($query);
		echo "</pre>\n";
		
		

	}
		
	
}

?>