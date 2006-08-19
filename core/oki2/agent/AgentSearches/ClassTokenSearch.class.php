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
 * @version $Id: ClassTokenSearch.class.php,v 1.1 2006/08/19 21:14:39 jwlee100 Exp $
 */

class ClassTokenSearch
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
	  die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a 		 child class.");
	
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
	   die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a 		 child class.");
	}
	
	/**
	 * Get all the DNs for the various CourseSections with the specified search criteria and search Type.
	 *
	 * <b>Warning!</b> This method is NOT defined in v.2 of the OSIDs.
	 * 
	 * @param mixed $searchCriteria
	 * @param object Type $groupSearchType
	 * @return object AgentIterator
	 * @access public
	 * @since 11/10/04
	 */
	function &getClassDNsBySearch ( & $searchCriteria) {
		$allGroups = array();
		
		// See if the agent exists as known by harmoni
		$authNMethodManager =& Services::getService("AuthNMethodManager");
		$authenticationManager =& Services::getService("AuthenticationManager");
		$agentManager =& Services::getService("AgentManager");
		
		$types =& $authNMethodManager->getAuthNTypes();
		while ($types->hasNextType()) {
			$type =& $types->nextType();
			$authNMethod =& $authNMethodManager->getAuthNMethodForType($type);
			if(!method_exists($authNMethod,"getClassTokensBySearch")){
			  continue;
			}
			$tokensIterator =& $authNMethod->getClassTokensBySearch($searchCriteria);
			
		
			
			while ($tokensIterator->hasNextObject()) {
				$token =& $tokensIterator->nextObject();
				$allGroups[] = $token->getIdentifier();
			}
		}		
		
		return $allGroups;
	}	
}

?>