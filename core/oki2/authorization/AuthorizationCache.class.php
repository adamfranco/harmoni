<?php

require_once(HARMONI.'oki2/authorization/HarmoniFunctionIterator.class.php');

/**
 * This class provides a mechanism for caching different authorization components and
 * also acts as an interface between the datastructures and the database.
 *
 * @package harmoni.osid_v2.authorization
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AuthorizationCache.class.php,v 1.29 2006/01/18 15:32:16 adamfranco Exp $
 */
class AuthorizationCache {

	/**
	 * An array of the cached Qualifier objects. The index of each element is the Id
	 * of the corresponding Qualifier.
	 * @var array _qualifiers 
	 * @access protected
	 */
	var $_qualifiers;


	/**
	 * An array of the cached Function objects. The index of each element is the Id
	 * of the corresponding Function.
	 * @var array _functions 
	 * @access protected
	 */
	var $_functions;


	/**
	 * An array of the cached Authorization objects. The index of each element is the Id
	 * of the corresponding Authorization.
	 * @var array _authorizations 
	 * @access protected
	 */
	var $_authorizations;
	
	
	/**
	 * The database connection as returned by the DBHandler.
	 * @var integer _dbIndex 
	 * @access protected
	 */
	var $_dbIndex;

	
	/**
	 * The name of the hierarchy database.
	 * @var string _hierarchyDB 
	 * @access protected
	 */
	var $_authzDB;
	
	
	/**
	 * Constructor
	 * @access protected
	 */
	function AuthorizationCache($dbIndex, $authzDB) {
		// ** argument validation **
		ArgumentValidator::validate($dbIndex, IntegerValidatorRule::getRule(), true);
		ArgumentValidator::validate($authzDB, StringValidatorRule::getRule(), true);
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
	 * @param object DateAndTime effectiveDate when the Authorization becomes effective
	 * @param object DateAndTime expirationDate when the Authorization stops being effective
	 * @return ref object Authorization
	 **/
	function &createAuthorization(& $agentId, & $functionId, & $qualifierId, $effectiveDate = NULL, $expirationDate = NULL) {
		// ** parameter validation
		ArgumentValidator::validate($agentId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($functionId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($qualifierId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($effectiveDate, OptionalRule::getRule(IntegerValidatorRule::getRule()), true);
		ArgumentValidator::validate($expirationDate, OptionalRule::getRule(IntegerValidatorRule::getRule()), true);
		// ** end of parameter validation
		
		// create the authorization object
		$idManager =& Services::getService("Id");
		$id =& $idManager->createId();
		$idValue = $id->getIdString();
		// figure out whether it's dated or not
		$dated = isset($effectiveDate) && isset($expirationDate);
		if ($dated)
			$authorization =& new HarmoniAuthorization($idValue, $agentId, $functionId, $qualifierId, true, $this, $effectiveDate, $expirationDate);
		else													 
			$authorization =& new HarmoniAuthorization($idValue, $agentId, $functionId, $qualifierId,true, $this);
		
		// now insert into database
		$dbHandler =& Services::getService("DatabaseManager");
		$dbt = $this->_authzDB.".az_authorization";

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
		$values[] = "'".addslashes($idValue)."'";
		$values[] = "'".addslashes($agentId->getIdString())."'";
		$values[] = "'".addslashes($functionId->getIdString())."'";
		$values[] = "'".addslashes($qualifierId->getIdString())."'";
		
		if ($dated) {
			if (is_object($effectiveDate))
				$values[] = 
					$dbHandler->toDBDate($effectiveDate, $this->_dbIndex);
			else
				$values[] = "NULL";
			
			if (is_object($expirationDate))
				$values[] = 
					$dbHandler->toDBDate($expirationDate, $this->_dbIndex);
			else
				$values[] = "NULL";
		}
		
		$query->setValues($values);
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() != 1) {
			$err = "Could not insert into database.";
			throwError(new Error($err, "authorization", true));
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
	function &createFunction(& $functionId, $displayName, $description, & $functionType, & $qualifierHierarchyId) {
		// ** parameter validation
		ArgumentValidator::validate($functionId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($displayName, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($description, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($functionType, ExtendsValidatorRule::getRule("Type"), true);
		ArgumentValidator::validate($qualifierHierarchyId, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation
		
		// create the Function object
		$idManager =& Services::getService("Id");
		$function =& new HarmoniFunction($functionId, $displayName, $description, 
										 $functionType, $qualifierHierarchyId,
										 $this->_dbIndex, $this->_authzDB);
		
		// now insert into database
		$dbHandler =& Services::getService("DatabaseManager");
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
		$where = $db."type.type_domain = '".addslashes($domain)."'";
		$where .= " AND {$db}type.type_authority = '".addslashes($authority)."'";
		$where .= " AND {$db}type.type_keyword = '".addslashes($keyword)."'";
		$where .= " AND {$db}type.type_description = '".addslashes($functionTypeDescription)."'";
											  
		$query->addWhere($where);

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() > 0) {// if the type is already in the database
			$functionTypeIdValue = $queryResult->field("id"); // get the id
			$queryResult->free();
		} else { // if not, insert it
			$query =& new InsertQuery();
			$query->setTable($db."type");
			$columns = array();
			$columns[] = "type_domain";
			$columns[] = "type_authority";
			$columns[] = "type_keyword";
			$columns[] = "type_description";
			$query->setColumns($columns);
			$values = array();
			$values[] = "'".addslashes($domain)."'";
			$values[] = "'".addslashes($authority)."'";
			$values[] = "'".addslashes($keyword)."'";
			$values[] = "'".addslashes($functionTypeDescription)."'";
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
		$values[] = "'".addslashes($idValue)."'";
		$values[] = "'".addslashes($displayName)."'";
		$values[] = "'".addslashes($description)."'";
		$values[] = "'".addslashes($qualifierHierarchyId->getIdString())."'";
		$values[] = "'".addslashes($functionTypeIdValue)."'";
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
	 * Creates a new Qualifier in the Authorization Service that has no parent.	 This is different from making a new instance of a Qualifier object locally as the Qualifier will be inserted into the Authorization Service.
	 * @param ref object qualifierId is externally defined
	 * @param string displayName the name to display for this Qualifier
	 * @param string description the description of this Qualifier
	 * @param ref object qualifierType the Type of this Qualifier
	 * @param ref object qualifierHierarchyId the Id of the Qualifier Hierarchy associated with this Qualifier
	 * @return ref object Qualifier
	 */
	function &createRootQualifier(& $qualifierId, $displayName, $description, & $qualifierType, & $qualifierHierarchyId) {
		// ** parameter validation
		ArgumentValidator::validate($qualifierId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($displayName, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($description, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($qualifierType, ExtendsValidatorRule::getRule("Type"), true);
		ArgumentValidator::validate($qualifierHierarchyId, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation

		// create the node for the qualifier		
		$hierarchyManager =& Services::getService("Hierarchy");
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
	 */
	function &createQualifier(& $qualifierId, $displayName, $description, & $qualifierType, & $parentId) {
		// ** parameter validation
		ArgumentValidator::validate($qualifierId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($displayName, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($description, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($qualifierType, ExtendsValidatorRule::getRule("Type"), true);
		ArgumentValidator::validate($parentId, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation

		// create the node for the qualifier		
		$hierarchyManager =& Services::getService("Hierarchy");
		
		// get the hierarchy id from the node
		$parentNode =& $hierarchyManager->getNode($parentId);
		// now get the hierarchy and create the node
		$hierarchy =& $hierarchyManager->getHierarchyForNode($parentNode);
		$node =& $hierarchy->createNode($qualifierId, $parentId, $qualifierType, $displayName, $description);

		// now create the qualifier
		$qualifier =& new HarmoniQualifier($node, $this);
		
		// and cache it
		$this->_qualifiers[$qualifierId->getIdString()] =& $qualifier;
		
		return $qualifier;
	}
	
	/**
	 * Get all the Function of the specified Type.
	 * @param ref object functionType the Type of the Functions to return
	 * @return ref object FunctionIterator
	 */
	function &getFunctionTypes() {
		
		$dbHandler =& Services::getService("DatabaseManager");
		
		$db = $this->_authzDB;
		$dbt = $db.".az_function";
		
		$query =& new SelectQuery();
		$query->addColumn("type_domain", "domain", $db.".type");
		$query->addColumn("type_authority", "authority", $db.".type");
		$query->addColumn("type_keyword", "keyword", $db.".type");
		$query->addColumn("type_description", "type_description", $db.".type");
		
		$query->addTable($dbt);
		$joinc = $dbt.".fk_type = ".$db.".type.type_id";
		$query->addTable($db.".type", INNER_JOIN, $joinc);
		
		$query->setGroupBy(array("type_domain", "type_authority", "type_keyword"));

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		$types = array();
		
		while ($queryResult->hasMoreRows()) {
			$row = $queryResult->getCurrentRow();
//			echo "<pre>";
//			print_r($row);
//			echo "</pre>";
			
			$types[] =& new HarmoniType($row['domain'], $row['authority'], 
									 $row['keyword'], $row['type_description']);

			$queryResult->advanceRow();
		}
		$queryResult->free();
		$obj =& new HarmoniTypeIterator($types);
		return $obj;
	}

	/**
	 * Get all the Function of the specified Type.
	 * @param ref object functionType the Type of the Functions to return
	 * @return ref object FunctionIterator
	 */
	function &getFunctions(& $functionType) {
		// ** parameter validation
		ArgumentValidator::validate($functionType, ExtendsValidatorRule::getRule("Type"), true);
		// ** end of parameter validation
		
		$dbHandler =& Services::getService("DatabaseManager");
		
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
		$where = $db.".type.type_domain = '".addslashes($functionType->getDomain())."'";
		$query->addWhere($where);
		$where = $db.".type.type_authority = '".addslashes($functionType->getAuthority())."'";
		$query->addWhere($where);
		$where = $db.".type.type_keyword = '".addslashes($functionType->getKeyword())."'";
		$query->addWhere($where);
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		$functions = array();
		
		while ($queryResult->hasMoreRows()) {
			$row = $queryResult->getCurrentRow();
//			echo "<pre>";
//			print_r($row);
//			echo "</pre>";
			
			$idValue = $row['id'];
			if (isset($this->_functions[$idValue])) {
				$function =& $this->_functions[$idValue];
			}
			else {
				$type =& new HarmoniType($row['domain'], $row['authority'], 
										 $row['keyword'], $row['type_description']);
				$idManager =& Services::getService("Id");
				$functionId =& $idManager->getId($row['id']);
				$hierarchyId =& $idManager->getId($row['hierarchy_id']);
				$function =& new HarmoniFunction($functionId, $row['reference_name'],
												 $row['description'], $type, $hierarchyId ,
												 $this->_dbIndex, $this->_authzDB);

				$this->_functions[$idValue] =& $function;
			}

			$functions[] =& $function;
			$queryResult->advanceRow();
		}
		$queryResult->free();
		
		$obj =& new HarmoniFunctionIterator($functions);
		
		return $obj;
	}


	/**
	 * Returns the Function with the specified id.
	 * @access public
	 * @param string id The id of the function.
	 * @return ref object The Function with the specified id.
	 **/
	function &getFunction($idValue) {
		// ** parameter validation
		ArgumentValidator::validate($idValue, StringValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		if (isset($this->_functions[$idValue]))
			return $this->_functions[$idValue];

		$dbHandler =& Services::getService("DatabaseManager");
		
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
		$where = $dbt.".function_id = '".addslashes($idValue)."'";
		$query->addWhere($where);
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		if ($queryResult->getNumberOfRows() != 1) {
			$queryResult->free();
			$str = "Exactly one row must have been returned";
			throwError($str, "authorization", true);
		}
		
		$row = $queryResult->getCurrentRow();
		$queryResult->free();
		$type =& new HarmoniType($row['domain'], $row['authority'], 
								 $row['keyword'], $row['type_description']);
		
		
		$idManager =& Services::getService("Id");
		$functionId =& $idManager->getId($row['id']);
		$hierarchyId =& $idManager->getId($row['hierarchy_id']);
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
	function &getQualifier(& $qualifierId) {
		// ** parameter validation
		ArgumentValidator::validate($qualifierId, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation
		
		$idValue = $qualifierId->getIdString();

		if (isset($this->_qualifiers[$idValue]))
			return $this->_qualifiers[$idValue];

		// get the node for the qualifier		
		$hierarchyManager =& Services::getService("Hierarchy");
		$node =& $hierarchyManager->getNode($qualifierId);
		// now create the qualifier
		$qualifier =& new HarmoniQualifier($node, $this);
		
		$this->_qualifiers[$idValue] =& $qualifier;
		
		return $qualifier;

	}
	
	/**
	 * Given a QualifierHierarchy Id, returns the Qualifier that is the root of 
	 * the tree of Qualifiers of this Type.
	 *
	 * @param object qualifierHierarchyId
	 * @return object QualifierIterator
	 */
	function &getRootQualifiers(& $qualifierHierarchyId) {
		$hierarchyManager =& Services::getService("Hierarchy", true);
		$hierarchy =& $hierarchyManager->getHierarchy($qualifierHierarchyId);
		
		// create an array for our qualifiers
		$qualifiers = array();
		
		// Get the qualifier for each node
		$nodes =& $hierarchy->getRootNodes();
		while ($nodes->hasNext()) {
			$node =& $nodes->next();
			$nodeId =& $node->getId();
			
			// Make sure that we have a qualifier for this node.
			if (!isset($this->_qualifiers[$nodeId->getIdString()])) {
				$this->_qualifiers[$nodeId->getIdString()] =& new HarmoniQualifier($node, $this);
			}
			
			$qualifiers[] =& $this->_qualifiers[$nodeId->getIdString()];
		}
		
		$obj =& new HarmoniQualifierIterator($qualifiers);
		
		return $obj;
	}

	
	/**
	 * Returns the Qualifier with the specified id.
	 * @access public
	 * @param string id The id of the Qualifier .
	 * @return ref object The Qualifier with the specified id.
	 **/
	function &getQualifierDescendants(& $qualifierId) {
		// ** parameter validation
		ArgumentValidator::validate($qualifierId, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation
		
		$idValue = $qualifierId->getIdString();

		// get the descendant nodes
		$hierarchyManager =& Services::getService("Hierarchy");
		$node =& $hierarchyManager->getNode($qualifierId);
		$hierarchy =& $hierarchyManager->getHierarchyForNode($node);
		$nodes =& $hierarchy->traverse($qualifierId, Hierarchy::TRAVERSE_MODE_DEPTH_FIRST(), 
										Hierarchy::TRAVERSE_DIRECTION_DOWN(), Hierarchy::TRAVERSE_LEVELS_ALL());

		// create the qualifiers
		$qualifiers = array();
		// get rid of the root node (it is not a descendant)
		$nodes->next();
		while ($nodes->hasNext()) {
			$node =& $nodes->next();
			$nodeId =& $node->getNodeId();
			$idValue = $nodeId->getIdString();
			
			if (isset($this->_qualifiers[$idValue]))
				$qualifier =& $this->_qualifiers[$idValue];
			else {
				$qualifier =& new HarmoniQualifier($hierarchy->getNode($nodeId), $this);
				$this->_qualifiers[$idValue] =& $qualifier;
			}
			
			$qualifiers[] =& $qualifier;
		}

		$obj =& new HarmoniQualifierIterator($qualifiers);

		return $obj;
	}



	/**
	 * Deletes the given Authorization.
	 * @access public
	 * @param ref object authorization The Authorization to delete.
	 **/
	function deleteAuthorization(& $authorization) {
		// ** parameter validation
		ArgumentValidator::validate($authorization, ExtendsValidatorRule::getRule("Authorization"), true);
		// ** end of parameter validation
		
//		echo "<pre>\n";
//		print_r($authorization);
//		echo "</pre>\n";

		// get the id
		$idValue = $authorization->_id;
		
		// now remove from database
		$dbHandler =& Services::getService("DatabaseManager");
		$dbt = $this->_authzDB.".az_authorization";

		$query =& new DeleteQuery();
		$query->setTable($dbt);
		$query->addWhere($dbt.".authorization_id = '".addslashes($idValue)."'");
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		if ($queryResult->getNumberOfRows() != 1) {
			$err = "Zero or more than one Authorization were deleted (must have been exactly one).";
			throwError(new Error($err, "authorizarion", true));
		}
		
		// update cache
		$this->_authorizations[$idValue] = null;
		unset($this->_authorizations[$idValue]);
	}
	
	
	/**
	 * Deletes the given Authorization.
	 * @access public
	 * @param ref object authorization The Authorization to delete.
	 **/
	function deleteQualifier(& $qualifierId) {
		// ** parameter validation
		ArgumentValidator::validate($qualifierId, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation

		// get the id
		$idValue = $qualifierId->getIdString();

		// create the node for the qualifier		
		$hierarchyManager =& Services::getService("Hierarchy");

		$node =& $hierarchyManager->getNode($qualifierId);
		$hierarchy =& $hierarchyManager->getHierarchyForNode($node);
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
		ArgumentValidator::validate($functionId, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation

		// get the id
		$idValue = $functionId->getIdString();
		
		// now remove from database
		$dbHandler =& Services::getService("DatabaseManager");
		$dbt = $this->_authzDB.".az_function";

		$query =& new DeleteQuery();
		$query->setTable($dbt);
		$query->addWhere($dbt.".function_id = '".addslashes($idValue)."'");
		
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
	 * criteria. Null values are interpreted as wildmarks. Warning: $returnExplicitOnly = false
	 * will increase the running time significantly - USE SPARINGLY!
	 * @access public
	 * @param string aId The string id of an agent.
	 * @param string fId The string id of a function.
	 * @param string qId The string id of a qualifier. This parameter can not be null
	 * and used as a wildmark.
	 * @param object fType The type of a function.
	 * @param boolean returnExplicitOnly If True, only explicit Authorizations
	 *		will be returned.
	 * @param boolean searchUp If true, the ancester nodes of the qualifier will
	 *		be checked as well
	 * @param boolean isActiveNow If True, only active Authorizations will be returned.
	 * @return ref object An AuthorizationIterator.
	 **/
	function &getAZs($aId, $fId, $qId, $fType, $returnExplicitOnly, $searchUp, $isActiveNow, $groupIds = array()) {
// 		printpre (func_get_args());
		// ** parameter validation
		$rule =& StringValidatorRule::getRule();
		ArgumentValidator::validate($groupIds, ArrayValidatorRuleWithRule::getRule(OptionalRule::getRule($rule)), true);
		ArgumentValidator::validate($aId, OptionalRule::getRule($rule), true);
		ArgumentValidator::validate($fId, OptionalRule::getRule($rule), true);
		ArgumentValidator::validate($qId, OptionalRule::getRule($rule), true);
		ArgumentValidator::validate($fType, OptionalRule::getRule(ExtendsValidatorRule::getRule("Type")), true);
		ArgumentValidator::validate($returnExplicitOnly, BooleanValidatorRule::getRule(), true);
		ArgumentValidator::validate($isActiveNow,BooleanValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$idManager =& Services::getService("Id");
		
		// the parameter that influences the result most is $returnExplicitOnly
		// 1) If $returnExplicitOnly is TRUE, then we only need to check for Authorizations
		// that have been explicitly created, i.e. no need to look for inherited 
		// authorizations
		// 2) If $returnExplicitOnly is FALSE, then we need to include inherited Authorizations
		// as well.
		
		// this array will store the ids of all qualifiers to be checked for authorizations
		$qualifiers = array();
		// check all ancestors of given qualifier
		$hierarchyManager =& Services::getService("Hierarchy");

		if (isset($qId)) {
			$qualifierId =& $idManager->getId($qId);
			$node =& $hierarchyManager->getNode($qualifierId);
			$hierarchy =& $hierarchyManager->getHierarchyForNode($node);
		
			if ($searchUp) {
				// these are the ancestor nodes
				$nodes =& $hierarchy->traverse($qualifierId, Hierarchy::TRAVERSE_MODE_DEPTH_FIRST(),
						Hierarchy::TRAVERSE_DIRECTION_UP(), Hierarchy::TRAVERSE_LEVELS_ALL());
				
				// now get the id of each node and store in array
				while($nodes->hasNext()){
					$info =& $nodes->next();
					$id =& $info->getNodeId();
					$qualifiers[] = $id->getIdString();
				}
			} else {
				$qualifiers = array($qId);
			}
		}
//		print_r($qualifiers);
		
		// setup the query
		$dbHandler =& Services::getService("DatabaseManager");
		$db = $this->_authzDB.".";
		$query =& new SelectQuery();
		$query->addColumn("authorization_id", "id", $db."az_authorization");
		$query->addColumn("fk_agent", "aId", $db."az_authorization");
		$query->addColumn("fk_function", "fId", $db."az_authorization");
		$query->addColumn("fk_qualifier", "qId", $db."az_authorization");
		$query->addColumn("authorization_effective_date", "eff_date", $db."az_authorization");
		$query->addColumn("authorization_expiration_date", "exp_date", $db."az_authorization");

		$query->addTable($db."az_authorization");

		// now include criteria
		
		// the qualifiers criteria
		if (isset($qId)) {
			foreach (array_keys($qualifiers) as $key) {
				$qualifiers[$key] = addslashes($qualifiers[$key]);
			}
			$list = implode("','", $qualifiers);
			$list = "'".$list."'";
				
			$where = $db."az_authorization.fk_qualifier IN ($list)";
			$query->addWhere($where);
		}
		
		if (count($groupIds)) {
			$agentList = implode("','", $groupIds);
			$agentList = "'".$aId."','".$agentList."'";
		} else {
			$agentList = "'".$aId."'";
		}
		
		// the agent criteria
		if (isset($aId) || count($groupIds)) {
//			$joinc = $db."az_authorization.fk_agent = ".$db."agent.agent_id";
//			$query->addTable($db."agent", INNER_JOIN, $joinc);
			$where = $db."az_authorization.fk_agent IN ($agentList)";
			$query->addWhere($where);
		}
		// the function criteria
		if (isset($fId)) {
			$joinc = $db."az_authorization.fk_function = ".$db."az_function.function_id";
			$query->addTable($db."az_function", INNER_JOIN, $joinc);
			$where = $db."az_authorization.fk_function = '".addslashes($fId)."'";
			$query->addWhere($where);
		}
		// the function type criteria
		if (isset($fType)) {
			// do not join with az_function if we did already
			if (!isset($fId)) {
				$joinc = $db."az_authorization.fk_function = ".$db."az_function.function_id";
				$query->addTable($db."az_function", INNER_JOIN, $joinc);
			}
			// now join with type
			$joinc = $db."az_function.fk_type = ".$db."type.type_id";
			$query->addTable($db."type", INNER_JOIN, $joinc);
			
			$domain = $fType->getDomain();
			$authority = $fType->getAuthority();
			$keyword = $fType->getKeyword();
			
			$where = $db."type.type_domain = '".addslashes($domain)."'";
			$query->addWhere($where);
			$where = $db."type.type_authority = '".addslashes($authority)."'";
			$query->addWhere($where);
			$where = $db."type.type_keyword = '".addslashes($keyword)."'";
			$query->addWhere($where);
		}
		// the isActiveNow criteria
		if ($isActiveNow) {
			$where = "(ISNULL(authorization_effective_date) OR (NOW() >= authorization_effective_date))";
			$query->addWhere($where);
			$where = "(ISNULL(authorization_expiration_date) OR (NOW() < authorization_expiration_date))";
			$query->addWhere($where);
		}
		
		$query->addOrderBy("authorization_id");
		
//		echo "<pre>\n";
//		echo MySQL_SQLGenerator::generateSQLQuery($query);
//		echo "</pre>\n";
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// this array will store the authorizations that will be returned		
		$authorizations = array();
		
		// we only want to create one implicitAZ for a given Agent/Function/Qualifier
		// combo, so maintain a list of already created ones to skip
		$createdImplicitAZs = array();
		$i = 0;
		
		// process all rows and create the explicit authorizations
		while ($queryResult->hasMoreRows()) {
			$row = $queryResult->getCurrentRow();
			
// 			printpre($row);

			$idValue = $row['id'];
			$id =& $idManager->getId($idValue);
			if (isset($this->_authorizations[$idValue])) {
				$authorization =& $this->_authorizations[$idValue];
			}
			else {
				$agentId =& $idManager->getId($row['aId']);
				$functionId =& $idManager->getId($row['fId']);
				$explicitQualifierId =& $idManager->getId($row['qId']);
				$effectiveDate =& $dbHandler->fromDBDate($row['eff_date'], $this->_dbIndex);
				$expirationDate =& $dbHandler->fromDBDate($row['exp_date'], $this->_dbIndex);
				
				// create the explicit authorization (each explicit authorization
				// has a corresponding row in the authorization db table)
				$authorization =& new HarmoniAuthorization($idValue, $agentId, 
											$functionId, $explicitQualifierId,
											true, $this, 
											$effectiveDate, 
											$expirationDate);
				$this->_authorizations[$idValue] =& $authorization;
			}
			
			// Explicit AZ for ancestor qualifiers and groups should have 
			// corresponding implicit AZs
			// in decendents, but not appear in their AZs directly.
			// Therefore, only add the explicit AZ if it is for the requested
			// qualifier and agent if we are fetching more than just the explicitAZs.
			if (($row['qId'] == $qId && $row['aId'] == $aId) || $returnExplicitOnly)
				$authorizations[] =& $authorization;

			// now create the implicit authorizations
			// the implicit authorizations will be created for all nodes
			// on the hierarchy path(s) between the node with the explicit authorization
			// and the node on which getAZs() was called.
			// If the row's qualifier and agent are what we asked for however,
			// then the AZ is explicit and doesn't need an implicit AZ as well.
			if ((!$returnExplicitOnly || $searchUp)
				&& !($row['qId'] == $qId && $row['aId'] == $aId))
			{
// 				printpre("Building Implicit AZs...");
// 				var_dump($returnExplicitOnly);
// 				var_dump($searchUp);
			
				// if this is an AZ that is implicit because of a group instead
				// of because of the hierarchy, create it.
				if ($row['qId'] == $qId && $row['aId'] != $aId) {
// 					printpre("In first clause (AuthorizationCache)");
					$qualifierId =& $idManager->getId($qId);
					
					// If we are getting implicit AZs for a given agent, make sure
					// that the implicit AZ has their Id.
					if ($aId)
						$agentId =& $idManager->getId($aId);
					else
						$agentId =& $authorization->getAgentId();
					
					$function =& $authorization->getFunction();
					$functionId =& $function->getId();
					$effectiveDate = $authorization->getEffectiveDate();
					$expirationDate = $authorization->getExpirationDate();
					$implicit =& new HarmoniAuthorization(null, 
														$agentId, 
														$functionId, 
														$qualifierId,
														false, 
														$this, 
														$effectiveDate, 
														$expirationDate);
					
					$azHash = $agentId->getIdString()
								."::".$functionId->getIdString()
								."::".$qualifierId->getIdString();
					if (!in_array($azHash, $createdImplicitAZs)) {
						$authorizations[] =& $implicit;
						$createdImplicitAZs[] = $azHash;
					}
				}
				
				// Otherwise, do what is necessary to create the implicit qualifier
				// based on the hierarchy
				
				// If we have a $qid then our results must only have been for it.
				// This means that if we got here, we have an authorization in
				// an ancestor somewhere, so we can savly return an implicit AZ.
				else if (!$returnExplicitOnly && $qId) {
// 					printpre("In second clause (AuthorizationCache)");
					
					// If we are getting implicit AZs for a given agent, make sure
					// that the implicit AZ has their Id.
					if ($aId)
						$agentId =& $idManager->getId($aId);
					else
						$agentId =& $authorization->getAgentId();
						
					$function =& $authorization->getFunction();
					$functionId =& $function->getId();
					$effectiveDate = $authorization->getEffectiveDate();
					$expirationDate = $authorization->getExpirationDate();
					
					$implicitQualifierId =& $idManager->getId($qId);
					$implicit =& new HarmoniAuthorization(null, $agentId, 
										$functionId, $implicitQualifierId,
										false, $this, $effectiveDate, 
										$expirationDate);
					
					$azHash = $agentId->getIdString()
								."::".$functionId->getIdString()
								."::".$implicitQualifierId->getIdString();
					if (!in_array($azHash, $createdImplicitAZs)) {
						$authorizations[] =& $implicit;
						$createdImplicitAZs[] = $azHash;
					}
					
				} 
				
				// If we are are just asking for all authorizations, not with
				// a particular qualifier, then we must build a hierarchy down
				// to make implicit qualifiers for the decendents of the 
				// explicit qualifier
				else if (!$returnExplicitOnly) {
					printpre($row);
					
					
					printpre("In third clause (AuthorizationCache)");
	
					$explicitQualifier =& $authorization->getQualifier();
					$explicitQualifierId =& $explicitQualifier->getId();
	
					// If we are getting implicit AZs for a given agent, make sure
					// that the implicit AZ has their Id.
					if ($aId)
						$agentId =& $idManager->getId($aId);
					else
						$agentId =& $authorization->getAgentId();
						
					$function =& $authorization->getFunction();
					$functionId =& $function->getId();
					$effectiveDate = $authorization->getEffectiveDate();
					$expirationDate = $authorization->getExpirationDate();
	
					// this is set 2
					$authZManager =& Services::getService("AuthZ");
					$hierarchies =& $authZManager->getQualifierHierarchies();
					
					while($hierarchies->hasNext()) {
						$hierarchyId =& $hierarchies->next();
						$hierarchy =& $hierarchyManager->getHierarchy($hierarchyId);
$timer =& new Timer;
$timer->start();						
						$nodes =& $hierarchy->traverse(
							$explicitQualifierId, 
							Hierarchy::TRAVERSE_MODE_DEPTH_FIRST(),
							Hierarchy::TRAVERSE_DIRECTION_DOWN(),
							Hierarchy::TRAVERSE_LEVELS_ALL());
$timer->end();
printf("LoadAZTime: %1.6f <br/>", $timer->printTime());
								
						// now get the id of each node and store in array
						$set2 = array();
						// skip the first node
						$nodes->next();
						while($nodes->hasNext()){
							$info =& $nodes->next();
							$nodeId =& $info->getNodeId();
							$implicit =& new HarmoniAuthorization(null, $agentId, 
												$functionId, $nodeId,
												false, $this, $effectiveDate, 
												$expirationDate);
							$azHash = $agentId->getIdString()
										."::".$functionId->getIdString()
										."::".$nodeId->getIdString();
// 							printpre($azHash);
							// Weird bugs were happening, with $createdImplicitAZs
							// but I can't figure out what is going on.
							if (!in_array($azHash, $createdImplicitAZs)) {
								$authorizations[] =& $implicit;
// 								$createdImplicitAZs[] = $azHash;
							}
							
						}
					}
				}
			}
			
			$queryResult->advanceRow();
		}
		$queryResult->free();
		
		return $authorizations;
	}
		
}

?>