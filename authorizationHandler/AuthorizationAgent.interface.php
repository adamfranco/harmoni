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
 * The <b>type</b> is a system-specific type used to differentiate different
 * types of agents.
 * 
 * @access public
 * @version $Id: AuthorizationAgent.interface.php,v 1.1 2003/06/30 03:08:32 dobomode Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 6/29/2003
 * @package harmoni.authorizationHandler
 */
class AuhtorizationAgentInterface {

	/**
	 * Returns the system id of this agent.
	 * @method public getSystemId
	 * @return integer The system id of this agent.
	 */
	function getSystemId() {}

	/**
	 * Returns the system name of this agent.
	 * @method public getSystemName
	 * @return string The system name of this agent.
	 */
	function getSystemName() {}

	/**
	 * Returns the type of this agent.
	 * @method public getType
	 * @return string The type of this agent.
	 */
	function getType() {}
	

	
}


?>