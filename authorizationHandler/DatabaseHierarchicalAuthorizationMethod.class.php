<?php

require_once(HARMONI."authorizationHandler/HierarchicalAuthorizationMethod.interface.php");
require_once(HARMONI."authorizationHandler/DatabaseHierarchicalAuthorizationMethodDataContainer.class.php");

/**
 * This is a database implementation of the HierarchicalAuthorizationMethodInterface.
 * <br><br>
 * The class is capable of authorizing an <b>agent</b> performing a <b>function</b> in a given 
 * <b>context</b>.<br>
 * <pre>
 * This authorization method is cached and makes use of three caches:
 * 
 * - cacheACF answers the following questions:
 * 
 * 		= What functions can this agent perform in this context?
 * 		= What can John do here?
 * 
 * - cacheFCA answers the following questions:
 * 
 * 		= What agents can perform this function in this context?
 * 		= Who can do this here?
 * 
 * - cacheAFC answers the following questions:
 * 
 * 		= In what context can John perform this function?
 * 		= Where can John do this?
 * 
 * All caches are synchronized, i.e. the information is consistent: if
 * agent A is authorized to do function F in context C, then that would
 * be indicated in all three caches.
 * 
 * Every cache is a 7-dimensional array!
 * </pre>
 * 
 * @access public
 * @version $Id: DatabaseHierarchicalAuthorizationMethod.class.php,v 1.8 2003/07/11 00:20:24 gabeschine Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 6/29/2003
 * @package harmoni.authorization
 * @see {@link HierarchicalAuthorizationContextInterface}
 * @see {@link AuthorizationAgentInterface}
 * @see {@link AuthorizationFunctionInterface}
 */
class DatabaseHierarchicalAuthorizationMethod extends HierarchicalAuthorizationMethodInterface {


	/**
	 * <code>dbIndex</code> - the index of the database connection that the
	 * authorization method will use as returned by the DBHandler service.
	 * @attribute private string _dbIndex
	 */
	var $_dbIndex;
	
	/**
	 * <code>primaryKeyColumn</code> - the name of the database table column that stores
	 * the primary key. The column must be set up to store integers.
	 * @attribute private string _primaryKeyColumn
	 */
	var $_primaryKeyColumn;

	/**
	 * <code>agentIdColumn</code> - the name of the database table column that stores
	 * the agent id. The column must be set up to store integers.
	 * @attribute private string _agentIdColumn
	 */
	var $_agentIdColumn;
	
	/**
	 * <code>agentTypeColumn</code> - the name of the database table column that stores
	 * the agent type. The column must be set up to store integers.
	 * @attribute private string _agentTypeColumn
	 */
	var $_agentTypeColumn;
	
	/**
	 * <code>functionIdColumn</code> - the name of the database table column that stores
	 * the function id. The column must be set up to store integers.
	 * @attribute private string _functionIdColumn
	 */
	var $_functionIdColumn;
	
	/**
	 * <code>contextIdColumn</code> - the name of the database table column that stores
	 * the context id. The column must be set up to store integers.
	 * @attribute private string _contextIdColumn
	 */
	var $_contextIdColumn;
	
	/**
	 * <code>contextDepthColumn</code> - the name of the database table column that stores
	 * the context hierarchy level. The column must be set up to store integers.
	 * @attribute private string _contextDepthColumn
	 */
	var $_contextDepthColumn;
	
	
	/**
	 * A properly set up AuthorizationContextHierarchyGeneratorInterface
	 * object that will be used to generate the context hierarchy. See
	 * {@link AuthorizationContextHierarchyGeneratorInterface}.
	 * @attribute private object _hierarchyGenerator
	 */
	var $_hierarchyGenerator;
	

	 /**
	  * One of the authorization method caches.
	  * <pre>
	  * - cacheACF answers the following questions:
	  * 
	  * 		= What functions can this agent perform in this context?
	  * 		= What can John do here?
	  * </pre>
	  * 
	  * @attribute private array _cacheACF
	  */
	 var $_cacheACF;
	 
	
	/**
     * One of the authorization method caches.
	 * <pre>
	 * - cacheFCA answers the following questions:
	 * 
	 * 		= What agents can perform this function in this context?
	 * 		= Who can do this here?
	 * </pre>
	 * 
	 * @attribute private array _cacheFCA
	 */
	var $_cacheFCA;
	
	/**
     * One of the authorization method caches.
	 * <pre>
	 * - cacheAFC answers the following questions:
	 * 
	 * 		= In what context can John perform this function?
	 * 		= Where can John do this?
	 * </pre>
	 * 
	 * @attribute private array _cacheAFC
	 */
	var $_cacheAFC;
	
	
	/**
	 * The constructor sets up the authorization method.
	 * @param object dataContainer This is a DatabaseHierarchicalAuthorizationMethodDataContainer
	 * object storing some arguments. See, {@link DatabaseHierarchicalAuthorizationMethodDataContainer}.
	 * @param object hierarchyGenerator A properly set up AuthorizationContextHierarchyGeneratorInterface
	 * object that will be used to generate the context hierarchy. See
	 * {@link AuthorizationContextHierarchyGeneratorInterface}.
	 * @access public
	 */
	function DatabaseHierarchicalAuthorizationMethod($dataContainer, 
													 $hierarchyGenerator) {
		// ** parameter validation
		$extendsRule1 =& new ExtendsValidatorRule("DatabaseHierarchicalAuthorizationMethodDataContainer");
		$extendsRule2 =& new ExtendsValidatorRule("AuthorizationContextHierarchyGeneratorInterface");
		ArgumentValidator::validate($dataContainer, $extendsRule1, true);
		ArgumentValidator::validate($hierarchyGenerator, $extendsRule2, true);
		// ** end of parameter validation
		
		// now, validate the data container
		$dataContainer->checkAll();
		
		// get arguments from data container and put in member variables
		$this->_dbIndex = $dataContainer->get("dbIndex");
		$this->_primaryKeyColumn = $dataContainer->get("primaryKeyColumn");
		$this->_agentIdColumn = $dataContainer->get("agentIdColumn");
		$this->_agentTypeColumn = $dataContainer->get("agentTypeColumn");
		$this->_functionIdColumn = $dataContainer->get("functionIdColumn");
		$this->_contextIdColumn = $dataContainer->get("contextIdColumn");
		$this->_contextDepthColumn = $dataContainer->get("contextDepthColumn");
		
		// make sure we are connected to the database
		Services::requireService("DBHandler", true);
		$dbHandler =& Services::getService("DBHandler");
		if (!$dbHandler->isConnected($this->_dbIndex)) {
			$str = "Cannot initialize the AuthorizationMethod, because ";
			$str .= "the database connection is inactive";
			throwError(new Error($str, "AuthorizationHandler", true));
		}
		
		$this->_hierarchyGenerator = $hierarchyGenerator;
	}


	/**
	 * Attempts to authorize an <b>agent</b> performing a <b>function</b> in a given 
	 * <b>context</b>.
	 * @method public authorize
	 * @param object agent An <code>AuthorizationAgentInterface</code> object describing the agent
	 * to be authorized.
	 * @param object function An <code>AuthorizationFunction</code> object describing the agent's action
	 * to be authorized.
	 * @param object context An <code>HierarchicalAuthorizationContext</code> object describing
	 * the context in which to perform authorization.
	 * @return boolean <code>true</code>, if the agent was successfully authorized;<br>
	 * <code>false</code>, otherwise.
	 */
	function authorize($agent, $function, $context) {
		// ** parameter validation
		$extendsRule1 =& new ExtendsValidatorRule("AuthorizationAgentInterface");
		$extendsRule2 =& new ExtendsValidatorRule("AuthorizationFunctionInterface");
		$extendsRule3 =& new ExtendsValidatorRule("HierarchicalAuthorizationContextInterface");
		ArgumentValidator::validate($agent, $extendsRule1, true);
		ArgumentValidator::validate($function, $extendsRule2, true);
		ArgumentValidator::validate($context, $extendsRule3, true);
		// ** end of parameter validation
		
		// extract fields from objects
		$agentId = $agent->getSystemId();
		$agentType = $agent->getType();
		$functionId = $function->getSystemId();
		$contextSystem = $context->getSystem();
		$contextSubsystem = $context->getSubsystem();
		$contextDepth = $context->getHierarchyLevel();
		$contextId = $context->getSystemId();
		
		// this boolean will show at the end whether the agent was authorized
		$authorized = false;
		// this int will store on which level we got successful authorization
		$authorizedLevel = $contextDepth + 1;
		// this int will store the level until which information is cached (exclusive)
		$cachedUntilLevel = $contextDepth + 1;

		// first thing to do is check the cache directly
		$authorized = $this->_cacheAFC[$agentId][$agentType]
									  [$functionId]
									  [$contextSystem][$contextSubsystem][$contextDepth][$contextId]
									  === true;

		if ($authorized == true) 
			return true;

		// get ancestors of this context
		$ancestors =& $this->_hierarchyGenerator->getAncestors($contextDepth, $contextId);
		// add this context to the ancestor array as well
		$ancestors[$contextDepth] = $contextId;
		$count = count($ancestors);
		
		// now see if any of the ancestors has been cached as AUTHORIZED
		for ($depth = 0; $depth < $count; $depth++) {
			// get value from cache
			$cachedValue = $this->_cacheAFC[$agentId][$agentType]
										  [$functionId]
										  [$contextSystem][$contextSubsystem][$depth][$ancestors[$depth]];
										  
			// if AUTHORIZED at this level then everything beyond is authorized as well
			if ($cachedValue === true && $authorizedLevel > $contextDepth) {
				$authorized = true;
				$authorizedLevel = $depth;
			}
				
			// if value is not set, this means this is as far as the cache goes
			else if (is_null($cachedValue)) {
			    $cachedUntilLevel = $depth;
				break;
			}
		}
		
		// if not authorized in cache AND there is missing information in the cache
		// run database query to determine authorization status
		if ($authorized === false && $cachedUntilLevel <= $contextDepth) {
			// get DBHandler service
			Services::requireService("DBHandler", true);
			$dbHandler =& Services::getService("DBHandler");

			// construct database query
			$query =& new SelectQuery();
			
			// this string will precede every column name
			$colPrefix = $contextSystem.".".$contextSubsystem.".";
			
			// run one query for each ancestor and the original context
			for ($depth = $cachedUntilLevel; $depth < $count; $depth++) {
				$query->reset();
				$query->addColumn($colPrefix.$this->_primaryKeyColumn);
			    $query->addTable($contextSystem.".".$contextSubsystem);
				$query->addWhere($colPrefix.$this->_agentIdColumn." = ".$agentId);
				$query->addWhere($colPrefix.$this->_agentTypeColumn." = ".$agentType);
				$query->addWhere($colPrefix.$this->_functionIdColumn." = ".$functionId);
				$query->addWhere($colPrefix.$this->_contextDepthColumn." = ".$depth);
				$query->addWhere($colPrefix.$this->_contextIdColumn." = ".$ancestors[$depth]);
	
				// follows, some debugging stuff
				//echo "<pre>";
				//echo MySQL_SQLGenerator::generateSQLQuery($query);
				//echo "</pre>";
	
				// run query
				$queryResult =& $dbHandler->query($query, $this->_dbIndex);
				
				// validate query results
				if ($queryResult === null) {
					$str = "Query failed. Possible invalid configuration of the AuthorizationMethod object.";
				    throwError(new Error($str, "AuthorizationHandler", true));
				}
				if ($queryResult->getNumberOfRows() > 1) {
					$str = "Query returned more than one rows. ";
					$str .= "Possible invalid configuration of the AuthorizationMethod object.";
				    throwError(new Error($str, "AuthorizationHandler", true));
				}
				
				// now see if the agent is authorized
				$authorized = $queryResult->getNumberOfRows() === 1;
				
				// if the agent was authorized at an ancestor then they would be authorized
				// at the given context as well.
				if ($authorized) {
					$authorizedLevel = $depth;
				    break;
				}
			}
		}

		// cache the result
		for ($depth = $cachedUntilLevel; $depth <= $contextDepth; $depth++) {
		
			// everything beyond $authorizedLevel IS authorized
			$authorizedAtLevel = ($depth >= $authorizedLevel);
			
			$this->_cacheACF[$agentId][$agentType]
							[$contextSystem][$contextSubsystem][$depth][$ancestors[$depth]]
							[$functionId]
							= $authorizedAtLevel;
			
			$this->_cacheFCA[$functionId]
							[$contextSystem][$contextSubsystem][$depth][$ancestors[$depth]]
							[$agentId][$agentType]
							= $authorizedAtLevel;
			
			$this->_cacheAFC[$agentId][$agentType]
							[$functionId]
							[$contextSystem][$contextSubsystem][$depth][$ancestors[$depth]]
							= $authorizedAtLevel;
		}
		
		return $authorized;
	}
	
	/**
	 * Grants a given agent the ability to perform a given function
	 * in a given context.
	 * @method public grant
	 * @see {@link HierarchicalAuthorizationMethodInterface::revoke}
	 * @param object agent An <code>AuthorizationAgentInterface</code> object describing the agent.
	 * @param object function An <code>AuthorizationFunction</code> object describing the agent's action
	 * to be granted.
	 * @param object context An <code>HierarchicalAuthorizationContext</code> object describing
	 * the context.
	 * @return boolean <code>true</code>, if successful; <code>false</code>, otherwise.
	 */
	function grant($agent, $function, $context) {
		// ** parameter validation
		$extendsRule1 =& new ExtendsValidatorRule("AuthorizationAgentInterface");
		$extendsRule2 =& new ExtendsValidatorRule("AuthorizationFunctionInterface");
		$extendsRule3 =& new ExtendsValidatorRule("HierarchicalAuthorizationContextInterface");
		ArgumentValidator::validate($agent, $extendsRule1, true);
		ArgumentValidator::validate($function, $extendsRule2, true);
		ArgumentValidator::validate($context, $extendsRule3, true);
		// ** end of parameter validation
		
		// extract fields from objects
		$agentId = $agent->getSystemId();
		$agentType = $agent->getType();
		$functionId = $function->getSystemId();
		$contextSystem = $context->getSystem();
		$contextSubsystem = $context->getSubsystem();
		$contextDepth = $context->getHierarchyLevel();
		$contextId = $context->getSystemId();
		
		// permission has already been granted
		if ($this->authorize($agent, $function, $context))
		    return false;
			
		// this string will precede every column name
		$colPrefix = $contextSystem.".".$contextSubsystem.".";

		// add to the database
		$query =& new InsertQuery();
		$query->setTable($contextSystem.".".$contextSubsystem);
		$columns = array();
		$columns[] = $colPrefix.$this->_agentIdColumn;
		$columns[] = $colPrefix.$this->_agentTypeColumn;
		$columns[] = $colPrefix.$this->_functionIdColumn;
		$columns[] = $colPrefix.$this->_contextDepthColumn;
		$columns[] = $colPrefix.$this->_contextIdColumn;
		$query->setColumns($columns);
		$values = array();
		$values[] = $agentId;
		$values[] = $agentType;
		$values[] = $functionId;
		$values[] = $contextDepth;
		$values[] = $contextId;
		$query->addRowOfValues($values);
		
		// follows, some debugging stuff
		//echo "<pre>";
		//echo MySQL_SQLGenerator::generateSQLQuery($query);
		//echo "</pre>";
	
		// get DBHandler service
		Services::requireService("DBHandler", true);
		$dbHandler =& Services::getService("DBHandler");
		
		// run query
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// validate query results
		if ($queryResult === null) {
			$str = "Query failed in grant().";
		    throw(new Error($str, "AuthorizationHandler", true));
		}
		if ($queryResult->getNumberOfRows() > 1) {
			$str = "Insert query must affect exactly one row in grant().";
		    throw(new Error($str, "AuthorizationHandler", true));
		}

		// update cache
		$this->_cacheACF[$agentId][$agentType]
					[$contextSystem][$contextSubsystem][$contextDepth][$contextId]
					[$functionId]
					= true;
		
		$this->_cacheFCA[$functionId]
					[$contextSystem][$contextSubsystem][$contextDepth][$contextId]
					[$agentId][$agentType]
					= true;
		
		$this->_cacheAFC[$agentId][$agentType]
					[$functionId]
					[$contextSystem][$contextSubsystem][$contextDepth][$contextId]
					= true;

		// get subtree of this context and revoke on each node (updating the cache,
		// meanwhile.
		$subtree =& $this->_hierarchyGenerator->generateSubtree($contextDepth, $contextId);
		foreach (array_keys($subtree) as $i => $depth)
			foreach ($subtree[$depth] as $id) {
				$this->_revoke($agentId, $agentType, 
							   $functionId, 
							   $contextSystem, $contextSubsystem, $depth, $id);

				// update cache
				$this->_cacheACF[$agentId][$agentType]
							[$contextSystem][$contextSubsystem][$depth][$id]
							[$functionId]
							= true;
				
				$this->_cacheFCA[$functionId]
							[$contextSystem][$contextSubsystem][$depth][$id]
							[$agentId][$agentType]
							= true;
				
				$this->_cacheAFC[$agentId][$agentType]
							[$functionId]
							[$contextSystem][$contextSubsystem][$depth][$id]
							= true;
			}
			
		return true;
	}
	
	
	
	/**
	 * A private auxilliary method for grant() and revoke(). Runs a delete DB query
	 * on the specified context.
	 * @method private _revoke
	 * @return boolean <code>true</code>, if successful; <code>false</code>, otherwise.
	 */
	function _revoke($agentId, $agentType, 
					 $functionId, 
					 $contextSystem, $contextSubsystem, $contextDepth, $contextId) {
		
		// this string will precede every column name
		$colPrefix = $contextSystem.".".$contextSubsystem.".";
		// create and run query
		$query =& new DeleteQuery();
		$query->setTable($contextSystem.".".$contextSubsystem);
		$query->addWhere($colPrefix.$this->_agentIdColumn." = ".$agentId);
		$query->addWhere($colPrefix.$this->_agentTypeColumn." = ".$agentType);
		$query->addWhere($colPrefix.$this->_functionIdColumn." = ".$functionId);
		$query->addWhere($colPrefix.$this->_contextDepthColumn." = ".$contextDepth);
		$query->addWhere($colPrefix.$this->_contextIdColumn." = ".$contextId);
		
		// follows, some debugging stuff
		//echo "<pre>";
		//echo MySQL_SQLGenerator::generateSQLQuery($query);
		//echo "</pre>";
		
		// get DBHandler service
		Services::requireService("DBHandler", true);
		$dbHandler =& Services::getService("DBHandler");
		
		// run query
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// validate query results
		if ($queryResult === null) {
			$str = "Delete query failed.";
		    throw(new Error($str, "AuthorizationHandler", true));
		}

		return ($queryResult->getNumberOfRows() == 1);
	}
	
	
	
	/**
	 * Revokes from a given agent the ability to perform a given function
	 * in a given context.
	 * @method public grant
	 * @see {@link HierarchicalAuthorizationMethodInterface::grant}
	 * @param object agent An <code>AuthorizationAgentInterface</code> object describing the agent.
	 * @param object function An <code>AuthorizationFunction</code> object describing the agent's action
	 * to be revoked.
	 * @param object context An <code>HierarchicalAuthorizationContext</code> object describing
	 * the context.
	 * @return boolean <code>true</code>, if successful; <code>false</code>, otherwise.
	 */
	function revoke($agent, $function, $context) {
		// ** parameter validation
		$extendsRule1 =& new ExtendsValidatorRule("AuthorizationAgentInterface");
		$extendsRule2 =& new ExtendsValidatorRule("AuthorizationFunctionInterface");
		$extendsRule3 =& new ExtendsValidatorRule("HierarchicalAuthorizationContextInterface");
		ArgumentValidator::validate($agent, $extendsRule1, true);
		ArgumentValidator::validate($function, $extendsRule2, true);
		ArgumentValidator::validate($context, $extendsRule3, true);
		// ** end of parameter validation
		
		// extract fields from objects
		$agentId = $agent->getSystemId();
		$agentType = $agent->getType();
		$functionId = $function->getSystemId();
		$contextSystem = $context->getSystem();
		$contextSubsystem = $context->getSubsystem();
		$contextDepth = $context->getHierarchyLevel();
		$contextId = $context->getSystemId();
		
		// permission has already been revoked
		if (!$this->authorize($agent, $function, $context))
		    return false;
			
		// get ancestors of this context
		$ancestors =& $this->_hierarchyGenerator->getAncestors($contextDepth, $contextId);
		$count = count($ancestors);
		
		// If an ancestor is authorized - error
		for ($depth = 0; $depth < $count; $depth++) {
			$id = $ancestors[$depth];
		    if ($this->_cacheAFC[$agentId][$agentType]
								[$functionId]
								[$contextSystem][$contextSubsystem][$depth][$id]
								=== true) return false;
		}
		
		// get subtree of this context, add the context itself,
		// and revoke on each node (updating the cache, meanwhile).
		$subtree =& $this->_hierarchyGenerator->generateSubtree($contextDepth, $contextId);
		$subtree[$contextDepth][] = $contextId;
		foreach (array_keys($subtree) as $i => $depth)
			foreach ($subtree[$depth] as $id) {
				$this->_revoke($agentId, $agentType, 
							   $functionId, 
							   $contextSystem, $contextSubsystem, $depth, $id);

				// update cache
				$this->_cacheACF[$agentId][$agentType]
							[$contextSystem][$contextSubsystem][$depth][$id]
							[$functionId]
							= false;
				
				$this->_cacheFCA[$functionId]
							[$contextSystem][$contextSubsystem][$depth][$id]
							[$agentId][$agentType]
							= false;
				
				$this->_cacheAFC[$agentId][$agentType]
							[$functionId]
							[$contextSystem][$contextSubsystem][$depth][$id]
							= false;
			}
			
		return true;
	}
	

		
	/**
	 * Clears the authorization method cache. Normally the method caches
	 * information so that number of queries is minimized. You should call
	 * this method if permissions or hierarchy structure has changed.
	 * 
	 * @method public clearCache
	 * @return void 
	 */
	function clearCache() {
		$this->_hierarchyGenerator->clearCache();
		unset($this->_cacheACF);
		unset($this->_cacheFCA);
		unset($this->_cacheAFC);
	}


}


?>