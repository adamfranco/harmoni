<?php

require_once(dirname(__FILE__)."/AgentSearch.interface.php");

/**
 * The AgentSearch interface defines methods for searching for agents. This is 
 * used by the AgentManager for searching for agents.
 * 
 * @package harmoni.osid.shared
 * @version $Id: AncestorGroupSearch.class.php,v 1.2 2004/12/01 18:56:33 adamfranco Exp $
 * @date $Date: 2004/12/01 18:56:33 $
 * @copyright 2004 Middlebury College
 */

class AncestorGroupSearch
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
		ArgumentValidator::validate($searchCriteria, new ExtendsValidatorRule("Id"));
		
		$groupOrAgentId = $searchCriteria->getIdString();
	
		$groups = array();
		
		return new HarmoniIterator($groups);
	}
}

?>