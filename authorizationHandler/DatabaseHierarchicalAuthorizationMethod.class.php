<?php

require_once(HARMONI."authorizationHandler/HierarchicalAuthorizationMethod.interface.php");
require_once(HARMONI."authorizationHandler/DatabaseHierarchicalAuthorizationMethodDataContainer.class.php");

/**
 * This is a database implementation of the HierarchicalAuthorizationMethodInterface.
 * <br><br>
 * The class is capable of authorizing an <b>agent</b> performing a <b>function</b> in a given 
 * <b>context</b>.
 * @access public
 * @version $Id: DatabaseHierarchicalAuthorizationMethod.class.php,v 1.2 2003/07/04 03:32:34 dobomode Exp $
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
	var $_authorizedColumn;
	

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
	 * <code>authorized</code> - the name of the database table column that stores
	 * whether the agent is authorized to perform this function in this context.
	 * The column must be set up to store integers. <code>0</code> means not
	 * authorized. Anything else means authorized (though <code>1</code> is
	 * the recommended value).
	 * @attribute private string _authorizedColumn
	 */
	var $_authorizedColumn;
	

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
		$this->_agentIdColumn = $dataContainer->get("agentIdColumn");
		$this->_agentTypeColumn = $dataContainer->get("agentTypeColumn");
		$this->_functionIdColumn = $dataContainer->get("functionIdColumn");
		$this->_contextIdColumn = $dataContainer->get("contextIdColumn");
		$this->_contextDepthColumn = $dataContainer->get("contextDepthColumn");
		$this->_authorizedColumn = $dataContainer->get("authorizedColumn");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
	

}


?>