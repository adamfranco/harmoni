<?php

/**
 * The AgentInformationHandler interface defines the methods required by any AgentInformationHandler class.
 *
 * @package harmoni.authenticationHandler.agentInformationHandler
 * @version $Id: AgentInformationHandler.interface.php,v 1.1 2003/06/25 20:43:49 gabeschine Exp $
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
	 * @see AuthenticationMethodInterface::setPriority()
	 * @see AuthenticationMethodInterface
	 * @see AuthenticationHandler
	 * @access public
	 * @return void 
	 **/
	function getAgentInformation( $systemName, $method = "") {
		
	}
}

?>