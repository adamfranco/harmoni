<?php

require_once(dirname(__FILE__)."/AgentSearch.interface.php");

/**
 * The AgentSearch interface defines methods for searching for agents. This is 
 * used by the AgentManager for searching for agents.
 * 
 * @package harmoni.osid.agent
 * @version $Id: HarmoniAgentExistsSearch.class.php,v 1.2 2005/01/12 16:51:45 adamfranco Exp $
 * @date $Date: 2005/01/12 16:51:45 $
 * @copyright 2004 Middlebury College
 */

class HarmoniAgentExistsSearch
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
	 * @date 11/10/04
	 */
	function &getAgentsBySearch ( & $searchCriteria, & $agentSearchType ) {
		$agents = array();
		
		// See if the agent exists as known by harmoni
		$agentInfo =& Services::getService("AgentInformation");
		if ($agentInfo->agentExists($searchCriteria)) {
			// if the agent exists, make sure that we have a populated agent
			// in the agent manager which we can return.			
			$authN =& Services::getService("AuthN");
			$agentId =& $authN->getAgentId($searchCriteria, new HarmoniAuthenticationType);
			
			$agentManager =& Services::getService("Agent");
			$agents[] =& $agentManager->getAgent($agentId);
		}
		
		return new HarmoniIterator($agents);
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
	 * @date 11/10/04
	 */
	function &getGroupsBySearch ( & $searchCriteria, & $groupSearchType ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
}

?>