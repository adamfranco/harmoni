<?php

/**
 * The AgentInformationHandler interface defines the methods required by any AgentInformationHandler class. The interface relies on an AuthenticationHandler.
 *
 * @package harmoni.authenticationHandler.agentInformationHandler
 * @version $Id: AgentInformationHandler.interface.php,v 1.2 2003/06/25 21:46:53 gabeschine Exp $
 * @copyright 2003 
 **/
class AgentInformationHandlerInterface {
	/**
	 * Gets agent information (such as email, etc) as defined in each AuthenticationMethod.
	 * 
	 * This function cycles through each installed AuthenticationMethod (or just 
	 * the one specified in $method if passed) and fetches the agent information
	 * associated with that method. If all methods are checked, this function
	 * will compile a single result, resolving conflicting information from
	 * multiple methods by looking at the method's priority setting, making
	 * lower number (higher priority) take precedence.
	 * @param string $systemName The system name to fetch information for.
	 * @param string $method (optional) The method name to fetch information from.
	 * If not specified, will use all methods and combine the information.
	 * @see AuthenticationMethodInterface::setPriority()
	 * @see AuthenticationMethodInterface
	 * @see AuthenticationHandler
	 * @access public
	 * @return void 
	 **/
	function getAgentInformation( $systemName, $method = "") {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
}

?>