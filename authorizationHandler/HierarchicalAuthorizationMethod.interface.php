<?php

/** 
 * This interface defines the functionallity of a hierarchical authorization
 * method capable of authorizing an <b>agent</b> performing a <b>function</b> in a given 
 * <b>context</b>.
 * @access public
 * @version $Id: HierarchicalAuthorizationMethod.interface.php,v 1.3 2003/07/04 03:32:34 dobomode Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 6/29/2003
 * @package harmoni.authorizationHandler
 * @see {@link HierarchicalAuthorizationContextInterface}
 * @see {@link AuthorizationAgentInterface}
 * @see {@link AuthorizationFunctionInterface}
 */
class HierarchicalAuthorizationMethodInterface {


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