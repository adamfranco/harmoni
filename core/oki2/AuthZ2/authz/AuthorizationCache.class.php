<?php

require_once(dirname(__FILE__).'/FunctionIterator.class.php');

/**
 * This class provides a mechanism for caching different authorization components and
 * also acts as an interface between the datastructures and the database.
 *
 * @package harmoni.osid_v2.authorization
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AuthorizationCache.class.php,v 1.1 2008/04/24 20:51:42 adamfranco Exp $
 */
class AuthZ2_AuthorizationCache {

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
	 * Constructor
	 * @access protected
	 */
	function __construct(AuthorizationManager $manager, $dbIndex, $harmoni_db = null) {
		// ** argument validation **
		ArgumentValidator::validate($dbIndex, IntegerValidatorRule::getRule(), true);
		// ** end of argument validation **
		
		$this->authorizationManager = $manager;
		$this->_dbIndex = $dbIndex;
		$this->_qualifiers = array();
		$this->_functions = array();
		$this->_authorizations = array();
		
		if (!is_null($harmoni_db)) {
			ArgumentValidator::validate($harmoni_db, ExtendsValidatorRule::getRule('Zend_Db_Adapter_Abstract'));
			$this->harmoni_db = $harmoni_db;
		}
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
	function createAuthorization(Id $agentId, Id $functionId, Id $qualifierId, $effectiveDate = NULL, $expirationDate = NULL) {
		// ** parameter validation
		ArgumentValidator::validate($effectiveDate, OptionalRule::getRule(IntegerValidatorRule::getRule()), true);
		ArgumentValidator::validate($expirationDate, OptionalRule::getRule(IntegerValidatorRule::getRule()), true);
		// ** end of parameter validation
		
		// create the authorization object
		$idManager = Services::getService("Id");
		$id =$idManager->createId();
		$idValue = $id->getIdString();
		// figure out whether it's dated or not
		$dated = isset($effectiveDate) && isset($expirationDate);
		if ($dated)
			$authorization = new AuthZ2_Authorization($idValue, $agentId, $functionId, $qualifierId, true, $this, $effectiveDate, $expirationDate);
		else													 
			$authorization = new AuthZ2_Authorization($idValue, $agentId, $functionId, $qualifierId,true, $this);
		
		$dbHandler = Services::getService("DatabaseManager");
		
		if (isset($this->harmoni_db)) {
			if (!isset($this->createAZ_stmt)) {
				$query = $this->harmoni_db->insert();
				$query->setTable("az2_explicit_az");
				$query->addRawValue("id", "?");
				$query->addRawValue("fk_agent", "?");
				$query->addRawValue("fk_function", "?");
				$query->addRawValue("fk_qualifier", "?");
				$query->addRawValue("effective_date", "?");
				$query->addRawValue("expiration_date", "?");
				$this->createAZ_stmt = $query->prepare();
			}
			$this->createAZ_stmt->bindValue(1, $idValue);
			$this->createAZ_stmt->bindValue(2, $agentId->getIdString());
			$this->createAZ_stmt->bindValue(3, $functionId->getIdString());
			$this->createAZ_stmt->bindValue(4, $qualifierId->getIdString());
			if (is_object($effectiveDate))
				$this->createAZ_stmt->bindValue(5, 
					$dbHandler->toDBDate($effectiveDate, $this->_dbIndex));
			else
				$this->createAZ_stmt->bindValue(5, null);
			if (is_object($expirationDate))
				$this->createAZ_stmt->bindValue(6, 
					$dbHandler->toDBDate($expirationDate, $this->_dbIndex));
			else
				$this->createAZ_stmt->bindValue(6, null);
			
			$this->createAZ_stmt->execute();
		} else {
			// now insert into database
			$dbHandler = Services::getService("DatabaseManager");
			
			$query = new InsertQuery();
			$query->setTable("az2_explicit_az");
			$columns = array();
			$columns[] = "id";
			$columns[] = "fk_agent";
			$columns[] = "fk_function";
			$columns[] = "fk_qualifier";
			if ($dated) {
				$columns[] = "effective_date";
				$columns[] = "expiration_date";
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
			
			$dbHandler->query($query, $this->_dbIndex);
		}

		$this->_authorizations[$idValue] =$authorization;
		
		$this->createImplicitAZsForAZ($authorization);

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
	function createFunction($functionId, $displayName, $description, $functionType, $qualifierHierarchyId) {
		// ** parameter validation
		ArgumentValidator::validate($functionId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($displayName, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($description, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($functionType, ExtendsValidatorRule::getRule("Type"), true);
		ArgumentValidator::validate($qualifierHierarchyId, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation
		
		// create the Function object
		$idManager = Services::getService("Id");
		$function = new AuthZ2_Function($functionId, $displayName, $description, 
										 $functionType, $qualifierHierarchyId,
										 $this->_dbIndex);
		
		// now insert into database
		$dbHandler = Services::getService("DatabaseManager");
		$idValue = $functionId->getIdString();

		// 1. Insert the type
		
		$domain = $functionType->getDomain();
		$authority = $functionType->getAuthority();
		$keyword = $functionType->getKeyword();
		$functionTypeDescription = $functionType->getDescription();

		// check whether the type is already in the DB, if not insert it
		$query = new SelectQuery();
		$query->addTable("az2_function_type");
		$query->addColumn("id");
		$query->addWhereEqual('domain', $domain);
		$query->addWhereEqual('authority', $authority);
		$query->addWhereEqual('keyword', $keyword);

		$queryResult =$dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() > 0) {// if the type is already in the database
			$functionTypeIdValue = $queryResult->field("id"); // get the id
			$queryResult->free();
		} else { // if not, insert it
			$query = new InsertQuery();
			$query->setTable("az2_function_type");
			$query->setAutoIncrementColumn("id", "az2_function_type_id_seq");
			$query->addValue("domain", $domain);
			$query->addValue("authority", $authority);
			$query->addValue("keyword", $keyword);
			$query->addValue("description", $functionTypeDescription);

			$queryResult = $dbHandler->query($query, $this->_dbIndex);
			$functionTypeIdValue = $queryResult->getLastAutoIncrementValue();
		}
		
		// 2. Now that we know the id of the type, insert in the DB
		try {
			$query = new InsertQuery();
			$query->setTable("az2_function");
			$query->addValue("id", $idValue);
			$query->addValue("reference_name", $displayName);
			$query->addValue("description", $description);
			$query->addValue("fk_qualifier_hierarchy", $qualifierHierarchyId->getIdString());
			$query->addValue("fk_type", $functionTypeIdValue);
			
			$queryResult =$dbHandler->query($query, $this->_dbIndex);
			if ($queryResult->getNumberOfRows() != 1) {
				throw new OperationFailedException("AuthorizationFunction, $functionId, could not be inserted. ");
			}
		} catch (DuplucateKeyDatabaseException $e) {
			throw new OperationFailedException("AuthorizationFunction, $functionId, already exists.");
		}

		$this->_functions[$idValue] =$function;

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
	function createRootQualifier($qualifierId, $displayName, $description, $qualifierType, $qualifierHierarchyId) {
		// ** parameter validation
		ArgumentValidator::validate($qualifierId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($displayName, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($description, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($qualifierType, ExtendsValidatorRule::getRule("Type"), true);
		ArgumentValidator::validate($qualifierHierarchyId, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation

		// create the node for the qualifier		
		$hierarchyManager = $this->authorizationManager->getHierarchyManager();
		$hierarchy =$hierarchyManager->getHierarchy($qualifierHierarchyId);
		$node =$hierarchy->createRootNode($qualifierId, $qualifierType, $displayName, $description);

		// now create the qualifier
		$qualifier = new AuthZ2_Qualifier($node, $this);
		
		// and cache it
		$this->_qualifiers[$qualifierId->getIdString()] =$qualifier;
		
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
	function createQualifier($qualifierId, $displayName, $description, $qualifierType, $parentId) {
		// ** parameter validation
		ArgumentValidator::validate($qualifierId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($displayName, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($description, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($qualifierType, ExtendsValidatorRule::getRule("Type"), true);
		ArgumentValidator::validate($parentId, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation

		// create the node for the qualifier		
		$hierarchyManager = $this->authorizationManager->getHierarchyManager();
		
		// get the hierarchy id from the node
		$parentNode =$hierarchyManager->getNode($parentId);
		// now get the hierarchy and create the node
		$hierarchy =$hierarchyManager->getHierarchyForNode($parentNode);
		$node =$hierarchy->createNode($qualifierId, $parentId, $qualifierType, $displayName, $description);

		// now create the qualifier
		$qualifier = new AuthZ2_Qualifier($node, $this);
		
		// and cache it
		$this->_qualifiers[$qualifierId->getIdString()] =$qualifier;
		
		return $qualifier;
	}
	
	/**
	 * Get all the Function of the specified Type.
	 * @param ref object functionType the Type of the Functions to return
	 * @return ref object FunctionIterator
	 */
	function getFunctionTypes() {
		if (!isset($this->_functionTypes)) {
			
			$dbHandler = Services::getService("DatabaseManager");
						
			$query = new SelectQuery();
			$query->addColumn("domain");
			$query->addColumn("authority");
			$query->addColumn("keyword");
			$query->addColumn("description", "type_description", "az2_function_type");
			
			$query->addTable("az2_function");
			$joinc = "fk_type = "."az2_function_type.id";
			$query->addTable("az2_function_type", INNER_JOIN, $joinc);
			
			$query->setGroupBy(array("domain", "authority", "keyword", "type_description"));
	
			$queryResult =$dbHandler->query($query, $this->_dbIndex);
			
			$this->_functionTypes = array();
			
			while ($queryResult->hasMoreRows()) {
				$row = $queryResult->getCurrentRow();
	//			echo "<pre>";
	//			print_r($row);
	//			echo "</pre>";
				
				$this->_functionTypes[] = new HarmoniType($row['domain'], $row['authority'], 
										 $row['keyword'], $row['type_description']);
	
				$queryResult->advanceRow();
			}
			$queryResult->free();
		}
		
		$obj = new HarmoniTypeIterator($this->_functionTypes);
		return $obj;
	}

	/**
	 * Get all the Function of the specified Type.
	 * @param ref object functionType the Type of the Functions to return
	 * @return ref object FunctionIterator
	 */
	function getFunctions($functionType) {
		// ** parameter validation
		ArgumentValidator::validate($functionType, ExtendsValidatorRule::getRule("Type"), true);
		// ** end of parameter validation

		$typeString = $functionType->asString();
		if (!isset($this->_functions) || !isset($this->_functions[$typeString])) {			
			if (!isset($this->_functions))
				$this->_functions = array();
				
			$this->_functions[$typeString] = array();
			
			
			$dbHandler = Services::getService("DatabaseManager");
			
			$query = new SelectQuery();
			$query->addColumn("id", "id", "az2_function");
			$query->addColumn("reference_name");
			$query->addColumn("description", "description", "az2_function");
			$query->addColumn("fk_qualifier_hierarchy", "hierarchy_id");
			$query->addColumn("domain");
			$query->addColumn("authority");
			$query->addColumn("keyword");
			$query->addColumn("description", "type_description", "az2_function_type");
			$query->addTable("az2_function");
			$joinc = "fk_type = "."az2_function_type.id";
			$query->addTable("az2_function_type", INNER_JOIN, $joinc);
			$query->addWhereEqual("domain", $functionType->getDomain());
			$query->addWhereEqual("authority", $functionType->getAuthority());
			$query->addWhereEqual("keyword", $functionType->getKeyword());
			
			$queryResult =$dbHandler->query($query, $this->_dbIndex);

			
			while ($queryResult->hasMoreRows()) {
				$row = $queryResult->getCurrentRow();
	//			echo "<pre>";
	//			print_r($row);
	//			echo "</pre>";
				
				$idValue = $row['id'];
				if (isset($this->_functions[$idValue])) {
					$function =$this->_functions[$idValue];
				}
				else {
					$type = new HarmoniType($row['domain'], $row['authority'], 
											 $row['keyword'], $row['type_description']);
					$idManager = Services::getService("Id");
					$functionId =$idManager->getId($row['id']);
					$hierarchyId =$idManager->getId($row['hierarchy_id']);
					$function = new AuthZ2_Function($functionId, $row['reference_name'],
													 $row['description'], $type, $hierarchyId ,
													 $this->_dbIndex);
	
					$this->_functions[$idValue] =$function;
				}
	
				$this->_functions[$typeString][] =$function;
				$queryResult->advanceRow();
			}
			$queryResult->free();
		}
		$obj = new AuthZ2_FunctionIterator($this->_functions[$typeString]);
		return $obj;
	}


	/**
	 * Returns the Function with the specified id.
	 * @access public
	 * @param string id The id of the function.
	 * @return ref object The Function with the specified id.
	 **/
	function getFunction($idValue) {
		// ** parameter validation
		ArgumentValidator::validate($idValue, StringValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		if (isset($this->_functions[$idValue]))
			return $this->_functions[$idValue];

		$dbHandler = Services::getService("DatabaseManager");
		
		$query = new SelectQuery();
		$query->addColumn("id", "id", "az2_function");
		$query->addColumn("reference_name");
		$query->addColumn("description", "description", "az2_function");
		$query->addColumn("fk_qualifier_hierarchy", "hierarchy_id");
		$query->addColumn("domain");
		$query->addColumn("authority");
		$query->addColumn("keyword");
		$query->addColumn("description", "type_description", "az2_function_type");
		$query->addTable("az2_function");
		$joinc = "fk_type = az2_function_type.id";
		$query->addTable("az2_function_type", INNER_JOIN, $joinc);
		$query->addWhereEqual("az2_function.id", $idValue);
		
		$queryResult =$dbHandler->query($query, $this->_dbIndex);
		
		if ($queryResult->getNumberOfRows() != 1) {
			$num = $queryResult->getNumberOfRows();
			$queryResult->free();
			throw new UnknownIdException("Expecting exactly one row, found ".$num);
		}
		
		$row = $queryResult->getCurrentRow();
		$queryResult->free();
		$type = new HarmoniType($row['domain'], $row['authority'], 
								 $row['keyword'], $row['type_description']);
		
		
		$idManager = Services::getService("Id");
		$functionId =$idManager->getId($row['id']);
		$hierarchyId =$idManager->getId($row['hierarchy_id']);
		$function = new AuthZ2_Function($functionId, $row['reference_name'],
										 $row['description'], $type, $hierarchyId ,
										 $this->_dbIndex);
		
		$this->_functions[$idValue] =$function;
		
		return $function;
	}
	
	
	/**
	 * Returns the Qualifier with the specified id.
	 * @access public
	 * @param string id The id of the Qualifier .
	 * @return ref object The Qualifier with the specified id.
	 **/
	function getQualifier($qualifierId) {
		// ** parameter validation
		ArgumentValidator::validate($qualifierId, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation
		
		$idValue = $qualifierId->getIdString();

		if (isset($this->_qualifiers[$idValue]))
			return $this->_qualifiers[$idValue];

		// get the node for the qualifier		
		$hierarchyManager = $this->authorizationManager->getHierarchyManager();
		$node =$hierarchyManager->getNode($qualifierId);
		// now create the qualifier
		$qualifier = new AuthZ2_Qualifier($node, $this);
		
		$this->_qualifiers[$idValue] =$qualifier;
		
		return $qualifier;

	}
	
	/**
	 * Given a QualifierHierarchy Id, returns the Qualifier that is the root of 
	 * the tree of Qualifiers of this Type.
	 *
	 * @param object qualifierHierarchyId
	 * @return object QualifierIterator
	 */
	function getRootQualifiers($qualifierHierarchyId) {
		$hierarchyManager = $this->authorizationManager->getHierarchyManager();
		$hierarchy =$hierarchyManager->getHierarchy($qualifierHierarchyId);
		
		// create an array for our qualifiers
		$qualifiers = array();
		
		// Get the qualifier for each node
		$nodes =$hierarchy->getRootNodes();
		while ($nodes->hasNext()) {
			$node =$nodes->next();
			$nodeId =$node->getId();
			
			// Make sure that we have a qualifier for this node.
			if (!isset($this->_qualifiers[$nodeId->getIdString()])) {
				$this->_qualifiers[$nodeId->getIdString()] = new AuthZ2_Qualifier($node, $this);
			}
			
			$qualifiers[] =$this->_qualifiers[$nodeId->getIdString()];
		}
		
		$obj = new AuthZ2_QualifierIterator($qualifiers);
		
		return $obj;
	}

	
	/**
	 * Returns the Qualifier with the specified id.
	 * @access public
	 * @param string id The id of the Qualifier .
	 * @return ref object The Qualifier with the specified id.
	 **/
	function getQualifierDescendants(Id $qualifierId) {		
		$idValue = $qualifierId->getIdString();

		// get the descendant nodes
		$hierarchyManager = $this->authorizationManager->getHierarchyManager();
		$node = $hierarchyManager->getNode($qualifierId);
		$hierarchy = $hierarchyManager->getHierarchyForNode($node);
		$nodes = $hierarchy->traverse($qualifierId, Hierarchy::TRAVERSE_MODE_DEPTH_FIRST, 
										Hierarchy::TRAVERSE_DIRECTION_DOWN, Hierarchy::TRAVERSE_LEVELS_ALL);

		// create the qualifiers
		$qualifiers = array();
		// get rid of the root node (it is not a descendant)
		$nodes->next();
		while ($nodes->hasNext()) {
			$node = $nodes->next();
			$nodeId = $node->getNodeId();
			$idValue = $nodeId->getIdString();
			
			if (isset($this->_qualifiers[$idValue]))
				$qualifier =$this->_qualifiers[$idValue];
			else {
				$qualifier = new AuthZ2_Qualifier($hierarchy->getNode($nodeId), $this);
				$this->_qualifiers[$idValue] =$qualifier;
			}
			
			$qualifiers[] =$qualifier;
		}

		$obj = new AuthZ2_QualifierIterator($qualifiers);

		return $obj;
	}


	/**
	 * Deletes the given Authorization.
	 * @access public
	 * @param ref object authorization The Authorization to delete.
	 **/
	function deleteAuthorization($authorization) {
		// ** parameter validation
		ArgumentValidator::validate($authorization, ExtendsValidatorRule::getRule("Authorization"), true);
		// ** end of parameter validation
		
//		echo "<pre>\n";
//		print_r($authorization);
//		echo "</pre>\n";

		// get the id
		$idValue = $authorization->_id;
		
		// now remove from database
		$dbHandler = Services::getService("DatabaseManager");

		$query = new DeleteQuery();
		$query->setTable("az2_explicit_az");
		$query->addWhereEqual("id", $idValue);
		
		$queryResult =$dbHandler->query($query, $this->_dbIndex);
		
		if ($queryResult->getNumberOfRows() != 1) {
			$err = "Zero or more than one Authorization were deleted (must have been exactly one).";
			throwError(new Error($err, "authorizarion", true));
		}
		
		// update cache
		$this->_authorizations[$idValue] = null;
		unset($this->_authorizations[$idValue]);
		
		// No need to delete Implicit AZs as they will be dropped by the database
		// foreign-key constraints.
	}
	
	
	/**
	 * Deletes the given Authorization.
	 * @access public
	 * @param ref object authorization The Authorization to delete.
	 **/
	function deleteQualifier($qualifierId) {
		// ** parameter validation
		ArgumentValidator::validate($qualifierId, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation

		// get the id
		$idValue = $qualifierId->getIdString();

		// create the node for the qualifier		
		$hierarchyManager = $this->authorizationManager->getHierarchyManager();

		$node =$hierarchyManager->getNode($qualifierId);
		$hierarchy =$hierarchyManager->getHierarchyForNode($node);
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
	function deleteFunction($functionId) {
		// ** parameter validation
		ArgumentValidator::validate($functionId, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation

		// get the id
		$idValue = $functionId->getIdString();
		
		// now remove from database
		$dbHandler = Services::getService("DatabaseManager");

		$query = new DeleteQuery();
		$query->setTable("az2_function");
		$query->addWhereEqual("id", $idValue);
		
		$queryResult =$dbHandler->query($query, $this->_dbIndex);
		
		if ($queryResult->getNumberOfRows() != 1) {
			$err = "Zero or more than one function were deleted (must have been exactly one).";
			throwError(new Error($err, "authorizarion", true));
		}
		
		// update cache
		$this->_functions[$idValue] = null;
		unset($this->_functions[$idValue]);
	}
	
	/**
	 * Answer an explicit AZ by id-string
	 * 
	 * @param string $idString
	 * @return object Authorization
	 * @access public
	 * @since 4/22/08
	 */
	public function getExplicitAZById ($idString) {
		$idManager = Services::getService("Id");
		$id = $idManager->getId($idString);
		if (!isset($this->_authorizations[$idString])) {
			
			$dbHandler = Services::getService("DatabaseManager");
			$query = new SelectQuery();
			$query->addColumn("fk_agent", "aid");
			$query->addColumn("fk_function", "fid");
			$query->addColumn("fk_qualifier", "qid");
			$query->addColumn("effective_date", "eff_date");
			$query->addColumn("expiration_date", "exp_date");
	
			$query->addTable("az2_explicit_az");
			$query->addWhereEqual("id", $idString);
			
			$result = $dbHandler->query($query, $this->_dbIndex);
			if (!$result->hasNext())
				throw new UnknownIdException("Could not find explicit AZ with id, '$idString'.");
			$row = $result->next();
			
			$agentId = $idManager->getId($row['aid']);
			$functionId =$idManager->getId($row['fid']);
			$explicitQualifierId =$idManager->getId($row['qid']);
			$effectiveDate =$dbHandler->fromDBDate($row['eff_date'], $this->_dbIndex);
			$expirationDate =$dbHandler->fromDBDate($row['exp_date'], $this->_dbIndex);
			
			// create the explicit authorization (each explicit authorization
			// has a corresponding row in the authorization db table)
			$authorization = new AuthZ2_Authorization($idString, $agentId, 
										$functionId, $explicitQualifierId,
										true, $this, 
										$effectiveDate, 
										$expirationDate);
			$this->_authorizations[$idString] = $authorization;
		}
		
		return $this->_authorizations[$idString];
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
	 * @param boolean isActiveNow If True, only active Authorizations will be returned.
	 * @return array
	 **/
	function getAZs($aId, $fId, $qId, $fType, $returnExplicitOnly, $isActiveNow, $groupIds = array()) {
// 		printpre (func_get_args());
		// ** parameter validation
		$rule = StringValidatorRule::getRule();
		ArgumentValidator::validate($groupIds, ArrayValidatorRuleWithRule::getRule(OptionalRule::getRule($rule)), true);
		ArgumentValidator::validate($aId, OptionalRule::getRule($rule), true);
		ArgumentValidator::validate($fId, OptionalRule::getRule($rule), true);
		ArgumentValidator::validate($qId, OptionalRule::getRule($rule), true);
		ArgumentValidator::validate($fType, OptionalRule::getRule(ExtendsValidatorRule::getRule("Type")), true);
		ArgumentValidator::validate($returnExplicitOnly, BooleanValidatorRule::getRule(), true);
		ArgumentValidator::validate($isActiveNow,BooleanValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$idManager = Services::getService("Id");
		
		// the parameter that influences the result most is $returnExplicitOnly
		// 1) If $returnExplicitOnly is TRUE, then we only need to check for Authorizations
		// that have been explicitly created, i.e. no need to look for inherited 
		// authorizations
		// 2) If $returnExplicitOnly is FALSE, then we need to include inherited Authorizations
		// as well.
		
		// Agents/Groups
		if (isset($aId))
			$agentIds = array($aId);
		else
			$agentIds = array();
		$allAgentIds = array_merge($agentIds, $groupIds);
		
		$explicitQueryResult = $this->getExplicitAZQueryResult($allAgentIds, $fId, $qId, $fType, $isActiveNow);
		
		if ($returnExplicitOnly) {
			return $this->getAuthorizationsFromQueryResult($explicitQueryResult, $aId, $qId, $returnExplicitOnly);
		} else {
			$implicitQueryResult = $this->getImplicitAZQueryResult($allAgentIds, $fId, $qId, $fType, $isActiveNow);		
				
			return array_merge(
				$this->getAuthorizationsFromQueryResult($explicitQueryResult, $aId, $qId, $returnExplicitOnly),
				$this->getAuthorizationsFromQueryResult($implicitQueryResult, $aId, $qId, $returnExplicitOnly));
		}
	}
	
	var $shouldAvoidPdoBug = array();
	/**
	 * This is a temporary work-around for bug 1970447:
	 * https://sourceforge.net/tracker/index.php?func=detail&aid=1970447&group_id=82171&atid=565234
	 * 
	 *  A PHP/PDO bug is resulting in problems when escaped quotes exist in an SQL 
	 *  tring that is then prepared.
	 *  
	 *  See: http://slug.middlebury.edu/~afranco/PHP_PDO_segfault/
	 *  See: http://bugs.php.net/bug.php?id=41125
	 * 
	 * @param array $agentIds
	 * @return boolean
	 * @access private
	 * @since 5/23/08
	 */
	private function avoidPdoBug (array $agentIds) {
		foreach ($agentIds as $id) {
			if (strpos($id, "'") !== false) {
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Answer an ExplicitAZ query result for a set of agentIds, function, qualifiery, type,
	 * and active-setting.
	 * 
	 * @param array $agentIds The string id of an agent.
	 * @param string $fId The string id of a function.
	 * @param string $qId The string id of a qualifier. This parameter can not be null
	 * and used as a wildmark.
	 * @param object $fType The type of a function.
	 * @param boolean $isActiveNow If True, only active Authorizations will be returned.
	 * @return object SelectQueryResultInterface
	 * @access protected
	 * @since 7/11/08
	 */
	protected function getExplicitAZQueryResult (array $agentIds, $fId, $qId, $fType, $isActiveNow) {
		// This is a temporary work-around for bug 1970447:
		// https://sourceforge.net/tracker/index.php?func=detail&aid=1970447&group_id=82171&atid=565234
		// 
		// A PHP/PDO bug is resulting in problems when escaped quotes exist in an SQL 
		// tring that is then prepared.
		// 
		// See: http://slug.middlebury.edu/~afranco/PHP_PDO_segfault/
		// See: http://bugs.php.net/bug.php?id=41125
		if ($this->avoidPdoBug($agentIds)) {
			$dbHandler = Services::getService("DatabaseManager");
			$query = $this->getExplicitAZQuery($agentIds, $fId, $qId, $fType, $isActiveNow);
			return $dbHandler->query($query, $this->_dbIndex);
		}
		// Normal Case
		
		
		if (isset($this->harmoni_db)) {
			$statement = $this->getExplicitAZQueryStatement($agentIds, $fId, $qId, $fType, $isActiveNow);
			$statement->execute();
			return $statement->getResult();
		} else {
			$dbHandler = Services::getService("DatabaseManager");
			$query = $this->getExplicitAZQuery($agentIds, $fId, $qId, $fType, $isActiveNow);
			return $dbHandler->query($query, $this->_dbIndex);
		}
	}
	
	/**
	 * Answer an ExplicitAZ query result for a set of agentIds, function, qualifiery, type,
	 * and active-setting.
	 * 
	 * @param array $agentIds The string id of an agent.
	 * @param string $fId The string id of a function.
	 * @param string $qId The string id of a qualifier. This parameter can not be null
	 * and used as a wildmark.
	 * @param object $fType The type of a function.
	 * @param boolean $isActiveNow If True, only active Authorizations will be returned.
	 * @return object SelectQueryResultInterface
	 * @access protected
	 * @since 7/11/08
	 */
	protected function getImplicitAZQueryResult (array $agentIds, $fId, $qId, $fType, $isActiveNow) {
		// This is a temporary work-around for bug 1970447:
		// https://sourceforge.net/tracker/index.php?func=detail&aid=1970447&group_id=82171&atid=565234
		// 
		// A PHP/PDO bug is resulting in problems when escaped quotes exist in an SQL 
		// tring that is then prepared.
		// 
		// See: http://slug.middlebury.edu/~afranco/PHP_PDO_segfault/
		// See: http://bugs.php.net/bug.php?id=41125
		if ($this->avoidPdoBug($agentIds)) {
			$dbHandler = Services::getService("DatabaseManager");
			$query = $this->getImplicitAZQuery($agentIds, $fId, $qId, $fType, $isActiveNow);
			return $dbHandler->query($query, $this->_dbIndex);
		}
		// Normal Case
		
		
		if (isset($this->harmoni_db)) {
			$statement = $this->getImplicitAZQueryStatement($agentIds, $fId, $qId, $fType, $isActiveNow);
			$statement->execute();
			return $statement->getResult();
		} else {
			$dbHandler = Services::getService("DatabaseManager");
			$query = $this->getImplicitAZQuery($agentIds, $fId, $qId, $fType, $isActiveNow);
			return $dbHandler->query($query, $this->_dbIndex);
		}
	}
	
	/**
	 * Answer the Harmoni_Db statement for an Explicit AZ query
	 * 
	 * @param array $agentIds The string id of an agent.
	 * @param string $fId The string id of a function.
	 * @param string $qId The string id of a qualifier. This parameter can not be null
	 * and used as a wildmark.
	 * @param object $fType The type of a function.
	 * @return Harmoni_Db_Statement
	 * @access protected
	 * @since 7/11/08
	 */
	protected function getExplicitAZQueryStatement (array $agentIds, $fId, $qId, $fType, $isActiveNow) {
		// 			$fType = new Type('Authorization', 'edu.middlebury.harmoni', 'View/Use'); // debug
		
		if (!isset($this->getExplicitAZQueryResult_stmts))
				$this->getExplicitAZQueryResult_stmts = array();
		
		$queryKey = 'Query';
		if (count($agentIds))
			$queryKey .= ', with Agents: '.implode(' ', $agentIds);
		if ($qId)
			$queryKey .= ', with qId';
		if ($fId)
			$queryKey .= ', with fId';
		if ($fType)
			$queryKey .= ', with fType';
		if ($isActiveNow)
			$queryKey .= ', active';
		
		// Create the statement
		if (!isset($this->getExplicitAZQueryResult_stmts[$queryKey])) {
			$query = $this->harmoni_db->select();
			$query->addColumn("id", "id", "az2_explicit_az");
			$query->addColumn("fk_agent", "aid");
			$query->addColumn("fk_function", "fid");
			$query->addColumn("fk_qualifier", "qid");
			$query->addColumn("effective_date", "eff_date");
			$query->addColumn("expiration_date", "exp_date");
	
			$query->addTable("az2_explicit_az");
			
			if (count($agentIds))
				$query->addWhereIn('fk_agent', $agentIds);
				
			if ($qId)
				$query->addWhere($this->harmoni_db->quoteIdentifier('fk_qualifier').' = :qId');
				
			if ($fId)
				$query->addWhere($this->harmoni_db->quoteIdentifier('fk_function').' = :fId');
				
			if ($fType) {
				$subQuery = $this->harmoni_db->select();
				$subQuery->addColumn("az2_function.id");
				$subQuery->addTable("az2_function_type");
				$subQuery->addTable("az2_function", INNER_JOIN, 'az2_function_type.id = az2_function.fk_type');
				$subQuery->addWhere($this->harmoni_db->quoteIdentifier('domain').' = :domain');
				$subQuery->addWhere($this->harmoni_db->quoteIdentifier('authority').' = :authority');
				$subQuery->addWhere($this->harmoni_db->quoteIdentifier('keyword').' = :keyword');
				
				$query->addWhere($this->harmoni_db->quoteIdentifier('fk_function').' IN ('.$subQuery.')');
// 					$query->addWhere('fk_function.id', $subQuery);
			}
			
			// the isActiveNow criteria
			if ($isActiveNow) {
				$where = "(effective_date IS NULL OR (NOW() >= effective_date))";
				$query->addWhere($where);
				$where = "(expiration_date IS NULL OR (NOW() < expiration_date))";
				$query->addWhere($where);
			}
			
			$query->addOrderBy("az2_explicit_az.id");
			
// 			printpre($query->asString()); 
// 				throw new Exception('debug');
			
			$this->getExplicitAZQueryResult_stmts[$queryKey] = $query->prepare();
		}
		
		// Bind the params
		if ($qId)
			$this->getExplicitAZQueryResult_stmts[$queryKey]->bindValue(':qId', $qId);
		if ($fId)
			$this->getExplicitAZQueryResult_stmts[$queryKey]->bindValue(':fId', $fId);
		if ($fType) {
			$this->getExplicitAZQueryResult_stmts[$queryKey]->bindValue(':domain', $fType->getDomain());
			$this->getExplicitAZQueryResult_stmts[$queryKey]->bindValue(':authority', $fType->getDomain());
			$this->getExplicitAZQueryResult_stmts[$queryKey]->bindValue(':keyword', $fType->getDomain());
		}
		
		return $this->getExplicitAZQueryResult_stmts[$queryKey];
	}
	
	/**
	 * Answer the Harmoni_Db statement for an Implicit AZ query
	 * 
	 * @param array $agentIds The string id of an agent.
	 * @param string $fId The string id of a function.
	 * @param string $qId The string id of a qualifier. This parameter can not be null
	 * and used as a wildmark.
	 * @param object $fType The type of a function.
	 * @return Harmoni_Db_Statement
	 * @access protected
	 * @since 7/11/08
	 */
	protected function getImplicitAZQueryStatement (array $agentIds, $fId, $qId, $fType, $isActiveNow) {
		// 			$fType = new Type('Authorization', 'edu.middlebury.harmoni', 'View/Use'); // debug
		
		if (!isset($this->getImplicitAZQueryResult_stmts))
				$this->getImplicitAZQueryResult_stmts = array();
		
		$queryKey = 'Query';
		if (count($agentIds))
			$queryKey .= ', with Agents: '.implode(' ', $agentIds);
		if ($qId)
			$queryKey .= ', with qId';
		if ($fId)
			$queryKey .= ', with fId';
		if ($fType)
			$queryKey .= ', with fType';
		if ($isActiveNow)
			$queryKey .= ', active';
		
		// Create the statement
		if (!isset($this->getImplicitAZQueryResult_stmts[$queryKey])) {
			$query = $this->harmoni_db->select();
			$query->addColumn("fk_explicit_az");
			$query->addColumn("id", "id", "az2_implicit_az");
			$query->addColumn("fk_agent", "aid");
			$query->addColumn("fk_function", "fid");
			$query->addColumn("fk_qualifier", "qid");
			$query->addColumn("effective_date", "eff_date");
			$query->addColumn("expiration_date", "exp_date");
	
			$query->addTable("az2_implicit_az");
			
			if (count($agentIds))
				$query->addWhereIn('fk_agent', $agentIds);
				
			if ($qId)
				$query->addWhere($this->harmoni_db->quoteIdentifier('fk_qualifier').' = :qId');
				
			if ($fId)
				$query->addWhere($this->harmoni_db->quoteIdentifier('fk_function').' = :fId');
				
			if ($fType) {
				$subQuery = $this->harmoni_db->select();
				$subQuery->addColumn("az2_function.id");
				$subQuery->addTable("az2_function_type");
				$subQuery->addTable("az2_function", INNER_JOIN, 'az2_function_type.id = az2_function.fk_type');
				$subQuery->addWhere($this->harmoni_db->quoteIdentifier('domain').' = :domain');
				$subQuery->addWhere($this->harmoni_db->quoteIdentifier('authority').' = :authority');
				$subQuery->addWhere($this->harmoni_db->quoteIdentifier('keyword').' = :keyword');
				
				$query->addWhere($this->harmoni_db->quoteIdentifier('fk_function').' IN ('.$subQuery.')');
// 					$query->addWhere('fk_function.id', $subQuery);
			}
			
			// the isActiveNow criteria
			if ($isActiveNow) {
				$where = "(effective_date IS NULL OR (NOW() >= effective_date))";
				$query->addWhere($where);
				$where = "(expiration_date IS NULL OR (NOW() < expiration_date))";
				$query->addWhere($where);
			}
			
			$query->addOrderBy("az2_implicit_az.id");
			
// 			printpre($query->asString()); 
// 				throw new Exception('debug');
			
			$this->getImplicitAZQueryResult_stmts[$queryKey] = $query->prepare();
		}
		
		// Bind the params
		if ($qId)
			$this->getImplicitAZQueryResult_stmts[$queryKey]->bindValue(':qId', $qId);
		if ($fId)
			$this->getImplicitAZQueryResult_stmts[$queryKey]->bindValue(':fId', $fId);
		if ($fType) {
			$this->getImplicitAZQueryResult_stmts[$queryKey]->bindValue(':domain', $fType->getDomain());
			$this->getImplicitAZQueryResult_stmts[$queryKey]->bindValue(':authority', $fType->getDomain());
			$this->getImplicitAZQueryResult_stmts[$queryKey]->bindValue(':keyword', $fType->getDomain());
		}
		
		return $this->getImplicitAZQueryResult_stmts[$queryKey];
	}
	
	/**
	 * Answer An AZ query for explict AZs
	 * 
	 * @param array $agentIds The agent Ids to match
	 * @param string fId The string id of a function.
	 * @param string qId The string id of a qualifier. This parameter can not be null
	 * and used as a wildmark.
	 * @param object fType The type of a function.
	 * @param boolean isActiveNow If True, only active Authorizations will be returned.
	 * @return SelectQueryInterface 
	 * @access protected
	 * @since 4/23/08
	 */
	protected function getExplicitAZQuery (array $agentIds, $fId, $qId, $fType, $isActiveNow) {
		
		$query = new SelectQuery();
		$query->addColumn("id", "id", "az2_explicit_az");
		$query->addColumn("fk_agent", "aid");
		$query->addColumn("fk_function", "fid");
		$query->addColumn("fk_qualifier", "qid");
		$query->addColumn("effective_date", "eff_date");
		$query->addColumn("expiration_date", "exp_date");

		$query->addTable("az2_explicit_az");

		// now include criteria
		
		// the qualifiers criteria
		if (isset($qId)) {
			$query->addWhereEqual('fk_qualifier', $qId);
		}
		
		// the agent criteria
		if (count($agentIds)) {	
			$query->addWhereIn('fk_agent', $agentIds);
		}
		
		// the function criteria
		if (isset($fId)) {
			$joinc = "az2_explicit_az.fk_function = az2_function.id";
			$query->addTable("az2_function", INNER_JOIN, $joinc);
			$query->addWhereEqual("fk_function", $fId);
		}
		// the function type criteria
		if (isset($fType)) {
			// do not join with az_function if we did already
			if (!isset($fId)) {
				$joinc = "az2_explicit_az.fk_function = az2_function.id";
				$query->addTable("az2_function", INNER_JOIN, $joinc);
			}
			// now join with type
			$joinc = "az2_function.fk_type = az2_function_type.id";
			$query->addTable("az2_function_type", INNER_JOIN, $joinc);
			
			$query->addWhereEqual("domain", $fType->getDomain());
			$query->addWhereEqual("authority", $fType->getAuthority());
			$query->addWhereEqual("keyword", $fType->getKeyword());
		}
		// the isActiveNow criteria
		if ($isActiveNow) {
			$where = "(effective_date IS NULL OR (NOW() >= effective_date))";
			$query->addWhere($where);
			$where = "(expiration_date IS NULL OR (NOW() < expiration_date))";
			$query->addWhere($where);
		}
		
		$query->addOrderBy("az2_explicit_az.id");
		
		return $query;
	}
	
	/**
	 * Answer An AZ query for implicit AZs
	 * 
	 * @param array $agentIds The agent Ids to match
	 * @param string fId The string id of a function.
	 * @param string qId The string id of a qualifier. This parameter can not be null
	 * and used as a wildmark.
	 * @param object fType The type of a function.
	 * @param boolean isActiveNow If True, only active Authorizations will be returned.
	 * @return SelectQueryInterface 
	 * @access protected
	 * @since 4/23/08
	 */
	protected function getImplicitAZQuery (array $agentIds, $fId, $qId, $fType, $isActiveNow) {
		
		$query = new SelectQuery();
		$query->addColumn("fk_explicit_az");
		$query->addColumn("id", "id", "az2_implicit_az");
		$query->addColumn("fk_agent", "aid");
		$query->addColumn("fk_function", "fid");
		$query->addColumn("fk_qualifier", "qid");
		$query->addColumn("effective_date", "eff_date");
		$query->addColumn("expiration_date", "exp_date");

		$query->addTable("az2_implicit_az");

		// now include criteria
		
		// the qualifiers criteria
		if (isset($qId)) {
			$query->addWhereEqual('fk_qualifier', $qId);
		}
		
		// the agent criteria
		if (count($agentIds)) {	
			$query->addWhereIn('fk_agent', $agentIds);
		}
		
		// the function criteria
		if (isset($fId)) {
			$joinc = "az2_implicit_az.fk_function = az2_function.id";
			$query->addTable("az2_function", INNER_JOIN, $joinc);
			$query->addWhereEqual("fk_function", $fId);
		}
		// the function type criteria
		if (isset($fType)) {
			// do not join with az_function if we did already
			if (!isset($fId)) {
				$joinc = "az2_implicit_az.fk_function = az2_function.id";
				$query->addTable("az2_function", INNER_JOIN, $joinc);
			}
			// now join with type
			$joinc = "az2_function.fk_type = az2_function_type.id";
			$query->addTable("az2_function_type", INNER_JOIN, $joinc);
			
			$query->addWhereEqual("domain", $fType->getDomain());
			$query->addWhereEqual("authority", $fType->getAuthority());
			$query->addWhereEqual("keyword", $fType->getKeyword());
		}
		// the isActiveNow criteria
		if ($isActiveNow) {
			$where = "(effective_date IS NULL OR (NOW() >= effective_date))";
			$query->addWhere($where);
			$where = "(expiration_date IS NULL OR (NOW() < expiration_date))";
			$query->addWhere($where);
		}
		
		$query->addOrderBy("az2_implicit_az.id");
		
		return $query;
	}
	
	/**
	 * Answer an array of authorization objects from a query result.
	 * 
	 * @param object SelectQueryResultInterface $result
	 * @param string $aId The string id of an agent.
	 * @param string $qId The string id of a qualifier. This parameter can not be null
	 * and used as a wildmark.
	 * @param boolean $returnExplicitOnly If True, only explicit Authorizations
	 *		will be returned.
	 * @return array
	 * @access protected
	 * @since 4/23/08
	 */
	protected function getAuthorizationsFromQueryResult (SelectQueryResultInterface $result, $aId, $qId, $returnExplicitOnly) 
	{
		$idManager = Services::getService("Id");
		$dbHandler = Services::getService("DatabaseManager");
		
		// this array will store the authorizations that will be returned		
		$authorizations = array();
		
		// we only want to create one implicitAZ for a given Agent/Function/Qualifier
		// combo, so maintain a list of already created ones to skip
		$createdImplicitAZs = array();
		$i = 0;
		
		// process all rows and create the explicit authorizations
		while ($result->hasMoreRows()) {
			$row = $result->getCurrentRow();
			
// 			printpre($row);
			
			if (isset($row['fk_explicit_az'])) {
				$idValue = 'implicit_'.$row['id'];
				$isExplicit = false;
			} else {
				$idValue = $row['id'];
				$isExplicit = true;	
			}
			$id =$idManager->getId($idValue);
			if (isset($this->_authorizations[$idValue])) {
				$authorization =$this->_authorizations[$idValue];
			}
			else {
				$agentId = $idManager->getId($row['aid']);
				$functionId =$idManager->getId($row['fid']);
				$explicitQualifierId =$idManager->getId($row['qid']);
				$effectiveDate =$dbHandler->fromDBDate($row['eff_date'], $this->_dbIndex);
				$expirationDate =$dbHandler->fromDBDate($row['exp_date'], $this->_dbIndex);
				
				// create the explicit authorization (each explicit authorization
				// has a corresponding row in the authorization db table)
				$authorization = new AuthZ2_Authorization($row['id'], $agentId, 
											$functionId, $explicitQualifierId,
											$isExplicit, $this, 
											$effectiveDate, 
											$expirationDate);
				$this->_authorizations[$idValue] =$authorization;
			}
			
			// Explicit AZ for groups should have corresponding implicit AZs
			// in decendents, but not appear in their AZs directly.
			// Therefore, only add the explicit AZ if it is for the requested
			// agent if we are fetching more than just the explicitAZs.
			if (!$aId || $row['aid'] == $aId)
				$authorizations[] = $authorization;

			// now create the implicit authorizations for those caused by group membership
			// (where the aid specified is not the one in the explicit AZ.
			//
			// We are going to take the small cop-out of not creating implicit AZs
			// for every agent who is a member of a group az, only those if an agent
			// is specified. Maybe this should be changed, but it wasn't how the 
			// system used to work.
			if (!$returnExplicitOnly && $aId && $row['aid'] != $aId) {
// 				printpre("Building Implicit AZs...\n\t\$aId = $aId");
// 				var_dump($returnExplicitOnly);
			
				// This is implicit because of a group
// 					printpre("In first clause (AuthorizationCache)");
				$qualifierId =$idManager->getId($qId);
				
				// If we are getting implicit AZs for a given agent, make sure
				// that the implicit AZ has their Id.
				$agentId =$idManager->getId($aId);
				
				$function =$authorization->getFunction();
				$functionId =$function->getId();
				$effectiveDate = $authorization->getEffectiveDate();
				$expirationDate = $authorization->getExpirationDate();
				$implicit = new AuthZ2_Authorization(null, 
													$agentId, 
													$functionId, 
													$qualifierId,
													false, 
													$this, 
													$effectiveDate, 
													$expirationDate);
				
				// If the AZ causing this implicit AZ is an explicitAZ, set a reference
				// to it.
				if ($isExplicit)
					$implicit->setExplicitAZId($authorization->getIdString());
				// Otherwise, set the id of the Explicit AZ causing this original implicit one.
				else
					$implicit->setExplicitAZId($row['fk_explicit_az']);
				
				$azHash = $agentId->getIdString()
							."::".$functionId->getIdString()
							."::".$qualifierId->getIdString();
				if (!in_array($azHash, $createdImplicitAZs)) {
					$authorizations[] =$implicit;
					$createdImplicitAZs[] = $azHash;
				}
			}
			
			$result->advanceRow();
		}
		$result->free();
		
		return $authorizations;
	}
	
	/**
	 * Create implicit Authorizations for an explicit authorization.
	 * 
	 * @param object Authorization $explicitAZ
	 * @return void
	 * @access protected
	 * @since 4/21/08
	 */
	protected function createImplicitAZsForAZ (Authorization $explicitAZ) {
		$this->createImplicitAZsDownForAZ($explicitAZ);
		$this->createImplicitAZsUpForAZ($explicitAZ);
	}
	
	/**
	 * Create implicit Authorizations for an explicit authorization going down the
	 * hierarchy.
	 * 
	 * @param object Authorization $explicitAZ
	 * @return void
	 * @access protected
	 * @since 4/21/08
	 */
	protected function createImplicitAZsDownForAZ (Authorization $explicitAZ) {
		$decendentIds = $this->getQualifierDescendentIds($explicitAZ->getQualifier()->getId());
		$this->createImplicitAZs(array($explicitAZ), $decendentIds);
	}
	
	/**
	 * Create implicit Authorizations for an explicit authorization going up the
	 * hierarchy.
	 * 
	 * @param object Authorization $explicitAZ
	 * @return void
	 * @access protected
	 * @since 4/21/08
	 */
	public function createImplicitAZsUpForAZ (Authorization $explicitAZ) {
		$idMgr = Services::getService("Id");
		if (!$explicitAZ->getFunction()->getId()->isEqual($idMgr->getId("edu.middlebury.authorization.view")))
			return;
		
		$ancestorIds = $this->getQualifierAncestorIds($explicitAZ->getQualifier()->getId());
		$this->createImplicitAZs(array($explicitAZ), $ancestorIds);
		
	}
	
	/**
	 * Delete implicit Authorizations given a sub-tree node and an array ids of that
	 * node's former parents or ancestors.
	 * 
	 * @param object Node $subtreeRootNode
	 * @param array $formerAncestorIds An array of Id objects
	 * @return void
	 * @access public
	 * @since 4/21/08
	 */
	public function deleteHierarchyImplictAZs (Node $subtreeRootNode, array $formerAncestorIds) {
		// Get a list of Explicit Authorizations in the subtree that would have
		// cascaded up to the former ancestors and remove the corresponding
		// implicit AZs from the former ancestors.
		$upAZs = $this->getCascadingUpAZs(array($subtreeRootNode->getId()));
		$this->deleteImplicitAZs($upAZs, $formerAncestorIds);
		
		// Get a list of the Explicit Authorizations in the former ancestors that would
		// have cascaded down to the subtree and remove the corresponding implicit
		// AZs from the subtree.
		$downAZs = $this->getCascadingDownAZs($formerAncestorIds);
		$nodes = $this->getQualifierDescendentIds($subtreeRootNode->getId());
		$nodes[] = $subtreeRootNode->getId();
		$this->deleteImplicitAZs($downAZs, $nodes);
	}
	
	/**
	 * Create implicit Authorizations given a sub-tree node and an array ids of that
	 * node's new parents or ancestors.
	 * 
	 * @param object Node $subtreeRootNode
	 * @param array $newAncestorIds An array of Id objects
	 * @return void
	 * @access public
	 * @since 4/21/08
	 */
	public function createHierarchyImplictAZs (Node $subtreeRootNode, array $newAncestorIds) {
		// Wrap this operation in a transaction to prevent partial addition.
		if (isset($this->harmoni_db)) {
			$this->harmoni_db->beginTransaction();
		} else {
			$dbHandler = Services::getService("DatabaseManager");	
			$dbHandler->beginTransaction($this->_dbIndex);
		}
		
		// Get a list of Explicit Authorizations in the subtree that will
		// cascade up to the new ancestors and add the corresponding
		// implicit AZs to the new ancestors.
		$upAZs = $this->getCascadingUpAZs(array($subtreeRootNode->getId()));
		$this->createImplicitAZs($upAZs, $newAncestorIds);
		
		// Get a list of the Explicit Authorizations in the new ancestors that will
		// cascade down to the subtree and add the corresponding implicit
		// AZs to the subtree.
		$downAZs = $this->getCascadingDownAZs($newAncestorIds);
		$nodes = $this->getQualifierDescendentIds($subtreeRootNode->getId());
		$nodes[] = $subtreeRootNode->getId();
		$this->createImplicitAZs($downAZs, $nodes);
		
		// Wrap this operation in a transaction to prevent partial addition.
		if (isset($this->harmoni_db)) {
			$this->harmoni_db->commit();
		} else {
			$dbHandler = Services::getService("DatabaseManager");	
			$dbHandler->commitTransaction($this->_dbIndex);
		}
	}
	
	/**
	 * Answer the explicit AZ that would cascade down from the Node ids passed
	 * 
	 * @param array $nodeIds
	 * @return array An array of explicit Authorization objects
	 * @access protected
	 * @since 4/21/08
	 */
	protected function getCascadingDownAZs (array $nodeIds) {		
		$allExplicit = array();
		foreach ($nodeIds as $nodeId) {
			$explicitAZs = $this->getAZs(
				null, 		// Any Agent
				null, 		// Any Function Id
				$nodeId->getIdString(),
				null,		// Any Function Type
				true,		// Explicit only
				false		// Do not limit to only active
			);
			$allExplicit = array_merge($allExplicit, $explicitAZs);
		}
		
		return $allExplicit;
	}
	
	/**
	 * Answer the explicit AZ that would cascade up from the Node ids passed.
	 * These will only be 'edu.middlebury.authorization.view' authorizations.
	 * 
	 * @param array $nodeIds
	 * @return array An array of explicit Authorization objects
	 * @access protected
	 * @since 4/21/08
	 */
	protected function getCascadingUpAZs (array $nodeIds) {		
		$allExplicit = array();
		foreach ($nodeIds as $nodeId) {
			$explicitAZs = $this->getAZs(
				null, 		// Any Agent
				"edu.middlebury.authorization.view", 		// Just the 'view' function
				$nodeId->getIdString(),
				null,		// Any Function Type
				true,		// Explicit only
				false		// Do not limit to only active
			);
			$allExplicit = array_merge($allExplicit, $explicitAZs);
		}
		
		return $allExplicit;
	}
	
	/**
	 * Answer the node ids in a subtree
	 * 
	 * @param object Id $node
	 * @return array array of Id objects
	 * @access protected
	 * @since 4/21/08
	 */
	protected function getQualifierDescendentIds (Id $qualifierId) {
		
		$hierarchyMgr = $this->authorizationManager->getHierarchyManager();
		$node = $hierarchyMgr->getNode($qualifierId);
		$hierarchy = $hierarchyMgr->getHierarchyForNode($node);
		$info = $hierarchy->traverse(
					$node->getId(), 
					Hierarchy::TRAVERSE_MODE_DEPTH_FIRST,
					Hierarchy::TRAVERSE_DIRECTION_DOWN,
					Hierarchy::TRAVERSE_LEVELS_ALL);
		
		$ids = array();
		
		// get rid of the root node (it is not a ancestor of itsself)
		$info->next();
		while ($info->hasNext()) {
			$ids[] = $info->next()->getNodeId();
		}
// 		printpre(count($ids)." descendents found for Node, '".$qualifierId."', '".$node->getDisplayName()."'.");
// 		exit;
		return $ids;
	}
	
		
	/**
	 * Answer an array of qualifier ancestor Ids
	 * 
	 * @param object Id $qualifierId
	 * @return array
	 * @access protected
	 * @since 4/22/08
	 */
	protected function getQualifierAncestorIds (Id $qualifierId) {
		// get the descendant nodes
		$hierarchyManager = $this->authorizationManager->getHierarchyManager();
		$node = $hierarchyManager->getNode($qualifierId);
		$hierarchy = $hierarchyManager->getHierarchyForNode($node);
		$info = $hierarchy->traverse($qualifierId, Hierarchy::TRAVERSE_MODE_DEPTH_FIRST, 
										Hierarchy::TRAVERSE_DIRECTION_UP, Hierarchy::TRAVERSE_LEVELS_ALL);

		$ids = array();
		// get rid of the root node (it is not a ancestor of itsself)
		$info->next();
		while ($info->hasNext()) {
			$ids[] = $info->next()->getNodeId();
		}
// 		printpre(count($ids)." ancestors found for Node, '".$qualifierId."', '".$node->getDisplayName()."'.");
// 		exit;
		return $ids;
	}
	
	/**
	 * Delete implicit Authorizations on an array of NodeIds that were caused by any
	 * of an array of explict authorizations
	 * 
	 * @param array $explicitAZs An array of Authorization objects
	 * @param array $nodeIds An array of Id objects
	 * @return void
	 * @access protected
	 * @since 4/21/08
	 */
	protected function deleteImplicitAZs (array $explicitAZs, array $nodeIds) {
		if (!count($explicitAZs))
			return;
		if (!count($nodeIds))
			return;
		
		$explicitAZIdStrings = array();
		foreach ($explicitAZs as $az) {
			$explicitAZIdStrings[] = $az->getIdString();
		}
		
		$nodeIdStrings = array();
		foreach ($nodeIds as $id) {
			$nodeIdStrings[] = $id->getIdString();
		}
		
		$query = new DeleteQuery();
		$query->setTable("az2_implicit_az");
		$query->addWhereIn("fk_explicit_az", $explicitAZIdStrings);
		$query->addWhereIn("fk_qualifier", $nodeIdStrings);
			
		$dbHandler = Services::getService("DatabaseManager");	
		$dbHandler->query($query, $this->_dbIndex);
	}
	
	/**
	 * Create implicit Authorizations on an array of NodeIds caused by
	 * an array of explict authorizations
	 * 
	 * @param array $explicitAZs An array of Authorization objects
	 * @param array $nodeIds An array of Id objects
	 * @return void
	 * @access protected
	 * @since 4/21/08
	 */
	protected function createImplicitAZs (array $explicitAZs, array $nodeIds) {
		foreach ($explicitAZs as $explicitAZ) {
			foreach ($nodeIds as $nodeId) {
				$this->createImplicitAZ($explicitAZ, $nodeId);
			}
		}
	}
	
	/**
	 * Create an implicit AZ at a nodeId for an explicit AZ.
	 * 
	 * @param object Authorization $explicitAZ
	 * @param object Id $nodeId
	 * @return void
	 * @access protected
	 * @since 4/21/08
	 */
	protected function createImplicitAZ (Authorization $explicitAZ, Id $nodeId) {
		if (isset($this->harmoni_db)) {
			if (!isset($this->createImplicitAZ_stmt)) {
				$query = $this->harmoni_db->insert();
				$query->setTable("az2_implicit_az");
				$query->addRawValue("fk_explicit_az", "?");
				$query->addRawValue("fk_agent", "?");
				$query->addRawValue("fk_function", "?");
				$query->addRawValue("fk_qualifier", "?");
				$query->addRawValue("effective_date", "?");
				$query->addRawValue("expiration_date", "?");
				$this->createImplicitAZ_stmt = $query->prepare();
			}
			
			$this->createImplicitAZ_stmt->bindValue(1, $explicitAZ->getIdString());
			$this->createImplicitAZ_stmt->bindValue(2, $explicitAZ->getAgentId()->getIdString());
			$this->createImplicitAZ_stmt->bindValue(3, $explicitAZ->getFunction()->getId()->getIdString());
			$this->createImplicitAZ_stmt->bindValue(4, $nodeId->getIdString());
			
			$effectiveDate = $explicitAZ->getEffectiveDate();
			if (is_null($effectiveDate))
				$this->createImplicitAZ_stmt->bindValue(5, null);
			else
				$this->createImplicitAZ_stmt->bindValue(5, $effectiveDate->asString());
				
			$expirationDate = $explicitAZ->getExpirationDate();
			if (is_null($expirationDate))
				$this->createImplicitAZ_stmt->bindValue(6, null);
			else
				$this->createImplicitAZ_stmt->bindValue(6, $expirationDate->asString());
			
			try {
				$this->createImplicitAZ_stmt->execute();
			} catch (Exception $e) {
				printpre($e->getMessage());
				printpre("fk_explicit_az => ".$explicitAZ->getIdString().
						"\nfk_agent => ".$explicitAZ->getAgentId()->getIdString().
						"\nfk_function => ". $explicitAZ->getFunction()->getId()->getIdString().
						"\nfk_qualifier => ".$explicitAZ->getAgentId()->getIdString());				
				printpre(__LINE__); exit;
			}
		} else {
			// now insert into database
			$dbHandler = Services::getService("DatabaseManager");
			
			$query = new InsertQuery();
			$query->setTable("az2_implicit_az");
			$query->addValue("fk_explicit_az", $explicitAZ->getIdString());
			$query->addValue("fk_agent", $explicitAZ->getAgentId()->getIdString());
			$query->addValue("fk_function", $explicitAZ->getFunction()->getId()->getIdString());
			$query->addValue("fk_qualifier", $nodeId->getIdString());
			
			$effectiveDate = $explicitAZ->getEffectiveDate();
			if (is_null($effectiveDate))
				$query->addRawValue("effective_date", "NULL");
			else
				$query->addValue("effective_date", $effectiveDate->asString());
			
			$expirationDate = $explicitAZ->getExpirationDate();
			if (is_null($expirationDate))
				$query->addRawValue("expiration_date", "NULL");
			else
				$query->addValue("expiration_date", $expirationDate->asString());
			
			$dbHandler->query($query, $this->_dbIndex);
		}
	}
}
?>