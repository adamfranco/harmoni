<?php

require_once(HARMONI."services/Service.interface.php");

/**
 * The AgentInformationHandler interface defines the methods required by any AgentInformationHandler class. The interface relies on an AuthenticationHandler.
 *
 * @package harmoni.interfaces.authentication.agentinformation
 * @version $Id: AgentInformationHandler.interface.php,v 1.7 2003/08/06 22:32:40 gabeschine Exp $
 * @copyright 2003 
 **/
class AgentInformationHandlerInterface extends ServiceInterface {
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
	 * @param boolean $searchMode Specifies if we should do a wildcard search
	 * for the supplied $systemName.
	 * @param optional string $method The method name to fetch information from.
	 * If not specified, will use all methods and combine the information.
	 * @see {@link AuthenticationMethodInterface::setPriority()}
	 * @see {@link AuthenticationMethodInterface}
	 * @see {@link AuthenticationHandler}
	 * @access public
	 * @return array An associative array of agent information. If $method is
	 * omitted, a join based on priority of all {@link AuthenticationMethod}s is
	 * returned. If $searchMode=true, an associative array of said arrays is returned,
	 * following the format: [username1]=>array([key1]=>value1,...),...
	 **/
	function getAgentInformation( $systemName, $searchMode=false, $method = "") {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
}

?>