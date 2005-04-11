<?php

require_once(dirname(__FILE__)."/AgentSearch.interface.php");

/**
 * The AgentSearch interface defines methods for searching for agents. This is 
 * used by the AgentManager for searching for agents.
 *
 * @package harmoni.osid_v2.agent.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TokenSearch.class.php,v 1.1 2005/04/11 20:56:06 adamfranco Exp $
 */

class TokenSearch
	extends AgentSearchInterface {
		
	/**
	 * Get all the Agents with the specified search criteria and search Type.
	 *
	 * This method is defined in v.2 of the OSIDs.
	 * 
	 * @param mixed $searchCriteria
	 * @param object Type $agentSearchType
	 * @return object AgentIterator
	 * @access public
	 * @since 11/10/04
	 */
	function &getAgentsBySearch ( & $searchCriteria) {
		$allAgents = array();
		
		// See if the agent exists as known by harmoni
		$authNMethodManager =& Services::getService("AuthNMethodManager");
		$authenticationManager =& Services::getService("AuthenticationManager");
		$agentManager =& Services::getService("AgentManager");
		
		$types =& $authNMethodManager->getAuthNTypes();
		while ($types->hasNextType()) {
			$type =& $types->nextType();
			$authNMethod =& $authNMethodManager->getAuthNMethodForType($type);
			$tokensIterator =& $authNMethod->getTokensBySearch($searchCriteria);
			
			while ($tokensIterator->hasNextObject()) {
				$agentId =& $authenticationManager->_getAgentIdForAuthNTokens(
					$tokensIterator->nextObject(), $type);
				$allAgents[] =& $agentManager->getAgent($agentId);
			}
		}
		
		return new HarmoniIterator($allAgents);
	}
	
	/**
	 * Get all the Groups with the specified search criteria and search Type.
	 *
	 * This method is defined in v.2 of the OSIDs.
	 * 
	 * @param mixed $searchCriteria
	 * @param object Type $groupSearchType
	 * @return object AgentIterator
	 * @access public
	 * @since 11/10/04
	 */
	function &getGroupsBySearch ( & $searchCriteria) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}	
}

?>