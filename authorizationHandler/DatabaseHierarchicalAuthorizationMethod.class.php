<?php

require_once(HARMONI."authorizationHandler/HierarchicalAuthorizationMethod.interface.php");
require_once(HARMONI."authorizationHandler/DatabaseHierarchicalAuthorizationMethodDataContainer.class.php");

/**
 * This is a database implementation of the HierarchicalAuthorizationMethodInterface.
 * <br><br>
 * The class is capable of authorizing an <b>agent</b> performing a <b>function</b> in a given 
 * <b>context</b>.
 * @access public
 * @version $Id: DatabaseHierarchicalAuthorizationMethod.class.php,v 1.4 2003/07/09 01:28:27 dobomode Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 6/29/2003
 * @package harmoni.authorizationHandler
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
			throw(new Error($str, "AuthorizationHandler", true));
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
		
		// this string will precede every column name
		$colPrefix = $contextSystem.".".$contextSubsystem.".";
		
		// get ancestors of this context
		$ancestors =& $this->_hierarchyGenerator->getAncestors($contextDepth, $contextId);
		$ancestors[$contextDepth] = $contextId;
		$count = count($ancestors);
		
		// this boolean will show at the end whether the agent was authorized
		$authorized = false;

		// construct database query
		$query =& new SelectQuery();
		// run one query for each ancestor and the original context
		for ($depth = 0; $depth < $count; $depth++) {
			$query->reset();
			$query->addColumn($colPrefix.$this->_primaryKeyColumn);
		    $query->addTable($contextSystem.".".$contextSubsystem);
			$query->addWhere($colPrefix.$this->_agentIdColumn." = ".$agentId);
			$query->addWhere($colPrefix.$this->_agentTypeColumn." = ".$agentType);
			$query->addWhere($colPrefix.$this->_functionIdColumn." = ".$functionId);
			$query->addWhere($colPrefix.$this->_contextDepthColumn." = ".$depth);
			$query->addWhere($colPrefix.$this->_contextIdColumn." = ".$ancestors[$depth]);

			// run query
			Services::requireService("DBHandler", true);
			$dbHandler =& Services::getService("DBHandler");
			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
			
			// validate query results
			if ($queryResult === null) {
				$str = "Query failed. Possible invalid configuration of the AuthorizationMethod object.";
			    throw(new Error($str, "AuthorizationHandler", true));
			}
			if ($queryResult->getNumberOfRows() > 1) {
				$str = "Query returned more than one rows. ";
				$str .= "Possible invalid configuration of the AuthorizationMethod object.";
			    throw(new Error($str, "AuthorizationHandler", true));
			}
			
			// now see if the agent is authorized (unless they have already been authorized)
			$authorized = $queryResult->getNumberOfRows() === 1;
			
			// if the agent was authorized at an ancestor then they would be authorized
			// at the given context as well.
			if ($authorized)
			    break;
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
	 * @return void 
	 */
	function grant($agent, $function, $context) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
	 * @return void 
	 */
	function revoke($agent, $function, $context) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
	}


}


?>