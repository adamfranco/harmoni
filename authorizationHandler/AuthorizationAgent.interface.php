<?php

/** 
 * Defines the functionallity of an authorization agent, one of the three
 * authorization components. An authorization agent specifies the agent to be
 * authorized. It stores several properties:
 * <br><br>
 * The <b>system id</b> is a system-specific unique numeric id of the agent.
 * <br><br>
 * The <b>system name</b> is a system-specific unique name of the agent.
 * <br><br>
 * The <b>type</b> is a system-specific type used to differentiate between verious
 * types of agents.
 * 
 * @access public
 * @version $Id: AuthorizationAgent.interface.php,v 1.2 2003/06/30 20:41:44 dobomode Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 6/29/2003
 * @package harmoni.authorizationHandler
 */
class AuthorizationAgentInterface {

	/**
	 * Returns the system id of this agent.
	 * <br><br>
	 * The <b>system id</b> is a system-specific unique numeric id of the agent.
	 * @method public getSystemId
	 * @return integer The system id of this agent.
	 */
	function getSystemId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Returns the system name of this agent.
	 * <br><br>
	 * The <b>system name</b> is a system-specific unique name of the agent.
	 * @method public getSystemName
	 * @return string The system name of this agent.
	 */
	function getSystemName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Returns the type of this agent.
	 * <br><br>
	 * The <b>type</b> is a system-specific type used to differentiate between verious
	 * types of agents.
	 * @method public getType
	 * @return string The type of this agent.
	 */
	function getType() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
}


?>